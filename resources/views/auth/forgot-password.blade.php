<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>

    @vite('resources/css/app.css')
    <title>Reset Kata Sandi | SPMB SMK Kitri Bakti</title>

    <!-- Logo Tab -->
    <link rel="icon" href="{{ asset('/images/logokitri.png') }}" type="image/png">
</head>

<body class="min-h-screen flex items-center justify-center px-4 bg-gray-100">

    <div class="w-full max-w-md text-center">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('/images/logokitri.png') }}"
                 alt="Logo"
                 class="w-24 h-24 object-contain drop-shadow-lg">
        </div>

        <!-- Title -->
        <h2 class="text-3xl font-bold text-gray-800">Reset Kata Sandi</h2>
        <p class="text-gray-500 text-sm mt-1 mb-8">
            Masukkan email kamu untuk menerima link reset sandi.
        </p>

        @if (session('status'))
            <div class="mb-4 p-3 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}" class="text-left">
            @csrf

            <label class="block text-gray-700 font-semibold mb-1">Alamat Email</label>

            <input
                type="email"
                name="email"
                class="w-full px-5 py-3.5 rounded-lg border border-gray-300 bg-gray-50
                       focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300
                       transition-all duration-200 outline-none shadow-sm"
                placeholder="Masukkan email aktif..."
                required
            >

            @error('email')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror

            <!-- Button -->
            <button
                type="submit"
                class="w-full mt-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                       rounded-xl shadow-md active:scale-[0.98] transition duration-200">
                Kirim Link Reset Password
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}"
               class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
                ← Kembali ke Login
            </a>
        </div>
    </div>

</body>

</html>
