<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-green-50 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8 border border-green-100">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold text-green-700">Staff Portal</h1>
            <p class="text-sm text-green-500 mt-1">Welcome back! Please login to continue.</p>
        </div>

        <!-- Error Message -->
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 text-sm rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('staff.login.post') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-green-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email"
                       class="w-full px-4 py-2 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                       required autofocus>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-green-700 mb-1">Password</label>
                <input type="password" name="password" id="password"
                       class="w-full px-4 py-2 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                Login
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-gray-400">
            &copy; {{ date('Y') }} GOParcel Staff Portal. All rights reserved.
        </div>
    </div>

</body>
</html>
