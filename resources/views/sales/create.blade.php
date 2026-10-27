@extends('layouts.app')

@section('title', 'Buat Penjualan')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('sales.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Buat Penjualan</h1>
            <p class="text-sm text-gray-500 mt-1">Tambah transaksi penjualan baru</p>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
        @csrf

        {{-- Sale Info Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Penjualan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Customer</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}"
                           placeholder="Kosongkan jika pelanggan umum..."
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                    <p class="text-xs text-gray-400 mt-1">Opsional — jika kosong akan dicatat sebagai "Umum"</p>
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Catatan tambahan (opsional)..."
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Items Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Detail Item Penjualan</h2>
                <button type="button" onclick="addSaleItemRow()"
                        class="inline-flex items-center px-3 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 text-sm font-medium rounded-lg transition-colors duration-150">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Item
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full" id="saleItemsTable">
                    <thead>
                        <tr class="border-b border-purple-100">
                            <th class="px-3 py-3 text-left text-xs font-semibold text-purple-700 uppercase w-6">#</th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Produk</th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-purple-700 uppercase w-36">Kuantitas</th>
                            <th class="px-3 py-3 text-right text-xs font-semibold text-purple-700 uppercase w-44">Harga Satuan</th>
                            <th class="px-3 py-3 text-right text-xs font-semibold text-purple-700 uppercase w-44">Subtotal</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-purple-700 uppercase w-16"></th>
                        </tr>
                    </thead>
                    <tbody id="saleItemsBody">
                        {{-- Dynamic rows added by JS --}}
                    </tbody>
                </table>
            </div>

            {{-- Grand Total --}}
            <div class="mt-4 pt-4 border-t border-purple-100 flex justify-end">
                <div class="text-right">
                    <span class="text-sm text-gray-500">Grand Total</span>
                    <p class="text-2xl font-bold text-purple-700" id="saleGrandTotal">Rp 0</p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('sales.index') }}"
               class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-150">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Penjualan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const products = @json($products);
    let saleItemIndex = 0;
    const formatter = new Intl.NumberFormat('id-ID');

    function getProductById(id) {
        return products.find(function(p) { return p.id == id; });
    }

    function addSaleItemRow() {
        const tbody = document.getElementById('saleItemsBody');
        const row = document.createElement('tr');
        row.className = 'border-b border-purple-50 sale-item-row animate-fade-in';
        row.dataset.index = saleItemIndex;

        let productOptions = '<option value="">-- Pilih Produk --</option>';
        products.forEach(function(product) {
            const price = formatter.format(product.selling_price);
            productOptions += `<option value="${product.id}">${product.name} (${product.sku}) - Stok: ${product.stock} - Rp ${price}</option>`;
        });

        row.innerHTML = `
            <td class="px-3 py-3 text-sm text-gray-500 sale-row-number">${saleItemIndex + 1}</td>
            <td class="px-3 py-3">
                <select name="items[${saleItemIndex}][product_id]" required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm product-select"
                        onchange="onProductSelected(this)">
                    ${productOptions}
                </select>
            </td>
            <td class="px-3 py-3">
                <div class="relative">
                    <input type="number" name="items[${saleItemIndex}][quantity]" min="1" value="1" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm quantity-input"
                           oninput="onQuantityChanged(this)">
                    <p class="text-xs mt-1 stock-info text-gray-400">Stok: -</p>
                </div>
            </td>
            <td class="px-3 py-3 text-right">
                <span class="text-sm text-gray-800 unit-price-display">Rp 0</span>
                <input type="hidden" class="unit-price-value" value="0">
            </td>
            <td class="px-3 py-3 text-right">
                <span class="text-sm font-semibold text-gray-800 sale-subtotal-display">Rp 0</span>
            </td>
            <td class="px-3 py-3 text-center">
                <button type="button" onclick="removeSaleItemRow(this)"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-500 hover:bg-red-50 hover:text-red-700 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </td>
        `;

        tbody.appendChild(row);
        saleItemIndex++;
        updateSaleRowNumbers();
    }

    function removeSaleItemRow(btn) {
        const row = btn.closest('tr');
        row.remove();
        updateSaleRowNumbers();
        calculateSaleGrandTotal();
    }

    function updateSaleRowNumbers() {
        const rows = document.querySelectorAll('#saleItemsBody .sale-item-row');
        rows.forEach(function(row, index) {
            row.querySelector('.sale-row-number').textContent = index + 1;
        });
    }

    function onProductSelected(select) {
        const row = select.closest('tr');
        const productId = select.value;
        const product = getProductById(productId);

        const unitPriceDisplay = row.querySelector('.unit-price-display');
        const unitPriceValue = row.querySelector('.unit-price-value');
        const stockInfo = row.querySelector('.stock-info');
        const quantityInput = row.querySelector('.quantity-input');

        if (product) {
            unitPriceDisplay.textContent = 'Rp ' + formatter.format(product.selling_price);
            unitPriceValue.value = product.selling_price;
            stockInfo.textContent = 'Stok: ' + product.stock;
            stockInfo.className = 'text-xs mt-1 stock-info text-gray-400';

            // Validate current quantity
            validateQuantity(quantityInput, product.stock);
        } else {
            unitPriceDisplay.textContent = 'Rp 0';
            unitPriceValue.value = 0;
            stockInfo.textContent = 'Stok: -';
            stockInfo.className = 'text-xs mt-1 stock-info text-gray-400';
        }

        calculateSaleSubtotal(row);
        calculateSaleGrandTotal();
    }

    function onQuantityChanged(input) {
        const row = input.closest('tr');
        const select = row.querySelector('.product-select');
        const productId = select.value;
        const product = getProductById(productId);

        if (product) {
            validateQuantity(input, product.stock);
        }

        calculateSaleSubtotal(row);
        calculateSaleGrandTotal();
    }

    function validateQuantity(input, availableStock) {
        const row = input.closest('tr');
        const stockInfo = row.querySelector('.stock-info');
        const quantity = parseInt(input.value) || 0;

        if (quantity > availableStock) {
            input.classList.add('border-red-500', 'ring-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            input.classList.remove('border-gray-300', 'focus:border-purple-500', 'focus:ring-purple-500');
            stockInfo.textContent = 'Stok: ' + availableStock + ' — Melebihi stok!';
            stockInfo.className = 'text-xs mt-1 stock-info text-red-500 font-medium';
        } else {
            input.classList.remove('border-red-500', 'ring-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            input.classList.add('border-gray-300', 'focus:border-purple-500', 'focus:ring-purple-500');
            stockInfo.textContent = 'Stok: ' + availableStock;
            stockInfo.className = 'text-xs mt-1 stock-info text-gray-400';
        }
    }

    function calculateSaleSubtotal(row) {
        const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
        const unitPrice = parseFloat(row.querySelector('.unit-price-value').value) || 0;
        const subtotal = quantity * unitPrice;
        row.querySelector('.sale-subtotal-display').textContent = 'Rp ' + formatter.format(subtotal);
    }

    function calculateSaleGrandTotal() {
        let total = 0;
        const rows = document.querySelectorAll('#saleItemsBody .sale-item-row');
        rows.forEach(function(row) {
            const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
            const unitPrice = parseFloat(row.querySelector('.unit-price-value').value) || 0;
            total += quantity * unitPrice;
        });
        document.getElementById('saleGrandTotal').textContent = 'Rp ' + formatter.format(total);
    }

    // Form validation
    document.getElementById('saleForm').addEventListener('submit', function(e) {
        const rows = document.querySelectorAll('#saleItemsBody .sale-item-row');
        if (rows.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada satu item penjualan.');
            return false;
        }

        // Check stock validation
        let hasStockError = false;
        rows.forEach(function(row) {
            const select = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.quantity-input');
            const productId = select.value;
            const product = getProductById(productId);
            const quantity = parseInt(quantityInput.value) || 0;

            if (product && quantity > product.stock) {
                hasStockError = true;
            }
        });

        if (hasStockError) {
            e.preventDefault();
            alert('Kuantitas melebihi stok yang tersedia. Silakan periksa kembali item yang ditandai merah.');
            return false;
        }
    });

    // Add initial row
    addSaleItemRow();
</script>
@endpush

@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.2s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection
