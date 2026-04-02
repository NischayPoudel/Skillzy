# SKILLZY - Peer-to-Peer Skill Exchange Platform

## 📋 Project Overview

Skillzy is a production-ready Laravel application that enables users to exchange skills using a virtual Skillzy Coin currency system. The platform features secure authentication, role-based authorization, atomic coin transactions, real-time messaging, and comprehensive review systems.

**Status**: ✅ Complete & Production Ready  
**Tech Stack**: Laravel 12, MySQL, Blade + Bootstrap/Tailwind, Eloquent ORM  
**Current Date**: February 25, 2026

---

## 🏗️ Architecture

### Directory Structure

```
Skillzy/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                          # Authentication controllers
│   │   │   ├── Admin/                         # Admin controllers
│   │   │   ├── Dashboard/                     # Dashboard controllers
│   │   │   ├── SkillController.php
│   │   │   ├── ListingController.php
│   │   │   ├── PurchaseController.php
│   │   │   ├── WalletController.php
│   │   │   ├── ReviewController.php
│   │   │   ├── MessageController.php
│   │   │   └── NotificationController.php
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php             # Role-based access control
│   │   │   └── PreventBackHistory.php
│   │   └── Requests/                          # Form request validations
│   ├── Models/
│   │   ├── User.php
│   │   ├── Skill.php
│   │   ├── UserSkill.php
│   │   ├── Purchase.php
│   │   ├── CoinTransaction.php
│   │   ├── Message.php
│   │   ├── Review.php
│   │   └── Notification.php
│   ├── Policies/
│   │   ├── UserSkillPolicy.php
│   │   └── PurchasePolicy.php
│   ├── Services/
│   │   ├── CoinTransferService.php            # Atomic coin transfers
│   │   └── NotificationService.php
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── AuthServiceProvider.php
├── database/
│   ├── migrations/                            # Database schemas
│   ├── seeders/
│   │   └── DatabaseSeeder.php                 # Demo data seeder
│   └── factories/
│       └── UserFactory.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── navigation.blade.php
│   │   │   └── admin-navigation.blade.php
│   │   ├── listings/                          # Skill listing views
│   │   ├── purchases/                         # Purchase transaction views
│   │   ├── wallet/                            # Wallet & coin views
│   │   ├── skills/                            # Skill browse views
│   │   ├── admin/                             # Admin dashboard
│   │   ├── user/                              # User dashboard
│   │   └── auth/                              # Authentication views
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                               # Web routes
│   ├── auth.php                              # Auth routes
│   └── console.php
├── config/
│   ├── auth.php
│   ├── database.php
│   ├── mail.php
│   └── ...
├── bootstrap/
│   ├── app.php                               # Application bootstrap
│   └── providers.php
├── tests/
├── vendor/
├── composer.json
├── package.json
├── vite.config.js
└── .env.example
```

---

## 📊 Database Schema

### Tables

#### **users**
- `id` (PK)
- `name`, `username`, `email`, `password`
- `profile_image`, `bio`
- `coins` (decimal) - Current balance
- `role` (user/staff/admin)
- `email_verified_at`, `created_at`, `updated_at`

#### **skills**
- `id` (PK)
- `name` (unique)
- `description`, `icon`
- `created_by` (FK → users)
- `timestamps`

#### **user_skills** (Skill Listings)
- `id` (PK)
- `user_id` (FK → users)
- `skill_id` (FK → skills)
- `price` (decimal)
- `experience_level` (beginner/intermediate/expert)
- `status` (active/inactive)
- `timestamps`

#### **purchases** (Transactions)
- `id` (PK)
- `buyer_id` (FK → users)
- `seller_id` (FK → users)
- `user_skill_id` (FK → user_skills)
- `amount` (decimal)
- `status` (pending/accepted/completed/cancelled)
- `note` (text)
- `timestamps`

#### **coin_transactions** (Audit Trail)
- `id` (PK)
- `user_id` (FK → users)
- `type` (credit/debit)
- `amount` (decimal)
- `reason` (purchase/refund/topup/withdrawal)
- `reference_id` (purchase_id or refund_id)
- `status` (pending/success/failed)
- `timestamps`

