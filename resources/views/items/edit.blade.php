@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Item</h2>
<form action="{{ route('items.update', $item) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm text-gray-600">Nama</label>
        <input type="text" name="name" value="{{ old('name', $item->name) }}" class="w-full border-gray-300 rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm text-gray-600">Jumlah</label>
        <input type="number" name="quantity" value="{{ old('quantity', $item->quantity) }}" class="w-full border-gray-300 rounded px-3 py-2" min="0">
    </div>
    <div>
        <label class="block text-sm text-gray-600">Harga</label>
        <input type="number" name="price" step="0.01" value="{{ old('price', $item->price) }}" class="w-full border-gray-300 rounded px-3 py-2" min="0">
    </div>
    <div>
        <label class="block text-sm text-gray-600">Tipe</label>
        <select name="item_type" class="w-full border-gray-300 rounded px-3 py-2">
            <option value="Medicine" {{ old('item_type', $item->item_type) == 'Medicine' ? 'selected' : '' }}>Medicine</option>
            <option value="MedicalEquipment" {{ old('item_type', $item->item_type) == 'MedicalEquipment' ? 'selected' : '' }}>Medical Equipment</option>
            <option value="Consumable" {{ old('item_type', $item->item_type) == 'Consumable' ? 'selected' : '' }}>Consumable</option>
        </select>
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
</form>
@endsection
