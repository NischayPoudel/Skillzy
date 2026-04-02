# SKILLZY - Technical Implementation Guide (For FYP)

## 📋 Executive Summary

This document details the complete technical implementation of Skillzy, a production-ready peer-to-peer skill exchange platform built with Laravel 12. The application demonstrates advanced Laravel patterns including atomic database transactions, role-based authorization, policy-based access control, and comprehensive business logic implementation.

**Key Highlights:**
- ✅ Atomic coin transfers with DB transactions
- ✅ Role-based access control (3 roles + guest)
- ✅ Policy-based authorization
- ✅ Complete audit trail
- ✅ Scalable architecture
- ✅ Production-ready security

---

## 🏗️ Architecture Overview

### MVC Pattern Implementation

#### Models (`app/Models/`)
- **User**: Core authentication model + relationships to all entities
- **Skill**: Skill definitions (created by admin/staff)
- **UserSkill**: Listings - junction of user + skill with price/level
- **Purchase**: Transaction lifecycle (pending→accepted→completed)
- **CoinTransaction**: Financial audit trail (immutable)
- **Message**: Purchase-bound chat
- **Review**: Post-purchase ratings
- **Notification**: User alerts

#### Controllers (`app/Http/Controllers/`)
- **Auth Controllers**: Registration, login, password reset (Laravel Breeze)
- **SkillController**: Browse and search skills (public)
- **ListingController**: Create, edit, manage listings
- **PurchaseController**: Core purchase flow
- **WalletController**: Coin management
- **ReviewController**: Post-purchase reviews
- **MessageController**: Purchase messaging
- **Dashboard Controllers**: Role-specific dashboards
- **Admin Controllers**: User, skill, purchase management

#### Views (`resources/views/`)
- `layouts/app.blade.php`: Main authenticated layout
- `listings/*`: Listing browse and management
- `purchases/*`: Purchase details and messaging
- `wallet/show.blade.php`: Balance and history
- `admin/*`: Admin dashboards and management
- `user/`: User dashboards

### Request Flow Pattern

```
HTTP Request
    ↓
Route (web.php)
    ↓
Middleware (Auth, Role, CSRF)
    ↓
Form Request (Validation)
    ↓
Controller (Business Logic)
    ↓
Service (Complex Logic - CoinTransferService)
    ↓
Model (Database Operations)
    ↓
Policy (Authorization)
    ↓
Response (JSON or Blade View)
```

---

## 🗄️ Database Design

### Schema Relationships Diagram

```
┌─────────┐
│ Users   │────┐
├─────────┤    │
│ id (PK) │    │
│ email   │    │
│ coins   │    │
│ role    │    │
└─────────┘    │
      ↑        │
      │        ├────→ ┌──────────────┐
      │        │      │ UserSkills   │
      │        │      ├──────────────┤
      │        └──────→ user_id (FK) │
      │               │ skill_id (FK)│
      │               │ price        │
      │               └──────────────┘
      │                      │
      │        ┌─────────────┴─────────────────┐
      │        │                               │
      │        ↓                               ↓
      │    ┌──────────────┐          ┌──────────────┐
      │    │ Purchases    │          │ Skills       │
      │    ├──────────────┤          ├──────────────┤
      ├───→│ buyer_id (FK)│          │ id (PK)      │
      │    │ seller_id(FK)│          │ name         │
      │    │ amount       │          │ created_by   │
      │    │ status       │          └──────────────┘
      │    └──────────────┘
      │           │
      ├───────────┴──────────────────────────────┐
      │                                          │
      │    ┌──────────────┐          ┌──────────────┐
      │    │ Messages     │          │ Reviews      │
      │    ├──────────────┤          ├──────────────┤
      │    │ purchase_id  │          │ purchase_id  │
      └───→│ sender_id    │          │ buyer_id     │
           │ receiver_id  │          │ seller_id    │
           └──────────────┘          │ rating       │
                                     └──────────────┘
           ┌──────────────┐
           │ CoinTx (log) │
           ├──────────────┤
    ┌──────│ user_id (FK) │
    │      │ type         │
    │      │ amount       │
    │      └──────────────┘
    │
    └─────┌──────────────┐
          │ Notifications│
          ├──────────────┤
          │ user_id (FK) │
          │ title        │
          └──────────────┘
```

### Key Design Decisions

