# Khalti Payment Integration Guide

## Overview
The Skillzy application now has a fully integrated Khalti payment gateway for wallet top-ups. This guide explains the implementation, setup, and troubleshooting.

## Architecture

### Components
1. **KhaltiService** (`app/Services/KhaltiService.php`)
   - Handles all Khalti API interactions
   - Initiates payments
   - Verifies payment status
   - Manages merchant configuration

2. **WalletController** (`app/Http/Controllers/WalletController.php`)
   - Displays wallet page and balance
   - Initiates Khalti payment for top-ups
   - Handles Khalti payment callbacks
   - Processes successful and failed payments

3. **Routes** (`routes/web.php`)
   - `GET /wallet` - Show wallet dashboard
   - `POST /wallet/topup` - Initiate Khalti payment
   - `GET /wallet/callback` - Handle Khalti callback

4. **Wallet View** (`resources/views/wallet/show.blade.php`)
   - Display current coin balance
   - Top-up form with Khalti payment
   - Transaction history

## Configuration

### Environment Variables
Add/update these in your `.env` file:

```env
KHALTI_PUBLIC_KEY=your_public_key_here
KHALTI_SECRET_KEY=your_secret_key_here
KHALTI_MERCHANT_CODE=your_merchant_code
KHALTI_BASE_URL=https://dev.khalti.com/api/v2/
PAYMENT_MODE=khalti
```

### How to Get Khalti Credentials

