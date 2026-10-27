<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ============================================================
        // USERS
        // ============================================================
        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $staff = User::create([
            'name'     => 'Staff Toko',
            'email'    => 'staff@admin.com',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);

        // ============================================================
        // CATEGORIES
        // ============================================================
        $categories = [];
        $categoryNames = [
            'Gitar',
            'Piano & Keyboard',
            'Drum & Perkusi',
            'Bass',
            'Biola & String',
            'Alat Tiup',
            'Aksesoris Musik',
            'Audio & Sound System',
        ];

        foreach ($categoryNames as $name) {
            $categories[$name] = Category::create([
                'name' => $name,
            ]);
        }

        // ============================================================
        // PRODUCTS
        // ============================================================
        $productsData = [
            [
                'sku'            => 'MUS-001',
                'name'           => 'Gitar Akustik Yamaha F310',
                'category'       => 'Gitar',
                'description'    => 'Gitar akustik berkualitas dari Yamaha, cocok untuk pemula hingga menengah.',
                'purchase_price' => 1200000,
                'selling_price'  => 1500000,
                'stock'          => 15,
                'minimum_stock'  => 3,
            ],
            [
                'sku'            => 'MUS-002',
                'name'           => 'Gitar Elektrik Fender Stratocaster',
                'category'       => 'Gitar',
                'description'    => 'Gitar elektrik legendaris dari Fender dengan tone khas Stratocaster.',
                'purchase_price' => 8500000,
                'selling_price'  => 10500000,
                'stock'          => 5,
                'minimum_stock'  => 2,
            ],
            [
                'sku'            => 'MUS-003',
                'name'           => 'Gitar Klasik Yamaha C40',
                'category'       => 'Gitar',
                'description'    => 'Gitar klasik nylon string, ideal untuk belajar fingerstyle.',
                'purchase_price' => 900000,
                'selling_price'  => 1200000,
                'stock'          => 10,
                'minimum_stock'  => 3,
            ],
            [
                'sku'            => 'MUS-004',
                'name'           => 'Keyboard Yamaha PSR-E373',
                'category'       => 'Piano & Keyboard',
                'description'    => 'Keyboard portable dengan 61 tuts dan berbagai fitur pembelajaran.',
                'purchase_price' => 2800000,
                'selling_price'  => 3500000,
                'stock'          => 8,
                'minimum_stock'  => 2,
            ],
            [
                'sku'            => 'MUS-005',
                'name'           => 'Digital Piano Casio CDP-S110',
                'category'       => 'Piano & Keyboard',
                'description'    => 'Digital piano slim dengan 88 tuts weighted hammer action.',
                'purchase_price' => 5500000,
                'selling_price'  => 6800000,
                'stock'          => 4,
                'minimum_stock'  => 1,
            ],
            [
                'sku'            => 'MUS-006',
                'name'           => 'Drum Akustik Pearl Export',
                'category'       => 'Drum & Perkusi',
                'description'    => 'Set drum akustik 5-piece dari Pearl, standar profesional.',
                'purchase_price' => 7000000,
                'selling_price'  => 8500000,
                'stock'          => 3,
                'minimum_stock'  => 1,
            ],
            [
                'sku'            => 'MUS-007',
                'name'           => 'Drum Elektrik Yamaha DTX402K',
                'category'       => 'Drum & Perkusi',
                'description'    => 'Drum elektrik kompak dengan modul suara berkualitas tinggi.',
                'purchase_price' => 5000000,
                'selling_price'  => 6200000,
                'stock'          => 4,
                'minimum_stock'  => 1,
            ],
            [
                'sku'            => 'MUS-008',
                'name'           => 'Cajon Pearl',
                'category'       => 'Drum & Perkusi',
                'description'    => 'Cajon perkusi akustik untuk permainan unplugged.',
                'purchase_price' => 800000,
                'selling_price'  => 1100000,
                'stock'          => 12,
                'minimum_stock'  => 3,
            ],
            [
                'sku'            => 'MUS-009',
                'name'           => 'Bass Elektrik Ibanez SR300E',
                'category'       => 'Bass',
                'description'    => 'Bass elektrik 4-string dengan neck tipis dan nyaman dimainkan.',
                'purchase_price' => 4500000,
                'selling_price'  => 5500000,
                'stock'          => 6,
                'minimum_stock'  => 2,
            ],
            [
                'sku'            => 'MUS-010',
                'name'           => 'Bass Akustik Fender',
                'category'       => 'Bass',
                'description'    => 'Bass akustik elektrik dari Fender dengan proyeksi suara kuat.',
                'purchase_price' => 3500000,
                'selling_price'  => 4500000,
                'stock'          => 4,
                'minimum_stock'  => 1,
            ],
            [
                'sku'            => 'MUS-011',
                'name'           => 'Biola Cremona SV-75',
                'category'       => 'Biola & String',
                'description'    => 'Biola ukuran 4/4 dengan kualitas suara yang jernih.',
                'purchase_price' => 1500000,
                'selling_price'  => 2000000,
                'stock'          => 7,
                'minimum_stock'  => 2,
            ],
            [
                'sku'            => 'MUS-012',
                'name'           => 'Ukulele Mahalo',
                'category'       => 'Biola & String',
                'description'    => 'Ukulele soprano berwarna-warni, ideal untuk pemula.',
                'purchase_price' => 250000,
                'selling_price'  => 400000,
                'stock'          => 20,
                'minimum_stock'  => 5,
            ],
            [
                'sku'            => 'MUS-013',
                'name'           => 'Saxophone Alto Yamaha YAS-280',
                'category'       => 'Alat Tiup',
                'description'    => 'Saxophone alto untuk pelajar dengan intonasi akurat.',
                'purchase_price' => 900000,
                'selling_price'  => 11000000,
                'stock'          => 3,
                'minimum_stock'  => 1,
            ],
            [
                'sku'            => 'MUS-014',
                'name'           => 'Flute Yamaha YFL-222',
                'category'       => 'Alat Tiup',
                'description'    => 'Flute silver-plated dengan mekanisme yang halus.',
                'purchase_price' => 5500000,
                'selling_price'  => 7000000,
                'stock'          => 5,
                'minimum_stock'  => 1,
            ],
            [
                'sku'            => 'MUS-015',
                'name'           => 'Harmonika Hohner',
                'category'       => 'Alat Tiup',
                'description'    => 'Harmonika diatonis 10-hole dari Hohner, kualitas Jerman.',
                'purchase_price' => 350000,
                'selling_price'  => 500000,
                'stock'          => 15,
                'minimum_stock'  => 3,
            ],
            [
                'sku'            => 'MUS-016',
                'name'           => 'Senar Gitar D\'Addario EJ16',
                'category'       => 'Aksesoris Musik',
                'description'    => 'Set senar gitar akustik phosphor bronze, light gauge.',
                'purchase_price' => 80000,
                'selling_price'  => 120000,
                'stock'          => 50,
                'minimum_stock'  => 10,
            ],
            [
                'sku'            => 'MUS-017',
                'name'           => 'Pick Gitar Dunlop (set 12)',
                'category'       => 'Aksesoris Musik',
                'description'    => 'Set 12 pick gitar Dunlop Tortex dengan berbagai ketebalan.',
                'purchase_price' => 25000,
                'selling_price'  => 45000,
                'stock'          => 100,
                'minimum_stock'  => 20,
            ],
            [
                'sku'            => 'MUS-018',
                'name'           => 'Tuner Digital Korg',
                'category'       => 'Aksesoris Musik',
                'description'    => 'Tuner clip-on digital untuk gitar, bass, dan ukulele.',
                'purchase_price' => 150000,
                'selling_price'  => 250000,
                'stock'          => 25,
                'minimum_stock'  => 5,
            ],
            [
                'sku'            => 'MUS-019',
                'name'           => 'Speaker Monitor Yamaha HS5',
                'category'       => 'Audio & Sound System',
                'description'    => 'Studio monitor 5 inch dengan respons frekuensi flat.',
                'purchase_price' => 2200000,
                'selling_price'  => 2800000,
                'stock'          => 6,
                'minimum_stock'  => 2,
            ],
            [
                'sku'            => 'MUS-020',
                'name'           => 'Mixer Behringer Xenyx 802',
                'category'       => 'Audio & Sound System',
                'description'    => 'Mixer analog 8-channel kompak untuk live dan recording.',
                'purchase_price' => 900000,
                'selling_price'  => 1200000,
                'stock'          => 8,
                'minimum_stock'  => 2,
            ],
            [
                'sku'            => 'MUS-021',
                'name'           => 'Stand Gitar',
                'category'       => 'Aksesoris Musik',
                'description'    => 'Stand gitar universal lipat, cocok untuk gitar akustik dan elektrik.',
                'purchase_price' => 50000,
                'selling_price'  => 85000,
                'stock'          => 2,
                'minimum_stock'  => 5,
            ],
            [
                'sku'            => 'MUS-022',
                'name'           => 'Kabel Jack 3m',
                'category'       => 'Aksesoris Musik',
                'description'    => 'Kabel jack instrument 6.35mm sepanjang 3 meter.',
                'purchase_price' => 30000,
                'selling_price'  => 55000,
                'stock'          => 1,
                'minimum_stock'  => 10,
            ],
            [
                'sku'            => 'MUS-023',
                'name'           => 'Microphone Shure SM58',
                'category'       => 'Audio & Sound System',
                'description'    => 'Microphone dinamis legendaris untuk vokal live performance.',
                'purchase_price' => 1500000,
                'selling_price'  => 1900000,
                'stock'          => 0,
                'minimum_stock'  => 3,
            ],
        ];

        $products = [];
        foreach ($productsData as $data) {
            $categoryName = $data['category'];
            unset($data['category']);
            $data['category_id'] = $categories[$categoryName]->id;
            $products[$data['sku']] = Product::create($data);
        }

        // ============================================================
        // SUPPLIERS
        // ============================================================
        $suppliers = [];

        $suppliers[] = Supplier::create([
            'name'    => 'PT Yamaha Music Indonesia',
            'phone'   => '021-1234567',
            'email'   => 'supplier@yamaha.co.id',
            'address' => 'Jl. Jend. Gatot Subroto Kav. 4, Jakarta Selatan',
        ]);

        $suppliers[] = Supplier::create([
            'name'    => 'CV Melody Instrument',
            'phone'   => '022-7654321',
            'email'   => 'info@melodyinstrument.com',
            'address' => 'Jl. Braga No. 45, Bandung',
        ]);

        $suppliers[] = Supplier::create([
            'name'    => 'Toko Musik Harmony',
            'phone'   => '031-9876543',
            'email'   => 'harmony@musik.com',
            'address' => 'Jl. Tunjungan No. 12, Surabaya',
        ]);

        $suppliers[] = Supplier::create([
            'name'    => 'PT Fender Indonesia',
            'phone'   => '021-5551234',
            'email'   => 'sales@fender.co.id',
            'address' => 'Jl. Sudirman Kav. 52-53, Jakarta Pusat',
        ]);

        $suppliers[] = Supplier::create([
            'name'    => 'CV Sound Pro',
            'phone'   => '024-3456789',
            'email'   => 'info@soundpro.co.id',
            'address' => 'Jl. Pandanaran No. 78, Semarang',
        ]);

        // ============================================================
        // SAMPLE PURCHASES
        // ============================================================

        // Purchase 1: Yamaha instruments from PT Yamaha Music Indonesia
        $purchase1 = Purchase::create([
            'purchase_number' => 'PUR-' . Carbon::now()->format('Ymd') . '-0001',
            'supplier_id'     => $suppliers[0]->id, // PT Yamaha Music Indonesia
            'user_id'         => $admin->id,
            'purchased_at'    => Carbon::now()->subDays(7),
            'total'           => 0,
            'notes'           => 'Restok produk Yamaha bulan ini.',
            'status'          => 'completed',
        ]);

        $purchase1Items = [
            ['product' => 'MUS-001', 'quantity' => 10, 'unit_cost' => 1200000],
            ['product' => 'MUS-004', 'quantity' => 5,  'unit_cost' => 2800000],
            ['product' => 'MUS-007', 'quantity' => 3,  'unit_cost' => 5000000],
        ];

        $purchase1Total = 0;
        foreach ($purchase1Items as $item) {
            $product = $products[$item['product']];
            $subtotal = $item['quantity'] * $item['unit_cost'];
            PurchaseItem::create([
                'purchase_id' => $purchase1->id,
                'product_id'  => $product->id,
                'quantity'    => $item['quantity'],
                'unit_cost'   => $item['unit_cost'],
                'subtotal'    => $subtotal,
            ]);
            $purchase1Total += $subtotal;

            // Update stock
            $product->increment('stock', $item['quantity']);
        }
        $purchase1->update(['total' => $purchase1Total]);

        // Purchase 2: Accessories from CV Melody Instrument
        $purchase2 = Purchase::create([
            'purchase_number' => 'PUR-' . Carbon::now()->format('Ymd') . '-0002',
            'supplier_id'     => $suppliers[1]->id, // CV Melody Instrument
            'user_id'         => $staff->id,
            'purchased_at'    => Carbon::now()->subDays(3),
            'total'           => 0,
            'notes'           => 'Pembelian aksesoris dan string.',
            'status'          => 'completed',
        ]);

        $purchase2Items = [
            ['product' => 'MUS-016', 'quantity' => 30, 'unit_cost' => 80000],
            ['product' => 'MUS-017', 'quantity' => 50, 'unit_cost' => 25000],
            ['product' => 'MUS-011', 'quantity' => 5,  'unit_cost' => 1500000],
        ];

        $purchase2Total = 0;
        foreach ($purchase2Items as $item) {
            $product = $products[$item['product']];
            $subtotal = $item['quantity'] * $item['unit_cost'];
            PurchaseItem::create([
                'purchase_id' => $purchase2->id,
                'product_id'  => $product->id,
                'quantity'    => $item['quantity'],
                'unit_cost'   => $item['unit_cost'],
                'subtotal'    => $subtotal,
            ]);
            $purchase2Total += $subtotal;

            // Update stock
            $product->increment('stock', $item['quantity']);
        }
        $purchase2->update(['total' => $purchase2Total]);

        // Purchase 3: Audio equipment from CV Sound Pro
        $purchase3 = Purchase::create([
            'purchase_number' => 'PUR-' . Carbon::now()->format('Ymd') . '-0003',
            'supplier_id'     => $suppliers[4]->id, // CV Sound Pro
            'user_id'         => $admin->id,
            'purchased_at'    => Carbon::now()->subDays(1),
            'total'           => 0,
            'notes'           => 'Pembelian peralatan audio.',
            'status'          => 'completed',
        ]);

        $purchase3Items = [
            ['product' => 'MUS-019', 'quantity' => 4, 'unit_cost' => 2200000],
            ['product' => 'MUS-020', 'quantity' => 5, 'unit_cost' => 900000],
        ];

        $purchase3Total = 0;
        foreach ($purchase3Items as $item) {
            $product = $products[$item['product']];
            $subtotal = $item['quantity'] * $item['unit_cost'];
            PurchaseItem::create([
                'purchase_id' => $purchase3->id,
                'product_id'  => $product->id,
                'quantity'    => $item['quantity'],
                'unit_cost'   => $item['unit_cost'],
                'subtotal'    => $subtotal,
            ]);
            $purchase3Total += $subtotal;

            // Update stock
            $product->increment('stock', $item['quantity']);
        }
        $purchase3->update(['total' => $purchase3Total]);

        // ============================================================
        // SAMPLE SALES
        // ============================================================

        // Sale 1: Customer buys a guitar and accessories
        $sale1 = Sale::create([
            'sale_number'     => 'SAL-' . Carbon::now()->format('Ymd') . '-0001',
            'user_id'         => $staff->id,
            'customer_name'   => 'Budi Santoso',
            'sold_at'         => Carbon::now()->subDays(5),
            'total'           => 0,
            'notes'           => 'Pelanggan membeli gitar akustik dan aksesoris.',
            'status'          => 'completed',
        ]);

        $sale1Items = [
            ['product' => 'MUS-001', 'quantity' => 1, 'unit_price' => 1500000],
            ['product' => 'MUS-016', 'quantity' => 2, 'unit_price' => 120000],
            ['product' => 'MUS-018', 'quantity' => 1, 'unit_price' => 250000],
        ];

        $sale1Total = 0;
        foreach ($sale1Items as $item) {
            $product = $products[$item['product']];
            $subtotal = $item['quantity'] * $item['unit_price'];
            SaleItem::create([
                'sale_id'    => $sale1->id,
                'product_id' => $product->id,
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal'   => $subtotal,
            ]);
            $sale1Total += $subtotal;

            // Decrease stock
            $product->decrement('stock', $item['quantity']);
        }
        $sale1->update(['total' => $sale1Total]);

        // Sale 2: Customer buys a keyboard
        $sale2 = Sale::create([
            'sale_number'     => 'SAL-' . Carbon::now()->format('Ymd') . '-0002',
            'user_id'         => $admin->id,
            'customer_name'   => 'Siti Rahayu',
            'sold_at'         => Carbon::now()->subDays(2),
            'total'           => 0,
            'notes'           => 'Pembelian keyboard untuk sekolah musik.',
            'status'          => 'completed',
        ]);

        $sale2Items = [
            ['product' => 'MUS-004', 'quantity' => 2, 'unit_price' => 3500000],
            ['product' => 'MUS-021', 'quantity' => 2, 'unit_price' => 85000],
        ];

        $sale2Total = 0;
        foreach ($sale2Items as $item) {
            $product = $products[$item['product']];
            $subtotal = $item['quantity'] * $item['unit_price'];
            SaleItem::create([
                'sale_id'    => $sale2->id,
                'product_id' => $product->id,
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal'   => $subtotal,
            ]);
            $sale2Total += $subtotal;

            // Decrease stock
            $product->decrement('stock', $item['quantity']);
        }
        $sale2->update(['total' => $sale2Total]);

        // Sale 3: Customer buys bass and ukulele
        $sale3 = Sale::create([
            'sale_number'     => 'SAL-' . Carbon::now()->format('Ymd') . '-0003',
            'user_id'         => $staff->id,
            'customer_name'   => 'Ahmad Wijaya',
            'sold_at'         => Carbon::now()->subDay(),
            'total'           => 0,
            'notes'           => 'Pelanggan membeli bass dan ukulele.',
            'status'          => 'completed',
        ]);

        $sale3Items = [
            ['product' => 'MUS-009', 'quantity' => 1, 'unit_price' => 5500000],
            ['product' => 'MUS-012', 'quantity' => 3, 'unit_price' => 400000],
        ];

        $sale3Total = 0;
        foreach ($sale3Items as $item) {
            $product = $products[$item['product']];
            $subtotal = $item['quantity'] * $item['unit_price'];
            SaleItem::create([
                'sale_id'    => $sale3->id,
                'product_id' => $product->id,
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal'   => $subtotal,
            ]);
            $sale3Total += $subtotal;

            // Decrease stock
            $product->decrement('stock', $item['quantity']);
        }
        $sale3->update(['total' => $sale3Total]);
    }
}
