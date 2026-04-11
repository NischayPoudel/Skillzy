# Email Setup & Verification Guide

## ✅ Completed Configuration

### 1. Environment Variables (.env)
- **MAIL_MAILER**: smtp (Gmail SMTP)
- **MAIL_HOST**: smtp.gmail.com
- **MAIL_PORT**: 587
- **MAIL_USERNAME**: nischaypoudel.nick@gmail.com
- **MAIL_PASSWORD**: aomu wdvb kdgg pwjm
- **MAIL_FROM_ADDRESS**: nischaypoudel.nick@gmail.com

### 2. User Model (app/Models/User.php)
- ✅ Implemented `MustVerifyEmail` interface
- Email verification is now required

### 3. Routes (routes/auth.php)
- ✅ Email verification routes configured
- ✅ Password reset routes added:
  - `GET /forgot-password` - Show forgot password form
  - `POST /forgot-password` - Send password reset link
  - `GET /reset-password/{token}` - Show password reset form
  - `POST /reset-password` - Update password

## 📧 Features Enabled

### Email Verification During Registration
1. User registers with email
2. Verification email is automatically sent
3. User must verify email before accessing app
4. Access verification routes:
   - `GET /verify-email` - Verification notice
   - `GET /verify-email/{id}/{hash}` - Verify email link
   - `POST /email/verification-notification` - Resend verification email

### Forgot Password
1. User clicks "Forgot Password"
2. Enters their email address
3. Receives password reset link
4. Clicks link to reset password
5. Sets new password

## 🔧 Next Steps

### Before Testing
1. **Run migrations** to ensure database is ready:
   ```bash
   php artisan migrate
   ```

2. **Clear cache** to ensure new configuration is loaded:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Create mailable notifications** (if not already created):
   ```bash
   php artisan make:mail VerifyEmailMailable
   php artisan make:mail ResetPasswordMailable
   ```

### Testing Email Functionality

#### Test Registration & Email Verification
1. Go to `/register`
2. Fill in the form with test data
3. You should receive a verification email to `nischaypoudel.nick@gmail.com`
4. Check spam folder if not in inbox
5. Click the verification link in the email

#### Test Password Reset
1. Go to `/forgot-password`
2. Enter the test email
3. You should receive a password reset email
4. Click the reset link
5. Set a new password

## ⚙️ Gmail App Password Setup

The password in your .env (`aomu wdvb kdgg pwjm`) appears to be a Gmail App Password.

**If you haven't set it up yet:**
1. Go to [Google Account Security](https://myaccount.google.com/security)
2. Enable 2-Factor Authentication
3. Go to "App passwords"
4. Select "Mail" and "Windows Computer"
5. Copy the 16-character password
6. Update `MAIL_PASSWORD` in `.env`

## 📋 File Changes Made

1. `.env` - Updated mail configuration
2. `app/Models/User.php` - Implemented MustVerifyEmail interface
3. `routes/auth.php` - Added password reset routes

## 🚀 Production Considerations

- Ensure `APP_ENV=production` on production
- Use HTTPS for all email links
- Consider email rate limiting (already configured with `throttle:6,1`)
- Monitor email delivery logs in `storage/logs/laravel.log`

## Troubleshooting

If emails aren't sending:
1. Check `.env` file for correct credentials
2. Run `php artisan tinker` and test:
   ```php
   Mail::raw('Test', function($msg) { $msg->to('nischaypoudel.nick@gmail.com'); });
   ```
3. Check `storage/logs/laravel.log` for errors
4. Verify Gmail allows less secure apps or that app password is set
5. Try `MAIL_MAILER=log` temporarily to see if emails are being queued
