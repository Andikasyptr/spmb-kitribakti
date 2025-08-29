<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @vite('resources/css/app.css')
  <!-- Logo Tab Browser -->
    <link rel="icon" href="{{ asset('/images/hm.png') }}" type="image/png">
  <title>Login | smkhijaumuda</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
    
    @keyframes fadeInRight {
      0% { opacity: 0; transform: translateX(40px); }
      100% { opacity: 1; transform: translateX(0); }
    }
    .animate-fadeInRight { animation: fadeInRight 1s ease-out forwards; }
    
    .error-message {
      animation: shake 0.5s ease-in-out;
    }
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60% { transform: translateX(-5px); }
      40%, 80% { transform: translateX(5px); }
    }
  </style>
</head>
<body class="h-full overflow-hidden">
  <div class="flex min-h-screen overflow-hidden">
    <!-- Left Side - Image -->
  <div class="hidden lg:block w-1/2 h-screen animate-fadeInRight">
  <img class="object-cover w-full h-full" src="{{ asset('images/loginn.JPG') }}" alt="Background" />
</div>


    <!-- Right Side - Sign In Form -->
    <div class="w-full lg:w-1/2 max-w-md mx-auto flex flex-col justify-center px-8 animate-fadeInUp">
      <div>
      <img class="h-auto w-40 md:w-24 lg:w-28 mb-1 mx-auto transition duration-700 ease-in-out transform hover:scale-105" src="{{ asset('images/hm.png') }}" alt="Logo">
        <h2 class="text-2xl font-bold text-gray-900 text-center">Masuk Ke Akun Kamu</h2>
        <p class="mt-2 text-sm text-gray-600 text-center">
          belum memiliki akun?
          <a href="{{ route ('register') }}" class="text-indigo-600 font-medium hover:underline">daftar akun sekarang</a>
        </p>
      </div>

      <!-- Error Messages -->
      @if($errors->any())
        <div class="mt-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-md error-message">
          {{ $errors->first() }}
        </div>
      @endif

      @if(session('error'))
        <div class="mt-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-md error-message">
          {{ session('error') }}
        </div>
      @endif

      <form class="mt-2 space-y-3" action="{{ route('login') }}" method="POST">
        @csrf

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
          <input type="email" name="email" id="email" value="{{ old('email') }}" required
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
        </div>

        <div class="relative">
          <label for="password" class="block text-sm font-medium text-gray-700">Kata sandi</label>
          <input type="password" name="password" id="password" required
            class="mt-1 w-full px-4 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">

          <!-- Tombol ikon mata -->
          <button type="button" onclick="togglePassword()"
            class="absolute top-1/2 right-3 transform -translate-y-3/3 text-gray-500 hover:text-indigo-600">
            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 
                    8.268 2.943 9.542 7-1.274 4.057-5.064 
                    7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>

        <div class="flex items-center justify-between text-sm">
          <label class="flex items-center">
            <input type="checkbox" name="remember" class="mr-2">
            ingatkan saya
          </label>
          <!--<a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline font-medium">Lupa kata sandi?</a>-->
        </div>

        <button type="submit"
          class="w-full bg-indigo-600 text-white py-2 rounded-md font-semibold hover:bg-indigo-500 transition duration-300 ease-in-out transform hover:scale-105">
          Masuk
        </button>

        {{-- <div class="flex items-center justify-center text-gray-500 text-sm">
          <span class="border-t w-1/5 mr-3"></span>
          atau lanjutkan dengan
          <span class="border-t w-1/5 ml-3"></span>
        </div>

        <div class="flex space-x-4">
          <a href="{{ route('login.google') }}" 
            class="flex items-center justify-center w-1/2 border border-gray-300 py-2 rounded-md hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 mr-2">
            Google
          </a>
          <a href="#" 
            class="flex items-center justify-center w-1/2 border border-gray-300 py-2 rounded-md hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
            <img src="https://www.svgrepo.com/show/512317/github-142.svg" alt="GitHub" class="w-5 h-5 mr-2">
            GitHub
          </a>
        </div>
      </form>
    </div> --}}
  </div>
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const eyeIcon = document.getElementById("eye-icon");
      const isPassword = passwordInput.type === "password";

      passwordInput.type = isPassword ? "text" : "password";

      eyeIcon.innerHTML = isPassword
        ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.964 9.964 0 012.841-4.331m3.155-1.752A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.257 2.592M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M3 3l18 18" />`
        : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
    }
  </script>
</body>
</html>