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

class SendWhatsAppStatusNotification implements ShouldQueue
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
            $order = $this->order->fresh();
            $status = $order->status;
            
            $message = $this->getMessageByStatus($order);
            
            if ($message) {
                $waService->sendMessage($order->customer_phone, $message);
            }
        } catch (\Exception $e) {
            Log::error("Failed to send status WA for order {$this->order->order_number}: " . $e->getMessage());
        }
    }

    protected function getMessageByStatus(Order $order): ?string
    {
        $name = $order->customer_name;
        $orderNo = $order->order_number;

        switch ($order->status) {
            case 'processing':
                return "🧁 *PESANAN SEDANG DIPROSES* 🧁\n\n" .
                    "Halo Kak *{$name}*,\n" .
                    "Kabar baik! Pesanan Kakak dengan nomor `#{$orderNo}` saat ini sedang dalam tahap *pengerjaan/diproses* oleh tim dapur kami.\n\n" .
                    "Mohon ditunggu ya Kak, kami pastikan hasilnya spesial untuk Kakak! ✨";

            case 'shipping':
                $courier = $order->courier_name ?? 'Kurir kami';
                $tracking = $order->tracking_number ? "\n📍 *No. Resi:* `{$order->tracking_number}`" : "";
                
                return "🚚 *PESANAN DALAM PENGIRIMAN* 🚚\n\n" .
                    "Halo Kak *{$name}*,\n" .
                    "Pesanan Kakak `#{$orderNo}` sudah selesai dan sekarang dalam *perjalanan* menuju lokasi Kakak.\n\n" .
                    "📦 *Kurir:* {$courier}{$tracking}\n\n" .
                    "Mohon siapkan diri untuk menerima paket manis dari kami ya! 🥧✨";

            case 'completed':
                return "✅ *PESANAN SELESAI* ✅\n\n" .
                    "Halo Kak *{$name}*,\n" .
                    "Pesanan Kakak `#{$orderNo}` telah *berhasil diterima*.\n\n" .
                    "Terima kasih banyak sudah mempercayai Maryam Cake & Cookies. Semoga suka dengan kuenya ya! Ditunggu pesanan berikutnya Kak. 🙏🍰";

            case 'cancelled':
                return "❌ *PESANAN DIBATALKAN* ❌\n\n" .
                    "Halo Kak *{$name}*,\n" .
                    "Mohon maaf, pesanan Kakak `#{$orderNo}` telah *dibatalkan*.\n\n" .
                    "Jika Kakak merasa ada kesalahan atau ingin bertanya lebih lanjut, silakan hubungi admin kami ya. Terima kasih.";

            default:
                return null;
        }
    }
}
