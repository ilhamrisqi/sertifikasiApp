@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Manajemen Obat</h2>
<a href="{{ route('medicines.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Obat</a>

<table class="min-w-full text-sm text-left bg-white rounded shadow">
    <thead class="bg-gray-100 text-gray-600">
        <tr>
            <th class="py-2 px-4">Nama Item</th>
            <th class="py-2 px-4">Dosis</th>
            <th class="py-2 px-4">Kadaluarsa</th>
            <th class="py-2 px-4">Perlu Resep?</th>
            <th class="py-2 px-4">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($medicines as $medicine)
        <tr class="border-t">
            <td class="py-2 px-4">{{ $medicine->item->name }}</td>
            <td class="py-2 px-4">{{ $medicine->dosage }}</td>
            <td class="py-2 px-4 text-red-500">{{ \Carbon\Carbon::parse($medicine->expiry_date)->translatedFormat('d F Y') }}</td>
            <td class="py-2 px-4">{{ $medicine->requires_prescription ? 'Ya' : 'Tidak' }}</td>
            <td class="py-2 px-4">
                <a href="{{ route('medicines.edit', $medicine) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                <form action="{{ route('medicines.destroy', $medicine) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus obat ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
