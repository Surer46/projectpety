<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta name="description" content="@yield('description', 'Cafeteria PETY — Sistema Integrado')"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Cafeteria PETY')</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<link rel="manifest" href="/manifest.json"/>
<meta name="theme-color" content="#0f172a"/>
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
.material-symbols-rounded {
  font-family: 'Material Symbols Rounded';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;
  line-height: 1;
  letter-spacing: normal;
  text-transform: none;
  display: inline-block;
  white-space: nowrap;
  word-wrap: normal;
  direction: ltr;
  -webkit-font-smoothing: antialiased;
}
:root{
  --active-bg:#c79c5e;
  --text:#ffffff;
  --muted:#94a3b8;
  --accent:#c79c5e;
  --success:#10b981;
  --danger:#ef4444;
}
.font-serif {
  font-family: 'Playfair Display', Georgia, serif;
}
body{
  font-family:'Inter',system-ui,sans-serif;
  background:#101725;
  color:var(--text);
  min-height:100vh;
}
body::before{
  display:none;
}
.glass-panel{
  background:rgba(30,38,56,0.3);
  border:1px solid rgba(255,255,255,0.03);
  border-radius:20px;
}

/* --- Global Animations --- */
@keyframes slideUpFade {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-page-content {
    animation: slideUpFade 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Modal Animations */
@keyframes modalBackdropFade { 0% { opacity: 0; } 100% { opacity: 1; } }
@keyframes modalContentPop { 0% { opacity: 0; transform: scale(0.95) translateY(15px); } 100% { opacity: 1; transform: scale(1) translateY(0); } }
@keyframes modalBackdropFadeOut { 0% { opacity: 1; } 100% { opacity: 0; } }
@keyframes modalContentPopOut { 0% { opacity: 1; transform: scale(1) translateY(0); } 100% { opacity: 0; transform: scale(0.95) translateY(15px); } }

.modal-enter { animation: modalBackdropFade 0.3s ease-out forwards !important; }
.modal-enter-content { animation: modalContentPop 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards !important; }
.modal-exit { animation: modalBackdropFadeOut 0.2s ease-in forwards !important; }
.modal-exit-content { animation: modalContentPopOut 0.2s ease-in forwards !important; }
</style>
@stack('styles')
</head>

<body class="flex flex-col h-screen overflow-hidden">
    @php
        $activeNav = request()->segment(1) ?: 'ventas';
        // Determinar si es ruta administrativa
        $isAdminRoute = in_array($activeNav, ['backoffice', 'inventario', 'promociones-comidas']);
    @endphp

    <!-- 1. TOPBAR HORIZONTAL (Global) -->
    <header class="sticky top-0 z-50 w-full bg-[#0a0f18]/90 backdrop-blur-md border-b border-white/5 py-4 flex items-center justify-between text-white shrink-0 h-[72px]" style="padding-left: 2rem; padding-right: 2rem;">
        <!-- Logo -->
        <a href="{{ route('bienvenida') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-slate-950 shadow-lg" style="background-color: #c79c5e;">
                <span class="material-symbols-rounded">coffee</span>
            </div>
            <span class="font-bold text-xl tracking-tight">Cafeteria PETY</span>
        </a>

        <!-- Menú Cliente -->
        <nav class="hidden md:flex items-center gap-8">
            <a href="{{ route('pos') }}" class="pb-1 {{ $activeNav == 'ventas' ? 'border-b-2 font-medium' : 'border-b-2 border-transparent text-slate-400 hover:text-white transition-all' }}" style="{{ $activeNav == 'ventas' ? 'border-color: #c79c5e; color: #c79c5e;' : '' }}">
                Menú
            </a>
            <a href="{{ route('reservaciones') }}" class="pb-1 {{ $activeNav == 'reservaciones' ? 'border-b-2 font-medium' : 'border-b-2 border-transparent text-slate-400 hover:text-white transition-all' }}" style="{{ $activeNav == 'reservaciones' ? 'border-color: #c79c5e; color: #c79c5e;' : '' }}">
                Reservaciones
            </a>
            <a href="{{ route('pedidos.index') }}" class="pb-1 {{ $activeNav == 'mis-pedidos' ? 'border-b-2 font-medium' : 'border-b-2 border-transparent text-slate-400 hover:text-white transition-all' }}" style="{{ $activeNav == 'mis-pedidos' ? 'border-color: #c79c5e; color: #c79c5e;' : '' }}">
                Mis Pedidos
            </a>
            <a href="{{ route('atencion-cliente') }}" class="pb-1 {{ $activeNav == 'atencion-cliente' ? 'border-b-2 font-medium' : 'border-b-2 border-transparent text-slate-400 hover:text-white transition-all' }}" style="{{ $activeNav == 'atencion-cliente' ? 'border-color: #c79c5e; color: #c79c5e;' : '' }}">
                Atención al Cliente
            </a>
        </nav>

        <!-- 2. ACCESO CONDICIONAL A ADMINISTRACIÓN -->
        <div class="flex items-center gap-4">
            <!-- Indicador de Red (Sprint 6 PWA) -->
            <div id="network-status-badge" class="flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-full border transition-all" style="background-color: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); color: #10b981;">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span id="network-status-text">En línea</span>
            </div>

            @auth
                @if(auth()->user()->hasRole('dueño') || auth()->user()->hasRole('administrador') || auth()->user()->role === 'cajero')
                <a href="{{ route('backoffice') }}" class="hidden sm:flex items-center text-amber-500 border border-amber-500/20 font-bold hover:bg-amber-500 hover:text-slate-950 transition-all text-sm shadow-lg shadow-amber-500/10" style="background: rgba(245,158,11,0.1); padding: 0.6rem 1.2rem; border-radius: 1rem; gap: 0.5rem;">
                    <span class="material-symbols-rounded" style="font-size: 20px;">admin_panel_settings</span>
                    Administración
                </a>
                @endif
                <div style="position: relative;">
                    <button id="user-menu-btn" class="flex items-center text-sm font-medium cursor-pointer hover:opacity-80 transition-opacity" style="gap: 1rem;" onclick="document.getElementById('user-dropdown').classList.toggle('hidden')">
                        <div class="w-9 h-9 rounded-full bg-slate-800 border border-white/10 flex items-center justify-center">
                            <span class="material-symbols-rounded text-[20px] text-amber-500">person</span>
                        </div>
                        <span class="hidden sm:block text-slate-200">{{ auth()->user()->name }}</span>
                    </button>
                    <!-- Dropdown -->
                    <div id="user-dropdown" class="hidden" style="position: absolute; right: 0; top: 100%; margin-top: 0.75rem; width: 14rem; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); padding: 0.5rem 0; z-index: 50;">
                        <a href="{{ route('compras.index') }}" class="block text-sm text-slate-300 hover:bg-white/5 hover:text-white flex items-center transition-colors" style="gap: 0.5rem; padding: 0.6rem 1rem;"><span class="material-symbols-rounded" style="font-size: 18px;">history</span> Mis compras (historial)</a>
                        <a href="{{ route('settings') }}" class="block text-sm text-slate-300 hover:bg-white/5 hover:text-white flex items-center transition-colors" style="gap: 0.5rem; padding: 0.6rem 1rem;"><span class="material-symbols-rounded" style="font-size: 18px;">settings</span> Configuración</a>
                        <div class="border-t border-white/5" style="margin: 0.5rem 0;"></div>
                        <a href="#" class="block text-sm text-red-400 hover:bg-white/5 flex items-center transition-colors" style="gap: 0.5rem; padding: 0.6rem 1rem;"><span class="material-symbols-rounded" style="font-size: 18px;">logout</span> Cerrar sesión</a>
                    </div>
                </div>
            @else
                <a href="{{ route('backoffice') }}" class="hidden sm:flex items-center border font-bold transition-all text-sm shadow-lg" style="color: #c79c5e; border-color: rgba(199,156,94,0.3); background: rgba(199,156,94,0.1); padding: 0.6rem 1.2rem; border-radius: 1rem; gap: 0.5rem;" onmouseover="this.style.backgroundColor='#c79c5e'; this.style.color='#0a0f18';" onmouseout="this.style.backgroundColor='rgba(199,156,94,0.1)'; this.style.color='#c79c5e';">
                    <span class="material-symbols-rounded" style="font-size: 20px;">admin_panel_settings</span>
                    Administración
                </a>
                <div style="position: relative;">
                    <button id="user-menu-btn-guest" class="flex items-center text-sm font-medium cursor-pointer hover:opacity-80 transition-opacity" style="gap: 1rem;" onclick="document.getElementById('user-dropdown-guest').classList.toggle('hidden')">
                        <div class="w-9 h-9 rounded-full bg-slate-800 border border-white/10 flex items-center justify-center">
                            <span class="material-symbols-rounded text-[20px]" style="color: #c79c5e;">person</span>
                        </div>
                        <span class="hidden sm:block text-slate-200">Oscar Dueño</span>
                    </button>
                    <!-- Dropdown -->
                    <div id="user-dropdown-guest" class="hidden" style="position: absolute; right: 0; top: 100%; margin-top: 0.75rem; width: 14rem; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); padding: 0.5rem 0; z-index: 50;">
                        <a href="{{ route('compras.index') }}" class="block text-sm text-slate-300 hover:bg-white/5 hover:text-white flex items-center transition-colors" style="gap: 0.5rem; padding: 0.6rem 1rem;"><span class="material-symbols-rounded" style="font-size: 18px;">history</span> Mis compras (historial)</a>
                        <a href="{{ route('settings') }}" class="block text-sm text-slate-300 hover:bg-white/5 hover:text-white flex items-center transition-colors" style="gap: 0.5rem; padding: 0.6rem 1rem;"><span class="material-symbols-rounded" style="font-size: 18px;">settings</span> Configuración</a>
                        <div class="border-t border-white/5" style="margin: 0.5rem 0;"></div>
                        <a href="#" class="block text-sm text-red-400 hover:bg-white/5 flex items-center transition-colors" style="gap: 0.5rem; padding: 0.6rem 1rem;"><span class="material-symbols-rounded" style="font-size: 18px;">logout</span> Cerrar sesión</a>
                    </div>
                </div>
            @endauth
        </div>
    </header>

    <!-- 3. CONTENEDOR FLEX PRINCIPAL -->
    <div class="flex w-full flex-1 overflow-hidden">
        
        <!-- SIDEBAR LATERAL IZQUIERDA (Exclusiva para Administración) -->
        <aside class="{{ $isAdminRoute ? 'flex' : 'hidden' }} w-64 border-r flex-col shrink-0 h-full overflow-y-auto" style="background-color: #0a0f18; border-color: rgba(255,255,255,0.05); padding: 1.5rem; gap: 0.5rem;">
            <div class="text-[0.7rem] font-bold text-slate-500 uppercase tracking-wider mb-2 mt-2" style="padding: 0 0.75rem;">
                Módulos Administrativos
            </div>
            
            <a href="{{ route('backoffice') }}" class="flex items-center transition-all {{ $activeNav == 'backoffice' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5 font-medium' }}" style="padding: 0.75rem; border-radius: 0.75rem; gap: 0.75rem; border: 1px solid; {{ $activeNav == 'backoffice' ? 'background: rgba(199,156,94,0.1); color: #c79c5e; border-color: rgba(199,156,94,0.3);' : 'border-color: transparent;' }}">
                <span class="material-symbols-rounded text-[22px] shrink-0">admin_panel_settings</span>
                <span class="truncate whitespace-nowrap text-sm">Backoffice</span>
            </a>

            <a href="{{ route('promotions-meals.index') }}" class="flex items-center transition-all {{ $activeNav == 'promociones-comidas' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5 font-medium' }}" style="padding: 0.75rem; border-radius: 0.75rem; gap: 0.75rem; border: 1px solid; {{ $activeNav == 'promociones-comidas' ? 'background: rgba(199,156,94,0.1); color: #c79c5e; border-color: rgba(199,156,94,0.3);' : 'border-color: transparent;' }}">
                <span class="material-symbols-rounded text-[22px] shrink-0">table_restaurant</span>
                <span class="truncate whitespace-nowrap text-sm">Ofertas, Comidas & Mesas</span>
            </a>

            <a href="{{ route('inventory') }}" class="flex items-center transition-all {{ $activeNav == 'inventario' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5 font-medium' }}" style="padding: 0.75rem; border-radius: 0.75rem; gap: 0.75rem; border: 1px solid; {{ $activeNav == 'inventario' ? 'background: rgba(199,156,94,0.1); color: #c79c5e; border-color: rgba(199,156,94,0.3);' : 'border-color: transparent;' }}">
                <span class="material-symbols-rounded text-[22px] shrink-0">inventory_2</span>
                <span class="truncate whitespace-nowrap text-sm">Inventario</span>
            </a>


            <div class="mt-auto border-t" style="border-color: rgba(255,255,255,0.05); padding-top: 1rem;">
                <a href="{{ route('pos') }}" class="flex items-center text-slate-400 hover:text-white hover:bg-white/5 transition-all font-medium" style="padding: 0.75rem; border-radius: 0.75rem; gap: 0.75rem; border: 1px solid transparent;">
                    <span class="material-symbols-rounded text-[22px]">storefront</span>
                    Volver al POS
                </a>
            </div>
        </aside>

        <!-- 4. CONTENIDO DINÁMICO -->
        <!-- Si es ruta administrativa, le damos padding, si no, lo dejamos expandirse -->
        <main class="flex-1 w-full min-w-0 h-full overflow-y-auto animate-page-content" style="padding: {{ $isAdminRoute ? '2rem' : '1.5rem' }};">
            @yield('content')
        </main>

    </div>

    <!-- Tostadas globales / Alertas -->
    <div id="toast" class="fixed bottom-6 left-1/2 transform -translate-x-1/2 md:translate-x-0 md:top-24 md:bottom-auto md:left-auto md:right-8 z-[9999] flex items-center rounded-2xl shadow-2xl opacity-0 scale-90 pointer-events-none transition-all duration-300 backdrop-blur-xl" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); min-width: 320px; padding: 1rem 1.5rem 1rem 2rem; gap: 1.25rem;">
        <div id="toast-icon-wrapper" class="shrink-0 flex items-center justify-center rounded-full border shadow-inner" style="width: 2.25rem; height: 2.25rem; background-color: rgba(199, 156, 94, 0.1); border-color: rgba(199, 156, 94, 0.3); color: #c79c5e;">
            <span class="material-symbols-rounded block" style="font-size: 20px; line-height: 1; text-align: center; margin: 0; padding: 0;" id="toast-icon">check</span>
        </div>
        <div class="flex flex-col flex-1 justify-center">
            <span id="toast-title" class="text-white font-bold tracking-wide" style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.1rem; line-height: 1.2;">¡Éxito!</span>
            <span id="toast-text" class="text-slate-400 text-[0.85rem] leading-snug mt-0.5"></span>
        </div>
    </div>

    @stack('scripts')
    
    <script>
        // Función global para Toasts estéticos (Rich Notifications)
        function toast(message, type = 'success') {
            const el = document.getElementById('toast');
            const icon = document.getElementById('toast-icon');
            const iconWrapper = document.getElementById('toast-icon-wrapper');
            const txt = document.getElementById('toast-text');
            const title = document.getElementById('toast-title');
            
            txt.textContent = message;
            
            let colorHex = '#c79c5e'; // Gold para success
            let iconName = 'check_circle';
            let titleText = '¡Listo!';
            
            if (type === 'error') {
                colorHex = '#ef4444'; // Red para error
                iconName = 'error';
                titleText = 'Error';
            } else if (type === 'info') {
                colorHex = '#3b82f6'; // Blue para info
                iconName = 'info';
                titleText = 'Información';
            } else if (type === 'success') {
                colorHex = '#c79c5e';
                iconName = 'task_alt';
                titleText = 'Agregado al Carrito';
            }
            
            title.textContent = titleText;
            
            iconWrapper.style.backgroundColor = `${colorHex}1A`; // 10% opacity
            iconWrapper.style.borderColor = `${colorHex}4D`; // 30% opacity
            iconWrapper.style.color = colorHex;
            iconWrapper.style.boxShadow = `inset 0 0 15px ${colorHex}1A`;
            
            icon.textContent = iconName;
            
            // Mostrar animado
            el.classList.remove('opacity-0', 'scale-90', 'pointer-events-none');
            el.classList.add('opacity-100', 'scale-100');
            
            // Ocultar
            setTimeout(() => {
                el.classList.remove('opacity-100', 'scale-100');
                el.classList.add('opacity-0', 'scale-90', 'pointer-events-none');
            }, 3500);
        }

        // Dropdown Click-Outside
        window.addEventListener('click', function(e) {
            const dropdownBtn = document.getElementById('user-menu-btn');
            const dropdown = document.getElementById('user-dropdown');
            if (dropdownBtn && dropdown && !dropdownBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
            
            const dropdownBtnGuest = document.getElementById('user-menu-btn-guest');
            const dropdownGuest = document.getElementById('user-dropdown-guest');
            if (dropdownBtnGuest && dropdownGuest && !dropdownBtnGuest.contains(e.target) && !dropdownGuest.contains(e.target)) {
                dropdownGuest.classList.add('hidden');
            }
        });

        // PWA & Service Worker Registration (Sprint 6)
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then(reg => {
                    console.log('PETA POS ServiceWorker registrado:', reg.scope);
                }).catch(err => {
                    console.log('Error al registrar ServiceWorker:', err);
                });
            });
        }

        // Network Status Monitor & Auto-Sync Engine (Sprint 6)
        function updateNetworkStatus() {
            const badge = document.getElementById('network-status-badge');
            const text = document.getElementById('network-status-text');
            const dot = badge ? badge.querySelector('span:first-child') : null;

            if (navigator.onLine) {
                if (badge) {
                    badge.style.backgroundColor = 'rgba(16, 185, 129, 0.1)';
                    badge.style.borderColor = 'rgba(16, 185, 129, 0.2)';
                    badge.style.color = '#10b981';
                }
                if (text) text.textContent = 'En línea';
                if (dot) dot.className = 'w-2 h-2 rounded-full bg-emerald-500 animate-pulse';

                syncPendingOrders();
            } else {
                if (badge) {
                    badge.style.backgroundColor = 'rgba(245, 158, 11, 0.1)';
                    badge.style.borderColor = 'rgba(245, 158, 11, 0.2)';
                    badge.style.color = '#f59e0b';
                }
                if (text) text.textContent = 'Modo Offline';
                if (dot) dot.className = 'w-2 h-2 rounded-full bg-amber-500';
            }
        }

        window.addEventListener('online', updateNetworkStatus);
        window.addEventListener('offline', updateNetworkStatus);
        document.addEventListener('DOMContentLoaded', updateNetworkStatus);

        function syncPendingOrders() {
            const pendingOrders = JSON.parse(localStorage.getItem('pending_offline_orders') || '[]');
            if (pendingOrders.length === 0) return;

            if (typeof toast === 'function') {
                toast(`Sincronizando ${pendingOrders.length} venta(s) offline...`, 'info');
            }

            fetch('{{ route("orders.sync-offline") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ orders: pendingOrders })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    localStorage.removeItem('pending_offline_orders');
                    if (typeof toast === 'function') {
                        toast(`${data.synced_count} ventas sincronizadas con éxito`, 'success');
                    }
                }
            })
            .catch(err => {
                console.error('Error sincronizando órdenes offline:', err);
            });
        }

        setInterval(() => {
            if (navigator.onLine) syncPendingOrders();
        }, 15000);
    </script>
</body>
</html>
