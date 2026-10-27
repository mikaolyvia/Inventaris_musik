<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventorySalesSystemTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $staff;
    protected Category $category;
    protected Product $product;
    protected Supplier $supplier;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Tester',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->staff = User::create([
            'name' => 'Staff Tester',
            'email' => 'staff@test.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);

        $this->category = Category::create([
            'name' => 'Gitar',
        ]);

        $this->supplier = Supplier::create([
            'name' => 'PT Yamaha Musik',
            'phone' => '021-123456',
            'email' => 'yamaha@test.com',
            'address' => 'Jakarta',
        ]);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'sku' => 'MUS-TEST-01',
            'name' => 'Gitar Akustik Yamaha Test',
            'description' => 'Test guitar',
            'purchase_price' => 1000000,
            'selling_price' => 1500000,
            'stock' => 10,
            'minimum_stock' => 2,
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->staff)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Selamat Datang');
    }

    public function test_staff_cannot_access_admin_user_management(): void
    {
        $response = $this->actingAs($this->staff)->get('/users');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_user_management(): void
    {
        $response = $this->actingAs($this->admin)->get('/users');
        $response->assertStatus(200);
        $response->assertSee('Kelola User');
    }

    public function test_purchase_increments_stock(): void
    {
        $initialStock = $this->product->stock;
        $qtyToBuy = 5;

        $response = $this->actingAs($this->staff)->post('/purchases', [
            'supplier_id' => $this->supplier->id,
            'status' => 'completed',
            'purchase_date' => date('Y-m-d'),
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => $qtyToBuy,
                    'unit_cost' => 1000000,
                ],
            ],
        ]);

        $response->assertRedirect('/purchases');
        $this->assertDatabaseHas('purchases', [
            'supplier_id' => $this->supplier->id,
            'status' => 'completed',
        ]);

        $this->product->refresh();
        $this->assertEquals($initialStock + $qtyToBuy, $this->product->stock);
    }

    public function test_sale_decrements_stock(): void
    {
        $initialStock = $this->product->stock;
        $qtyToSell = 3;

        $response = $this->actingAs($this->staff)->post('/sales', [
            'customer_name' => 'Budi Santoso',
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => $qtyToSell,
                ],
            ],
        ]);

        $response->assertRedirect('/sales');
        $this->assertDatabaseHas('sales', [
            'customer_name' => 'Budi Santoso',
            'status' => 'completed',
        ]);

        $this->product->refresh();
        $this->assertEquals($initialStock - $qtyToSell, $this->product->stock);
    }

    public function test_sale_fails_when_stock_insufficient(): void
    {
        $initialStock = $this->product->stock;
        $excessQty = $initialStock + 10;

        $response = $this->actingAs($this->staff)->post('/sales', [
            'customer_name' => 'Pembeli Borongan',
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => $excessQty,
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items');

        // Verify stock has NOT changed
        $this->product->refresh();
        $this->assertEquals($initialStock, $this->product->stock);
    }

    public function test_cancelling_sale_restores_stock(): void
    {
        // 1. Create a sale
        $this->actingAs($this->staff)->post('/sales', [
            'customer_name' => 'Pelanggan Retur',
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 4,
                ],
            ],
        ]);

        $sale = Sale::latest()->first();
        $this->product->refresh();
        $this->assertEquals(6, $this->product->stock);

        // 2. Cancel the sale
        $response = $this->actingAs($this->admin)->post("/sales/{$sale->id}/cancel");
        $response->assertRedirect("/sales/{$sale->id}");

        $sale->refresh();
        $this->assertEquals('cancelled', $sale->status);

        // 3. Stock restored
        $this->product->refresh();
        $this->assertEquals(10, $this->product->stock);
    }

    public function test_product_sku_must_be_unique(): void
    {
        $response = $this->actingAs($this->admin)->post('/products', [
            'sku' => $this->product->sku, // duplicate
            'name' => 'Gitar Duplikat',
            'category_id' => $this->category->id,
            'purchase_price' => 500000,
            'selling_price' => 750000,
            'stock' => 5,
            'minimum_stock' => 1,
        ]);

        $response->assertSessionHasErrors('sku');
    }

    public function test_user_can_login_via_form_with_csrf(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('name="_token"', false);

        $loginResponse = $this->post('/login', [
            'email' => $this->staff->email,
            'password' => 'password',
        ]);

        $loginResponse->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->staff);
    }

    public function test_staff_cannot_delete_product(): void
    {
        $response = $this->actingAs($this->staff)->delete("/products/{$this->product->id}");
        $response->assertStatus(403);
        $this->assertDatabaseHas('products', ['id' => $this->product->id]);
    }

    public function test_admin_can_delete_product_without_transactions(): void
    {
        $unusedProduct = Product::create([
            'category_id' => $this->category->id,
            'sku' => 'MUS-UNUSED',
            'name' => 'Produk Tanpa Transaksi',
            'purchase_price' => 100000,
            'selling_price' => 150000,
            'stock' => 5,
            'minimum_stock' => 1,
        ]);

        $response = $this->actingAs($this->admin)->delete("/products/{$unusedProduct->id}");
        $response->assertRedirect('/products');
        $this->assertSoftDeleted('products', ['id' => $unusedProduct->id]);
    }

    public function test_staff_cannot_delete_category(): void
    {
        $response = $this->actingAs($this->staff)->delete("/categories/{$this->category->id}");
        $response->assertStatus(403);
        $this->assertDatabaseHas('categories', ['id' => $this->category->id]);
    }

    public function test_staff_cannot_delete_supplier(): void
    {
        $response = $this->actingAs($this->staff)->delete("/suppliers/{$this->supplier->id}");
        $response->assertStatus(403);
        $this->assertDatabaseHas('suppliers', ['id' => $this->supplier->id]);
    }

    public function test_staff_cannot_cancel_sale(): void
    {
        $this->actingAs($this->staff)->post('/sales', [
            'customer_name' => 'Test Pelanggan',
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 1,
                ],
            ],
        ]);

        $sale = Sale::latest()->first();

        // Staff tries to cancel
        $response = $this->actingAs($this->staff)->post("/sales/{$sale->id}/cancel");
        $response->assertStatus(403);

        $sale->refresh();
        $this->assertEquals('completed', $sale->status);
    }
}
