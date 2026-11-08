<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder; use Illuminate\Support\Facades\DB; use Illuminate\Support\Str;
class BeautyDemoSeeder extends Seeder {
 public function run(): void {
  $items=[
  ['Dew Drop Hydrating Serum',1,2,99000,129000,'Semua jenis kulit','Serum hidrasi untuk tampilan kulit segar.'],
  ['Barrier Repair Cream',1,3,119000,149000,'Kering dan sensitif','Krim pelembap untuk mendukung skin barrier.'],
  ['Rice Glow Toner',1,4,79000,99000,'Semua jenis kulit','Toner ringan untuk rutinitas harian.'],
  ['Vitamin C Bright Serum',1,2,109000,139000,'Normal dan kusam','Serum perawatan dengan vitamin C.'],
  ['Daily UV Shield SPF 50',1,4,89000,115000,'Semua jenis kulit','Sunscreen untuk pemakaian pagi hari.'],
  ['Cica Calming Gel',1,3,85000,105000,'Sensitif dan berminyak','Gel ringan dengan sensasi menenangkan.'],
  ['Peptide Eye Cream',1,1,145000,179000,'Semua jenis kulit','Perawatan area mata untuk rutinitas malam.'],
  ['AHA Gentle Exfoliating Toner',1,2,95000,119000,'Normal dan berminyak','Eksfoliasi lembut sesuai petunjuk pemakaian.'],
  ['Cloud Velvet Lip Tint',2,4,59000,75000,'Semua jenis kulit','Lip tint dengan warna lembut untuk sehari-hari.'],
  ['Soft Focus Blush',2,5,69000,89000,'Semua jenis kulit','Blush untuk tampilan pipi segar.'],
  ['Second Skin Cushion',2,2,139000,169000,'Semua jenis kulit','Cushion untuk riasan harian.'],
  ['Everyday Brow Pencil',2,4,39000,49000,'Semua jenis kulit','Pensil alis praktis untuk membingkai alis.'],
  ['Luminous Highlighter',2,5,79000,99000,'Semua jenis kulit','Highlighter untuk sentuhan akhir makeup.'],
  ['Nude Mood Eyeshadow',2,5,99000,125000,'Semua jenis kulit','Palet warna netral untuk berbagai suasana.'],
  ['Silky Shea Body Lotion',3,1,72000,89000,'Semua jenis kulit','Lotion untuk menjaga kelembapan tubuh.'],
  ['Vanilla Cloud Body Wash',3,5,65000,79000,'Semua jenis kulit','Pembersih tubuh dengan aroma lembut.'],
  ['Exfoliating Body Scrub',3,3,78000,99000,'Semua jenis kulit','Scrub untuk perawatan tubuh berkala.'],
  ['Repairing Hair Mask',4,2,88000,109000,'Rambut kering','Masker rambut untuk perawatan mingguan.'],
  ['Rosemary Scalp Tonic',4,3,92000,115000,'Semua jenis rambut','Tonic untuk melengkapi perawatan kulit kepala.'],
  ['Silk Finish Hair Serum',4,4,69000,85000,'Semua jenis rambut','Serum rambut untuk tampilan lebih rapi.'],
  ['Blooming Petals Eau de Parfum',5,1,159000,189000,'Floral','Parfum floral untuk aktivitas sehari-hari.'],
  ['Soft Musk Eau de Toilette',5,5,139000,169000,'Woody musk','Aroma lembut untuk penggunaan harian.'],
  ['Citrus Day Mist',5,2,99000,125000,'Fresh citrus','Body mist segar untuk menemani harimu.'],
  ['Midnight Amber Perfume',5,5,179000,215000,'Warm amber','Aroma hangat untuk momen spesial.']
  ];
  $photos=['dew-drop-hydrating-serum','barrier-repair-cream','rice-glow-toner','vitamin-c-bright-serum','daily-uv-shield-spf-50','cica-calming-gel','peptide-eye-cream','aha-gentle-exfoliating-toner','cloud-velvet-lip-tint','soft-focus-blush','second-skin-cushion','everyday-brow-pencil','luminous-highlighter','nude-mood-eyeshadow','silky-shea-body-lotion','vanilla-cloud-body-wash','exfoliating-body-scrub','repairing-hair-mask','rosemary-scalp-tonic','silk-finish-hair-serum','blooming-petals-eau-de-parfum','soft-musk-eau-de-toilette','citrus-day-mist','midnight-amber-perfume'];
  foreach($items as $i=>$x){[$name,$cat,$brand,$price,$old,$skin,$desc]=$x;$slug=Str::slug($name);$id=DB::table('produk')->where('slug',$slug)->value('id_produk');$data=['id_kategori'=>$cat,'id_brand'=>$brand,'nama_produk'=>$name,'slug'=>$slug,'sku'=>'LUX-'.str_pad($i+20,4,'0',STR_PAD_LEFT),'deskripsi'=>$desc,'manfaat'=>$desc,'cara_pakai'=>'Gunakan sesuai kebutuhan dan petunjuk pada kemasan.','komposisi'=>'Lihat informasi komposisi pada kemasan produk.','jenis_kulit'=>$skin,'berat_gram'=>30,'harga'=>$price,'harga_coret'=>$old,'status'=>'aktif','updated_at'=>now()];if($id){DB::table('produk')->where('id_produk',$id)->update($data);}else{$data['created_at']=now();$id=DB::table('produk')->insertGetId($data);}DB::table('stok_produk')->updateOrInsert(['id_produk'=>$id],['jumlah_stok'=>rand(12,65),'stok_minimum'=>5,'updated_at'=>now()]);DB::table('gambar_produk')->updateOrInsert(['id_produk'=>$id,'urutan'=>0],['path_gambar'=>'/images/products/'.$photos[$i].'.svg','alt_text'=>$name,'gambar_utama'=>1,'urutan'=>0,'created_at'=>now()]);}
  foreach(DB::table('produk')->get() as $existing){DB::table('stok_produk')->updateOrInsert(['id_produk'=>$existing->id_produk],['jumlah_stok'=>30,'stok_minimum'=>5,'updated_at'=>now()]);DB::table('gambar_produk')->updateOrInsert(['id_produk'=>$existing->id_produk,'urutan'=>0],['path_gambar'=>'/images/products/'.Str::slug($existing->nama_produk).'.svg','alt_text'=>$existing->nama_produk,'gambar_utama'=>1,'urutan'=>0,'created_at'=>now()]);}
  foreach([['id_metode'=>1,'nama_metode'=>'Transfer Bank','jenis_metode'=>'transfer_bank'],['id_metode'=>2,'nama_metode'=>'Virtual Account','jenis_metode'=>'virtual_account'],['id_metode'=>3,'nama_metode'=>'E-Wallet','jenis_metode'=>'e_wallet'],['id_metode'=>4,'nama_metode'=>'COD','jenis_metode'=>'cod']] as $m){DB::table('metode_pembayaran')->updateOrInsert(['id_metode'=>$m['id_metode']],$m+['instruksi'=>'Ikuti instruksi pembayaran pada halaman pesanan.','status'=>'aktif']);}
  foreach([['JNE','JNE'],['J&T Express','JNT'],['SiCepat','SICEPAT'],['AnterAja','ANTERAJA']] as $c){DB::table('kurir')->updateOrInsert(['kode_kurir'=>$c[1]],['nama_kurir'=>$c[0],'kode_kurir'=>$c[1],'layanan'=>'Regular','status'=>'aktif']);}
  foreach([['menunggu_pembayaran','Menunggu Pembayaran'],['dibayar','Dibayar'],['diproses','Diproses'],['dikemas','Dikemas'],['dikirim','Dikirim'],['selesai','Selesai'],['dibatalkan','Dibatalkan'],['gagal','Gagal']] as $i=>$s){DB::table('status_pesanan')->updateOrInsert(['kode_status'=>$s[0]],['kode_status'=>$s[0],'nama_status'=>$s[1],'deskripsi'=>$s[1],'urutan'=>$i+1]);}
 }
}
