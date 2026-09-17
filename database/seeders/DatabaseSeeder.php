<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\AprioriConfig;
use App\Models\Transaction;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::findOrCreate('admin');
        Role::findOrCreate('wisatawan');
        $admin = User::factory()->create(['name' => 'Admin BUMDes', 'email' => 'admin@jalatrang.test', 'phone' => '081234567890']);
        $admin->assignRole('admin');
        $visitor = User::factory()->create(['name' => 'Wisatawan Demo', 'email' => 'wisatawan@jalatrang.test']);
        $visitor->assignRole('wisatawan');
        $wisata = Category::create(['name' => 'Paket Wisata', 'slug' => 'paket-wisata', 'description' => 'Pengalaman khas Desa Jalatrang.']);
        $merch = Category::create(['name' => 'Cenderamata', 'slug' => 'cenderamata', 'description' => 'Produk lokal untuk dibawa pulang.']);
        $items = [
            [$wisata, 'PW-01', 'Edukasi Pertanian', 'Belajar bertani bersama warga.', 75000, '3 jam', 'ODr3OCHB8S8'],
            [$wisata, 'PW-02', 'Alam Trekking', 'Menyusuri jalur alam Jalatrang.', 85000, '4 jam', 'rFyVKjtmEpM'],
            [$wisata, 'PW-03', 'Budaya Sunda', 'Pengalaman seni dan budaya Sunda.', 100000, '4 jam', 'YUHGb7GkkBM'],
            [$wisata, 'PW-04', 'Foto Sawah', 'Sesi foto di hamparan sawah.', 50000, '2 jam', 'WTNIiRpYSoY'],
            [$wisata, 'PW-05', 'Seharian Penuh', 'Paket wisata lengkap satu hari.', 175000, '8 jam', '2BboZLvlbqw'],
            [$merch, 'MD-01', 'Kopi Jalatrang', 'Kopi lokal pilihan.', 35000, null, 'VLhb6vY2Szo'],
            [$merch, 'MD-02', 'Gula Aren', 'Gula aren murni produksi warga.', 25000, null, 'GgxDAUlCrMk'],
            [$merch, 'MD-03', 'Keripik Singkong', 'Keripik singkong khas Jalatrang.', 20000, null, 'Vk8zXs90v-s'],
            [$merch, 'MD-04', 'Anyaman Bambu', 'Kerajinan anyaman bambu.', 65000, null, '6XVyZTQqAzU'],
            [$merch, 'MD-05', 'Batik Jalatrang', 'Kain batik motif lokal.', 150000, null, 'rvty2lMd3LY'],
            [$merch, 'MD-06', 'Madu Hutan', 'Madu alami dari hutan sekitar.', 60000, null, 'K3RGVrI26MM'],
            [$merch, 'MD-07', 'Tas Pandan', 'Tas anyaman pandan.', 85000, null, 'RJtUtecKkZk'],
            [$merch, 'MD-08', 'Topi Anyaman Pandan', 'Topi anyaman khas desa.', 45000, null, 'wTFVNTGEt2E'],
        ];

        foreach ($items as [$category, $code, $name, $description, $price, $duration, $youtubeVideoId]) {
            Product::create([
                'category_id' => $category->id,
                'code' => $code,
                'name' => $name,
                'slug' => str($code.' '.$name)->slug(),
                'description' => $description,
                'price' => $price,
                'stock' => 100,
                'duration' => $duration,
                'image' => 'images/products/'.str($code)->lower().'.webp',
                'youtube_video_id' => $youtubeVideoId,
                'is_active' => true,
            ]);
        }
        AprioriConfig::create(['min_support'=>.10, 'min_confidence'=>.60, 'schedule_enabled'=>true, 'schedule_interval_hours'=>24]);
        $products = Product::all()->keyBy('code');
        // Dataset simulasi 500 transaksi dengan pola pembelian yang bervariasi,
        // agar support, confidence, dan lift merepresentasikan hubungan yang realistis.
        for ($i=1; $i<=500; $i++) {
            $package = match (true) { $i <= 160 => 'PW-01', $i <= 280 => 'PW-02', $i <= 370 => 'PW-03', $i <= 440 => 'PW-04', default => 'PW-05' };
            $basket = [$package];
            $rules = [
                'PW-01' => [['MD-03', 5, 4], ['MD-01', 7, 3], ['MD-06', 11, 2]],
                'PW-02' => [['MD-08', 4, 3], ['MD-07', 6, 3], ['MD-03', 10, 2]],
                'PW-03' => [['MD-05', 4, 3], ['MD-04', 5, 3], ['MD-01', 9, 2]],
                'PW-04' => [['MD-03', 3, 2], ['MD-02', 6, 2]],
                'PW-05' => [['MD-06', 4, 3], ['MD-02', 5, 3], ['MD-07', 10, 2]],
            ];
            foreach ($rules[$package] as [$merchandise, $mod, $threshold]) if ($i % $mod < $threshold) $basket[] = $merchandise;
            if ($i % 13 === 0) $basket[] = 'MD-02';
            if ($i % 17 === 0) $basket[] = 'MD-01';
            $basket = array_unique($basket);
            $transaction = Transaction::create(['user_id'=>$visitor->id,'transaction_code'=>'SIM-'.str_pad((string)$i,4,'0',STR_PAD_LEFT),'visitor_name'=>'Wisatawan Simulasi '.$i,'visit_date'=>now()->subDays(500-$i)->toDateString(),'total_price'=>0,'status'=>'completed']);
            $total=0; foreach ($basket as $code) { $p=$products[$code]; $transaction->items()->create(['product_id'=>$p->id,'quantity'=>1,'price'=>$p->price,'subtotal'=>$p->price]); $total += $p->price; } $transaction->update(['total_price'=>$total]);
        }
    }
}
