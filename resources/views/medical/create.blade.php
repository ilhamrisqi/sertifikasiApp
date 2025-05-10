@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Tambah Alat Medis</h2>

<form action="{{ route('medical.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow max-w-lg">
    @csrf

    <div>
        <label class="block mb-1">Nama Alat</label>
        <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block mb-1">Jumlah Alat</label>
        <input type="number" name="quantity" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block mb-1">Harga Alat</label>
        <input type="number" name="price" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block mb-1">Departemen</label>
        <input type="text" name="department" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block mb-1">Status Operasional</label>
        <select name="operational_status" class="w-full border border-gray-300 rounded px-3 py-2" required>
            <option value="Active">Active</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Broken">Broken</option>
        </select>
    </div>

    <div>
        <label class="block mb-1">Jadwal Perawatan</label>
        <input type="date" name="maintenance_schedule" class="w-full border border-gray-300 rounded px-3 py-2">
    </div>
    
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
</form>
@endsection
