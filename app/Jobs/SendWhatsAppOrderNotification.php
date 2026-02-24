<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendWhatsAppOrderNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $waService): void
    {
        try {
            $order = $this->order->load('items.product');
            $itemsList = "";
            
            foreach ($order->items as $item) {
                $itemsList .= "- {$item->product->name} (x{$item->quantity})\n";
            }

            $date = $order->created_at->format('d/m/Y H:i');
            
            $message = "🧁 *KONFIRMASI PESANAN - MARYAM CAKE & COOKIES* 🧁\n\n";
            $message .= "Halo Kak *{$order->customer_name}*, terima kasih sudah berbelanja!\n";
            $message .= "Kami telah menerima pesanan Kakak dengan rincian sebagai berikut:\n\n";
            $message .= "🔖 *Nomor Pesanan:* `#{$order->order_number}`\n";
            $message .= "📅 *Tanggal:* {$date}\n\n";
            $message .= "📋 *Daftar Pesanan:*\n{$itemsList}\n";
            $message .= "💰 *Total Pembayaran:* *Rp " . number_format($order->total_price, 0, ',', '.') . "*\n";
            $message .= "💳 *Metode Pembayaran:* {$order->payment_method_name}\n";
            
            if ($order->is_preorder) {
                $deliveryDate = Carbon::parse($order->delivery_date)->format('d M Y - H:i');
                $message .= "📦 *Jadwal Pengiriman:* {$deliveryDate}\n";
            }

            $message .= "\n----------------------------------\n";
            $message .= "📄 *Unduh Invoice (PDF):*\n" . route('order.invoice', $order->order_number) . "\n";
            $message .= "----------------------------------\n\n";
            $message .= "Pesanan Kakak akan segera kami proses. Mohon ditunggu ya! ✨\n";
            $message .= "Terima kasih telah mempercayai toko kami! 🙏🍰";

            $waService->sendMessage($order->customer_phone, $message);

            // Notify Admin
            $adminPhone = env('WHATSAPP_ADMIN_PHONE');
            if ($adminPhone) {
                $adminMessage = "🔔 *PESANAN BARU MASUK!* 🔔\n\n";
                $adminMessage .= "Ada pesanan baru nih kak! Berikut detailnya:\n\n";
                $adminMessage .= "👤 *Pelanggan:* {$order->customer_name}\n";
                $adminMessage .= "📞 *No. HP:* {$order->customer_phone}\n";
                $adminMessage .= "📍 *Alamat:* {$order->address}\n\n";
                $adminMessage .= "📋 *Item yang diorder:*\n{$itemsList}\n";
                $adminMessage .= "💰 *Total:* *Rp " . number_format($order->total_price, 0, ',', '.') . "*\n";
                $adminMessage .= "💳 *Metode:* {$order->payment_method_name}\n";
                
                if ($order->is_preorder) {
                    $deliveryDate = Carbon::parse($order->delivery_date)->format('d M Y - H:i');
                    $adminMessage .= "📦 *Jadwal Pengiriman:* {$deliveryDate}\n";
                }

                $adminMessage .= "\nSegera diproses ya kak! 🚀";

                $waService->sendMessage($adminPhone, $adminMessage);
            }
            
        } catch (\Exception $e) {
            Log::error("Failed to send WA in Job for order {$this->order->order_number}: " . $e->getMessage());
            throw $e; // Retry according to queue config
        }
    }
}
