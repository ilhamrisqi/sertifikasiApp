@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Pengguna</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            <ul class="list-disc pl-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Nama -->
        <div class="relative">
            <input name="name" id="name" type="text" required
                class="peer border border-gray-300 rounded-md w-full p-3 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                placeholder="Nama">
            <label for="name" class="absolute left-3 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-sm peer-focus:text-green-600">
                Nama
            </label>
        </div>

        <!-- Email -->
        <div class="relative">
            <input name="email" id="email" type="email" required
                class="peer border border-gray-300 rounded-md w-full p-3 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                placeholder="Email">
            <label for="email" class="absolute left-3 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-sm peer-focus:text-green-600">
                Email
            </label>
        </div>

        <!-- Password -->
        <div class="relative">
            <input name="password" id="password" type="password" required
                class="peer border border-gray-300 rounded-md w-full p-3 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                placeholder="Password">
            <label for="password" class="absolute left-3 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-1 peer-focus:text-sm peer-focus:text-green-600">
                Password
            </label>
        </div>

        <!-- Role -->
        <div class="relative">
            <select name="role" id="role" required
                class="border border-gray-300 rounded-md w-full p-3 bg-white focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="" disabled selected>-- Pilih Role --</option>
                <option value="Pharmacist">💊 Pharmacist</option>
                <option value="Technician">🔧 Technician</option>
                <option value="Admin">🛠 Admin</option>
            </select>
        </div>

        <!-- Tombol Submit -->
        <div class="text-right">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 shadow-sm">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
