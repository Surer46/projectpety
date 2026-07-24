@extends('layouts.app')

@section('title', 'Iniciar Sesión — Cafeteria PETY')

@section('content')
<div class="w-full flex flex-col items-center justify-center py-6 px-4">
    
    <!-- TARJETA PRINCIPAL DE LOGIN (Cumpliendo estrictamente AGENTS.md) -->
    <div class="w-full max-w-md flex flex-col gap-6 rounded-[2.5rem] border shadow-2xl relative overflow-hidden" 
         style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 2.5rem;">
        
        <!-- Glow ambiental superior -->
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-48 h-48 rounded-full blur-3xl pointer-events-none" style="background: rgba(199,156,94,0.15);"></div>

        <!-- Encabezado de Marca -->
        <div class="text-center flex flex-col items-center gap-3">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-slate-950 shadow-xl" style="background-color: #c79c5e;">
                <span class="material-symbols-rounded text-3xl">coffee</span>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight" style="font-family: 'Playfair Display', Georgia, serif;">Acceso al Sistema</h1>
                <p class="text-xs text-slate-400 mt-1">Ingresa tus credenciales para acceder a tus pedidos, reservaciones y administración.</p>
            </div>
        </div>

        <!-- Mensajes de Alerta/Error -->
        @if (isset($errors) && $errors->any())
            <div class="rounded-xl border p-4 text-xs font-semibold flex items-start gap-3" style="background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.25); color: #f87171;">
                <span class="material-symbols-rounded text-lg shrink-0" style="color: #ef4444;">error</span>
                <div class="flex flex-col gap-1">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        @if (session('status'))
            <div class="rounded-xl border p-4 text-xs font-semibold flex items-center gap-3" style="background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.25); color: #34d399;">
                <span class="material-symbols-rounded text-lg shrink-0" style="color: #10b981;">check_circle</span>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- FORMULARIO DE LOGIN -->
        <form method="POST" action="{{ route('login.post') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Campo: Correo / Usuario -->
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1" for="login_input">
                    Correo electrónico o Usuario
                </label>
                <input type="text" 
                       id="login_input" 
                       name="login" 
                       value="{{ old('login') }}" 
                       required 
                       autofocus
                       placeholder="ej. oscar@cafeteriapety.com"
                       class="w-full text-white outline-none transition-all focus:border-[#c79c5e]" 
                       style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
            </div>

            <!-- Campo: Contraseña -->
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-xs font-bold text-slate-400 uppercase" for="password_input">
                        Contraseña
                    </label>
                </div>
                <input type="password" 
                       id="password_input" 
                       name="password" 
                       required
                       placeholder="••••••••"
                       class="w-full text-white outline-none transition-all focus:border-[#c79c5e]" 
                       style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
            </div>

            <!-- Recordarme -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 text-slate-400 cursor-pointer hover:text-white transition-colors">
                    <input type="checkbox" name="remember" class="rounded accent-[#c79c5e]" style="width: 1rem; height: 1rem;">
                    <span>Recordar mi sesión</span>
                </label>
            </div>

            <!-- Botón de Iniciar Sesión (Formato estándar AGENTS.md) -->
            <button type="submit" 
                    class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer w-full mt-2" 
                    style="background-color: #c79c5e; color: #0a0f18; padding: 0.85rem 1.5rem; border-radius: 1rem; border: none;">
                <span class="material-symbols-rounded text-lg">login</span>
                <span>Iniciar Sesión</span>
            </button>
        </form>

        <!-- SECCIÓN DE ACCESO RÁPIDO DE PRUEBAS (1-Click Demo Login) -->
        <div class="flex flex-col gap-3" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 0.5rem;">
            <div class="text-center">
                <span class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-wider">Cuentas de Prueba Rápidas</span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                <!-- Cuentas -->
                <button type="button" 
                        onclick="fillDemoAccount('oscar@cafeteriapety.com', 'password123')"
                        class="flex flex-col items-center justify-center text-center border border-white/5 hover:border-[#c79c5e]/50 hover:bg-white/5 transition-all text-xs cursor-pointer"
                        style="padding: 0.65rem 0.5rem; border-radius: 0.75rem; background: rgba(15, 23, 42, 0.4);">
                    <span class="font-bold text-amber-400 truncate w-full">👑 Oscar</span>
                    <span class="text-[0.65rem] text-slate-400">Dueño</span>
                </button>

                <button type="button" 
                        onclick="fillDemoAccount('laura@cafeteriapety.com', 'password123')"
                        class="flex flex-col items-center justify-center text-center border border-white/5 hover:border-[#c79c5e]/50 hover:bg-white/5 transition-all text-xs cursor-pointer"
                        style="padding: 0.65rem 0.5rem; border-radius: 0.75rem; background: rgba(15, 23, 42, 0.4);">
                    <span class="font-bold text-slate-200 truncate w-full">👩‍💼 Laura</span>
                    <span class="text-[0.65rem] text-slate-400">Gerente</span>
                </button>

                <button type="button" 
                        onclick="fillDemoAccount('carlos@cafeteriapety.com', 'password123')"
                        class="flex flex-col items-center justify-center text-center border border-white/5 hover:border-[#c79c5e]/50 hover:bg-white/5 transition-all text-xs cursor-pointer"
                        style="padding: 0.65rem 0.5rem; border-radius: 0.75rem; background: rgba(15, 23, 42, 0.4);">
                    <span class="font-bold text-slate-200 truncate w-full">💳 Carlos</span>
                    <span class="text-[0.65rem] text-slate-400">Cajero</span>
                </button>
            </div>
        </div>

        <!-- Volver al Menú -->
        <div class="text-center" style="margin-top: -0.25rem;">
            <a href="{{ route('pos') }}" class="text-xs text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1">
                <span class="material-symbols-rounded text-sm">arrow_back</span>
                <span>Continuar explorando el Menú como invitado</span>
            </a>
        </div>

    </div>
</div>

@push('scripts')
<script>
function fillDemoAccount(email, password) {
    document.getElementById('login_input').value = email;
    document.getElementById('password_input').value = password;
    if (typeof toast === 'function') {
        toast('Credenciales de demo cargadas. Haz clic en Iniciar Sesión.', 'info');
    }
}
</script>
@endpush
@endsection