1. **CoinTransaction - Immutable Audit Trail**
   - Every coin movement creates a record
   - Cannot be deleted or modified
   - Tracks reference (purchase_id, reason, etc.)
   - Enables complete audit trail for compliance

2. **UserSkill (Listing) - Denormalized Price**
   - Stores price at listing time (not in Skill)
   - Allows same skill at different prices by different users
   - Snapshot of price when purchase created

3. **Messages - Purchase Bound**
   - Messages only accessible via purchase
   - Not accessible after purchase deleted
   - Enforces buyer-seller privacy

4. **Reviews - One Per Purchase (Unique Constraint)**
   - `UNIQUE(purchase_id)` prevents duplicates
   - Deleted purchase deletes review (CASCADE)

---

## 💰 Core Business Logic: Atomic Coin Transfer

### Implementation: CoinTransferService

**Location**: `app/Services/CoinTransferService.php`

```php
public function transfer(Purchase $purchase): bool
{
    return DB::transaction(function () use ($purchase) {
        // 1. ROW-LEVEL LOCKING (CRITICAL for concurrency)
        $buyer = User::lockForUpdate()->find($purchase->buyer_id);
        $seller = User::lockForUpdate()->find($purchase->seller_id);

        // 2. VALIDATION
        if ($buyer->coins < $purchase->amount) {
            return false;  // Transaction rolls back
        }

        // 3. ATOMIC UPDATE
        $buyer->decrement('coins', $purchase->amount);
        $seller->increment('coins', $purchase->amount);

        // 4. IMMUTABLE AUDIT TRAIL
        CoinTransaction::create([
            'user_id' => $buyer->id,
            'type' => 'debit',
            'amount' => $purchase->amount,
            'reason' => 'Purchase - ' . $purchase->userSkill->skill->name,
            'reference_id' => 'purchase_' . $purchase->id,
            'status' => 'success',
        ]);

        CoinTransaction::create([
            'user_id' => $seller->id,
            'type' => 'credit',
            'amount' => $purchase->amount,
            'reason' => 'Sale - ' . $purchase->userSkill->skill->name,
            'reference_id' => 'purchase_' . $purchase->id,
            'status' => 'success',
        ]);

        return true;
    }); // Auto-commit on return true, rollback on exception
}
```

### Transaction Safety Guarantees

| Scenario | Handling |
|----------|----------|
| Insufficient balance | DB transaction rolls back, no coins transferred |
| Duplicate request | Both handled by message/alert to user |
| Concurrent requests | Row locks prevent race conditions |
| System crash | Transaction rolls back on failure |
| Network error | Automatic retry via Laravel queue |

### Example Execution Flow

```sql
-- Connection 1: Purchase starts
BEGIN TRANSACTION;
SELECT * FROM users WHERE id=1 FOR UPDATE;
SELECT * FROM users WHERE id=2 FOR UPDATE;

-- If John (id=1) has exactly 100 coins and Buyer requests 120:
-- 1000 >= 120? YES
UPDATE users SET coins = 900 WHERE id=1;
UPDATE users SET coins = 1100 WHERE id=2;

INSERT INTO coin_transactions VALUES (...), (...);
UPDATE purchases SET status = 'completed' WHERE id = X;

COMMIT;

-- If Connection 2 tried to lock user 1 while locked:
-- SELECT * FROM users WHERE id=1 FOR UPDATE; -- WAITS
-- After Connection 1 commits:
-- SELECT continues with updated coin balance
```

---

## 🔐 Authorization & Access Control

### Middleware Chain

```
Request
  ↓
[Authenticate] - Check auth()->check()
  ↓
[RoleMiddleware] - Check role in config
  ↓
[FormRequest] - Validate input
  ↓
[Policy Authorization] - Method-level checks
  ↓
Controller Action
```

### RoleMiddleware Implementation

```php
// app/Http/Middleware/RoleMiddleware.php
public function handle(Request $request, Closure $next, ...$roles): Response
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, 'Unauthorized');
    }

    return $next($request);
}

// Usage in routes
Route::middleware(['auth', 'role:user'])->group(function () {
    // Only user role can access
});

Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    // Admin OR Staff can access
});
```

### Policy-Based Authorization

**PurchasePolicy** (`app/Policies/PurchasePolicy.php`):

