# Khalti API Endpoints Reference

## Overview
This document provides reference information for the Khalti API endpoints used in Skillzy.

## API Versions
- **Development:** `https://dev.khalti.com/api/v2/`
- **Production:** `https://khalti.com/api/v2/`

---

## 1. Payment Initiation Endpoint

### Endpoint
```
POST /epayment/initiate/
```

### Headers
```
Authorization: Key YOUR_SECRET_KEY
Content-Type: application/json
```

### Request Body
```json
{
  "return_url": "https://yourdomain.com/wallet/callback",
  "website_url": "https://yourdomain.com",
  "amount": 100000,
  "purchase_order_id": "wallet_topup_1_1234567890_1234",
  "purchase_order_name": "Wallet Top-up - John Doe",
  "customer_info": {
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "9841234567"
  },
  "merchant_username": "SKILLZY"
}
```

### Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| return_url | String | Yes | URL to redirect after payment |
| website_url | String | Yes | Your website URL |
| amount | Integer | Yes | Amount in paisa (1 NPR = 100 paisa) |
| purchase_order_id | String | Yes | Unique order ID (no duplicates) |
| purchase_order_name | String | Yes | Order name displayed to user |
| customer_info | Object | No | Customer details |
| merchant_username | String | Yes | Your merchant code |
| amount_breakdown | Object | No | Breakdown of amount |

### Response (Success - 200)
```json
{
  "pidx": "GhKc41A916271T070T070733T1692938302766",
  "payment_url": "https://dev.khalti.com/epayment/initiate/GhKc41A916271T070T070733T1692938302766",
  "expires_at": "2024-03-30T15:45:00Z"
}
```

### Response (Error - 4xx/5xx)
```json
{
  "detail": "Invalid secret key"
}
```

### Example Usage in Skillzy
```php
$khaltiService->initiatePayment([
    'return_url' => route('wallet.callback'),
    'purchase_order_id' => 'wallet_topup_1_1712207342_1234',
    'purchase_order_name' => 'Wallet Top-up - John Doe',
    'amount' => 1000, // in NPR
    'customer_info' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '9841234567',
    ],
]);
```

---

## 2. Payment Verification Endpoint

### Endpoint
```
POST /epayment/lookup/
```

### Headers
```
Authorization: Key YOUR_SECRET_KEY
Content-Type: application/json
```

### Request Body
```json
{
  "pidx": "GhKc41A916271T070T070733T1692938302766",
  "merchant_username": "SKILLZY"
}
```

### Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| pidx | String | Yes | Payment ID from initiation response |
| merchant_username | String | Yes | Your merchant code |

### Response (Payment Completed - 200)
```json
{
  "pidx": "GhKc41A916271T070T070733T1692938302766",
  "transaction_id": "TID123456",
  "amount": 100000,
  "purchase_order_id": "wallet_topup_1_1712207342_1234",
  "purchase_order_name": "Wallet Top-up - John Doe",
  "status": "Completed",
  "payment_method": "KHALTI",
  "created_at": "2024-03-30T15:30:00Z"
}
```

### Response (Payment Pending - 200)
```json
{
  "pidx": "GhKc41A916271T070T070733T1692938302766",
  "status": "Pending",
  "message": "Payment is still pending"
}
```

### Response (Payment Failed - 200)
```json
{
  "pidx": "GhKc41A916271T070T070733T1692938302766",
  "status": "Expired",
  "message": "Payment session has expired"
}
```

### Possible Status Values
| Status | Description |
|--------|-------------|
| Completed | Payment successful |
| Pending | Awaiting payment completion |
| Expired | Payment session expired |
| Failed | Payment failed |
| Cancelled | User cancelled payment |

### Example Usage in Skillzy
```php
$verification = $khaltiService->verifyPayment($pidx);

if ($verification['success'] && $verification['status'] === 'Completed') {
    // Add coins to wallet
    $user->coins += $verification['amount'];
}
```

---

## 3. Payment Callback Flow

### User Completion
After user completes payment on Khalti, they're redirected to:

```
GET {return_url}?pidx={pidx}&status={status}
```

### Example Callback URL
```
https://skillzy.local/wallet/callback?pidx=GhKc41A916271T070T070733T1692938302766&status=Completed
```

### Callback Parameters
| Parameter | Example | Description |
|-----------|---------|-------------|
| pidx | GhKc41A916271T070... | Payment ID |
| status | Completed | Payment status |

### Processing Callback
```php
// In routes/web.php
Route::get('/wallet/callback', [WalletController::class, 'callback'])->name('wallet.callback');

// In WalletController::callback()
$pidx = request('pidx');
$status = request('status');

// Always verify with backend - don't trust callback status alone!
$verification = $khaltiService->verifyPayment($pidx);
```

---

## 4. Error Codes & Messages

### HTTP Status Codes

