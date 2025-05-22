<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign In</title>
  <!-- Tailwind CSS via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center font-inter">

  <div class="w-full max-w-2xl mx-auto p-6">
    <div class="text-center mb-8">
      <h1 class="text-4xl font-bold text-white mb-2 animate-slide-down">Welcome Back</h1>
      <p class="text-gray-400 animate-fade-in delay-200">Please sign in to continue</p>
    </div>

    <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-700 relative">
      <!-- Gradient bar -->
      <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-purple-500 to-indigo-500"></div>

      {{-- Session Status --}}
      @if (session('status'))
        <div class="bg-red-600 bg-opacity-80 text-white text-center py-3">
          {{ session('status') }}
        </div>
      @endif

      <div class="px-10 py-8">
        <h2 class="text-2xl font-semibold text-white mb-1">Sign In</h2>
        <p class="text-gray-400 mb-6">Enter your credentials to access your account</p>

        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-6">
          @csrf

          <!-- Email -->
          <div>
            <label for="email" class="block text-gray-200 font-medium mb-1">
              Email <span class="text-sm text-gray-400">*</span>
            </label>
            <div class="relative">
              <input id="email" name="email" type="email" required autofocus
                class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="name@example.com" value="{{ old('email') }}" autocomplete="username" />
              <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                <!-- mail icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                  <polyline points="22,6 12,13 2,6"/>
                </svg>
              </span>
            </div>
            @error('email')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <div class="flex justify-between items-center mb-1">
              <label for="password" class="text-gray-200 font-medium">
                Password <span class="text-sm text-gray-400">*</span>
              </label>
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-400 hover:underline">
                  Forgot password?
                </a>
              @endif
            </div>
            <div class="relative">
              <input id="password" name="password" type="password" required
                class="w-full pl-10 pr-10 py-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="••••••••" autocomplete="current-password" />
              <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                <!-- lock icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
              </span>
              <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 focus:outline-none">
                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                  <path d="M1 1l22 22"/>
                </svg>
              </button>
            </div>
            @error('password')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Remember Me -->
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="remember" class="form-checkbox h-5 w-5 text-indigo-500 bg-gray-700 border-gray-600 rounded focus:ring-indigo-400" />
            <span class="text-gray-400">Remember me</span>
          </label>

          <!-- Submit -->
          <button id="loginButton" type="submit"
            class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-medium shadow-lg flex justify-center items-center space-x-2 disabled:opacity-50">
            <svg class="spinner hidden h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            <span>Sign In</span>
          </button>
        </form>

        <!-- OR divider -->
        <div class="flex items-center my-6">
          <div class="flex-1 h-px bg-gray-600"></div>
          
          <div class="flex-1 h-px bg-gray-600"></div>
        </div>

     

    </div>
  </div>

  <script>
    function togglePassword() {
      const pw = document.getElementById('password');
      const eye = document.getElementById('eyeIcon');
      const eyeOff = document.getElementById('eyeOffIcon');
      if (pw.type === 'password') {
        pw.type = 'text';
        eye.classList.add('hidden');
        eyeOff.classList.remove('hidden');
      } else {
        pw.type = 'password';
        eye.classList.remove('hidden');
        eyeOff.classList.add('hidden');
      }
    }

    document.getElementById('loginForm').addEventListener('submit', () => {
      const btn = document.getElementById('loginButton');
      const spinner = btn.querySelector('.spinner');
      const text = btn.querySelector('span');
      spinner.classList.remove('hidden');
      text.textContent = 'Signing in...';
      btn.disabled = true;
    });
  </script>

  <!-- Animations -->
  <style>
    @keyframes slide-down { from { opacity: 0; transform: translateY(-20px);} to { opacity:1; transform: translateY(0);} }
    .animate-slide-down { animation: slide-down 0.5s ease-out both; }
    @keyframes fade-in { from { opacity:0;} to { opacity:1;} }
    .animate-fade-in { animation: fade-in 0.5s ease-out both; }
    .delay-200 { animation-delay: 0.2s; }
  </style>
</body>
</html>
