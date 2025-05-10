@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Manajemen Pengguna</h2>
<table class="min-w-full text-sm text-left bg-white rounded shadow">
    <thead class="bg-gray-100 text-gray-600">
        <tr>
 
            <th class="py-2 px-4">ID</th>
            <th class="py-2 px-4">Nama</th>
            <th class="py-2 px-4">Email</th>
            <th class="py-2 px-4">Role</th>
            <th class="py-2 px-4">Status</th>
            <th class="py-2 px-4">Aksi</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr class="border-t">
            <td class="py-2 px-4">{{ $user->id }}</td>
            <td class="py-2 px-4">{{ $user->name }}</td>
            <td class="py-2 px-4">{{ $user->email }}</td>
            <td class="py-2 px-4 capitalize">{{ $user->role }}</td>      
            <td class="py-2 px-4">
                @if ($user->status == 'active')
                <span class="text-green-500">Aktif</span>
                @else
                <span class="text-red-500">Tidak Aktif</span>
                @endif
            </td>
            <td class="py-2 px-4">
                <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection