
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AdminController;

// ==========================================
// CUSTOMER WEBSITE
// Domain: luxskinbeauty.com
// ==========================================

Route::domain(env('APP_DOMAIN', '127.0.0.1'))->group(function () {

    // Homepage & Product Catalog
    Route::get('/', [StoreController::class, 'home'])->name('home');
    Route::get('/produk', [StoreController::class, 'catalog'])->name('catalog');
    Route::get('/produk/{slug}', [StoreController::class, 'product'])->name('product');

    // Customer Authentication
    Route::get('/login', fn () => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', fn () => view('auth.register'))->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Shopping Cart
    Route::post('/keranjang/{id}', [StoreController::class, 'addCart'])->name('cart.add');
    Route::get('/keranjang', [StoreController::class, 'cart'])->name('cart');
    Route::patch('/keranjang/{id}', [StoreController::class, 'updateCart'])->name('cart.update');
    Route::delete('/keranjang/{id}', [StoreController::class, 'removeCart'])->name('cart.remove');

    // Customer Address
    Route::get('/alamat', [StoreController::class, 'addresses'])->name('addresses');
    Route::post('/alamat', [StoreController::class, 'saveAddress'])->name('addresses.save');

    // Checkout & Orders
    Route::get('/checkout', [StoreController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [StoreController::class, 'placeOrder'])->name('checkout.place');
    Route::post('/pesanan/{id}/bukti-pembayaran', [StoreController::class, 'paymentProof'])->name('orders.payment-proof');
    Route::get('/pesanan', [StoreController::class, 'orders'])->name('orders');
});


// ==========================================
// ADMIN WEBSITE
// Domain: admin.luxskinbeauty.com
// ==========================================

Route::domain(env('ADMIN_DOMAIN', 'admin.luxskinbeauty.test'))->group(function () {

    // Admin Login
    Route::get('/login', fn () => view('admin.login'))
        ->name('admin.login');

    Route::post('/login', [AuthController::class, 'adminLogin'])
        ->name('admin.login.post');

    // Protected Admin Pages
    Route::middleware(['admin'])->group(function () {

        // Admin Logout
        Route::post('/logout', [AuthController::class, 'adminLogout'])
            ->name('admin.logout');

        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])
            ->name('admin');

        // Product Management (CRUD)
        Route::get('/produk', [AdminController::class, 'products'])
            ->name('admin.products');

        Route::get('/produk/tambah', [AdminController::class, 'createProduct'])
            ->name('admin.products.create');

        Route::post('/produk', [AdminController::class, 'storeProduct'])
            ->name('admin.products.store');

        Route::get('/produk/{id}/edit', [AdminController::class, 'editProduct'])
            ->name('admin.products.edit');

        Route::put('/produk/{id}', [AdminController::class, 'updateProduct'])
            ->name('admin.products.update');

        Route::delete('/produk/{id}', [AdminController::class, 'deleteProduct'])
            ->name('admin.products.delete');

        // Order Management
        Route::get('/pesanan', [AdminController::class, 'orders'])
            ->name('admin.orders');

        Route::patch('/pesanan/{id}', [AdminController::class, 'updateOrder'])
            ->name('admin.orders.update');
        Route::post('/pesanan/{id}/konfirmasi-pembayaran', [AdminController::class, 'confirmPayment'])->name('admin.payment.confirm');

        // Database / ERD Module Management
        Route::get('/data/{table}', [AdminController::class, 'dataModule'])
            ->name('admin.data');

        Route::post('/data/{table}', [AdminController::class, 'storeData'])
            ->name('admin.data.store');

        Route::put('/data/{table}/{id}', [AdminController::class, 'updateData'])
            ->name('admin.data.update');

        Route::delete('/data/{table}/{id}', [AdminController::class, 'deleteData'])
            ->name('admin.data.delete');
    });
});
