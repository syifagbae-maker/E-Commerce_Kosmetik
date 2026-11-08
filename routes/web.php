
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\GambarProdukController;


// ==========================================
// CUSTOMER WEBSITE
// ==========================================

// HOMEPAGE
Route::get('/', [StoreController::class, 'home'])
    ->name('home');

// PRODUCT CATALOG
Route::get('/produk', [StoreController::class, 'catalog'])
    ->name('catalog');

// NAVIGASI LUXSKIN
Route::get('/new-arrivals', [StoreController::class, 'newArrivals'])
    ->name('new-arrivals');

Route::get('/brands', [StoreController::class, 'brands'])
    ->name('brands');

Route::get('/categories', [StoreController::class, 'categories'])
    ->name('categories');

Route::get('/promotions', [StoreController::class, 'promotions'])
    ->name('promotions');

// PRODUCT DETAIL
Route::get('/produk/{slug}', [StoreController::class, 'product'])
    ->name('product');


// CUSTOMER LOGIN & REGISTER
Route::get('/login', fn () => view('auth.login'))
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::get('/register', fn () => view('auth.register'))
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');


// GOOGLE LOGIN
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])
    ->name('google.login');

Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');


// FACEBOOK LOGIN
Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])
    ->name('facebook.login');

Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback'])
    ->name('facebook.callback');


// CUSTOMER LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// SHOPPING CART
Route::post('/keranjang/{id}', [StoreController::class, 'addCart'])
    ->name('cart.add');

Route::get('/keranjang', [StoreController::class, 'cart'])
    ->name('cart');

Route::patch('/keranjang/{id}', [StoreController::class, 'updateCart'])
    ->name('cart.update');

Route::delete('/keranjang/{id}', [StoreController::class, 'removeCart'])
    ->name('cart.remove');


// CUSTOMER ADDRESS
Route::get('/alamat', [StoreController::class, 'addresses'])
    ->name('addresses');

Route::post('/alamat', [StoreController::class, 'saveAddress'])
    ->name('addresses.save');


// CHECKOUT & ORDERS
Route::get('/checkout', [StoreController::class, 'checkout'])
    ->name('checkout');

Route::post('/checkout', [StoreController::class, 'placeOrder'])
    ->name('checkout.place');

Route::post('/pesanan/{id}/bukti-pembayaran', [
    StoreController::class,
    'paymentProof'
])->name('orders.payment-proof');

Route::get('/pesanan', [StoreController::class, 'orders'])
    ->name('orders');


// ==========================================
// ADMIN WEBSITE
// ==========================================

Route::prefix('admin')->group(function () {

    // ADMIN LOGIN
    Route::get('/login', fn () => view('admin.login'))
        ->name('admin.login');

    Route::post('/login', [AuthController::class, 'adminLogin'])
        ->name('admin.login.post');


    // ADMIN PAGES - LOGIN REQUIRED
    Route::middleware(['admin'])->group(function () {

        // DASHBOARD
        Route::get('/', [AdminController::class, 'dashboard'])
            ->name('admin');

        // LOGOUT
        Route::post('/logout', [AuthController::class, 'adminLogout'])
            ->name('admin.logout');


        // PRODUCT MANAGEMENT
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


        // PRODUCT IMAGE MANAGEMENT
        Route::resource('/gambar-produk', GambarProdukController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.gambar-produk.index',
                'create' => 'admin.gambar-produk.create',
                'store' => 'admin.gambar-produk.store',
                'edit' => 'admin.gambar-produk.edit',
                'update' => 'admin.gambar-produk.update',
                'destroy' => 'admin.gambar-produk.destroy',
            ]);


        // CATEGORY MANAGEMENT
        Route::resource('/kategori', KategoriController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.kategori.index',
                'create' => 'admin.kategori.create',
                'store' => 'admin.kategori.store',
                'edit' => 'admin.kategori.edit',
                'update' => 'admin.kategori.update',
                'destroy' => 'admin.kategori.destroy',
            ]);


        // BRAND MANAGEMENT
        Route::resource('/brand', BrandController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.brands.index',
                'create' => 'admin.brands.create',
                'store' => 'admin.brands.store',
                'edit' => 'admin.brands.edit',
                'update' => 'admin.brands.update',
                'destroy' => 'admin.brands.destroy',
            ]);


        // ORDER MANAGEMENT
        Route::get('/pesanan', [AdminController::class, 'orders'])
            ->name('admin.orders');

        Route::patch('/pesanan/{id}', [AdminController::class, 'updateOrder'])
            ->name('admin.orders.update');

        Route::post('/pesanan/{id}/konfirmasi-pembayaran', [
            AdminController::class,
            'confirmPayment'
        ])->name('admin.payment.confirm');


        // DATABASE MODULE MANAGEMENT
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


// ==========================================
// DATABASE CHECK
// ==========================================

Route::get('/cek-produk-luxskin', function () {

    return response()->json([
        'database' => DB::connection()->getDatabaseName(),
        'total_produk' => DB::table('produk')->count(),
        'produk' => DB::table('produk')
            ->select('id_produk', 'nama_produk', 'status')
            ->orderByDesc('id_produk')
            ->limit(10)
            ->get(),
    ]);

});
