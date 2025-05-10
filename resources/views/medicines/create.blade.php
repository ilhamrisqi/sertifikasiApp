@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Tambah Obat Baru</h2>
<form action="{{ route('medicines.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
    @csrf
    <div>
        <label class="block text-sm text-gray-600">Nama Obat</label>
        <input type="text" name="name" class="w-full bg-blue-50 border-gray-300 rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm text-gray-600">Kuantitas</label>
        <input type="number" name="quantity" class="w-full bg-blue-50 border-gray-300 rounded px-3 py-2" required>
    <div>
        <label class="block text-sm text-gray-600">Dosis</label>
        <input type="text" name="dosage" class="w-full bg-blue-50 border-gray-300 rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm text-gray-600">Harga</label>
        <input type="number" name="price" class="w-full bg-blue-50 border-gray-300 rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm text-gray-600">Kadaluarsa</label>
        <input type="date" name="expiry_date" class="w-full bg-blue-50 border-gray-300 rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm text-gray-600">Perlu Resep?</label>
        <select name="requires_prescription" class="w-full bg-blue-50 border-gray-300 rounded px-3 py-2">
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
        </select>
    </div>
    <div>
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
            Simpan
        </button>
    </div>
</form>
@endsection
