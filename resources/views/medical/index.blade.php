@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Manajemen Alat Medis</h2>
<a href="{{ route('medical.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Alat</a>

<table class="min-w-full text-sm text-left bg-white rounded shadow">
    <thead class="bg-gray-100 text-gray-600">
        <tr>
            <th class="py-2 px-4">Nama Alat</th>
            <th class="py-2 px-4">Departemen</th>
            <th class="py-2 px-4">Status</th>
            <th class="py-2 px-4">Jadwal Perawatan</th>
            <th class="py-2 px-4">Aksi</th>
        </tr>
    </thead>
    <tbody>

        @if($equipments)
        @foreach($equipments as $equipment)
        <tr class="border-t">
            <td class="py-2 px-4">{{ $equipment->item->name }}</td>
            <td class="py-2 px-4">{{ $equipment->department }}</td>
            <td class="py-2 px-4">{{ $equipment->operational_status }}</td>
            <td class="py-2 px-4 text-blue-600">
                {{ $equipment->maintenance_schedule ? \Carbon\Carbon::parse($equipment->maintenance_schedule)->translatedFormat('d F Y') : '-' }}
            </td>
            <td class="py-2 px-4">
                <a href="{{ route('medical.edit', $equipment) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                <form action="{{ route('medical.destroy', $equipment) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus data alat ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach

        @else

        <h1>tidak ada data</h1>
        @endif
    
    </tbody>
</table>
@endsection
