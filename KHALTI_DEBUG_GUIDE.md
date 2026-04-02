# Khalti Payment - 302 Redirect Error Fix

## Issue Description
When trying to submit the wallet top-up form, you're getting a **302 Found** redirect back to `/wallet` instead of being redirected to Khalti for payment.

## Root Cause
The 302 redirect means the form submission is failing and being redirected back. This is usually caused by:
1. Khalti API credentials not working
2. Network connectivity issues
3. API response format issues

## Troubleshooting Steps

### Step 1: Check Logs
Look at the Laravel logs to see what error occurred:

```bash
# On Windows with Git Bash or PowerShell
tail -f storage/logs/laravel.log

# Or view the latest entries
Get-Content storage/logs/laravel.log -Tail 50
```

Look for entries with:
- `Khalti Payment Initiation Request`
- `Khalti Payment Raw Response`
- `Khalti Service Error - Payment Initiation`

### Step 2: Test Khalti API Connectivity (Debug Route)

1. Make sure you're in **debug mode** and go to:
```
http://127.0.0.1:8000/debug/khalti
```

2. This will show you:
   - If the API is reachable
   - What response you're getting
   - Khalti configuration status

3. Expected successful response:
```json
{
  "status": "debug_test",
  "khalti_response": {
    "success": true,
    "pidx": "GhKc41A916271T070T070733...",
    "payment_url": "https://dev.khalti.com/epayment/initiate/..."
  },
  "config": {
    "base_url": "https://dev.khalti.com/api/v2/",
    "merchant_code": "SKILLZY",
    "has_secret_key": true,
    "has_public_key": true
  }
}
```

### Step 3: Verify Configuration

Check your `.env` file has correct Khalti settings:

```bash
KHALTI_PUBLIC_KEY=your_key_here
KHALTI_SECRET_KEY=your_secret_here
KHALTI_MERCHANT_CODE=SKILLZY
KHALTI_BASE_URL=https://dev.khalti.com/api/v2/
PAYMENT_MODE=khalti
```

### Step 4: Restart Laravel Server

If you made any configuration changes:

```bash
# Stop the server (Ctrl+C)

# Clear configuration cache
php artisan config:clear
php artisan cache:clear

# Restart the server
php artisan serve
```

### Step 5: Check Internet Connection

Make sure your server can reach Khalti:

```bash
# Test connectivity to Khalti
ping dev.khalti.com

# Or try a simple HTTP request
curl -X GET https://dev.khalti.com/
```

## Common Error Solutions

### Error 1: "Invalid response from Khalti API"
**Cause:** API returned invalid JSON or an error
**Solution:**
- Check if Khalti API is up and running
- Verify your secret key is correct
- Check if merchant code is valid

### Error 2: "Permission denied" or "Unauthorized"
**Cause:** Khalti secret key is incorrect
**Solution:**
- Go to https://merchant.khalti.com/
- Get a fresh secret key
- Update `.env` with correct key
- Run `php artisan config:clear`

### Error 3: "No PIDX in response"
**Cause:** API returned a response but not a valid payment initiation
**Solution:**
- Check the debug route response
- Look at the full API response in logs
- Verify all required fields are being sent

### Error 4: "Network unreachable"
**Cause:** Your server can't reach Khalti servers
**Solution:**
- Check internet connectivity
- Verify firewall isn't blocking outgoing HTTPS
- Try the ping/curl tests above

## What Each Component Does

### Frontend (wallet form)
- Collects amount from user
- Validates with HTML5 number input
- Submits via POST to `/wallet/topup`

### Backend (WalletController::topup)
- Validates amount using Laravel rules
- Calls KhaltiService::initiatePayment()
- If success: Stores PIDX in session → Redirects to Khalti
- If failure: Redirects back with error message

### KhaltiService::initiatePayment
- Creates payment request payload
- Sends POST request to Khalti API
- Parses JSON response
- Returns success array or error

## Testing Without Real API

If you need to test without real Khalti API:

### Option 1: Mock the Service
Create a test version that returns fake data:

```php
// In config/services.php or .env
KHALTI_MODE=mock  // or 'real'

// Then in KhaltiService::initiatePayment
if (config('services.khalti.mode') === 'mock') {
    return [
        'success' => true,
        'pidx' => 'test_' . time(),
        'payment_url' => route('wallet.callback') . '?pidx=test_' . time() . '&status=Completed',
    ];
}
```

### Option 2: Use Khalti Sandbox
- Create account at https://merchant.khalti.com/
- Get sandbox credentials
- Use development credentials in `.env`
- Use https://dev.khalti.com/api/v2/ endpoint (already configured)

## Production Considerations

Before deploying to production:

1. **Update Khalti Base URL**
   ```
   KHALTI_BASE_URL=https://khalti.com/api/v2/
   ```

2. **Use Production Credentials**
   - Get from Khalti merchant dashboard
   - Update `KHALTI_SECRET_KEY` and `KHALTI_PUBLIC_KEY`

3. **Remove Debug Route**
   - Delete or disable `/debug/khalti` route
   - Make sure `APP_DEBUG=false` in production

4. **Monitor Logs**
   - Set up log rotation
   - Monitor for payment failures
   - Alert on errors

## Quick Fixes Checklist

- [ ] Check `.env` has all Khalti credentials
- [ ] Run `php artisan config:clear && php artisan cache:clear`
- [ ] Restart Laravel server
- [ ] Test `/debug/khalti` endpoint
- [ ] Check `storage/logs/laravel.log` for errors
- [ ] Verify internet connectivity
- [ ] Try different amount values
- [ ] Check if merchant code is set correctly

## Still Having Issues?

If the debug route shows:

1. **`success: true`** → API is working! Check logs for why form submission fails
2. **`success: false`** → Check the error message returned
3. **Connection timeout** → Network issue or firewall blocking
4. **Invalid JSON** → API returned HTML error page instead of JSON

## Disable Debug Route in Production

Add this to remove the debug route:

```php
// In routes/web.php - wrap debug route
if (config('app.debug')) {
    Route::get('/debug/khalti', ...);
}
```

Or delete this section entirely before deploying to production.

## Support Resources

- Khalti Docs: https://docs.khalti.com/
- Merchant Dashboard: https://merchant.khalti.com/
- Laravel HTTP Client: https://laravel.com/docs/http-client
