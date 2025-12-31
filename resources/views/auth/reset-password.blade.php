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
            Silakan masukkan kata sandi baru untuk akun Anda.
        </p>

        <!-- FORM RESET PASSWORD -->
        <form method="POST" action="{{ route('password.update') }}" class="text-left">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <label class="block text-gray-700 font-semibold mb-1">Alamat Email</label>
            <input type="email"
                   name="email"
                   value="{{ request('email') }}"
                   class="w-full px-5 py-3.5 rounded-lg border border-gray-300 bg-gray-50
                          focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300
                          transition-all duration-200 outline-none shadow-sm"
                   required>

            @error('email')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror

            <!-- Password Baru -->
            <label class="block text-gray-700 font-semibold mt-4 mb-1">Password Baru</label>
            <input type="password"
                   name="password"
                   class="w-full px-5 py-3.5 rounded-lg border border-gray-300 bg-gray-50
                          focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300
                          transition-all duration-200 outline-none shadow-sm"
                   required>

            @error('password')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror

            <!-- Konfirmasi Password -->
            <label class="block text-gray-700 font-semibold mt-4 mb-1">Konfirmasi Password Baru</label>
            <input type="password"
                   name="password_confirmation"
                   class="w-full px-5 py-3.5 rounded-lg border border-gray-300 bg-gray-50
                          focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300
                          transition-all duration-200 outline-none shadow-sm"
                   required>

            <!-- Button -->
            <button type="submit"
                    class="w-full mt-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                           rounded-xl shadow-md active:scale-[0.98] transition duration-200">
                Simpan Kata Sandi Baru
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
