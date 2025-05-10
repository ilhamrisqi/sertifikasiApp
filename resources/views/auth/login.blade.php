<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Your App</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center px-4">

    <div class="max-w-6xl w-full bg-white rounded-3xl shadow-xl overflow-hidden grid md:grid-cols-2">

        <div class="hidden md:flex items-center justify-center bg-blue-600 p-10">
            <h1 class="text-white text-4xl font-bold">Login</h1>
        </div>
        <!-- Right side / Form -->
        <div class="p-10">
            <h2 class="text-3xl font-bold text-slate-700 mb-4">Welcome Back 👋</h2>
            <p class="text-slate-500 mb-6">Enter your credentials to access your account</p>

            @if (session('status'))
                <div class="mb-4 p-3 text-sm text-green-700 bg-green-100 border border-green-300 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email address</label>
                    <input type="email" name="email" id="email" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" />
                </div>

                <div>
                    <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" />
                </div>

                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember"
                               class="border-gray-300 rounded focus:ring-blue-500">
                        <label for="remember" class="text-gray-600">Remember me</label>
                    </div>
                    <a href="#" class="text-blue-600 hover:underline">Forgot password?</a>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                    Sign in
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
            </p>
        </div>
    </div>

</body>
</html>
