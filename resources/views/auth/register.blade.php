<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @vite('resources/css/app.css')
  <link rel="icon" href="{{ asset('/images/hm.png') }}" type="image/png">
  <title>Register | Smkhijaumuda</title>
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

    /* Style untuk tombol mata */
    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #6b7280;
    }
    .relative { position: relative; }
  </style>
</head>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body class="h-full overflow-hidden">
  <div class="flex min-h-screen overflow-hidden">
    <!-- Left Side -->
    <div class="hidden lg:block w-1/2 h-screen animate-fadeInRight">
      <img class="object-cover w-full h-full" src="{{ asset('images/loginn.JPG') }}" alt="Background" />
    </div>

    <!-- Right Side -->
    <div class="w-full lg:w-1/2 max-w-md mx-auto flex flex-col justify-center px-8 animate-fadeInUp">
      <div>
        <img class="h-auto w-40 md:w-24 lg:w-28 mb-1 mx-auto transition duration-700 ease-in-out transform hover:scale-105" src="{{ asset('images/hm.png') }}" alt="Logo">
        <h2 class="text-2xl font-bold text-gray-900 text-center">Daftar Akun Baru</h2>
        <p class="mt-2 text-sm text-gray-600 text-center">
          sudah punya akun?
          <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">masuk di sini</a>
        </p>
      </div>

      <!-- Error Messages -->
      @if($errors->any())
        <div class="mt-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-md error-message">
          {{ $errors->first() }}
        </div>
      @endif

      <form id="registerForm" class="mt-4 space-y-3" action="{{ route('register') }}" method="POST">
        @csrf

        <!-- Nama Lengkap -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
          <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
          <input type="email" name="email" id="email" value="{{ old('email') }}" required
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
        </div>

       <!-- Password -->
<div class="mb-4">
  <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
  <div class="relative">
    <input type="password" name="password" id="password" required
      class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
    
    <!-- Tombol ikon mata -->
    <button type="button" onclick="togglePassword('password', 'eye-icon')"
      class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-indigo-600">
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
</div>

<!-- Konfirmasi Password -->
<div class="mb-4">
  <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
  <div class="relative">
    <input type="password" name="password_confirmation" id="password_confirmation" required
      class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out">
    
    <!-- Tombol ikon mata -->
    <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-confirm')"
      class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-indigo-600">
      <svg id="eye-icon-confirm" xmlns="http://www.w3.org/2000/svg" fill="none"
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
</div>


        <!-- Tombol Submit -->
        <button type="submit"
          class="w-full bg-indigo-600 text-white py-2 rounded-md font-semibold hover:bg-indigo-500 transition duration-300 ease-in-out transform hover:scale-105">
          Daftar Sekarang
        </button>
      </form>
    </div>
  </div>
<script>
  function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    const isPassword = input.type === "password";

    input.type = isPassword ? "text" : "password";

    if (isPassword) {
      // Ganti ikon mata menjadi "terbuka"
      icon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.964 9.964 0 012.841-4.331m3.155-1.752A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.257 2.592M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 3l18 18"/>
      `;
    } else {
      // Kembalikan ikon mata tertutup
      icon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
      `;
    }
  }
</script>

<!--<script>-->

  // SweetAlert after form submit
<!--  document.getElementById('registerForm').addEventListener('submit', function(e) {-->
    e.preventDefault(); // hentikan submit default
<!--    const form = this;-->

<!--    fetch(form.action, {-->
<!--      method: form.method,-->
<!--      headers: {-->
<!--        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,-->
<!--        'Accept': 'application/json',-->
<!--        'Content-Type': 'application/json'-->
<!--      },-->
<!--      body: JSON.stringify({-->
<!--        name: form.name.value,-->
<!--        email: form.email.value,-->
<!--        password: form.password.value,-->
<!--        password_confirmation: form.password_confirmation.value-->
<!--      })-->
<!--    })-->
<!--    .then(response => response.json())-->
<!--    .then(data => {-->
<!--      if (data.errors) {-->
<!--        Swal.fire({-->
<!--          icon: 'error',-->
<!--          title: 'Gagal Daftar',-->
<!--          text: data.errors[Object.keys(data.errors)[0]][0],-->
<!--          confirmButtonColor: '#6366F1'-->
<!--        });-->
<!--      } else {-->
<!--        Swal.fire({-->
<!--          icon: 'success',-->
<!--          title: 'Berhasil!',-->
<!--          text: 'Akun berhasil didaftarkan.',-->
<!--          confirmButtonColor: '#6366F1'-->
<!--        }).then(() => {-->
<!--          window.location.href = "{{ route('login') }}";-->
<!--        });-->
<!--      }-->
<!--    })-->
<!--    .catch(err => console.log(err));-->
<!--  });-->
<!--</script>-->

</body>
</html>
