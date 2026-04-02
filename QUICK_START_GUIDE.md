# SKILLZY - Quick Start Guide

## 🚀 5-Minute Setup

### Step 1: Database
```bash
# Create MySQL database
mysql -u root -p
> CREATE DATABASE skillzy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> EXIT;
```

### Step 2: Clone & Install
```bash
cd Skillzy
cp .env.example .env
composer install
npm install
php artisan key:generate
```

### Step 3: Configure Database
Edit `.env`:
```
DB_DATABASE=skillzy
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Migrate & Seed
```bash
php artisan migrate --seed
npm run build
php artisan serve
```

✅ **Done!** Visit: http://localhost:8000

---

## 👥 Demo Users

| Account | Email | Password |
|---------|-------|----------|
| **Admin** | admin@example.com | password |
| **John (Developer)** | john@example.com | password |
| **Jane (Designer)** | jane@example.com | password |
| **Mike (Consultant)** | mike@example.com | password |
| **Sarah (Marketer)** | sarah@example.com | password |

---

## 🎬 Complete Demo Flow (15 minutes)

### Scenario: Buy UI/UX Design Service

#### Act 1: John Browses Listings (5 min)
1. Open http://localhost:8000
2. Click **Login**
3. Use: `john@example.com` / `password`
4. You're on John's Dashboard
   - **2 My Listings**: PHP, API Development
   - **3 Purchases**: 2 complete, 1 accepted
   - **Coins**: 1000 (after demo transactions)

#### Act 2: Browse & Find Service (3 min)
1. Click **Browse Listings** (nav)
2. Search: "Design" or "UI"
3. You see **Jane's UI/UX Design** @ 120 coins
4. Click **View Details**
   - Rating: 5★ (1 review)
   - Level: Expert
   - By: Jane Designer

#### Act 3: Request Service (2 min)
1. Click **Request Service** button
2. Popup shows:
   ```
   Request Service (120 coins)
   
   Your balance: 1000 coins
   You will be charged: 120 coins
   ```
3. Click **Confirm**
4. Redirected to purchase detail page
   - Status: **pending** (yellow)
   - Waiting for seller...

#### Act 4: Switch to Jane (Seller) - Accept (2 min)
1. Click **Logout** (top-right)
2. Login: `jane@example.com` / `password`
3. Dashboard shows:
   - **💬 New Purchase Request** from John
4. Click **Purchases** → see John's pending request
5. View details
6. Click **Accept** button
7. Status: **pending → accepted** (blue)
8. Message: "Jane accepted your request"
9. Notification shows for John

#### Act 5: Jane Completes & Transfer Coins (AUTO) (2 min)
1. Still on Jane's purchase view
2. Click **Complete Purchase & Transfer Coins**
3. Popup: "System will now transfer 120 coins from John to Jane"
4. Click **Confirm**

**Behind the scenes:**
```sql
BEGIN TRANSACTION;

  SELECT * FROM users WHERE id=1 FOR UPDATE;  -- John (buyer)
  SELECT * FROM users WHERE id=2 FOR UPDATE;  -- Jane (seller)
  
  IF john.coins >= 120:
    UPDATE users SET coins = 880 WHERE id=1;  -- John
    UPDATE users SET coins = 920 WHERE id=2;  -- Jane
    
    INSERT INTO coin_transactions VALUES
      (user_id=1, type='debit', amount=120, ...),
      (user_id=2, type='credit', amount=120, ...);
    
    UPDATE purchases SET status='completed';
  ELSE:
    ROLLBACK;  -- Insufficient funds
    
COMMIT;

-- Create notifications
INSERT INTO notifications VALUES
  (user_id=1, 'Purchase Completed', ...),
  (user_id=2, 'You earned coins', ...);
