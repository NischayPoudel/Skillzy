<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class KhaltiService
{
    private string $secretKey;
    private string $publicKey;
    private string $baseUrl;
    private string $merchantCode;

    public function __construct()
    {
        $this->secretKey = config('services.khalti.secret_key');
        $this->publicKey = config('services.khalti.public_key');
        $this->baseUrl = config('services.khalti.base_url');
        $this->merchantCode = config('services.khalti.merchant_code') ?? 'SKILLZY';

        if (!$this->secretKey || !$this->publicKey) {
            throw new Exception('Khalti credentials not configured');
        }
    }

    /**
     * Initiate a payment request to Khalti
     *
     * @param array $data
     * @return array
     */
    public function initiatePayment(array $data): array
    {
        try {
            $payload = [
                'return_url' => $data['return_url'],
                'website_url' => config('app.url'),
                'amount' => (int)($data['amount'] * 100), // Convert to paisa
                'purchase_order_id' => $data['purchase_order_id'],
                'purchase_order_name' => $data['purchase_order_name'],
                'customer_info' => $data['customer_info'] ?? null,
                'merchant_username' => $this->merchantCode ?? 'SKILLZY',
            ];
            
            // Only add optional fields if provided
            if (!empty($data['amount_breakdown'])) {
                $payload['amount_breakdown'] = $data['amount_breakdown'];
            }

            Log::info('Khalti Payment Initiation Request', [
                'payload' => array_merge($payload, ['amount' => $data['amount']]),
                'api_url' => $this->baseUrl . 'epayment/initiate/',
            ]);

            $response = Http::timeout(10)->withHeaders([
                'Authorization' => 'Key ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . 'epayment/initiate/', $payload);

            // Decode response - handle as string
            $responseText = (string) $response;
            
            Log::debug('Khalti Payment Raw Response', [
                'response_body' => $responseText,
            ]);
            
            $body = json_decode($responseText, true);
            
            if (!is_array($body)) {
                Log::error('Khalti Payment Response is not JSON', [
                    'response' => $responseText,
                ]);
                throw new Exception('Invalid response from Khalti API');
            }
            
            if (empty($body['pidx'])) {
                Log::error('Khalti Payment Initiation Failed - No PIDX', [
                    'response' => $body,
                ]);
                
                $errorMsg = $body['detail'] ?? $body['error'] ?? 'Payment initiation failed';
                throw new Exception($errorMsg);
            }

            Log::info('Khalti Payment Initiated Successfully', [
                'pidx' => $body['pidx'] ?? null,
                'payment_url' => $body['payment_url'] ?? null,
            ]);

            return [
                'success' => true,
                'pidx' => $body['pidx'],
                'payment_url' => $body['payment_url'],
            ];
        } catch (\Throwable $e) {
            Log::error('Khalti Service Error - Payment Initiation', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify payment with Khalti
     *
     * @param string $pidx
     * @return array
     */
    public function verifyPayment(string $pidx): array
    {
        try {
            Log::info('Khalti Payment Verification Request', [
                'pidx' => $pidx,
                'api_url' => $this->baseUrl . 'epayment/lookup/',
            ]);

            $response = Http::timeout(10)->withHeaders([
                'Authorization' => 'Key ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . 'epayment/lookup/', [
                'pidx' => $pidx,
                'merchant_username' => $this->merchantCode,
            ]);

            $responseText = (string) $response;
            
            Log::debug('Khalti Payment Verification Raw Response', [
                'response_body' => $responseText,
            ]);
            
            $result = json_decode($responseText, true);

            if (!is_array($result)) {
                Log::error('Khalti Payment Verification - Invalid JSON', [
                    'pidx' => $pidx,
                    'response' => $responseText
                ]);
                return [
                    'success' => false,
                    'status' => 'Error',
                    'message' => 'Invalid response from Khalti',
                ];
            }

            // Check if payment was successful
            if ($result['status'] === 'Completed') {
                Log::info('Khalti Payment Verified Successfully', [
                    'pidx' => $pidx,
                    'amount' => $result['amount'] ?? null,
                    'transaction_id' => $result['transaction_id'] ?? null,
                ]);

                return [
                    'success' => true,
                    'status' => $result['status'],
                    'amount' => ($result['amount'] ?? 0) / 100, // Convert from paisa
                    'transaction_id' => $result['transaction_id'] ?? null,
                    'pidx' => $pidx,
                ];
            } else {
                Log::warning('Khalti Payment Not Completed', [
                    'pidx' => $pidx,
                    'status' => $result['status'] ?? 'unknown',
                ]);

                return [
                    'success' => false,
                    'status' => $result['status'] ?? 'Unknown',
                    'message' => 'Payment not completed',
                ];
            }
        } catch (\Throwable $e) {
            Log::error('Khalti Service Error - Payment Verification', [
                'error' => $e->getMessage(),
                'pidx' => $pidx,
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'status' => 'Error',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get the public key for frontend
     *
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * Get the base URL for frontend
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Generate a unique purchase order ID
     *
     * @param int $userId
     * @param string $type
     * @return string
     */
    public function generatePurchaseOrderId(int $userId, string $type = 'topup'): string
    {
        return sprintf('%s_%d_%d_%s', $type, $userId, time(), random_int(1000, 9999));
    }
}
