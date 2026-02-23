<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $session;

    public function __construct()
    {
        $this->baseUrl = rtrim(env('WHATSAPP_API_URL', 'https://waapi.fkstudio.my.id'), '/');
        $this->apiKey = env('WHATSAPP_API_KEY', '');
        $this->session = env('WHATSAPP_SESSION', 'default');
    }

    /**
     * Format number to chat ID (e.g., 62xxx@c.us)
     */
    public function formatChatId($number): string
    {
        $phone = preg_replace('/[^0-9]/', '', $number);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        return $phone . '@c.us';
    }

    /**
     * Send WhatsApp Message (WAHA format)
     */
    public function sendMessage($to, $message): bool
    {
        try {
            $payload = [
                'session' => $this->session,
                'chatId' => $this->formatChatId($to),
                'text' => $message
            ];

            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/api/sendText', $payload);

            if ($response->successful()) {
                return true;
            }

            Log::error('WAHA API Error: ' . $response->status() . ' - ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('WAHA API Exception: ' . $e->getMessage());
            return false;
        }
    }
}