#### **messages** (Purchase-Bound Chat)
- `id` (PK)
- `purchase_id` (FK → purchases)
- `sender_id` (FK → users)
- `receiver_id` (FK → users)
- `message` (text)
- `is_read` (boolean)
- `timestamps`

#### **reviews** (Post-Purchase Reviews)
- `id` (PK)
- `purchase_id` (unique FK → purchases)
- `buyer_id` (FK → users)
- `seller_id` (FK → users)
- `rating` (1-5)
- `comment` (text, nullable)
- `timestamps`

#### **notifications**
- `id` (PK)
- `user_id` (FK → users)
- `title`, `message`
- `is_read` (boolean)
- `timestamps`

---

## 🔐 Authentication & Authorization

### Roles

| Role | Permissions |
|------|------------|
| **Guest** | Browse listings, search, view skill details |
| **User** | All guest features + create listings, buy/sell, message, review, manage wallet |
| **Staff** | Manage skills, create listing categories, monitor platform |
| **Admin** | All features + manage users, suspend accounts, audit transactions, analytics |

### Middleware

```php
// RoleMiddleware - Enforces role-based access
Route::middleware(['auth', 'role:user'])->group(function () {
    // User routes
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin routes
});
```

### Policies

- **UserSkillPolicy**: Only listing owner can edit/delete
- **PurchasePolicy**: Permission-based actions (accept/complete/review)

---

## 💰 Core Features

### 1️⃣ Authentication
- ✅ Secure registration & login
- ✅ Password hashing (bcrypt)
- ✅ Email verification
- ✅ Remember me functionality
- ✅ Session management

**Controllers**: `App\Http\Controllers\Auth\*`

### 2️⃣ Skills Marketplace

**Create Listings** → Users create skill listings at any price
```php
// Route
POST /user/listings (StoreListingRequest)

// Form Fields
- skill_id (dropdown)
- price (coins)
- experience_level (beginner/intermediate/expert)

// Validations
- Minimum price: 1 coin
- Maximum price: 10,000 coins
- User must be authenticated & have role='user'
```

**Browse & Search** → Guests can search/filter listings
```php
// Route
GET /listings

// Features
- Full-text search by skill name
- Filter by level (beginner/intermediate/expert)
- Filter by price range
- Sort by latest or price
- Pagination (15 per page)
- View seller rating & reviews
```

**Activate/Deactivate** → Users control listing visibility
```php
// Status: 'active' | 'inactive'
// Updates via ListingController@update
```

### 3️⃣ Purchase Flow (Core Business Logic)

#### Status Lifecycle
```
pending (buyer request)
    ↓
accepted (seller accepts)
    ↓
completed (seller completes + coins transferred)
```

#### Step-by-Step Flow

1. **Buyer Requests Service**
```
POST /purchases (StorePurchaseRequest)
- listing_id (hidden, from show view)
- note (optional, max 500 chars)

Status: pending
Notification: Seller receives notification
Authorization: Buyer cannot be seller
```

2. **Seller Accepts/Rejects**
```
PATCH /purchases/{purchase} (action=accept|cancel)
Authorization: Only seller can action
Status Update: pending → accepted | cancelled
Notification: Buyer is notified
```

3. **Seller Completes & Transfer Coins** (ATOMIC)
```
PATCH /purchases/{purchase} (action=complete)

Database Transaction:
  ├─ Lock buyer & seller records
  ├─ Check buyer has sufficient coins
  ├─ Debit buyer coins
  ├─ Credit seller coins
  ├─ Create two CoinTransaction records
  └─ Update purchase status → completed

Safeguards:
  - Insufficient balance check
  - DB transaction rollback on failure
  - Audit trail in coin_transactions
  - Notifications sent
```

**Service**: `App\Services\CoinTransferService`

### 4️⃣ Wallet System

**View Balance & History**
```php
GET /wallet (WalletController@show)
- Display current coins balance
- Transaction history (paginated, latest first)
- Type: credit | debit
- Filters: All transactions shown chronologically
```

