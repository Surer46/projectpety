@extends('layouts.app')

@section('title', 'Iniciar Sesión — Cafeteria PETY')

@push('styles')
<style>
/* --- LOGIN HERO & BACKGROUND ANIMATIONS --- */
.login-hero-container {
    position: relative;
    width: 100%;
    min-height: calc(100vh - 72px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2.5rem 1rem;
    background-image: url('{{ asset("img/login_bg.jpg") }}');
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    overflow: hidden;
}

/* Gradient Overlay elegante idéntico a la Landing Page */
.login-hero-container::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        160deg,
        rgba(10, 15, 24, 0.88) 0%,
        rgba(15, 23, 42, 0.65) 45%,
        rgba(10, 15, 24, 0.92) 100%
    );
    z-index: 0;
    pointer-events: none;
}

/* Esferas de Bokeh flotantes con animación continua */
.glow-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    pointer-events: none;
    z-index: 1;
    opacity: 0.4;
    animation: floatGlow 12s infinite ease-in-out alternate;
}

.glow-orb-1 {
    top: 10%;
    left: 15%;
    width: 300px;
    height: 300px;
    background: rgba(199, 156, 94, 0.25);
    animation-delay: 0s;
}

.glow-orb-2 {
    bottom: 12%;
    right: 15%;
    width: 350px;
    height: 350px;
    background: rgba(59, 130, 246, 0.15);
    animation-delay: -4s;
}

.glow-orb-3 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 250px;
    height: 250px;
    background: rgba(199, 156, 94, 0.2);
    animation-delay: -8s;
}

@keyframes floatGlow {
    0% { transform: translateY(0px) scale(1); opacity: 0.35; }
    50% { transform: translateY(-30px) scale(1.1); opacity: 0.55; }
    100% { transform: translateY(20px) scale(0.95); opacity: 0.3; }
}

/* Entrada de Tarjeta Glassmorphism */
.login-card-animated {
    position: relative;
    z-index: 10;
    animation: loginCardIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    backdrop-filter: blur(24px) saturate(150%);
    -webkit-backdrop-filter: blur(24px) saturate(150%);
}