| Code | Meaning |
|------|---------|
| 200 | Request successful |
| 400 | Bad request (invalid parameters) |
| 401 | Unauthorized (invalid credentials) |
| 403 | Forbidden (invalid merchant) |
| 404 | Not found (PIDX doesn't exist) |
| 500 | Server error |

### Common Error Responses

#### Invalid Credentials
```json
{
  "detail": "Invalid API key or merchant code"
}
```

#### Invalid Amount
```json
{
  "detail": "Amount must be greater than 0"
}
```

#### Missing Required Field
```json
{
  "detail": "Missing required field: purchase_order_id"
}
```

#### Duplicate Order ID
```json
{
  "detail": "Duplicate purchase_order_id"
}
```

---

## 5. Amount Formatting

### Important: Paisa vs NPR
- **Khalti API uses PAISA (smallest unit)**
- **1 NPR = 100 Paisa**

### Examples
| NPR | Paisa |
|-----|-------|
| 1 | 100 |
| 10 | 1000 |
| 100 | 10000 |
| 1000 | 100000 |
| 5000 | 500000 |

### Conversion in Code
```php
// NPR to Paisa (for sending to Khalti)
$amount_npr = 1000;
$amount_paisa = $amount_npr * 100; // 100000

// Paisa to NPR (from Khalti response)
$amount_paisa = 100000;
$amount_npr = $amount_paisa / 100; // 1000
```

---

## 6. Testing Credentials

### Development Environment
```
Public Key: 2b147e51b6f047f08650911019241f50
Secret Key: 999a489f242f4b61ab05643034747b5b
Merchant Code: SKILLZY
Base URL: https://dev.khalti.com/api/v2/
```

### Get Actual Credentials
1. Visit https://merchant.khalti.com/
2. Sign up or login
3. Navigate to Settings → API Keys
4. Copy your keys

---

## 7. Security Best Practices

### Protect Secret Key
```php
// ✓ Correct: Only used server-side
$secretKey = config('services.khalti.secret_key');
$response = Http::withHeaders([
    'Authorization' => 'Key ' . $secretKey
])->post(...);

// ✗ Wrong: Never expose to frontend
// window.khalti_secret = "..." // DON'T DO THIS!
```

### Verify Payment Always
```php
// ✓ Correct: Always verify
$verification = $khaltiService->verifyPayment($pidx);
if ($verification['success'] && $verification['status'] === 'Completed') {
    // Process payment
}

// ✗ Wrong: Trust callback only
if ($request->query('status') === 'Completed') {
    // Process payment // DON'T DO THIS!
}
```

### Validate PIDX Match
```php
// ✓ Correct: Verify PIDX matches session
if ($callback_pidx === session('khalti_pidx')) {
    $verification = $khaltiService->verifyPayment($pidx);
}

// ✗ Wrong: Trust any PIDX
$verification = $khaltiService->verifyPayment($request->get('pidx')); // DON'T DO THIS!
```

---

## 8. Rate Limits

- **No documented rate limit** in Khalti documentation
- **Estimated:** ~1000 requests/minute per merchant
- **Recommendation:** Implement exponential backoff on failures

---

## 9. Timeout Settings

```php
// Khalti typically responds within 5 seconds
Http::timeout(10) // Set 10 second timeout
    ->post(...)
```

---

## 10. Webhook Support (Future)

Khalti supports webhooks as an alternative to user redirects:
- **Endpoint:** Your webhook URL
- **Event:** When payment is completed
- **Method:** POST with payment details

Currently not implemented in Skillzy (polling-based verification used instead).

---

## 11. Testing with curl

### Initiate Payment
```bash
curl -X POST https://dev.khalti.com/api/v2/epayment/initiate/ \
  -H "Authorization: Key 999a489f242f4b61ab05643034747b5b" \
  -H "Content-Type: application/json" \
  -d '{
    "return_url": "http://localhost:8000/wallet/callback",
    "website_url": "http://localhost:8000",
    "amount": 100000,
    "purchase_order_id": "order_'$(date +%s)'_'$((RANDOM))'",
    "purchase_order_name": "Test Payment",
    "customer_info": {
      "name": "Test User",
      "email": "test@example.com",
      "phone": "9841234567"
    },
    "merchant_username": "SKILLZY"
  }'
```

### Verify Payment
```bash
curl -X POST https://dev.khalti.com/api/v2/epayment/lookup/ \
  -H "Authorization: Key 999a489f242f4b61ab05643034747b5b" \
  -H "Content-Type: application/json" \
  -d '{
    "pidx": "GhKc41A916271T070T070733T1692938302766",
    "merchant_username": "SKILLZY"
  }'
```

---

## References
- Official Docs: https://docs.khalti.com/
- Merchant Dashboard: https://merchant.khalti.com/
- Support: support@khalti.com
