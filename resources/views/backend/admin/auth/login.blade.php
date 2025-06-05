<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-green-600 py-6 px-8 text-center">
                    <h1 class="text-2xl font-bold text-white">Admin Login</h1>
                    <p class="text-green-100 mt-1">Secure administration portal</p>
                </div>
                
                <!-- Login Form -->
                <form method="POST" action="{{ route('admin.login.post') }}" class="p-8 space-y-6">
                    @csrf
                    
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Enter admin email"
                            required
                            autofocus
                        >
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Enter password"
                            required
                        >
                    </div>
                    
                    <div>
                        <button 
                            type="submit" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        >
                            Sign In
                        </button>
                    </div>
                </form>
                
                <!-- Footer -->
                <div class="bg-gray-50 px-8 py-4 text-center border-t border-gray-200">
                    <p class="text-xs text-gray-500">© 2025 GoParcel Admin. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
