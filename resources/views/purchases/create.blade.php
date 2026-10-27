@extends('layouts.app')

@section('title', 'Buat Pembelian')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('purchases.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Buat Pembelian</h1>
            <p class="text-sm text-gray-500 mt-1">Tambah transaksi pembelian baru</p>
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

    <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
        @csrf

        {{-- Purchase Info Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pembelian</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Supplier <span class="text-red-500">*</span>
                    </label>
                    <select name="supplier_id" id="supplier_id" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div>
                    <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Pembelian <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="purchase_date" id="purchase_date"
                           value="{{ old('purchase_date', date('Y-m-d')) }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
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
                <h2 class="text-lg font-semibold text-gray-800">Detail Item Pembelian</h2>
                <button type="button" onclick="addItemRow()"
                        class="inline-flex items-center px-3 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 text-sm font-medium rounded-lg transition-colors duration-150">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Item
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full" id="itemsTable">
                    <thead>
                        <tr class="border-b border-purple-100">
                            <th class="px-3 py-3 text-left text-xs font-semibold text-purple-700 uppercase w-6">#</th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Produk</th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-purple-700 uppercase w-32">Kuantitas</th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-purple-700 uppercase w-44">Harga Satuan</th>
                            <th class="px-3 py-3 text-right text-xs font-semibold text-purple-700 uppercase w-44">Subtotal</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-purple-700 uppercase w-16"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        {{-- Dynamic rows added by JS --}}
                    </tbody>
                </table>
            </div>

            {{-- Grand Total --}}
            <div class="mt-4 pt-4 border-t border-purple-100 flex justify-end">
                <div class="text-right">
                    <span class="text-sm text-gray-500">Grand Total</span>
                    <p class="text-2xl font-bold text-purple-700" id="grandTotal">Rp 0</p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('purchases.index') }}"
               class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-150">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Pembelian
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const products = @json($products);
    let itemIndex = 0;
    const formatter = new Intl.NumberFormat('id-ID');

    function addItemRow() {
        const tbody = document.getElementById('itemsBody');
        const row = document.createElement('tr');
        row.className = 'border-b border-purple-50 item-row animate-fade-in';
        row.dataset.index = itemIndex;

        let productOptions = '<option value="">-- Pilih Produk --</option>';
        products.forEach(function(product) {
            productOptions += `<option value="${product.id}">${product.name} (${product.sku})</option>`;
        });

        row.innerHTML = `
            <td class="px-3 py-3 text-sm text-gray-500 row-number">${itemIndex + 1}</td>
            <td class="px-3 py-3">
                <select name="items[${itemIndex}][product_id]" required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm"
                        onchange="updateRowNumber()">
                    ${productOptions}
                </select>
            </td>
            <td class="px-3 py-3">
                <input type="number" name="items[${itemIndex}][quantity]" min="1" value="1" required
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm"
                       oninput="calculateSubtotal(this)">
            </td>
            <td class="px-3 py-3">
                <input type="number" name="items[${itemIndex}][unit_cost]" min="0" value="0" required
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm"
                       oninput="calculateSubtotal(this)">
            </td>
            <td class="px-3 py-3 text-right">
                <span class="text-sm font-semibold text-gray-800 subtotal-display">Rp 0</span>
            </td>
            <td class="px-3 py-3 text-center">
                <button type="button" onclick="removeItemRow(this)"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-500 hover:bg-red-50 hover:text-red-700 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </td>
        `;

        tbody.appendChild(row);
        itemIndex++;
        updateRowNumbers();
    }

    function removeItemRow(btn) {
        const row = btn.closest('tr');
        row.remove();
        updateRowNumbers();
        calculateGrandTotal();
    }

    function updateRowNumbers() {
        const rows = document.querySelectorAll('#itemsBody .item-row');
        rows.forEach(function(row, index) {
            row.querySelector('.row-number').textContent = index + 1;
        });
    }

    function calculateSubtotal(input) {
        const row = input.closest('tr');
        const quantity = parseInt(row.querySelector('input[name*="[quantity]"]').value) || 0;
        const unitCost = parseFloat(row.querySelector('input[name*="[unit_cost]"]').value) || 0;
        const subtotal = quantity * unitCost;
        row.querySelector('.subtotal-display').textContent = 'Rp ' + formatter.format(subtotal);
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        const rows = document.querySelectorAll('#itemsBody .item-row');
        rows.forEach(function(row) {
            const quantity = parseInt(row.querySelector('input[name*="[quantity]"]').value) || 0;
            const unitCost = parseFloat(row.querySelector('input[name*="[unit_cost]"]').value) || 0;
            total += quantity * unitCost;
        });
        document.getElementById('grandTotal').textContent = 'Rp ' + formatter.format(total);
    }

    // Form validation
    document.getElementById('purchaseForm').addEventListener('submit', function(e) {
        const rows = document.querySelectorAll('#itemsBody .item-row');
        if (rows.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada satu item pembelian.');
            return false;
        }
    });

    // Add initial row
    addItemRow();
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
