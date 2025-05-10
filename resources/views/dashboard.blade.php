@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Inventori</h2>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-gray-600 font-medium">Total Barang</h3>
            <p class="text-2xl font-bold text-blue-600">{{ $items->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-gray-600 font-medium">Stok Rendah</h3>
            <p class="text-2xl font-bold text-yellow-500">{{ $lowStockItems->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-gray-600 font-medium">Obat Kedaluwarsa</h3>
            <p class="text-2xl font-bold text-red-500">{{ $expiredMedicine->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-gray-600 font-medium">Nilai Inventori</h3>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Stok Rendah -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Barang dengan Stok Rendah</h3>
            @if($lowStockItems->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($lowStockItems as $item)
                                <tr class="bg-yellow-50">
                                    <td class="px-4 py-2">{{ $item->name }}</td>
                                    <td class="px-4 py-2">{{ $item->quantity }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($item->item_type) }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada barang dengan stok rendah.</p>
            @endif
        </div>

        {{-- obat dengan stok rendah --}}
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Obat dengan Stok Rendah</h3>
            @if($lowMedicine->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kedaluwarsa</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($lowMedicine as $medicine)
                                <tr class="bg-yellow-50">
                                    <td class="px-4 py-2">{{ $medicine->name }}</td>
                                    <td class="px-4 py-2">{{ $medicine->quantity }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ \Carbon\Carbon::parse($medicine->expiry_date)->format('d-m-Y') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada obat dengan stok rendah.</p>
            @endif
        </div>

        <!-- Obat Kedaluwarsa -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Obat Kedaluwarsa</h3>
            @if($expiredMedicine->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kedaluwarsa</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($expiredMedicine as $medicine)
                                <tr class="bg-red-50">
                                    <td class="px-4 py-2">{{ $medicine->item->name }}</td>
                                    <td class="px-4 py-2">{{ $medicine->item->quantity }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ \Carbon\Carbon::parse($medicine->expiry_date)->format('d-m-Y') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada obat yang kedaluwarsa.</p>
            @endif
        </div>

        <!-- Semua Barang -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Semua Barang</h3>
            @if($items->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nilai Total</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($items as $item)
                                <tr class="{{ isset($item->expiry_date) && \Carbon\Carbon::parse($item->expiry_date)->isPast() ? 'bg-red-50' : ($item->quantity <= 5 ? 'bg-yellow-50' : '') }}">
                                    <td class="px-4 py-2">{{ $item->name }}</td>
                                    <td class="px-4 py-2">{{ $item->quantity }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($item->item_type) }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">
                                        @if(isset($item->expiry_date) && \Carbon\Carbon::parse($item->expiry_date)->isPast())
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Kedaluwarsa</span>
                                        @elseif($item->quantity <= 5)
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Stok Rendah</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Normal</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada barang dalam inventori.</p>
            @endif
        </div>
    </div>
</div>
@endsection
