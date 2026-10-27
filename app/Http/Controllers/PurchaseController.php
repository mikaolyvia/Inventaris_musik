<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    /**
     * Display a listing of purchases.
     */
    public function index(Request $request)
    {
        $query = Purchase::with(['supplier', 'user']);

        if ($request->filled('search')) {
            $query->where('purchase_number', 'like', '%' . $request->search . '%');
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

        $purchases = $query->latest()->paginate(10)->withQueryString();

        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new purchase.
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created purchase.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:pending,completed',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        $purchaseDate = $request->filled('purchase_date') ? Carbon::parse($request->purchase_date) : Carbon::now();

        DB::transaction(function () use ($validated, $purchaseDate) {
            // Generate unique purchase number
            $purchaseNumber = 'PUR-' . Carbon::now()->format('Ymd') . '-' . str_pad(
                Purchase::whereDate('created_at', Carbon::today())->count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );

            // Create purchase header
            $purchase = Purchase::create([
                'purchase_number' => $purchaseNumber,
                'supplier_id' => $validated['supplier_id'],
                'user_id' => auth()->id(),
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
                'total' => 0,
                'purchased_at' => $purchaseDate,
            ]);

            $total = 0;

            // Create purchase items
            foreach ($validated['items'] as $item) {
                $subtotal = $item['quantity'] * $item['unit_cost'];
                $total += $subtotal;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
                ]);

                // If status is completed, increment product stock
                if ($validated['status'] === 'completed') {
                    $product = Product::find($item['product_id']);
                    $product->increment('stock', $item['quantity']);
                }
            }

            // Update total
            $purchase->update(['total' => $total]);
        });

        return redirect()->route('purchases.index')
            ->with('success', 'Pembelian berhasil ditambahkan.');
    }

    /**
     * Display the specified purchase.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['items.product', 'supplier', 'user']);

        return view('purchases.show', compact('purchase'));
    }

    /**
     * Cancel the specified purchase.
     */
    public function cancel(Purchase $purchase)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang diizinkan membatalkan transaksi pembelian.');
        }

        if ($purchase->status === 'cancelled') {
            return redirect()->route('purchases.show', $purchase)
                ->with('error', 'Pembelian sudah dibatalkan sebelumnya.');
        }

        DB::transaction(function () use ($purchase) {
            // If the purchase was completed, restore stock
            if ($purchase->status === 'completed') {
                foreach ($purchase->items as $item) {
                    $product = Product::find($item->product_id);
                    $product->decrement('stock', $item->quantity);
                }
            }

            $purchase->update(['status' => 'cancelled']);
        });

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Pembelian berhasil dibatalkan.');
    }
}
