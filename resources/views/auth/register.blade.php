<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register - Your App</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center px-4">

    <div class="max-w-6xl w-full bg-white rounded-3xl shadow-xl overflow-hidden grid md:grid-cols-2">
        <!-- Left side -->
        <div class="hidden md:flex items-center justify-center bg-blue-600 p-10">
            <h1 class="text-white text-4xl font-bold">Register</h1>
        </div>

        <!-- Right side / Form -->
        <div class="p-10">
            <h2 class="text-3xl font-bold text-slate-700 mb-4">Create an Account</h2>
            <p class="text-slate-500 mb-6">Fill the form below to register</p>

            @if ($errors->any())
                <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" />
                </div>

                <div>
                    <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email address</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" />
                </div>

                <div>
                    <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" />
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" />
                </div>

                <div>
                    <label for="role" class="block mb-1 text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">-- Select Role --</option>
                        <option value="Pharmacist" {{ old('role') == 'Pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                        <option value="Technician" {{ old('role') == 'Technician' ? 'selected' : '' }}>Technician</option>
                    </select>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                    Register
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a>
            </p>
        </div>
    </div>
</body>
</html>