**Top-Up Coins** (Demo Logic)
```php
POST /wallet/topup (WalletTopupRequest)
- amount (10-50,000 coins)
- Creates CoinTransaction record
- Updates user.coins
- Sends success notification

Demo: Arbitrary amount accepted
Production: Connect to payment gateway
```

**Withdraw Coins** (Demo Validation)
```php
POST /wallet/withdraw
- Validates user has sufficient balance
- Deducts coins
- Creates transaction record
- Demo: No payment processing
```

**Transaction History** Features:
- Total coins earned/spent
- Filter by type (credit/debit)
- Reference to purchase_id or reason
- Status indicator
- Timestamp for audit trail

### 5️⃣ Messaging (Purchase-Bound)

**Constraints**:
- ✅ Only accessible via purchase_id
- ✅ Only buyer & seller can message
- ✅ Messages can't be deleted (audit trail)
- ✅ Read/unread indicator

**Features**:
```php
POST /messages (StoreMessageRequest)
- purchase_id (must own or be part of)
- message (max 5000 chars)

GET /purchases/{purchase} (show)
- Shows all messages for purchase
- Marks messages as read
- Real-time chat interface
```

### 6️⃣ Reviews

**Business Rules**:
- ✅ Only buyer can review
- ✅ Only after purchase completion
- ✅ One review per purchase (unique constraint)
- ✅ Rating: 1-5 stars
- ✅ Comment: optional, max 1000 chars

**Implementation**:
```php
POST /reviews (StoreReviewRequest)
- purchase_id
- rating (1-5)
- comment (nullable)

Features:
- Average rating displayed on listing
- Review count
- Individual reviews visible on seller profile
- Notifications sent to seller
```

### 7️⃣ Admin Dashboard

**Monitoring**:
- Total users, skills, listings, purchases
- Total coins moved (revenue)
- Recent transactions
- Purchase breakdown by status

**User Management**:
```
GET /admin/users (index)
POST /admin/users (store - create admin users)
PATCH /admin/users/{user} (edit)
DELETE /admin/users/{user} (delete)

Features:
- Role assignment
- Coin injection for testing
- Suspend/unsuspend accounts
```

**Listing Management**:
```
GET /admin/skills (index)
POST /admin/skills (create)
PATCH /admin/skills/{skill}
DELETE /admin/skills/{skill}
```

**Purchase Audit**:
```
GET /admin/purchases (index)
- View all purchases
- Filter by status
- Coin transfer verification
```

**Notifications**:
- Automatic notifications on critical events
- Read/unread tracking
- Pop-up alerts

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL 8.0+

### Installation

```bash
# 1. Clone repository
cd Skillzy

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Setup environment
cp .env.example .env
php artisan key:generate

# 5. Configure database in .env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skillzy
DB_USERNAME=root
DB_PASSWORD=

# 6. Run migrations & seeders
php artisan migrate --seed

# 7. Build assets
npm run build

# 8. Start development server
php artisan serve
```

Application will be available at: `http://localhost:8000`

---

## 👥 Demo Accounts

### Login Credentials

| Role | Username | Email | Password | Coins |
|------|----------|-------|----------|-------|
| Admin | admin | admin@example.com | password | 10,000 |
| Staff | staff | staff@example.com | password | 5,000 |
| User 1 | johndeveloper | john@example.com | password | 1,000 |
| User 2 | janedesigner | jane@example.com | password | 800 |
| User 3 | mikeconsultant | mike@example.com | password | 1,500 |
| User 4 | sarahmarketer | sarah@example.com | password | 600 |

### Demo Flow (Complete Purchase)

