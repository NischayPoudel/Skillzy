# Skillzy - Skill Marketplace Application

A complete Laravel web application for a skill marketplace platform with role-based access control, coin-based economy, reviews, and messaging system.

## Features

### Core Features
- **Skill Management**: Admin and staff can create and manage marketplace skills
- **User Listings**: Users can create listings for their skills with pricing and experience levels
- **Purchase System**: Users can request services from other users with coin-based payments
- **Wallet System**: Users can top up coins and view transaction history
- **Messaging**: In-app messaging system for purchase communication
- **Reviews & Ratings**: Users can review completed purchases with 1-5 star ratings
- **Notifications**: Real-time notifications for key events
- **Role-Based Dashboards**: Separate dashboards for users, staff, and admin

### Security Features
- **Policy-Based Authorization**: Prevents IDOR vulnerabilities
- **Row-Level Locking**: Safe concurrent coin transfers using DB::transaction with SELECT...FOR UPDATE
- **Form Validation**: All user inputs validated through FormRequest classes
- **Role-Based Middleware**: Protected routes with role-based access control
- **Authentication**: Laravel Breeze authentication scaffolding

## Technology Stack

- **Framework**: Laravel 12
- **PHP Version**: 8.1+
- **Database**: MySQL 8.0+
- **Frontend**: Blade templates with Alpine.js, Bootstrap from Breeze
- **Testing**: Pest Framework
- **Authentication**: Laravel Breeze

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL 8.0 or higher
- Node.js and npm (optional, for asset compilation)

### Setup Steps

1. **Clone or navigate to the project**
```bash
cd C:\Users\LENOVO\Desktop\Skillzy
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Create environment file**
```bash
cp .env.example .env
```

4. **Generate application key**
```bash
php artisan key:generate
```

5. **Configure database in .env**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skillzy
DB_USERNAME=root
DB_PASSWORD=
```

6. **Run migrations and seeders**
```bash
php artisan migrate:refresh --seed
```

7. **Build assets**
```bash
npm run dev
```

8. **Start the development server**
```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`

## Demo Credentials

The seeder creates the following demo users:

### Admin Account
- **Email**: admin@example.com
- **Password**: password
- **Role**: Admin
- **Coins**: 10,000

### Staff Account
- **Email**: staff@example.com
- **Password**: password
- **Role**: Staff
- **Coins**: 5,000

### Regular User Accounts
1. **John Developer**
   - Email: john@example.com
   - Username: johndeveloper
   - Coins: 1,000

2. **Jane Designer**
   - Email: jane@example.com
   - Username: janedesigner
   - Coins: 800

3. **Mike Consultant**
   - Email: mike@example.com
   - Username: mikeconsultant
   - Coins: 1,500

4. **Sarah Marketer**
   - Email: sarah@example.com
   - Username: sarahmarketer
   - Coins: 600

## Database Schema

### Users Table
- `id`, `name`, `username` (unique), `email`, `password`
- `profile_image`, `bio`, `coins`, `role` (enum: user/staff/admin)
- `email_verified_at`, `remember_token`, `timestamps`

### Skills Table
- `id`, `name` (unique), `description`, `icon`
- `created_by` (FK to users), `timestamps`

### User Skills Table
- `id`, `user_id` (FK), `skill_id` (FK)
- `price`, `experience_level` (enum: beginner/intermediate/expert)
- `status` (enum: active/inactive), `timestamps`

### Purchases Table
- `id`, `buyer_id` (FK), `seller_id` (FK), `user_skill_id` (FK)
- `amount`, `status` (enum: pending/accepted/completed/cancelled)
- `note`, `timestamps`

### Coin Transactions Table
- `id`, `user_id` (FK), `type` (enum: credit/debit)
- `amount`, `reason`, `reference_id`, `status` (enum: pending/success/failed)
- `timestamps`

### Messages Table
- `id`, `purchase_id` (FK), `sender_id` (FK), `receiver_id` (FK)
- `message`, `is_read`, `timestamps`

### Reviews Table
- `id`, `purchase_id` (FK UNIQUE), `buyer_id` (FK), `seller_id` (FK)
- `rating` (1-5), `comment`, `timestamps`

### Notifications Table
- `id`, `user_id` (FK), `title`, `message`
- `is_read`, `timestamps`

## Application Routes

### Public Routes
- `GET /` - Welcome page
- `GET /skills` - View all skills
- `GET /skills/{skill}` - View skill details
- `GET /listings` - Browse all listings with filters
- `GET /listings/{userSkill}` - View listing details