1. Visit [Khalti Merchant Dashboard](https://merchant.khalti.com/)
2. Create an account or login
3. Go to Settings > API Keys
4. Copy your:
   - Public Key
   - Secret Key
5. Set your Merchant Code
6. For testing, use the development API endpoint

### Service Provider
The KhaltiService is automatically registered in `app/Providers/AppServiceProvider.php` as a singleton.

## How It Works

### Payment Flow

1. **User initiates top-up**
   - User enters amount and clicks "Proceed to Khalti Payment"
   - Amount is validated (must be 1-999999.99)

2. **Backend initiates payment**
   - WalletController calls `KhaltiService::initiatePayment()`
   - Khalti Payment API creates a payment request
   - Returns a payment URL and payment ID (PIDX)
   - Payment details stored in session

3. **User redirected to Khalti**
   - User is redirected to Khalti payment page
   - User completes payment using Khalti methods:
     - Khalti wallet
     - Mobile banking
     - Card payment
     - etc.

4. **Khalti redirects back to callback**
   - After payment (success or failure), user redirected to callback URL
   - Callback URL: `/wallet/callback?pidx={pidx}&status={status}`

5. **Backend verifies payment**
   - WalletController::callback() receives the request
   - Calls `KhaltiService::verifyPayment()` to verify with Khalti
   - Khalti confirms payment status

6. **Payment completion**
   - If verified: coins added to wallet, transaction recorded
   - If failed: error message displayed
   - Session data cleared

## Payment States

### Success Flow
```
User enters amount
    ↓
POST /wallet/topup
    ↓
KhaltiService::initiatePayment()
    ↓
Redirect to Khalti payment page
    ↓
User completes payment
    ↓
Khalti redirects to /wallet/callback
    ↓
KhaltiService::verifyPayment()
    ↓
Payment verified: status = "Completed"
    ↓
Coins added to wallet
    ↓
Redirect to /wallet with success message
```

### Failure Flow
```
Payment fails or user cancels
    ↓
Khalti redirects to /wallet/callback
    ↓
KhaltiService::verifyPayment()
    ↓
Payment status != "Completed"
    ↓
Redirect to /wallet with error message
```

## Error Handling

### Common Issues and Solutions

#### 1. "Khalti credentials not configured"
**Problem:** Missing Khalti environment variables
**Solution:** Add `KHALTI_PUBLIC_KEY` and `KHALTI_SECRET_KEY` to `.env`

#### 2. "Failed to initiate payment with Khalti"
**Problem:** API request to Khalti failed
**Check:**
- Verify API keys are correct
- Check internet connectivity
- Verify KHALTI_BASE_URL is correct
- Check Khalti API is not down
- Review logs in `storage/logs/`

#### 3. "Payment reference mismatch"
**Problem:** Session PIDX doesn't match callback PIDX
**Possible causes:**
- User opened multiple payment windows
- Session was cleared
- Multiple browsers/tabs
**Solution:** User must retry the payment

#### 4. "User not found for payment"
**Problem:** User account was deleted between payment and callback
**Solution:** System handles gracefully, directs to wallet

## Logging

All Khalti operations are logged to:
- **File:** `storage/logs/laravel-[date].log`
- **Level:** INFO for successful operations, ERROR for failures

### Log Entries
```
[2024-03-30 10:15:22] local.INFO: Khalti Payment Initiation
[2024-03-30 10:16:45] local.INFO: Khalti Payment Initiated Successfully
[2024-03-30 10:17:30] local.INFO: Khalti Payment Verification
[2024-03-30 10:17:31] local.INFO: Khalti Payment Verified Successfully
[2024-03-30 10:17:32] local.INFO: Payment processed successfully
```

## Testing

### Manual Testing Steps

1. **Test with Development Khalti Account**
   - Use test credentials from Khalti Dashboard
   - Don't use real money on development

2. **Test Successful Payment**
   ```
   1. Go to /wallet
   2. Enter amount (e.g., 100)
   3. Click "Proceed to Khalti Payment"
   4. Complete payment on Khalti page
   5. Verify coins are added to wallet
   6. Check transaction history on wallet page
   ```

3. **Test Failed Payment**
   ```
   1. Go to /wallet
   2. Enter amount
   3. Click button and cancel on Khalti page
   4. Verify error message shows
   5. Wallet balance unchanged
   ```

4. **Check Logs**
   - Monitor `storage/logs/laravel-[date].log`
   - Look for INFO and ERROR entries

### Database
- Transaction recorded in `coin_transactions` table
- Transaction status: 'success' or 'pending'
- Reference ID: Khalti PIDX

## API Response Handling

### KhaltiService::initiatePayment Response
```php
[
    'success' => true,
    'pidx' => 'GhKc41A916271T070T070733...',
    'payment_url' => 'https://dev.khalti.com/epayment/initiate/GhKc41A916271T070T070733...'
]
```

### KhaltiService::verifyPayment Response (Success)
```php
[
    'success' => true,
    'status' => 'Completed',
    'amount' => 1000.00,
    'transaction_id' => 'TID123456',
    'pidx' => 'GhKc41A916271T070T070733...'
]
```

### KhaltiService::verifyPayment Response (Pending)
```php
[
    'success' => false,
    'status' => 'Pending',
    'message' => 'Payment not completed'
]
```

## Security Considerations

1. **Secret Key Protection**
   - Keep `KHALTI_SECRET_KEY` secure
   - Never expose in frontend
   - Only used server-side in KhaltiService

2. **Payment Verification**
   - Always verify payment with Khalti backend
   - Don't trust frontend only
   - Verify PIDX matches session

3. **Amount Validation**
   - Validated on frontend (HTML5)
   - Validated on backend (Validation rules)
   - Amount checked during payment initiation

4. **Session Security**
   - Payment data stored in session
   - Session configuration in `config/session.php`
   - Automatically cleared after payment

## Database Schema

### coin_transactions Table
```sql
- id (primary key)
- user_id (foreign key to users)
- type: 'credit' or 'debit'
- amount: decimal(10, 2)
- reason: 'topup', 'purchase', etc.
- reference_id: Khalti PIDX or purchase ID
- status: 'success', 'pending', 'failed'
- created_at
- updated_at
```

## User Experience

### Success Message
"Top-up successful! [amount] coins added to your wallet."

### Error Messages
- "Invalid amount. Please enter a value between 0.01 and 999999.99"
- "Failed to initiate payment. Please try again."
- "Invalid payment reference."
- "Payment was not successful. Status: [status]"
- "An error occurred while verifying your payment."

### Payment Button States
- **Normal:** "Proceed to Khalti Payment"
- **Loading:** "Processing... Redirecting to Khalti..."
- **Disabled:** Button greyed out during processing

## Maintenance

### Regular Checks
1. Monitor Khalti API status
2. Review error logs regularly
3. Test payment flow monthly
4. Update credentials if rotated by Khalti

### Production Deployment
1. Update `KHALTI_BASE_URL` to production: `https://khalti.com/api/v2/`
2. Update credentials to production keys
3. Test thoroughly in staging
4. Monitor payment failures closely
5. Have rollback plan ready

## References
- [Khalti Documentation](https://docs.khalti.com/)
- [Khalti Payment API](https://docs.khalti.com/#payment)
- [Khalti Merchant Dashboard](https://merchant.khalti.com/)

## Support
For issues or questions:
1. Check logs: `storage/logs/laravel-[date].log`
2. Review this documentation
3. Contact Khalti support: support@khalti.com
4. Review Laravel logs for any PHP errors