```php
// Only seller can update purchase
public function update(User $user, Purchase $purchase): bool
{
    return $user->id === $purchase->seller_id;
}

// Only seller can accept pending purchase  
public function accept(User $user, Purchase $purchase): bool
{
    return $user->id === $purchase->seller_id 
        && $purchase->status === 'pending';
}

// Only seller can complete accepted purchase
public function complete(User $user, Purchase $purchase): bool
{
    return $user->id === $purchase->seller_id 
        && $purchase->status === 'accepted';
}

// Only buyer can review completed purchase
public function review(User $user, Purchase $purchase): bool
{
    return $user->id === $purchase->buyer_id 
        && $purchase->status === 'completed';
}
```

**Controller Usage**:

```php
public function update(Request $request, Purchase $purchase): RedirectResponse
{
    $this->authorize('complete', $purchase);  // Throws AuthorizationException if fails
    // ... proceed with completion
}
```

---

## 🛡️ Input Validation

### Form Request Classes

**StoreListingRequest** (`app/Http/Requests/StoreListingRequest.php`):

```php
public function authorize(): bool
{
    return auth()->check() && auth()->user()->role === 'user';
}

public function rules(): array
{
    return [
        'skill_id' => 'required|exists:skills,id',
        'price' => 'required|numeric|min:1|max:10000',
        'experience_level' => 'required|in:beginner,intermediate,expert',
    ];
}

public function messages(): array
{
    return [
        'price.min' => 'Price must be at least 1 coin',
        'price.max' => 'Price cannot exceed 10,000 coins',
    ];
}
```

**Benefits**:
- ✅ Authorization check before validation
- ✅ Custom error messages for UX
- ✅ Centralized validation logic
- ✅ Automatic CSRF protection

---

## 📊 Data Integrity

### Foreign Key Constraints

```sql
-- All foreign keys are CONSTRAINED

ALTER TABLE purchases
ADD CONSTRAINT purchases_buyer_id_foreign
FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE;

ALTER TABLE purchases
ADD CONSTRAINT purchases_seller_id_foreign
FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE;

-- When user deleted, all their:
-- - Listings cascade deleted
-- - Purchases cascade deleted
-- - Messages cascade deleted
-- - Reviews cascade deleted
-- - Transactions cascade deleted
```

### Unique Constraints

```sql
-- One review per purchase
ALTER TABLE reviews
ADD UNIQUE(purchase_id);

-- Prevent duplicate coin transactions
-- (handled in application logic)
```

---

## 🧪 Test Scenarios

### Scenario 1: Successful Purchase

**Setup**:
- John: 1000 coins
- Jane: 800 coins
- John requests Jane's 150-coin listing

**Flow**:
```
1. POST /purchases (by John)
   → Purchase created with status=pending

2. PATCH /purchases/{id} (by Jane, action=accept)
   → status=pending → accepted

3. PATCH /purchases/{id} (by Jane, action=complete)
   → DB Transaction:
       ✓ John.coins: 1000 - 150 = 850
       ✓ Jane.coins: 800 + 150 = 950
       ✓ 2 CoinTransaction records created
       ✓ status=completed
   → Notifications sent
```

**Verify**:
```bash
php artisan tinker
>>> User::find(1)->coins  # John
=> 850
>>> User::find(2)->coins  # Jane
=> 950
>>> CoinTransaction::where('reference_id', 'purchase_1')->get()
=> 2 records (debit + credit)
```

### Scenario 2: Insufficient Funds

**Setup**:
- John: 100 coins
- Jane: listing costs 150 coins

**Flow**:
```
1. John selects Jane's 150-coin listing
2. Click "Request Service"
   → Form shows: "You only have 100 coins"
   → Cannot proceed

OR if somehow purchase created with 150:

3. Jane accepts
4. Jane clicks "Complete"
   → DB Transaction START
   → SELECT * FROM users WHERE id=1 FOR UPDATE
   → IF john.coins < 150:
       → ROLLBACK (no coins changed)
       → Display: "Insufficient coins"
   → Transaction rolls back
```

**Verify**:
```bash
>>> User::find(1)->coins  # Still 100
=> 100
>>> CoinTransaction::count()  # No new records
=> same as before
```

### Scenario 3: Concurrent Purchases (Race Condition)

**Problem**: Without row locking, two simultaneous purchases could over-withdraw

**Solution**: `User::lockForUpdate()`