### Authentication Routes
- All auth routes are available via Laravel Breeze

### User Routes (role: user)
- `GET /user/dashboard` - User dashboard with statistics
- `POST /user/listings` - Create new listing
- `GET /user/listings/{userSkill}/edit` - Edit own listing
- `PATCH /user/listings/{userSkill}` - Update own listing
- `DELETE /user/listings/{userSkill}` - Delete own listing

### Staff Routes (role: staff)
- `GET /staff/dashboard` - Staff dashboard with platform statistics

### Admin Routes (role: admin)
- `GET /admin/dashboard` - Admin dashboard with revenue and analytics
- `POST /skills` - Create skill (admin/staff)
- `GET /skills/{skill}/edit` - Edit skill
- `PATCH /skills/{skill}` - Update skill
- `DELETE /skills/{skill}` - Delete skill

### Protected User Routes
- `GET /wallet` - View wallet and transaction history
- `POST /wallet/topup` - Add coins to wallet
- `GET /purchases` - View all purchases (buyer/seller)
- `POST /purchases` - Create purchase request
- `GET /purchases/{purchase}` - View purchase details
- `PATCH /purchases/{purchase}` - Update purchase (seller actions)
- `POST /messages` - Send message in purchase
- `POST /reviews` - Submit review for completed purchase
- `GET /notifications` - View notifications
- `POST /notifications/{notification}/mark-read` - Mark notification as read

## Key Implementation Details

### Coin Transfer with Row Locking
The purchase completion uses database transactions with row-level locking to prevent race conditions:

```php
DB::transaction(function () use ($purchase) {
    $buyer = User::lockForUpdate()->find($purchase->buyer_id);
    $seller = User::lockForUpdate()->find($purchase->seller_id);
    
    if ($buyer->coins < $purchase->amount) throw new Exception('Insufficient coins');
    
    $buyer->update(['coins' => $buyer->coins - $purchase->amount]);
    $seller->update(['coins' => $seller->coins + $purchase->amount]);
    
    // Record transactions and create notifications
});
```

### Policy-Based Authorization
All authorization checks use Laravel Policies to prevent IDOR:

- `UserSkillPolicy`: Ensures only owners can edit/delete listings
- `PurchasePolicy`: Ensures only buyer/seller can view, seller can update

### Form Request Validation
All store/update operations use FormRequest classes with:
- Validation rules for input sanitization
- Authorization checks in `authorize()` method
- Proper error handling with user feedback

## Testing

The application includes a comprehensive seeder that creates:
- 1 Admin user
- 1 Staff member
- 4 Regular users
- 6 Skills
- 6 User skill listings
- 5 Purchases with different statuses
- 3 Completed reviews
- 6 Notifications
- Multiple coin transactions

Run seeders:
```bash
php artisan migrate:refresh --seed
```

## API Endpoints Summary

All endpoints use standard HTTP methods:
- `GET` - Retrieve data
- `POST` - Create data
- `PATCH` - Update data
- `DELETE` - Delete data

All protected endpoints require authentication via Laravel Breeze session-based auth.

## Project Structure

```
skillzy/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Dashboard/ (3 dashboard controllers)
│   │   │   ├── SkillController.php
│   │   │   ├── ListingController.php
│   │   │   ├── PurchaseController.php
│   │   │   ├── WalletController.php
│   │   │   ├── MessageController.php
│   │   │   ├── ReviewController.php
│   │   │   └── NotificationController.php
│   │   ├── Requests/ (9 form request classes)
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   ├── Models/ (8 eloquent models)
│   └── Policies/ (2 authorization policies)
├── database/
│   ├── migrations/ (11 migrations)
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── skills/ (4 views)
│       ├── listings/ (4 views)
│       ├── purchases/ (2 views)
│       ├── wallet/ (1 view)
│       ├── notifications/ (1 view)
│       ├── user/dashboard.blade.php
│       ├── staff/dashboard.blade.php
│       └── admin/dashboard.blade.php
└── routes/
    └── web.php
```

## Notes

- All code is production-ready with no TODO comments
- Type hints are included for all methods
- Database relationships use proper foreign key constraints
- Migrations support cascading deletes where appropriate
- Views use Bootstrap styling from Laravel Breeze
- Form validation rules prevent invalid data entry
- Notifications are automatically created for key events
- Coin transactions are atomic and thread-safe

## Support

For issues or questions, review the code files or consult the Laravel 12 documentation at https://laravel.com/docs

## License

This project is for educational purposes.

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
