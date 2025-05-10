@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Obat</h2>
@if ($errors->any())
    <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-100" role="alert">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('medicines.update', $medicine) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm text-gray-600">Nama Obat</label>
        <input type="text" name="name" value="{{ old('name', $medicine->item['name']) }}" class="w-full border-gray-300 rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm text-gray-600">Kuantitas</label>
        <input type="number" name="quantity" value="{{ old('quantity', $medicine->item['quantity']) }}" class="w-full border-gray-300 rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm text-gray-600">Harga</label>
        <input type="number" name="price" value="{{ old('price', $medicine->item['price']) }}" class="w-full border-gray-300 rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm text-gray-600">Dosis</label>
        <input type="text" name="dosage" value="{{ old('dosage', $medicine->dosage) }}" class="w-full border-gray-300 rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm text-gray-600">Kadaluarsa</label>
        <input type="date" name="expiry_date" 
            value="{{ old('expiry_date', \Carbon\Carbon::parse($medicine->expiry_date)->format('Y-m-d')) }}" 
            class="w-full border-gray-300 rounded px-3 py-2">
    </div>
    
    <div>
        <label class="block text-sm text-gray-600">Perlu Resep?</label>
        <select name="requires_prescription" class="w-full border-gray-300 rounded px-3 py-2">
            <option value="1" {{ $medicine->requires_prescription ? 'selected' : '' }}>Ya</option>
            <option value="0" {{ !$medicine->requires_prescription ? 'selected' : '' }}>Tidak</option>
        </select>
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
</form>
@endsection
