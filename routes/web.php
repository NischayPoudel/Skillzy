<?php

use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\StaffDashboardController;
use App\Http\Controllers\Staff\DashboardController as StaffDashCtrl;
use App\Http\Controllers\Dashboard\UserDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\AboutController;
use App\Models\UserSkill;
use App\Models\Purchase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route model bindings
Route::model('listing', UserSkill::class);
Route::model('purchase', Purchase::class);

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user) {
        return redirect()->route($user->role . '.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public Skills Routes
Route::resource('skills', SkillController::class);

// Debug: Test Khalti Connection (remove in production)
Route::get('/debug/khalti', function () {
    if (!config('app.debug')) {
        abort(403);
    }
    
    $khaltiService = app(\App\Services\KhaltiService::class);
    
    $testData = [
        'return_url' => route('wallet.callback'),
        'purchase_order_id' => 'test_debug_' . time(),
        'purchase_order_name' => 'Debug Test Payment',
        'amount' => 1, // 1 NPR (minimum)
        'customer_info' => [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '9800000000',
        ],
    ];
    
    $response = $khaltiService->initiatePayment($testData);
    
    return response()->json([
        'status' => 'debug_test',
        'khalti_response' => $response,
        'config' => [
            'base_url' => config('services.khalti.base_url'),
            'merchant_code' => config('services.khalti.merchant_code'),
            'has_secret_key' => !empty(config('services.khalti.secret_key')),
            'has_public_key' => !empty(config('services.khalti.public_key')),
        ]
    ]);
})->name('debug.khalti');

// Public Listings Routes
Route::resource('listings', ListingController::class)->only(['index', 'show']);
Route::get('/search', [ListingController::class, 'search'])->name('listings.search');

// Support & About Pages
Route::get('/support', [SupportController::class, 'show'])->name('support.show');
Route::get('/about', [AboutController::class, 'show'])->name('about.show');

// Purchase Routes
Route::middleware('auth')->resource('purchases', PurchaseController::class)->only(['index', 'store', 'show', 'update']);

// Wallet & Transactions
Route::middleware('auth')->get('/wallet', [WalletController::class, 'show'])->name('wallet.show');
Route::middleware('auth')->post('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
Route::middleware('auth')->get('/wallet/callback', [WalletController::class, 'callback'])->name('wallet.callback');

// Messages
Route::middleware('auth')->get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::middleware('auth')->get('/messages/{userId}', [MessageController::class, 'show'])->name('messages.show');
Route::middleware('auth')->post('/messages', [MessageController::class, 'store'])->name('messages.store');

// Reviews
Route::middleware('auth')->post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Notifications
Route::middleware('auth')->get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::middleware('auth')->post('/notifications/{notification}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.markRead');

// User Routes
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', UserDashboardController::class)->name('dashboard');
    Route::resource('listings', ListingController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

// Staff Routes
Route::middleware(['auth', 'verified', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', StaffDashCtrl::class)->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Staff\UserController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::resource('purchases', \App\Http\Controllers\Staff\PurchaseController::class)->only(['index']);
    Route::resource('skills', \App\Http\Controllers\Staff\SkillController::class);
});

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('skills', \App\Http\Controllers\Admin\SkillController::class);
    Route::resource('purchases', \App\Http\Controllers\Admin\PurchaseController::class)->only(['index']);
    Route::resource('coins', \App\Http\Controllers\Admin\CoinController::class)->only(['index', 'edit', 'update']);
    Route::get('/coins/{user}/transactions', [\App\Http\Controllers\Admin\CoinController::class, 'transactions'])->name('coins.transactions');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
