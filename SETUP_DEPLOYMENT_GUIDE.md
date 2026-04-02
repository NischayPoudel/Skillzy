# SKILLZY - Setup & Deployment Instructions

## 📋 Prerequisites & System Requirements

### Required Software
- **PHP**: 8.2 or higher
- **MySQL**: 8.0 or higher  
- **Node.js**: 18.0 or higher
- **npm**: 9.0 or higher
- **Composer**: Latest version
- **Git**: For version control

### Recommended Tools
- **VSCode**: With PHP Intelephense & Laravel extensions
- **TablePlus/MySQL Workbench**: Database GUI (optional)
- **Postman**: API testing (optional)
- **Laravel Valet**: For local development (macOS)

### System Size
- **Disk Space**: ~500MB (including vendor)
- **RAM**: 2GB minimum for development
- **Initial DB Size**: ~10MB with demo data

---

## 🚀 Installation (Step-by-Step)

### Step 1: Clone Repository

```bash
# Navigate to desired location
cd ~/projects  # or C:\Users\YourName\Desktop for Windows

# Clone the repository
git clone https://github.com/your-repo/Skillzy.git
cd Skillzy

# Or if already available locally (Windows example)
cd c:\Users\LENOVO\Desktop\Skillzy
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies via Composer
composer install

# Install Node.js dependencies via npm
npm install

# This installs:
# - Laravel framework & packages
# - Tailwind CSS
# - Laravel Vite
# - Breeze (auth scaffolding)
```

### Step 3: Environment Configuration

```bash
# Copy example environment file
cp .env.example .env

# On Windows:
# copy .env.example .env

# Edit .env file (your editor)
nano .env
# or
code .env  # VSCode
```

### Step 4: Generate Application Key

```bash
php artisan key:generate

# Output should show:
# Application key set successfully.

# Verify in .env:
# APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

### Step 5: Configure Database

**Option A: MySQL (Recommended for Production)**

1. Create database:
```bash
mysql -u root -p
```

In MySQL prompt:
```sql
CREATE DATABASE skillzy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

2. Update `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skillzy
DB_USERNAME=root
DB_PASSWORD=your_password
```

**Option B: SQLite (Quick Testing)**

1. Create database file:
```bash
touch database/database.sqlite
```

2. Update `.env`:
```env
DB_CONNECTION=sqlite
# Remove other DB_* entries or comment them out
```

### Step 6: Run Database Migrations

```bash
# Run all migrations with seeders (demo data)
php artisan migrate --seed

# Output:
# ✓ Create users table
# ✓ Create skills table
# ✓ Create user_skills table
# ... (all migrations)
# ✓ Seeded: Database\Seeders\DatabaseSeeder
```

### Step 7: Build Frontend Assets

```bash
# Production build (minified)
npm run build

# Development build with hot reload
npm run dev  # (run in separate terminal)
```

### Step 8: Start Application

```bash
# Start Laravel development server
php artisan serve

# Output:
# INFO  Server running on [http://127.0.0.1:8000]
```

### Step 9: Access Application

1. Open browser
2. Navigate to: **http://localhost:8000**
3. You should see the Skillzy homepage
4. Click "Login" and use demo credentials

---

## ✅ Verification Checklist

After installation, verify everything works:

```bash
# Check PHP version
php --version
# Should show: PHP 8.2.x or higher

# Check Composer version
composer --version
# Should show: Composer 2.x.x or higher

# Check Node.js version
node --version
# Should show: v18.x.x or higher

# Check npm version
npm --version
# Should show: 9.x.x or higher

# Verify database connection
php artisan db

# Output should connect to database without errors
# Type "exit" to quit

# Check migrations
php artisan migrate:status
# Should show all migrations with "Yes" in Batch column

# Test artisan commands
php artisan tinker
>>> User::count()
=> 6  # Demo users

# Exit from Tinker
>>> exit
```

---

## 🧪 Testing the Application

### Test User Accounts

After seeding, you can login with:

| Email | Password | Role | Coins |
|-------|----------|------|-------|
| admin@example.com | password | Admin | 10,000 |
| staff@example.com | password | Staff | 5,000 |
| john@example.com | password | User | 1,000 |
| jane@example.com | password | User | 800 |
| mike@example.com | password | User | 1,500 |
| sarah@example.com | password | User | 600 |

### Quick Test Flow

```
1. Open http://localhost:8000
2. Click "Login"
3. Enter: john@example.com / password
4. You're on the dashboard
5. Click "Browse Listings"
6. Search "Design" or "UI"
7. Click "View Details" on Jane's listing
8. Click "Request Service"
9. View purchase request (status: pending)
```

---

## 🔧 Development Commands

### Database Management

```bash
# Migrate (create tables)
php artisan migrate

# Seed (insert demo data)
php artisan seed

# Reset (drop all tables and recreate)
php artisan migrate:reset

# Refresh (reset + migrate + seed)
php artisan migrate:refresh --seed

# Check migration status
php artisan migrate:status

# Rollback last batch
php artisan migrate:rollback

# Fresh (delete DB and start over - WILL DELETE DATA)
php artisan migrate:fresh --seed
```