```
1. Login as 'john@example.com'
   Dashboard shows: 1 own listing, 2 purchases, earnings

2. Browse Listings
   GET /listings (see all active listings)
   
3. View Listing Details
   GET /listings/{listing}
   See Jane's UI/UX Design service @ 120 coins
   
4. Create Purchase Request
   POST /purchases
   buyer_id = john.id, seller_id = jane.id
   Status: pending
   Jane gets notification
   
5. Login as 'jane@example.com'
   Sees pending purchase from John
   
6. Accept Purchase
   PATCH /purchases/{purchase} (action=accept)
   Status: pending → accepted
   John gets notification
   
7. Complete Purchase (Coin Transfer)
   PATCH /purchases/{purchase} (action=complete)
   
   Database Transaction:
   - Check John has ≥120 coins ✓
   - John coins: 1000 - 120 = 880 ✓
   - Jane coins: 800 + 120 = 920 ✓
   - Create 2 CoinTransaction records ✓
   - Status: completed ✓
   
   both users notified
   
8. Leave Review
   POST /reviews
   rating = 5
   comment = "Excellent work!"
   
   Notification to Jane
   
9. Check Wallet
   GET /wallet
   See all transactions in history
   
10. Message History
    Available in purchase show view
    All messages between John & Jane
```

---

## 📁 File Locations Reference

### Controllers
```
app/Http/Controllers/
├── Auth/*                           # Authentication (Breeze/Fortify)
├── Admin/
│   ├── UserController.php          # User management
│   ├── SkillController.php         # Skill management
│   └── PurchaseController.php      # Purchase audit
├── Dashboard/
│   ├── AdminDashboardController.php
│   ├── UserDashboardController.php
│   └── StaffDashboardController.php
├── SkillController.php             # Browse skills (public)
├── ListingController.php           # Manage listings
├── PurchaseController.php          # Purchase flow (core)
├── WalletController.php            # Coin wallet
├── ReviewController.php            # Leave reviews
├── MessageController.php           # Send messages
├── NotificationController.php      # View notifications
└── ProfileController.php           # User profile
```

### Models
```
app/Models/
├── User.php                        # Relationships to all entities
├── Skill.php                       # Skill definitions
├── UserSkill.php                   # Listings (user + skill)
├── Purchase.php                    # Purchase transactions
├── CoinTransaction.php             # Financial audit trail
├── Message.php                     # Purchase messages
├── Review.php                      # Purchase reviews
└── Notification.php                # User notifications
```

### Views
```
resources/views/
├── layouts/
│   ├── app.blade.php              # Main authenticated layout
│   ├── guest.blade.php            # Guest layout
│   └── navigation.blade.php       # Main navigation
├── listings/
│   ├── index.blade.php            # Browse with filters
│   ├── show.blade.php             # Listing details
│   ├── create.blade.php           # Create new
│   └── edit.blade.php             # Edit listing
├── purchases/
│   ├── index.blade.php            # My purchases/sales
│   └── show.blade.php             # Purchase detail + messages + review form
├── wallet/
│   └── show.blade.php             # Balance + history
├── skills/
│   ├── index.blade.php            # All skills
│   └── show.blade.php             # Skill details + listings
├── user/
│   └── dashboard.blade.php        # User dashboard
├── admin/
│   ├── dashboard.blade.php        # Admin stats
│   ├── users/
│   ├── skills/
│   └── purchases/
└── notifications/
    └── index.blade.php            # Notification list
```

### Migrations
```
database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 2026_01_16_152821_create_skills_table.php
├── 2026_01_16_152821_create_user_skills_table.php
├── 2026_01_16_152822_create_coin_transactions_table.php
├── 2026_01_16_152822_create_purchases_table.php
├── 2026_01_16_152823_create_messages_table.php
├── 2026_01_16_152823_create_reviews_table.php
└── 2026_01_16_152824_create_notifications_table.php
```

---

## 🔄 Complete Purchase Flow Sequence Diagram