```

5. Status: **completed** (green)
6. Both users get notifications

#### Act 6: John Leaves Review
1. Logout & login as `john@example.com`
2. Go to **My Purchases** → see completed purchase
3. Click **Leave Review** section
4. **Rating**: ⭐⭐⭐⭐⭐ (5 stars)
5. **Comment**: "Excellent service! Jane is great!"
6. Click **Submit**
7. Success: "Review posted!"
8. See review on page

#### Act 7: Check Wallet & History
1. Click **Wallet** (nav)
2. **Current Balance**: 880 coins (1000 - 120)
3. **Transaction History** shows:
   ```
   [Debit] Purchase - UI/UX Design | -120 coins | 2026-02-25 10:30
   [Credit] Top-up | +300 coins | 2026-02-25 09:15
   [Debit] Purchase - Design Service | -120 coins | 2026-02-25 08:45
   ```
4. Seller (Jane) wallet shows +120 credit

#### Act 8: View Notifications
1. Click **Notifications** (bell icon)
2. See all events:
   - ✓ Purchase Completed
   - ✓ Coins received/sent
   - ✓ Messages from buyer/seller
   - ✓ New review posted

---

## ✅ Verification Checklist

After running the demo, verify:

- [ ] John's coins: 1000 → 880 (after purchase)
- [ ] Jane's coins: 800 → 920 (after earning)
- [ ] Purchase status: pending → accepted → completed
- [ ] Review: visible on Jane's listing
- [ ] Jane's rating: updated (5★)
- [ ] Transaction history: shows debit for John, credit for Jane
- [ ] Notifications: both users got alerts
- [ ] Message history: preserved in purchase

---

## 🛠️ Common Tasks

### Create a New User
```bash
php artisan tinker

# Create regular user
>>> $user = User::create([
  'name' => 'Bob Trainer',
  'username' => 'bobtrainer',
  'email' => 'bob@example.com',
  'password' => bcrypt('password'),
  'coins' => 500,
  'role' => 'user',
]);

>>> $user->id
=> 7
```

### Add Coins to a User
```bash
php artisan tinker

>>> $user = User::find(1);  // John
>>> $user->increment('coins', 1000);  // Add 1000 coins

>>> $user->coins
=> 2000
```

### Create a Listing
```bash
php artisan tinker

>>> $skill = Skill::where('name', 'PHP Development')->first();
>>> UserSkill::create([
  'user_id' => 1,
  'skill_id' => $skill->id,
  'price' => 150,
  'experience_level' => 'expert',
  'status' => 'active',
]);
```

### Simulate Completed Transactions
```bash
php artisan tinker

>>> // Create purchase
>>> $purchase = Purchase::create([
  'buyer_id' => 1,
  'seller_id' => 2,
  'user_skill_id' => 1,
  'amount' => 100,
  'status' => 'completed',
]);

>>> // Manual coin transfer (use service in production)
>>> $buyer = User::find(1);
>>> $seller = User::find(2);
>>> $buyer->decrement('coins', 100);
>>> $seller->increment('coins', 100);
```

---

## 🐛 Debugging Tips

### Check User Coins Balance
```bash
php artisan tinker
>>> User::select('id', 'name', 'coins')->get();
```

### View All Transactions
```bash
>>> CoinTransaction::with('user')->latest()->limit(20)->get();
```

### Check Purchase Status
```bash
>>> Purchase::with('buyer', 'seller')->latest()->get();
```

### View Notifications
```bash
>>> Notification::where('user_id', 1)->latest()->get();
```

---

## 🚨 Troubleshooting

### "SQLSTATE[HY000] [2002] No such file or directory"
**Issue**: MySQL not running or wrong socket
**Fix**:
```bash
# Start MySQL
mysql.server start

# Or check .env
DB_HOST=127.0.0.1
DB_PORT=3306
```

### "Class 'PDO' not found"
**Issue**: PHP extensions missing
**Fix**:
```bash
# Check installed PHP extensions
php -m | grep pdo

# Install if needed
brew install php (macOS)
sudo apt-get install php-pdo-mysql (Linux)
```

### "No application encryption key"
**Issue**: APP_KEY not set
**Fix**:
```bash
php artisan key:generate
```

### Coins not updating after purchase complete
**Issue**: Transaction rolled back (insufficient funds)
**Solution**:
1. Check user's current coins: `php artisan tinker` → `User::find(1)->coins`
2. Verify the purchase amount
3. If coins are sufficient, try again
4. Check DB transaction logs

---

## 📞 Support

**Issues?**
1. Check `storage/logs/laravel.log` for errors
2. Run `php artisan config:clear`
3. Run `php artisan cache:clear`
4. Reset DB: `php artisan migrate:refresh --seed`

---

**Happy Skillzy-ing!** 🎉
