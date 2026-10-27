<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class SaleController extends Controller
{
    /**
     * Display a listing of sales.
     */
    public function index(Request $request)
    {
        $query = Sale::with('user');

        if ($request->filled('search')) {
            $query->where('sale_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sales = $query->latest()->paginate(10)->withQueryString();

        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();

        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created sale.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:150',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            // Generate unique sale number
            $saleNumber = 'SAL-' . Carbon::now()->format('Ymd') . '-' . str_pad(
                Sale::whereDate('created_at', Carbon::today())->count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );

            // Create sale header
            $sale = Sale::create([
                'sale_number' => $saleNumber,
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'] ?? null,
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
                'total' => 0,
                'sold_at' => Carbon::now(),
            ]);

            $total = 0;

            // Create sale items
            foreach ($validated['items'] as $item) {
                // Lock the product row for update to prevent race conditions
                $product = Product::lockForUpdate()->find($item['product_id']);

                // Check stock availability
                if ($product->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => "Stok produk '{$product->name}' tidak mencukupi. Stok tersedia: {$product->stock}, diminta: {$item['quantity']}.",
                    ]);
                }

                $unitPrice = $product->selling_price;
                $subtotal = $item['quantity'] * $unitPrice;
                $total += $subtotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                // Decrement product stock
                $product->decrement('stock', $item['quantity']);
            }

            // Update total
            $sale->update(['total' => $total]);
        });

        return redirect()->route('sales.index')
            ->with('success', 'Penjualan berhasil ditambahkan.');
    }

    /**
     * Display the specified sale.
     */
    public function show(Sale $sale)
    {
        $sale->load(['items.product', 'user']);

        return view('sales.show', compact('sale'));
    }

    /**
     * Cancel the specified sale.
     */
    public function cancel(Sale $sale)
    {
        if ($sale->status === 'cancelled') {
            return redirect()->route('sales.show', $sale)
                ->with('error', 'Penjualan sudah dibatalkan sebelumnya.');
        }

        DB::transaction(function () use ($sale) {
            // Restore stock for each item
            foreach ($sale->items as $item) {
                $product = Product::find($item->product_id);
                $product->increment('stock', $item->quantity);
            }

            $sale->update(['status' => 'cancelled']);
        });

        return redirect()->route('sales.show', $sale)
            ->with('success', 'Penjualan berhasil dibatalkan.');
    }
}