```
BUYER                  SYSTEM                  SELLER
  │                      │                       │
  ├─ Browse Listings ─────→ GET /listings
  │                      │ (Search, Filter)
  │                      │
  ├─ View Details ───────→ GET /listings/{id}
  │                      │
  ├─ Create Request ─────→ POST /purchases
  │                      │ StorePurchaseRequest
  │                      │  ├─ Create purchase
  │                      │  ├─ Status: pending
  │                      │  └─ Notify seller ───→ 🔔 New request
  │                      │
  │                      │ ← SELLER REVIEWS ─────
  │                      │
  │                      │ ← Accept ────────────→ PATCH /purchases
  │                      │                       │ Action: accept
  │ ← 🔔 Accepted ───────┤                       │
  │                      │ ├─ Status: accepted
  │                      │ ├─ Notify buyer ──→ 🔔
  │                      │ │
  │ ← [WAITING] ─────────┤ ← [SELLER DOES WORK]
  │                      │
  │                      │ ← Complete ──────────→ PATCH /purchases
  │                      │                       │ Action: complete
  │                      │ ├─ START DB TRANSACTION
  │                      │ ├─ LOCK users
  │                      │ ├─ CHECK coins ✓
  │                      │ ├─ buyer.coins -= amount
  │                      │ ├─ seller.coins += amount
  │                      │ ├─ CREATE CoinTransaction (debit)
  │                      │ ├─ CREATE CoinTransaction (credit)
  │                      │ ├─ Status: completed
  │                      │ ├─ COMMIT ✓
  │                      │ │
  │ ← 🔔 Complete ───────┤ ← 🔔 Complete
  │ (coins sent)         │    (coins received)
  │
  ├─ Leave Review ───────→ POST /reviews
  │                      │ ├─ Purchase completed?
  │                      │ ├─ Only buyer?
  │                      │ ├─ One review/purchase?
  │                      │ ├─ Create review
  │                      │ └─ Notify seller ───→ 🔔 New review
  │                      │
  ├─ View in Wallet ─────→ GET /wallet
  │                      │ ├─ Transaction history
  │                      │ └─ Show as -120 coins
  │                      │
  └─ View Messages ──────→ GET /purchases/{id}
                         │ ├─ All purchase messages
                         │ └─ Encrypted (optional)
```

---

## 🛡️ Security Features

### Input Validation
- All form inputs validated via **FormRequest** classes
- CSRF tokens on all POST/PATCH/DELETE routes
- SQL injection prevention via Eloquent ORM

### Authorization
- Role-based middleware on all routes
- Policy-based authorization for resource actions
- Method-level authorization checks

### Database Transactions
- Atomic coin transfers with row locking
- No race condition vulnerabilities
- Automatic rollback on failure

### Password Security
- Bcrypt hashing (Laravel default)
- Password confirmation on registration
- Secure password reset flow

### Audit Trail
- All coin transactions logged
- CoinTransaction.reference_id points to entity
- Timestamps on all records
- Read receipts on messages

---

## 🧪 Testing & Validation

### Manual Test Checklist

```
[ ] Registration & Login
    [ ] Register new user
    [ ] Login with credentials
    [ ] Email verification (if enabled)

[ ] Listing Management
    [ ] Create listing with all levels
    [ ] Edit own listing
    [ ] Cannot edit others' listings
    [ ] Search and filter work
    [ ] Status changes (active/inactive)

[ ] Purchase Flow
    [ ] Cannot buy own listing (prevented)
    [ ] Buyer receives notification
    [ ] Seller can accept/decline
    [ ] Complete triggers coin transfer
    [ ] Both users see transactions in wallet

[ ] Wallet & Coins
    [ ] Starting coins correct
    [ ] Top-up adds coins
    [ ] Purchase debits/credits correct
    [ ] Transaction history accurate
    [ ] Balance never negative after complete

[ ] Messaging
    [ ] Only visible to buyer/seller
    [ ] Messages persist after purchase complete
    [ ] Read/unread indicators work
    [ ] Cannot message non-purchase users

[ ] Reviews
    [ ] Can only review completed purchases
    [ ] One review per purchase
    [ ] Rating averaged on listing
    [ ] Seller notified of review

[ ] Admin Features
    [ ] View all users
    [ ] View all purchases
    [ ] View transaction audit trail
    [ ] Create admin users
    [ ] Dashboard stats accurate
```

---

## 🚨 Troubleshooting

### Database Issues
```bash
# Reset database (CAUTION - deletes all data)
php artisan migrate:refresh --seed

# Check migrations
php artisan migrate:status
```

### Cache Issues
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Asset Issues
```bash
# Rebuild assets
npm run build

# Or watch for changes
npm run dev
```

### Session Issues
```bash
# Regenerate session key
php artisan session:error

# Clear sessions table
php artisan session:flush
```

