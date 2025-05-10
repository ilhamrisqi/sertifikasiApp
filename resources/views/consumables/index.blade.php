@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Manajemen Consumable</h2>
<a href="{{ route('consumables.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Consumable</a>

<table class="min-w-full text-sm text-left bg-white rounded shadow">
    <thead class="bg-gray-100 text-gray-600">
        <tr>
            <th class="py-2 px-4">Nama Item</th>
            <th class="py-2 px-4">Jenis Penggunaan</th>
            <th class="py-2 px-4">Status Sterilisasi</th>
            <th class="py-2 px-4">Kadaluarsa</th>
            <th class="py-2 px-4">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($consumables as $consumable)
        <tr class="border-t">
            <td class="py-2 px-4">{{ $consumable->item->name }}</td>
            <td class="py-2 px-4">{{ $consumable->usage_type }}</td>
            <td class="py-2 px-4">{{ $consumable->sterilization_status }}</td>
            <td class="py-2 px-4 text-red-500">{{ $consumable->expiry_date->translatedFormat('d F Y') }}</td>
            <td class="py-2 px-4">
                <a href="{{ route('consumables.edit', $consumable) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                <form action="{{ route('consumables.destroy', $consumable) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus consumable ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
