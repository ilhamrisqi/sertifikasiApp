@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-semibold text-gray-700 mb-4">Tambah Pengguna</h2>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.update', $user->id) }}" method="POST" class="bg-white p-6 rounded shadow-md space-y-4">
    @csrf

    @method('PUT')
    <div>
        <label class="block text-gray-700">Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2" required>             
    </div>
    <div>
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-gray-700">Password</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2">
        <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password</small>
    </div>
    <div>
        <label class="block text-gray-700">Role</label>
        <select name="role" class="w-full border rounded px-3 py-2" required>
            <option value="" disabled selected>-- Pilih Role --</option>
            <option value="Pharmacist" {{ $user->role == 'Pharmacist' ? 'selected' : '' }}>💊 Pharmacist</option>
            <option value="Technician" {{ $user->role == 'Technician' ? 'selected' : '' }}>🔧 Technician</option>
            <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>🛠 Admin</option>
        </select>
    </div>
    <div>
        <label class="block text-gray-700">Status</label>
        <select name="status" class="w-full border rounded px-3 py-2" required>
            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>
    <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </div>
</form>
@endsection