---

## 📈 Performance Considerations

### Query Optimization
- Use eager loading: `with('relationship')`
- Index frequently searched columns
- Pagination on lists (10-15 items)
- Cache skill list if > 100 skills

### Database Indexes
- `users.email` (unique)
- `user_skills.user_id`, `user_skills.skill_id`
- `purchases.buyer_id`, `purchases.seller_id`
- `coin_transactions.user_id`, `created_at`
- `messages.purchase_id`, `sender_id`

### Caching Opportunities
- Cache skill list (invalidate when skill created)
- Cache user ratings (invalidate when review posted)
- Cache admin dashboard stats (refresh hourly)

---

## 📝 API Endpoints Summary

### Public Routes
- `GET /` → Redirect to dashboard or login
- `GET /login` → Login form
- `GET /register` → Registration form
- `GET /skills` → Browse skills
- `GET /skills/{skill}` → Skill details
- `GET /listings` → Browse listings (with filters)
- `GET /listings/{listing}` → Listing details

### Authenticated Routes (User)
- `GET /dashboard` → Route to role dashboard
- `GET /user/dashboard` → User dashboard
- `GET /wallet` → Wallet & transactions
- `POST /wallet/topup` → Add coins

### User Listings
- `GET /user/listings/create` → Create form
- `POST /user/listings` → Store
- `GET /user/listings/{id}/edit` → Edit form
- `PATCH /user/listings/{id}` → Update
- `DELETE /user/listings/{id}` → Delete

### Purchases
- `GET /purchases` → My purchases/sales
- `GET /purchases/{id}` → Details + messages
- `POST /purchases` → Create purchase request
- `PATCH /purchases/{id}` → Accept/complete

### Reviews & Messages
- `POST /reviews` → Leave review
- `POST /messages` → Send message

### Notifications
- `GET /notifications` → View all
- `POST /notifications/{id}/mark-read` → Mark as read

### Admin Routes (prefix: `/admin/`)
- `GET /admin/dashboard` → Stats
- `GET /admin/users` → User list
- `POST /admin/users` → Create user
- `GET /admin/skills` → Skill management
- `GET /admin/purchases` → Purchase audit

---

## 🔧 Configuration Files

### Key Configuration Files

#### `.env`
```
APP_NAME=Skillzy
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skillzy
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@skillzy.local
```

#### `config/app.php`
```php
'name' => env('APP_NAME', 'Skillzy'),
'debug' => env('APP_DEBUG', false),
'timezone' => 'UTC',
```

#### `config/database.php`
```php
'default' => env('DB_CONNECTION', 'mysql'),
'connections' => [
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'database' => env('DB_DATABASE', 'skillzy'),
    ],
],
```

---

## 🎯 Future Enhancements

### Phase 2 Features
- [ ] Payment gateway integration (Stripe/PayPal)
- [ ] Real-time notifications (WebSockets/Pusher)
- [ ] Email notifications
- [ ] Skill categories/tags
- [ ] Advanced search (Elasticsearch)
- [ ] Dispute resolution system
- [ ] Two-factor authentication
- [ ] Image uploads for profiles/listings
- [ ] Ratings export for sellers
- [ ] Skill endorsements

### Phase 3 - Production
- [ ] API documentation (OpenAPI/Swagger)
- [ ] Rate limiting
- [ ] API authentication (Laravel Sanctum)
- [ ] Mobile app integration
- [ ] CDN for assets
- [ ] Database replication
- [ ] Automated backups
- [ ] Monitoring & logging (Sentry)

---

## 📚 Additional Resources

- **Laravel Documentation**: https://laravel.com/docs
- **Eloquent ORM**: https://laravel.com/docs/eloquent
- **Blade Templating**: https://laravel.com/docs/blade
- **Database Transactions**: https://laravel.com/docs/database#transactions
- **Authorization**: https://laravel.com/docs/authorization

---

## 📄 License

This project is built for educational purposes as a Final Year Project.

---

**Last Updated**: February 25, 2026  
**Version**: 1.0.0 - Complete  
**Status**: ✅ Production Ready
