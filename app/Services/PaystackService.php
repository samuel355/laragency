<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaystackService
{
    public function initialize(array $payload): array
    {
        $response = $this->client()->post('/transaction/initialize', $payload);

        return $response->throw()->json();
    }

    public function verify(string $reference): array
    {
        $response = $this->client()->get('/transaction/verify/'.urlencode($reference));

        return $response->throw()->json();
    }

    public function reference(): string
    {
        return 'RR-'.Str::upper(Str::random(16));
    }

    public function verifyWebhookSignature(string $body, ?string $signature): bool
    {
        $secret = (string) config('services.paystack.secret_key');

        if ($secret === '' || $signature === null) {
            return false;
        }

        return hash_equals(hash_hmac('sha512', $body, $secret), $signature);
    }

    private function client(): PendingRequest
    {
        return Http::baseUrl(config('services.paystack.base_url'))
            ->acceptJson()
            ->asJson()
            ->withToken(config('services.paystack.secret_key'));
    }
}