### Cache Management

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear everything at once
php artisan optimize:clear
```

### Database Inspection

```bash
# Interactive PHP shell
php artisan tinker

# Inside Tinker:
>>> User::all();
>>> Purchase::with('buyer', 'seller')->get();
>>> CoinTransaction::latest()->limit(10)->get();
>>> exit
```

### Code Quality

```bash
# Check code style (Laravel Pint)
composer run pint

# Run tests (if configured)
php artisan test
```

---

## 📦 Useful npm Commands

```bash
# Development server with hot reload
npm run dev

# Production build
npm run build

# Build and watch for changes
npm run watch

# Lint code
npm run lint
```

---

## 🐛 Common Issues & Solutions

### Issue 1: "SQLSTATE[HY000] [2002] No such file or directory"

**Cause**: MySQL not running or socket not found

**Solution**:
```bash
# Start MySQL service
# macOS:
brew services start mysql

# Linux:
sudo service mysql start

# Windows:
# Start MySQL via Services or run mysql.server start
```

### Issue 2: "Class 'PDO' not found"

**Cause**: PHP PDO extension not installed

**Solution**:
```bash
# macOS
brew install php

# Linux (Ubuntu)
sudo apt-get install php-mysql php-pdo

# Windows
# Download XAMPP or use WSL with Linux commands
```

### Issue 3: "No application encryption key"

**Cause**: APP_KEY not generated

**Solution**:
```bash
php artisan key:generate
```

### Issue 4: "Vite manifest not found"

**Cause**: Frontend assets not built

**Solution**:
```bash
npm install
npm run build

# Or for development:
npm run dev  # In separate terminal
```

### Issue 5: "Migration file not found"

**Cause**: Wrong working directory

**Solution**:
```bash
# Make sure you're in project root
pwd  # Check current directory
# Should show: /path/to/Skillzy

# Then run:
php artisan migrate
```

### Issue 6: Coins not updating after purchase

**Cause**: Purchase not marked as "completed"

**Solution**:
1. Go to purchase detail page
2. Click "Complete Purchase & Transfer Coins" button
3. Confirm in popup
4. Check both users' wallets for updated balances

### Issue 7: "Syntax error or access violation"

**Cause**: Database schema issue

**Solution**:
```bash
# Reset everything
php artisan migrate:fresh --seed

# This will:
# - Drop all tables
# - Run fresh migrations
# - Seed demo data
```

---

## 🔒 Security Configuration

### Production .env Settings

```env
# Application
APP_ENV=production
APP_DEBUG=false
APP_URL=https://skillzy.example.com

# Database
DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_DATABASE=skillzy
DB_USERNAME=secure-username
DB_PASSWORD=very-strong-password

# Session
SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_SECURE_COOKIES=true  # HTTPS only
SESSION_HTTP_ONLY=true

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io  # or your email provider
MAIL_PORT=465
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS=noreply@skillzy.local

# Cache
CACHE_DRIVER=redis  # Use Redis in production

# Queue
QUEUE_CONNECTION=database  # Or use Redis/Beanstalk
```

### Enable HTTPS

```bash
# Using Let's Encrypt (free SSL)
# Install Certbot on your server, then:

certbot certonly --webroot -w /var/www/skillzy/public -d skillzy.example.com

# Configure in nginx/apache to redirect HTTP to HTTPS
```

### Database User Permissions

```sql
-- Create dedicated user with limited permissions
CREATE USER 'skillzy'@'localhost' IDENTIFIED BY 'strong-password';

-- Grant only necessary permissions
GRANT SELECT, INSERT, UPDATE, DELETE ON skillzy.* TO 'skillzy'@'localhost';

-- Remove dangerous permissions
-- Do NOT grant: DROP, CREATE, ALTER

-- Apply changes
FLUSH PRIVILEGES;
```

---

## 🚀 Deployment to Hosting

### Using Laravel Forge (Recommended)

```bash
# 1. Push to GitHub
git add .
git commit -m "Ready for deployment"
git push origin main

# 2. On Laravel Forge dashboard:
# - Create new server (DigitalOcean/AWS/Linode)
# - Connect GitHub repository
# - Configure environment variables
# - Deploy on push enabled

# 3. Automatically deployed!
```

### Manual Deployment (SSH)

```bash
# 1. Connect to server
ssh user@your-server.com

# 2. Navigate to web directory
cd /var/www/html

# 3. Clone repository
git clone <your-repo-url> skillzy
cd skillzy

# 4. Install dependencies
composer install --optimize-autoloader --no-dev

# 5. Configure environment
cp .env.example .env
php artisan key:generate

# 6. Configure database in .env

# 7. Run migrations
php artisan migrate --force

# 8. Build assets
npm install --production
npm run build

# 9. Fix permissions
sudo chown -R www-data:www-data .
sudo chmod -R 755 storage bootstrap/cache

