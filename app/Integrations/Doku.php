<?php

namespace App\Integrations;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Doku
{
    /**
     * DOKU Client ID.
     */
    private string $clientId;

    /**
     * DOKU Secret Key.
     */
    private string $secretKey;

    /**
     * DOKU Base URL.
     */
    private string $baseUrl;

    /**
     * DOKU API Path.
     */
    private string $apiPath;

    /**
     * DOKU Notification URL.
     */
    private string $notificationPath;

    /**
     * Set DOKU Credentials.
     */
    public function __construct()
    {
        $this->clientId = config('doku.client_id');
        $this->secretKey = config('doku.secret_key');
        $this->baseUrl = config('doku.production') ? config('doku.production_url') : config('doku.sandbox_url');
        $this->apiPath = config('doku.api_path');
        $this->notificationPath = config('doku.notification_path');
    }

    /**
     * Verify payment data and get payment checkout URL from DOKU API.
     */
    public function checkout(array $data): array
    {
        $data = [
            'order' => [
                'amount' => 100000,
                'invoice_number' => 'INV-001',
                'currency' => 'IDR',
                'line_items' => [
                    [
                        'id' => 'PRD-001',
                        'name' => 'Product 1',
                        'price' => 100000,
                        'quantity' => 1,
                    ],
                ],
                'language' => 'ID',
            ],
            'payment' => [
                'payment_due_date' => config('doku.checkout_expired'), // Minute
            ],
            'customer' => [
                'id' => 'CST-001',
                'name' => 'Robert Emerson',
                'email' => 'robert@gmail.com',
                'phone' => '082123456789',
            ],
        ];

        // Generate headers
        $headers = $this->generateHeaders($data);

        // Make POST request to DOKU Checkout API
        $url = $this->baseUrl . $this->apiPath;
        $response = Http::withHeaders($headers)->post($url, $data);
        $checkout = $response->json();

        if (!$checkout) {
            throw new Exception('Payment checkout failed.', Response::HTTP_BAD_REQUEST);
        }

        return $checkout;
    }

    /**
     * Generate DOKU headers.
     * Using example code by DOKU official github repository.
     *
     * @link https://github.com/PTNUSASATUINTIARTHA-DOKU/jokul-php-example
     */
    public function generateHeaders(array $data): array
    {
        // Prepare options
        $options = [
            'data' => $data,
            'client_id' => $this->clientId,
            'request_id' => Str::random(32),
            'request_datetime' => now()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z'),
            'request_target' => $this->apiPath,
        ];

        // Generate signature
        $signature = $this->generateSignature($options);

        $headers = [
            'Client-Id' => $options['client_id'],
            'Request-Id' => $options['request_id'],
            'Request-Timestamp' => $options['request_datetime'],
            'Signature' => $signature,
        ];

        return $headers;
    }

    /**
     * Generate DOKU signature.
     * Using example code by DOKU docs.
     *
     * @link https://dashboard.doku.com/docs/docs/http-notification/http-notification-best-practice
     */
    public function generateSignature(array $options): string
    {
        // Prepare options
        $data = $options['data'];
        $clientId = $options['client_id'];
        $requestId = $options['request_id'];
        $requestDatetime = $options['request_datetime'];
        $requestTarget = $options['request_target'];

        // Generate digest
        $digest = base64_encode(hash('sha256', json_encode($data), true));

        // Prepare signature component
        $signature =
            "Client-Id:$clientId\n" .
            "Request-Id:$requestId\n" .
            "Request-Timestamp:$requestDatetime\n" .
            "Request-Target:$requestTarget\n" .
            "Digest:$digest";

        // Generate signature
        $signature = 'HMACSHA256=' . base64_encode(hash_hmac('sha256', $signature, $this->secretKey, true));

        return $signature;
    }

    /**
     * DOKU HTTP Notification.
     * Retrieve callback from DOKU.
     */
    public function notification(Request $request): Response
    {
        dd($request->all());
    }
}
