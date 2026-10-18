
<?php

use App\Http\Controllers\Admin\ProdukController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('aura.home');
});

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return redirect('/admin');
    });

    Route::get('/admin', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        $totalProduk = DB::table('produk')->count();
        $totalPesanan = DB::table('pesanan')->count();
        $totalPelanggan = DB::table('users')
            ->where('role', 'customer')
            ->count();
        $totalKategori = DB::table('kategori')->count();

        $produkTerbaru = DB::table('produk')
            ->select(
                'id_produk',
                'nama_produk',
                'harga',
                'status',
                'created_at'
            )
            ->orderByDesc('id_produk')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'totalPelanggan',
            'totalKategori',
            'produkTerbaru'
        ));
    });

    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/produk', function () {
                if (auth()->user()->role !== 'admin') {
                    abort(403, 'Akses khusus admin.');
                }

                return app(ProdukController::class)->index(request());
            })->name('produk.index');

            Route::get('/produk/create', function () {
                if (auth()->user()->role !== 'admin') {
                    abort(403, 'Akses khusus admin.');
                }

                return app(ProdukController::class)->create();
            })->name('produk.create');

            Route::post('/produk', function () {
                if (auth()->user()->role !== 'admin') {
                    abort(403, 'Akses khusus admin.');
                }

                return app(ProdukController::class)->store(request());
            })->name('produk.store');
        });
});
