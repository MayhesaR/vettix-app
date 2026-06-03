<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vettix - Daftar Akun</title>
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
    <div class="w-full max-w-md my-8">
        
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
            
            <h2 class="text-xl font-semibold text-slate-800 mb-6 text-center">Daftar Akun Baru</h2>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            placeholder="John Doe" 
                            class="block w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border @error('name') border-rose-400 focus:ring-rose-400 focus:border-rose-400 @else border-slate-200 focus:ring-brand focus:border-brand @enderror rounded-xl text-slate-800 placeholder-slate-400 text-sm outline-none transition-all focus:bg-white focus:ring-2"
                        >
                    </div>
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

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
                            placeholder="nama@email.com" 
                            class="block w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border @error('email') border-rose-400 focus:ring-rose-400 focus:border-rose-400 @else border-slate-200 focus:ring-brand focus:border-brand @enderror rounded-xl text-slate-800 placeholder-slate-400 text-sm outline-none transition-all focus:bg-white focus:ring-2"
                        >
                    </div>
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Role Selector -->
                <div>
                    <label for="role" class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wider">Tipe Akun</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user-tag"></i>
                        </div>
                        <select 
                            name="role" 
                            id="role"
                            class="block w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 focus:ring-brand focus:border-brand rounded-xl text-slate-800 text-sm outline-none transition-all focus:bg-white focus:ring-2 cursor-pointer appearance-none"
                        >
                            <option value="peserta" {{ old('role') === 'peserta' ? 'selected' : '' }}>Peserta</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wider">Password</label>
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
                            class="block w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border @error('password') border-rose-400 focus:ring-rose-400 focus:border-rose-400 @else border-slate-200 focus:ring-brand focus:border-brand @enderror rounded-xl text-slate-800 placeholder-slate-400 text-sm outline-none transition-all focus:bg-white focus:ring-2"
                        >
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Password Confirmation Input -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-medium text-slate-600 mb-1.5 uppercase tracking-wider">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            required 
                            placeholder="••••••••" 
                            class="block w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 focus:ring-brand focus:border-brand rounded-xl text-slate-800 placeholder-slate-400 text-sm outline-none transition-all focus:bg-white focus:ring-2"
                        >
                    </div>
                </div>

                <!-- Submit button -->
                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 bg-brand hover:bg-brand-dark active:bg-brand-dark text-white font-semibold rounded-xl text-sm shadow-lg shadow-brand/20 transition-all duration-150 hover:-translate-y-0.5 active:translate-y-0 focus:ring-2 focus:ring-brand/50 outline-none"
                    >
                        Daftar
                    </button>
                </div>
            </form>

            <!-- Login link -->
            <div class="mt-6 pt-6 border-t border-slate-200/60 text-center">
                <p class="text-slate-600 text-sm">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-semibold text-brand hover:text-brand-dark transition-colors ml-1">Masuk di sini</a>
                </p>
            </div>

        </div>
        
    </div>

</body>
</html>
