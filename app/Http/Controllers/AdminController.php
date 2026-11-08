<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private array $modules = [
        'kategori' => ['title'=>'Kategori','pk'=>'id_kategori','fields'=>['nama_kategori'=>'Nama kategori','slug'=>'Slug','deskripsi'=>'Deskripsi','status'=>'Status']],
        'brand' => ['title'=>'Brand','pk'=>'id_brand','fields'=>['nama_brand'=>'Nama brand','slug'=>'Slug','deskripsi'=>'Deskripsi','logo'=>'Logo','status'=>'Status']],
        'status_pesanan' => ['title'=>'Status pesanan','pk'=>'id_status','fields'=>['kode_status'=>'Kode status','nama_status'=>'Nama status','deskripsi'=>'Deskripsi','urutan'=>'Urutan']],
        'metode_pembayaran' => ['title'=>'Metode pembayaran','pk'=>'id_metode','fields'=>['nama_metode'=>'Nama metode','jenis_metode'=>'Jenis metode','instruksi'=>'Instruksi','status'=>'Status']],
        'kurir' => ['title'=>'Kurir','pk'=>'id_kurir','fields'=>['nama_kurir'=>'Nama kurir','kode_kurir'=>'Kode kurir','layanan'=>'Layanan','status'=>'Status']],
        'voucher' => ['title'=>'Voucher','pk'=>'id_voucher','fields'=>['kode_voucher'=>'Kode voucher','nama_voucher'=>'Nama voucher','deskripsi'=>'Deskripsi','jenis_diskon'=>'Jenis diskon (persen/nominal)','nilai_diskon'=>'Nilai diskon','minimal_pembelian'=>'Minimal pembelian','maksimal_diskon'=>'Maksimal diskon','kuota'=>'Kuota','mulai_berlaku'=>'Mulai berlaku (YYYY-MM-DD HH:MM:SS)','akhir_berlaku'=>'Akhir berlaku (YYYY-MM-DD HH:MM:SS)','status'=>'Status']],
        'users' => ['title'=>'Akun pengguna','pk'=>'id_user','fields'=>['nama'=>'Nama','email'=>'Email','role'=>'Peran','no_hp'=>'No. HP']],
        'pembayaran' => ['title'=>'Pembayaran','pk'=>'id_pembayaran','fields'=>['id_pesanan'=>'ID pesanan','id_metode'=>'Metode','nomor_referensi'=>'Nomor referensi','jumlah_bayar'=>'Jumlah','status_pembayaran'=>'Status pembayaran','waktu_bayar'=>'Waktu bayar (YYYY-MM-DD HH:MM:SS)','bukti_pembayaran'=>'Bukti','catatan'=>'Catatan']],
        'pengiriman' => ['title'=>'Pengiriman','pk'=>'id_pengiriman','fields'=>['id_pesanan'=>'ID pesanan','id_kurir'=>'Kurir','nomor_resi'=>'Nomor resi','biaya_pengiriman'=>'Biaya','status_pengiriman'=>'Status','tanggal_dikirim'=>'Tanggal dikirim','estimasi_tiba'=>'Estimasi tiba','tanggal_diterima'=>'Tanggal diterima']],
        'ulasan_produk' => ['title'=>'Ulasan produk','pk'=>'id_ulasan','fields'=>['id_user'=>'Customer','id_produk'=>'Produk','id_detail_pesanan'=>'Detail pesanan','rating'=>'Rating','komentar'=>'Komentar','status'=>'Status']],
        'notifikasi' => ['title'=>'Notifikasi','pk'=>'id_notifikasi','fields'=>['id_user'=>'Customer','id_pesanan'=>'Pesanan','judul'=>'Judul','pesan'=>'Pesan','jenis_notifikasi'=>'Jenis','sudah_dibaca'=>'Dibaca']],
        'stok_produk' => ['title'=>'Stok produk','pk'=>'id_stok','fields'=>['id_produk'=>'Produk','jumlah_stok'=>'Jumlah stok','stok_minimum'=>'Stok minimum']],
        'alamat' => ['title'=>'Alamat customer','pk'=>'id_alamat','fields'=>['id_user'=>'Customer','label_alamat'=>'Label','nama_penerima'=>'Penerima','no_hp_penerima'=>'No. HP','provinsi'=>'Provinsi','kota'=>'Kota','kecamatan'=>'Kecamatan','kode_pos'=>'Kode pos','alamat_lengkap'=>'Alamat lengkap','catatan'=>'Catatan','alamat_utama'=>'Utama']],
        'keranjang' => ['title'=>'Keranjang customer','pk'=>'id_keranjang','fields'=>['id_user'=>'Customer','status'=>'Status']],
        'detail_keranjang' => ['title'=>'Item keranjang','pk'=>'id_detail_keranjang','fields'=>['id_keranjang'=>'Keranjang','id_produk'=>'Produk','jumlah'=>'Jumlah']],
        'detail_pesanan' => ['title'=>'Detail pesanan','pk'=>'id_detail_pesanan','fields'=>['id_pesanan'=>'Pesanan','id_produk'=>'Produk','nama_produk_saat_beli'=>'Nama produk saat beli','sku_saat_beli'=>'SKU saat beli','jumlah'=>'Jumlah','harga_satuan'=>'Harga satuan','subtotal'=>'Subtotal']],
        'penggunaan_voucher' => ['title'=>'Penggunaan voucher','pk'=>'id_penggunaan_voucher','fields'=>['id_voucher'=>'Voucher','id_user'=>'Customer','id_pesanan'=>'Pesanan','jumlah_diskon'=>'Diskon']],
        'riwayat_pengiriman' => ['title'=>'Riwayat pengiriman','pk'=>'id_riwayat_pengiriman','fields'=>['id_pengiriman'=>'Pengiriman','status_pengiriman'=>'Status','lokasi'=>'Lokasi','keterangan'=>'Keterangan','waktu_update'=>'Waktu update (YYYY-MM-DD HH:MM:SS)']],
        'riwayat_status_pesanan' => ['title'=>'Riwayat status pesanan','pk'=>'id_riwayat','fields'=>['id_pesanan'=>'Pesanan','id_status'=>'Status','keterangan'=>'Keterangan','waktu_status'=>'Waktu status (YYYY-MM-DD HH:MM:SS)']],
        'wishlist' => ['title'=>'Wishlist','pk'=>'id_wishlist','fields'=>['id_user'=>'Customer','id_produk'=>'Produk']],
        'gambar_produk' => ['title'=>'Galeri produk','pk'=>'id_gambar','fields'=>['id_produk'=>'Produk','path_gambar'=>'Path gambar','alt_text'=>'Alt text','gambar_utama'=>'Gambar utama','urutan'=>'Urutan']],
    ];

    public function dashboard()
    {
        $stats = [
            'produk'=>DB::table('produk')->count(),
            'pesanan'=>DB::table('pesanan')->count(),
            'pelanggan'=>DB::table('users')->where('role','customer')->count(),
            'omzet'=>DB::table('pesanan')->whereIn('id_status', DB::table('status_pesanan')->whereIn('kode_status',['dibayar','diproses','dikemas','dikirim','selesai'])->pluck('id_status'))->sum('total_harga'),
        ];
        $statusCounts = DB::table('status_pesanan as s')->leftJoin('pesanan as p','p.id_status','=','s.id_status')->select('s.nama_status',DB::raw('COUNT(p.id_pesanan) as total'))->groupBy('s.id_status','s.nama_status','s.urutan')->orderBy('s.urutan')->get();
        $orders = DB::table('pesanan as p')->join('users as u','u.id_user','=','p.id_user')->join('status_pesanan as s','s.id_status','=','p.id_status')->select('p.*','u.nama','s.nama_status')->latest('p.tanggal_pesanan')->limit(8)->get();
        return view('admin.dashboard', compact('stats','orders','statusCounts'));
    }

    public function products()
    {
        $products=DB::table('produk as p')->leftJoin('kategori as k','k.id_kategori','=','p.id_kategori')->leftJoin('brand as b','b.id_brand','=','p.id_brand')->leftJoin('stok_produk as s','s.id_produk','=','p.id_produk')->leftJoin('gambar_produk as g',function($j){$j->on('g.id_produk','=','p.id_produk')->where('g.gambar_utama',1); })->select('p.*','k.nama_kategori','b.nama_brand','s.jumlah_stok','g.path_gambar')->latest('p.id_produk')->paginate(15);
        return view('admin.products',compact('products'));
    }
    public function createProduct(){return view('admin.product-form',['product'=>null,'categories'=>DB::table('kategori')->get(),'brands'=>DB::table('brand')->get()]);}
    public function storeProduct(Request $r){$d=$this->validateProduct($r);$slug=Str::slug($d['nama_produk']);if(DB::table('produk')->where('slug',$slug)->exists())$slug.='-'.Str::lower(Str::random(4));$id=DB::table('produk')->insertGetId(collect($d)->except(['jumlah_stok','images'])->all()+['slug'=>$slug,'status'=>$d['status']??'aktif','created_at'=>now(),'updated_at'=>now()]);DB::table('stok_produk')->updateOrInsert(['id_produk'=>$id],['jumlah_stok'=>$d['jumlah_stok'],'stok_minimum'=>5,'updated_at'=>now()]);$this->saveProductImages($id,$r,$d['nama_produk']);return redirect()->route('admin.products')->with('success','Produk berhasil ditambahkan.');}
    public function editProduct($id){$product=DB::table('produk as p')->leftJoin('stok_produk as s','s.id_produk','=','p.id_produk')->leftJoin('gambar_produk as g',function($j){$j->on('g.id_produk','=','p.id_produk')->where('g.gambar_utama',1);})->where('p.id_produk',$id)->select('p.*','s.jumlah_stok','g.path_gambar')->first();abort_if(!$product,404);return view('admin.product-form',['product'=>$product,'categories'=>DB::table('kategori')->get(),'brands'=>DB::table('brand')->get()]);}
    public function updateProduct(Request $r,$id){$d=$this->validateProduct($r,$id);$data=collect($d)->except(['jumlah_stok','images'])->all();$data['updated_at']=now();DB::table('produk')->where('id_produk',$id)->update($data);DB::table('stok_produk')->updateOrInsert(['id_produk'=>$id],['jumlah_stok'=>$d['jumlah_stok'],'stok_minimum'=>5,'updated_at'=>now()]);$this->saveProductImages($id,$r,$d['nama_produk']);return redirect()->route('admin.products')->with('success','Produk berhasil diperbarui.');}
    private function validateProduct(Request $r,$id=null){return $r->validate(['nama_produk'=>'required|max:150','id_kategori'=>'required|integer','id_brand'=>'required|integer','sku'=>'required|max:50|unique:produk,sku'.($id?','.$id.',id_produk':''),'harga'=>'required|numeric|min:0','harga_coret'=>'nullable|numeric|min:0','berat_gram'=>'nullable|integer|min:0','deskripsi'=>'nullable','manfaat'=>'nullable','cara_pakai'=>'nullable','komposisi'=>'nullable','jenis_kulit'=>'nullable|max:100','jumlah_stok'=>'required|integer|min:0','status'=>'required|in:aktif,draft,nonaktif','images'=>'nullable|array|max:8','images.*'=>'image|mimes:jpg,jpeg,png,webp|max:4096']);}
    private function saveProductImages($id,Request $request,$name){$files=$request->file('images',[]);if(!$files)return;DB::table('gambar_produk')->where('id_produk',$id)->update(['gambar_utama'=>0]);foreach($files as $index=>$file){$path=$file->store('products','public');DB::table('gambar_produk')->insert(['id_produk'=>$id,'path_gambar'=>'/storage/'.$path,'alt_text'=>$name,'gambar_utama'=>$index===0?1:0,'urutan'=>DB::table('gambar_produk')->where('id_produk',$id)->count(),'created_at'=>now()]);}}
    public function deleteProduct($id){DB::table('produk')->where('id_produk',$id)->update(['status'=>'nonaktif','updated_at'=>now()]);return back()->with('success','Produk dinonaktifkan.');}
    public function orders(){ $orders=DB::table('pesanan as p')->join('users as u','u.id_user','=','p.id_user')->join('status_pesanan as s','s.id_status','=','p.id_status')->leftJoin('pembayaran as pay','pay.id_pesanan','=','p.id_pesanan')->leftJoin('metode_pembayaran as mp','mp.id_metode','=','pay.id_metode')->select('p.*','u.nama','u.email','s.nama_status','pay.status_pembayaran','pay.bukti_pembayaran','mp.nama_metode')->latest('p.tanggal_pesanan')->paginate(20);$statuses=DB::table('status_pesanan')->orderBy('urutan')->get();return view('admin.orders',compact('orders','statuses'));}
    public function updateOrder(Request $r,$id){$r->validate(['id_status'=>'required|integer|exists:status_pesanan,id_status']);DB::table('pesanan')->where('id_pesanan',$id)->update(['id_status'=>$r->id_status,'updated_at'=>now()]);DB::table('riwayat_status_pesanan')->insert(['id_pesanan'=>$id,'id_status'=>$r->id_status,'keterangan'=>'Status diperbarui oleh admin','waktu_status'=>now()]);return back()->with('success','Status pesanan diperbarui.');}


    public function confirmPayment($id){
        $payment=DB::table('pembayaran')->where('id_pesanan',$id)->first();
        abort_if(!$payment,404);
        DB::table('pembayaran')->where('id_pesanan',$id)->update(['status_pembayaran'=>'berhasil','waktu_bayar'=>now(),'updated_at'=>now(),'catatan'=>'Pembayaran dikonfirmasi oleh admin']);
        $paidStatus=DB::table('status_pesanan')->where('kode_status','dibayar')->value('id_status');
        if($paidStatus){DB::table('pesanan')->where('id_pesanan',$id)->update(['id_status'=>$paidStatus,'updated_at'=>now()]);DB::table('riwayat_status_pesanan')->insert(['id_pesanan'=>$id,'id_status'=>$paidStatus,'keterangan'=>'Pembayaran dikonfirmasi oleh admin','waktu_status'=>now()]);}
        return back()->with('success','Pembayaran berhasil dikonfirmasi.');
    }

    public function dataModule($table){$module=$this->module($table);$rows=DB::table($table)->orderByDesc($module['pk'])->paginate(20);return view('admin.data-module',compact('table','module','rows'));}
    public function storeData(Request $r,$table){$m=$this->module($table);$data=$this->moduleData($r,$table,$m);if($table==='gambar_produk' && $r->hasFile('gambar_file')){$r->validate(['gambar_file'=>'required|image|mimes:jpg,jpeg,png,webp|max:4096']);$path=$r->file('gambar_file')->store('products','public');$data['path_gambar']='/storage/'.$path;}if($table==='users')$data['password']=\Illuminate\Support\Facades\Hash::make($r->input('password','ChangeMe123!'));$data['created_at']=now();if(Schema::hasColumn($table,'updated_at'))$data['updated_at']=now();DB::table($table)->insert($data);return back()->with('success','Data berhasil ditambahkan.');}
    public function updateData(Request $r,$table,$id){$m=$this->module($table);$data=$this->moduleData($r,$table,$m);if($table==='gambar_produk' && $r->hasFile('gambar_file')){$r->validate(['gambar_file'=>'image|mimes:jpg,jpeg,png,webp|max:4096']);$path=$r->file('gambar_file')->store('products','public');$data['path_gambar']='/storage/'.$path;}if($table==='users' && $r->filled('password'))$data['password']=\Illuminate\Support\Facades\Hash::make($r->input('password'));if(Schema::hasColumn($table,'updated_at'))$data['updated_at']=now();DB::table($table)->where($m['pk'],$id)->update($data);return back()->with('success','Data berhasil diperbarui.');}
    public function deleteData($table,$id){$m=$this->module($table);if(in_array($table,['users','kategori','brand','status_pesanan','metode_pembayaran','kurir']))return back()->with('error','Data ini tidak dihapus langsung untuk menjaga riwayat transaksi. Ubah statusnya menjadi nonaktif jika tersedia.');DB::table($table)->where($m['pk'],$id)->delete();return back()->with('success','Data berhasil dihapus.');}
    private function module($table){abort_unless(isset($this->modules[$table]),404);return $this->modules[$table];}
    private function moduleData(Request $r,$table,$module){$data=[];foreach(array_keys($module['fields']) as $field){if($field==='password')continue;if($r->exists($field))$data[$field]=$r->input($field);}return $data;}
}
