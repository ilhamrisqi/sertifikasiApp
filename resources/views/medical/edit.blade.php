@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Alat Medis</h2>

<form action="{{ route('medical.update', $equipment->id) }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow max-w-lg">
    @csrf
    @method('PUT')

    <div>
        <label class="block mb-1">Nama</label>
        <input type="text" name="name" value="{{ $equipment->item->name }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block mb-1">Jumlah</label>
        <input type="number" name="quantity" value="{{ $equipment->item->quantity }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block mb-1">Harga</label>
        <input type="number" name="price" value="{{ $equipment->item->price }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block mb-1">Departemen</label>
        <input type="text" name="department" value="{{ $equipment->department }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block mb-1">Status Operasional</label>
        <select name="operational_status" class="w-full border border-gray-300 rounded px-3 py-2" required>
            <option value="Active" {{ $equipment->operational_status == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Maintenance" {{ $equipment->operational_status == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
            <option value="Broken" {{ $equipment->operational_status == 'Broken' ? 'selected' : '' }}>Broken</option>
        </select>
    </div>

    <div>
        <label class="block mb-1">Jadwal Perawatan</label>
        <input type="date" name="maintenance_schedule" value="{{ \Carbon\Carbon::parse($equipment->maintenance_schedule)->format('Y-m-d') }}" class="w-full border border-gray-300 rounded px-3 py-2">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
</form>
@endsection