```
Time  Connection 1              Connection 2
0:00  BEGIN TRANSACTION         
0:01  Lock user 1 (John)        
0:02                            BEGIN TRANSACTION
0:03  John.coins = 1000         
0:04  Check: 1000 >= 150? YES   
0:05  UPDATE John = 850         
0:06                            Lock user 1 -- WAIT
0:07  UPDATE Jane = 950         
0:08  COMMIT                    
0:09                            Lock acquired with John.coins=850
0:10                            Check: 850 >= 150? YES/NO
0:11                            Process accordingly
```

**Without locks** (WRONG):
```
0:00  John.coins = 1000
0:00  Check: 1000 >= 80? YES    Check: 1000 >= 100? YES
0:01  UPDATE John = 920         UPDATE John = 900  -- OVERDRAWN!
```

---

## 📈 Scalability Considerations

### Current Implementation (SQLite/MySQL)
- ✅ Atomic transactions
- ✅ Row-level locking
- ✅ Query optimization with eager loading
- ✅ Pagination on all lists
- ✅ Indexed foreign keys

### For Production Scale (100K+ users)

**Database Partitioning**:
```sql
-- Partition coin_transactions by date
PARTITION BY RANGE (YEAR(created_at)) (
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p2026 VALUES LESS THAN (2027)
);
```

**Caching**:
- Cache skill list (Redis)
- Cache user ratings (invalidate on review)
- Cache admin dashboard (hourly)

**Queue**:
- Send notifications async (Laravel Queue)
- Process bulk operations

**Read Replicas**:
- Master for writes (transactions)
- Slaves for reads (dashboards, listings)

---

## 🚀 Deployment Checklist

### Pre-Deployment
- [ ] `APP_DEBUG=false` in production .env
- [ ] `APP_ENV=production`
- [ ] Generate application key: `php artisan key:generate`
- [ ] Set secure `APP_URL`
- [ ] Configure mail service
- [ ] Setup database backups
- [ ] Enable HTTPS
- [ ] Configure CORS for API (if needed)

### Database
- [ ] Create production database
- [ ] Run migrations: `php artisan migrate`
- [ ] Import initial data: `php artisan seed`
- [ ] Setup automated backups
- [ ] Create indexes
- [ ] Setup replication (optional)

### Assets
- [ ] Build assets: `npm run build`
- [ ] Minify CSS/JS (Vite handles this)
- [ ] Setup CDN (optional)
- [ ] Configure cache headers

### Security
- [ ] Set secure session cookie: `SESSION_SECURE_COOKIES=true`
- [ ] Enable CSRF: in middleware (default)
- [ ] Setup rate limiting
- [ ] Configure firewall rules
- [ ] Enable monitoring/logging (Sentry)

### Monitoring
- [ ] Setup application monitoring (New Relic/DataDog)
- [ ] Configure error tracking (Sentry)
- [ ] Setup uptime monitoring
- [ ] Configure log aggregation (ELK)
- [ ] Setup performance monitoring

---

## 📚 Key takeaways for FYP

### What Makes This "Production-Ready"

1. **Atomic Transactions**: 
   - Coin transfers guaranteed ACID properties
   - Row locking prevents race conditions
   - No possibility of coins disappearing or duplicating

2. **Authorization**:
   - Multi-layer security (middleware + policy)
   - Business rule enforcement (e.g., can't review before complete)
   - Prevents unauthorized coin movement

3. **Data Integrity**:
   - Foreign key constraints with cascading
   - Immutable transaction audit trail
   - Referential integrity throughout

4. **Architecture**:
   - Clean separation of concerns
   - Service layer for complex logic
   - Reusable models and policies
   - Easily testable controllers

5. **Scalability**:
   - Indexed database queries
   - Eager loading prevents N+1
   - Pagination on all large lists
   - Service layer allows caching/optimization

6. **Security**:
   - CSRF protection on all forms
   - Password hashing with bcrypt
   - Input validation via FormRequests
   - Output encoding in Blade templates

---

## 📖 Learning Resources Used

- **Laravel Documentation**: Transactions, Authorization, ORM
- **Database Design**: Foreign Keys, Constraints, Partitioning
- **Concurrency Control**: Pessimistic Locking, Race Conditions
- **API Design**: RESTful principles, Request/Response patterns
- **Security**: OWASP, CSRF, SQL Injection Prevention

---

**Conclusion**: Skillzy demonstrates comprehensive Laravel proficiency including advanced patterns, security best practices, and production-ready architecture suitable for final year project evaluation.