@keyframes loginCardIn {
    0% { opacity: 0; transform: translateY(35px) scale(0.96); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

/* Micro-animación de pulso para el logo */
.brand-logo-anim {
    animation: logoPulse 3s infinite ease-in-out;
}
@keyframes logoPulse {
    0%, 100% { transform: scale(1); box-shadow: 0 10px 25px rgba(199,156,94,0.3); }
    50% { transform: scale(1.06); box-shadow: 0 15px 35px rgba(199,156,94,0.5); }
}
</style>
@endpush

@section('content')
<div class="login-hero-container">
    
    <!-- Orbes de Luz Ambiental Flotantes -->
    <div class="glow-orb glow-orb-1"></div>
    <div class="glow-orb glow-orb-2"></div>
    <div class="glow-orb glow-orb-3"></div>

    <!-- TARJETA PRINCIPAL DE LOGIN (Cumpliendo estrictamente AGENTS.md + Glassmorphism) -->
    <div class="login-card-animated w-full max-w-md flex flex-col gap-6 rounded-[2.5rem] border shadow-2xl overflow-hidden" 
         style="background-color: rgba(30, 38, 56, 0.75); border-color: rgba(255,255,255,0.12); padding: 2.5rem;">
        
        <!-- Glow ambiental superior interno -->
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-48 h-48 rounded-full blur-3xl pointer-events-none" style="background: rgba(199,156,94,0.2);"></div>

        <!-- Encabezado de Marca -->
        <div class="text-center flex flex-col items-center gap-3">
            <div class="brand-logo-anim w-14 h-14 rounded-2xl flex items-center justify-center text-slate-950 transition-all" style="background-color: #c79c5e;">
                <span class="material-symbols-rounded text-3xl">coffee</span>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight" style="font-family: 'Playfair Display', Georgia, serif;">Acceso al Sistema</h1>
                <p class="text-xs text-slate-300 mt-1">Ingresa tus credenciales para acceder a tus pedidos, reservaciones y administración.</p>
            </div>
        </div>

        <!-- Mensajes de Alerta/Error -->
        @if (isset($errors) && $errors->any())
            <div class="rounded-xl border p-4 text-xs font-semibold flex items-start gap-3" style="background: rgba(239,68,68,0.15); border-color: rgba(239,68,68,0.3); color: #f87171;">
                <span class="material-symbols-rounded text-lg shrink-0" style="color: #ef4444;">error</span>
                <div class="flex flex-col gap-1">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        @if (session('status'))
            <div class="rounded-xl border p-4 text-xs font-semibold flex items-center gap-3" style="background: rgba(16,185,129,0.15); border-color: rgba(16,185,129,0.3); color: #34d399;">
                <span class="material-symbols-rounded text-lg shrink-0" style="color: #10b981;">check_circle</span>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- FORMULARIO DE LOGIN -->
        <form method="POST" action="{{ route('login.post') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Campo: Correo / Usuario -->
            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase mb-1" for="login_input">
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
                       style="background: rgba(15, 23, 42, 0.6); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.1);" />
            </div>

            <!-- Campo: Contraseña -->
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-xs font-bold text-slate-300 uppercase" for="password_input">
                        Contraseña
                    </label>
                </div>
                <input type="password" 
                       id="password_input" 
                       name="password" 
                       required
                       placeholder="••••••••"
                       class="w-full text-white outline-none transition-all focus:border-[#c79c5e]" 
                       style="background: rgba(15, 23, 42, 0.6); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.1);" />
            </div>

            <!-- Recordarme -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 text-slate-300 cursor-pointer hover:text-white transition-colors">
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
                <span class="text-[0.7rem] font-bold text-slate-300 uppercase tracking-wider">Cuentas de Prueba Rápidas</span>
            </div>
            
            <div class="grid grid-cols-2 gap-2">
                <!-- Cuentas -->
                <button type="button" 
                        onclick="fillDemoAccount('oscar@cafeteriapety.com', 'password123')"
                        class="flex flex-col items-center justify-center text-center border border-white/10 hover:border-[#c79c5e]/60 hover:bg-white/10 transition-all text-xs cursor-pointer"
                        style="padding: 0.65rem 0.5rem; border-radius: 0.75rem; background: rgba(15, 23, 42, 0.5);">
                    <span class="font-bold text-amber-400 truncate w-full">👑 Oscar Dueño</span>
                    <span class="text-[0.65rem] text-slate-300">Rol: Dueño (Admin)</span>
                </button>

                <button type="button" 
                        onclick="fillDemoAccount('juan.perez@example.com', 'password123')"
                        class="flex flex-col items-center justify-center text-center border border-white/10 hover:border-[#c79c5e]/60 hover:bg-white/10 transition-all text-xs cursor-pointer"
                        style="padding: 0.65rem 0.5rem; border-radius: 0.75rem; background: rgba(15, 23, 42, 0.5);">
                    <span class="font-bold text-emerald-400 truncate w-full">🛒 Juan Pérez</span>
                    <span class="text-[0.65rem] text-slate-300">Rol: Cliente</span>
                </button>

                <button type="button" 
                        onclick="fillDemoAccount('laura@cafeteriapety.com', 'password123')"
                        class="flex flex-col items-center justify-center text-center border border-white/10 hover:border-[#c79c5e]/60 hover:bg-white/10 transition-all text-xs cursor-pointer"
                        style="padding: 0.65rem 0.5rem; border-radius: 0.75rem; background: rgba(15, 23, 42, 0.5);">
                    <span class="font-bold text-slate-200 truncate w-full">👩‍💼 Laura Gerente</span>
                    <span class="text-[0.65rem] text-slate-300">Rol: Gerente</span>
                </button>

                <button type="button" 
                        onclick="fillDemoAccount('carlos@cafeteriapety.com', 'password123')"
                        class="flex flex-col items-center justify-center text-center border border-white/10 hover:border-[#c79c5e]/60 hover:bg-white/10 transition-all text-xs cursor-pointer"
                        style="padding: 0.65rem 0.5rem; border-radius: 0.75rem; background: rgba(15, 23, 42, 0.5);">
                    <span class="font-bold text-slate-200 truncate w-full">💳 Carlos Cajero</span>
                    <span class="text-[0.65rem] text-slate-300">Rol: Cajero</span>
                </button>
            </div>
        </div>

        <!-- Volver al Menú -->
        <div class="text-center" style="margin-top: -0.25rem;">
            <a href="{{ route('pos') }}" class="text-xs text-slate-300 hover:text-white transition-colors inline-flex items-center gap-1">
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
