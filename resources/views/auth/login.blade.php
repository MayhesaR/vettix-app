<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vettix - Log In</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            light: '#e0fcfd',
                            DEFAULT: '#00c2cb',
                            dark: '#009ba2',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
    </style>
</head>
<body class="bg-gradient-to-tr from-slate-900 via-indigo-950 to-slate-900 min-h-screen flex items-center justify-center p-4">

    <!-- Card Container -->
    <div class="w-full max-w-md">
        
        <!-- Brand/Logo Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-brand/10 text-brand text-3xl mb-3 shadow-[0_0_20px_rgba(0,194,203,0.2)]">
                <i class="fa-solid fa-code-branch"></i>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Vettix</h1>
            <p class="text-slate-400 text-sm mt-1">Platform Manajemen Event & Sertifikat</p>
        </div>

        <!-- Form Card -->
        <div class="glass-card rounded-3xl p-8 shadow-2xl transition-all duration-300 hover:shadow-brand/5">
            
            <h2 class="text-xl font-semibold text-slate-800 mb-6 text-center">Masuk ke Akun Anda</h2>

            <!-- Success message -->
            @if (session('success'))
                <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error message -->
            @if (session('error'))
                <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 text-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Global errors -->
            @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 text-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                    <span>Terdapat beberapa kesalahan input.</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wider">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            placeholder="nama@email.com" 
                            class="block w-full pl-10 pr-4 py-3 bg-slate-50/50 border @error('email') border-rose-400 focus:ring-rose-400 focus:border-rose-400 @else border-slate-200 focus:ring-brand focus:border-brand @enderror rounded-xl text-slate-800 placeholder-slate-400 text-sm outline-none transition-all focus:bg-white focus:ring-2"
                        >
                    </div>
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="block text-xs font-medium text-slate-600 uppercase tracking-wider">Password</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required 
                            placeholder="••••••••" 
                            class="block w-full pl-10 pr-4 py-3 bg-slate-50/50 border @error('password') border-rose-400 focus:ring-rose-400 focus:border-rose-400 @else border-slate-200 focus:ring-brand focus:border-brand @enderror rounded-xl text-slate-800 placeholder-slate-400 text-sm outline-none transition-all focus:bg-white focus:ring-2"
                        >
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Remember me -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        class="h-4 w-4 rounded border-slate-300 text-brand focus:ring-brand transition-colors cursor-pointer"
                    >
                    <label for="remember" class="ml-2 block text-sm text-slate-600 cursor-pointer select-none">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <!-- Submit button -->
                <div>
                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 bg-brand hover:bg-brand-dark active:bg-brand-dark text-white font-semibold rounded-xl text-sm shadow-lg shadow-brand/20 transition-all duration-150 hover:-translate-y-0.5 active:translate-y-0 focus:ring-2 focus:ring-brand/50 outline-none"
                    >
                        Masuk
                    </button>
                </div>
            </form>

            <!-- Register link -->
            <div class="mt-8 pt-6 border-t border-slate-200/60 text-center">
                <p class="text-slate-600 text-sm">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-semibold text-brand hover:text-brand-dark transition-colors ml-1">Daftar sekarang</a>
                </p>
            </div>

        </div>
        
    </div>

</body>
</html>