# 10. Start queue worker (if using jobs)
php artisan queue:work --daemon

# 11. Setup cron for scheduling
crontab -e
# Add: * * * * * cd /var/www/html/skillzy && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📊 Performance Optimization

### Laravel Configuration

```bash
# Cache configuration (production)
php artisan config:cache

# Cache routes for faster loading
php artisan route:cache

# Cache models with `php artisan model:cache` (Laravel 9+)
php artisan model:cache

# For development, clear these caches:
php artisan config:clear
php artisan route:clear
php artisan model:prune-missing
```

### Database Optimization

```bash
# Update table statistics
ANALYZE TABLE users;
ANALYZE TABLE user_skills;
ANALYZE TABLE purchases;
ANALYZE TABLE coin_transactions;

# On regular schedule (weekly):
# MySQL can optimize automatically
OPTIMIZE TABLE users;
```

### Asset Optimization

```bash
# Production builds are automatically minified with Vite
npm run build

# Verify final assets in:
# public/build/manifest.json
# public/build/assets/app-HASH.js
# public/build/assets/app-HASH.css
```

---

## 📈 Monitoring & Logging

### Laravel Logging

```bash
# View logs in real-time
tail -f storage/logs/laravel.log

# Or on Windows:
Get-Content storage/logs/laravel.log -Wait

# Configure log level in .env:
LOG_LEVEL=debug   # development
LOG_LEVEL=warning # production
```

### Database Query Logging

```php
// In config/app.php or service provider:
DB::listen(function ($query) {
    Log::info('Query: ' . $query->sql, $query->bindings);
});
```

### Application Monitoring

```bash
# Install Telescope (development debugging)
composer require laravel/telescope --dev
php artisan telescope:install

# Access at: http://localhost:8000/telescope

# Production monitoring services:
# - New Relic
# - DataDog  
# - Scout APM
# - Sentry (error tracking)
```

---

## 🔄 Backup & Recovery

### Database Backup

```bash
# Backup SQL dump
mysqldump -u root -p skillzy > skillzy-backup-$(date +%Y%m%d).sql

# Backup with compression
mysqldump -u root -p skillzy | gzip > skillzy-backup-$(date +%Y%m%d).sql.gz

# Restore from backup
mysql -u root -p skillzy < skillzy-backup-20260225.sql

# Or with compression
gunzip < skillzy-backup-20260225.sql.gz | mysql -u root -p skillzy
```

### File Backup

```bash
# Backup entire project
tar -czf skillzy-backup-$(date +%Y%m%d).tar.gz .

# Exclude node_modules and vendor (they can be reinstalled)
tar --exclude='node_modules' --exclude='vendor' --exclude='.git' -czf skillzy-backup-$(date +%Y%m%d).tar.gz .
```

### Automated Backups (Cron)

```bash
# Create backup script: /usr/local/bin/backup-skillzy.sh
#!/bin/bash
DIR="/var/www/html/skillzy"
BACKUP="/backups/skillzy"
DATE=$(date +\%Y\%m\%d)

mysqldump -u skillzy -p$DB_PASSWORD skillzy | gzip > $BACKUP/db-$DATE.sql.gz
tar -czf $BACKUP/files-$DATE.tar.gz $DIR

# Delete old backups (keep 30 days)
find $BACKUP -name "*.gz" -mtime +30 -delete

# Add to crontab (run daily at 2 AM):
0 2 * * * /usr/local/bin/backup-skillzy.sh
```

---

## 🎓 Learning Resources

### Laravel Documentation
- **Official Docs**: https://laravel.com/docs
- **API Reference**: https://laravel.com/api
- **Packages**: https://packagist.org

### Database
- **MySQL Docs**: https://dev.mysql.com/doc/
- **Eloquent ORM**: https://laravel.com/docs/eloquent
- **Query Builder**: https://laravel.com/docs/queries

### Video Tutorials
- **Laracasts**: https://laracasts.com
- **Laravel Beyond CRUD**: https://laravelbeyondcrud.com
- **Real-time apps with Livewire**: https://livewire.laravel.com

---

## 📞 Support & Troubleshooting

### Getting Help

1. **Check Laravel Docs**: https://laravel.com/docs
2. **Read Error Message Carefully**: Laravel errors are very descriptive
3. **Check `storage/logs/laravel.log`**: Most errors logged there
4. **Use Tinker**: `php artisan tinker` to debug
5. **Laravel Community**: https://laracasts.com, Reddit /r/laravel

### Common Artisan Commands

```bash
# List all available commands
php artisan

# Get help on specific command
php artisan help migrate

# Run custom command
php artisan command:name {argument} {--option}
```

---

**Congratulations! Your Skillzy application is ready.** 🎉

For questions or issues, refer to the complete documentation in:
- `SKILLZY_COMPLETE_DOCUMENTATION.md` - System design
- `TECHNICAL_IMPLEMENTATION_GUIDE.md` - Architecture details
- `QUICK_START_GUIDE.md` - Quick demo walkthrough
