@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Consumable</h2>

<form action="{{ route('consumables.update', $consumable) }}" method="POST" class="bg-white p-6 rounded shadow-md space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block mb-1">Nama</label>
        <input type="text" name="name" value="{{ $consumable->item->name }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block mb-1">Jumlah</label>
        <input type="number" name="quantity" value="{{ $consumable->item->quantity }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block mb-1">Harga</label>
        <input type="number" name="price" value="{{ $consumable->item->price }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block mb-1">Jenis Penggunaan</label>
        <select name="usage_type" class="w-full border border-gray-300 rounded px-3 py-2" required>
            <option value="Single Use" {{ $consumable->usage_type == 'Single Use' ? 'selected' : '' }}>Single Use</option>
            <option value="Multiple Use" {{ $consumable->usage_type == 'Multiple Use' ? 'selected' : '' }}>Multiple Use</option>
        </select>
    </div>

    <div>
        <label class="block text-gray-700">Status Sterilisasi</label>
        <select name="sterilization_status" class="w-full border rounded px-3 py-2" required>
            <option value="Sterilized" {{ $consumable->sterilization_status == 'Sterilized' ? 'selected' : '' }}>Sterilized</option>
            <option value="Not Sterilized" {{ $consumable->sterilization_status == 'Not Sterilized' ? 'selected' : '' }}>Not Sterilized</option>
        </select>
    </div>

    <div>
        <label class="block text-gray-700">Tanggal Kadaluarsa</label>
        <input type="date" name="expiry_date" value="{{ $consumable->expiry_date->format('Y-m-d') }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
</form>
@endsection
