# Skillzy - Quick Start Guide

## Getting Started (5 minutes)

### Prerequisites
- PHP 8.1+ installed
- MySQL 8.0+ running
- Composer installed

### Quick Setup

1. **Navigate to project**
```bash
cd C:\Users\LENOVO\Desktop\Skillzy
```

2. **Start the server**
```bash
php artisan serve
```
The app will be running at: **http://127.0.0.1:8000**

3. **Login with demo account**
- Email: `admin@example.com`
- Password: `password`

**Done!** The app is ready to use with pre-populated demo data.

## Demo Accounts Available

| Name | Email | Password | Role | Coins |
|------|-------|----------|------|-------|
| Admin User | admin@example.com | password | Admin | 10,000 |
| Staff Member | staff@example.com | password | Staff | 5,000 |
| John Developer | john@example.com | password | User | 1,000 |
| Jane Designer | jane@example.com | password | User | 800 |
| Mike Consultant | mike@example.com | password | User | 1,500 |
| Sarah Marketer | sarah@example.com | password | User | 600 |

## Key Features to Try

### For Users
1. ✅ **Browse Skills** - Go to home page, scroll to see all available skills
2. ✅ **Browse Listings** - Click "Listings" to see user-created listings with filters
3. ✅ **Create Listing** - Click "Dashboard" → "Create Listing" to offer your own skill
4. ✅ **Request Service** - View a listing and click "Request Service"
5. ✅ **Messaging** - Go to Purchases and chat with buyer/seller
6. ✅ **Leave Review** - Complete a purchase and submit a review (1-5 stars)
7. ✅ **Wallet** - Top up coins and view transaction history
8. ✅ **Notifications** - See all your activity notifications

### For Admin
1. ✅ **Create Skills** - Go to Skills → Create to add marketplace skills
2. ✅ **Admin Dashboard** - View platform statistics and revenue
3. ✅ **Edit Skills** - Manage existing skills

### For Staff
1. ✅ **Staff Dashboard** - View platform analytics

## Important Routes

| Page | URL | Access |
|------|-----|--------|
| Home | `/` | Public |
| Skills | `/skills` | Public |
| Listings | `/listings` | Public |
| Dashboard | `/dashboard` | Auth Required |
| Wallet | `/wallet` | Auth Required |
| Purchases | `/purchases` | Auth Required |
| Notifications | `/notifications` | Auth Required |

## Testing Purchase Flow

1. **Login as John Developer** (john@example.com)
2. **Go to Listings** (/listings)
3. **Find Jane Designer's "UI/UX Design" listing** ($120)
4. **Click "Request Service"**
5. **Switch to Jane's account** (jane@example.com)
6. **Go to Purchases** - See John's pending request
7. **Click "Accept"** to accept the request
8. **Switch back to John**
9. **Go to Purchases** - Click on the purchase
10. **Complete the purchase** - Coins will transfer atomically
11. **Leave a Review** - Rate and comment on the service
12. **Both users get Notifications** - Check notifications to see events

## Database Reset

If you want to reset all data and start fresh:

```bash
php artisan migrate:refresh --seed
```

This will:
- Drop all tables
- Run all migrations (creating fresh schema)
- Seed demo data again

## Troubleshooting

### Server won't start
```bash
# Check if port 8000 is available
# Try different port:
php artisan serve --port=8001
```

### Database errors
```bash
# Ensure MySQL is running and .env is configured
# Then run:
php artisan migrate:refresh --seed
```

### Assets not loading
```bash
# Compile assets
npm run dev
```

## File Structure Overview

```
app/
├── Http/Controllers/ - 10 controllers for all features
├── Models/ - 8 eloquent models with relationships
└── Policies/ - Authorization rules

database/
├── migrations/ - 11 database schema files
└── seeders/ - Demo data seeder

resources/views/ - 19 Blade templates for UI

routes/web.php - All application routes
```

## What's Implemented

✅ Complete skill marketplace
✅ User authentication & authorization
✅ Purchase requests with coin transfers
✅ In-app messaging system
✅ Reviews and ratings (1-5 stars)
✅ Wallet with top-up functionality
✅ Transaction history tracking
✅ Notification system
✅ Role-based access (User, Staff, Admin)
✅ Advanced search & filtering
✅ Safe concurrent coin transfers (row locking)
✅ IDOR prevention (Policy-based auth)
✅ Form validation on all inputs
✅ Responsive Bootstrap UI

## Code Highlights

### Safe Coin Transfer
```php
// Atomic transfer with row locking prevents race conditions
DB::transaction(function () {
    $buyer = User::lockForUpdate()->find($buyerId);
    $seller = User::lockForUpdate()->find($sellerId);
    // Both user records locked during update
    // All-or-nothing execution
});
```

### IDOR Prevention
```php
// Policies enforce authorization
$this->authorize('update', $purchase);
// Returns 403 if user doesn't own/aren't involved in purchase
```

### Advanced Filtering
```
// Listings support multiple filters at once
/listings?skill=PHP&level=expert&price_min=100&price_max=500&sort=price_asc
```

## Production Checklist

- [ ] Update .env with production database
- [ ] Set APP_DEBUG=false
- [ ] Set APP_ENV=production
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Seed demo data: `php artisan seed --force`
- [ ] Build assets: `npm run build`
- [ ] Configure mail (for notifications)
- [ ] Set up backups

## Next Steps

1. Explore the codebase in `/app` directory
2. Check out routes in `/routes/web.php`
3. Review models for relationship examples
4. Study controllers for business logic
5. Examine views for Blade patterns
6. Read IMPLEMENTATION_SUMMARY.md for detailed info

## Support

- Laravel Docs: https://laravel.com/docs
- Blade Docs: https://laravel.com/docs/blade
- Eloquent Docs: https://laravel.com/docs/eloquent

## Key Files to Review

| File | Purpose |
|------|---------|
| `app/Http/Controllers/PurchaseController.php` | Coin transfer logic |
| `app/Policies/UserSkillPolicy.php` | Authorization example |
| `routes/web.php` | All application routes |
| `database/seeders/DatabaseSeeder.php` | Demo data |
| `resources/views/purchases/show.blade.php` | Complex template example |

---

**Enjoy exploring Skillzy!** 🚀
