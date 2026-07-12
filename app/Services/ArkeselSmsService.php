<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ArkeselSmsService
{
    public function send(string $phone, string $message): void
    {
        $apiKey = (string) config('services.arkesel.api_key');

        if ($apiKey === '') {
            Log::info('Arkesel SMS skipped because ARKESEL_API_KEY is empty.', [
                'phone' => $phone,
                'message' => $message,
            ]);

            return;
        }

        Http::acceptJson()
            ->asJson()
            ->withToken($apiKey)
            ->post(config('services.arkesel.endpoint'), [
                'sender' => config('services.arkesel.sender'),
                'message' => $message,
                'recipients' => [$phone],
            ])
            ->throw();
    }
}
