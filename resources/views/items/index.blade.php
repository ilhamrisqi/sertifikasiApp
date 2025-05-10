@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Manajemen Item</h2>
<a href="{{ route('items.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Item</a>

<table class="min-w-full text-sm text-left bg-white rounded shadow">
    <thead class="bg-gray-100 text-gray-600">
        <tr>
            <th class="py-2 px-4">Nama</th>
            <th class="py-2 px-4">Jumlah</th>
            <th class="py-2 px-4">Harga</th>
            <th class="py-2 px-4">Tipe</th>
            <th class="py-2 px-4">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr class="border-t">
            <td class="py-2 px-4">{{ $item->name }}</td>
            <td class="py-2 px-4">{{ $item->quantity }}</td>
            <td class="py-2 px-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
            <td class="py-2 px-4">{{ $item->item_type }}</td>
            <td class="py-2 px-4">
                <a href="{{ route('items.edit', $item) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus item ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
