@extends('layouts.app')
@section('title', 'Cafeteria PETY | Configuración')

@section('content')
<div class="flex flex-col" style="padding: 1.5rem; gap: 2rem;">
  <!-- Header -->
  <div class="flex items-center justify-between flex-wrap" style="gap: 1rem;">
    <div>
      <div class="text-2xl font-bold tracking-tight text-white flex items-center gap-2">
        <span class="material-symbols-rounded text-amber-500" style="font-size: 28px;">settings</span>
        Configuración del Sistema
      </div>
      <p class="text-sm text-slate-400 mt-1">Ajustes de perfil, negocio e impuestos.</p>
    </div>
  </div>

  <!-- Profile Banner -->
  <div class="glass-panel flex items-center gap-5" style="padding: 1.75rem; border-radius: 1.5rem;">
    <div class="w-16 h-16 rounded-full border-2 border-white/20 shadow-lg flex items-center justify-center bg-slate-800 overflow-hidden shrink-0">
      <img src="{{ $perfil->AvatarUrl }}" alt="Avatar" class="w-full h-full object-cover" onerror="this.style.display='none'">
    </div>
    <div>
      <h2 class="text-xl font-bold text-white">{{ $perfil->Name }}</h2>
      <div class="flex items-center mt-1 gap-2">
        <span class="inline-flex items-center rounded-full text-xs font-bold" style="padding: 0.25rem 0.75rem; gap: 0.375rem; background-color: {{ $perfil->IsAdmin ? 'rgba(16,185,129,0.1)' : 'rgba(245,158,11,0.1)' }}; color: {{ $perfil->IsAdmin ? '#10b981' : '#f59e0b' }}; border: 1px solid {{ $perfil->IsAdmin ? 'rgba(16,185,129,0.2)' : 'rgba(245,158,11,0.2)' }};">
          <span class="material-symbols-rounded" style="font-size: 14px; font-variation-settings: 'FILL' 1; position: relative; top: -0.5px;">{{ $perfil->IsAdmin ? 'shield' : 'badge' }}</span>
          <span style="position: relative; top: 0.5px;">{{ ucfirst($perfil->Role) }} ({{ $perfil->Username }})</span>
        </span>
      </div>
    </div>
  </div>

  <!-- Tabs Nav -->
  <div class="flex items-center overflow-x-auto hide-scrollbar" style="background-color: rgba(15,23,42,0.5); padding: 0.5rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.05); gap: 0.5rem;">
    <button onclick="switchTab('perfil')" id="tab-btn-perfil" class="flex items-center text-sm font-semibold transition-all whitespace-nowrap text-slate-950 shadow-md" style="background-color: #c79c5e; padding: 0.5rem 1rem; border-radius: 0.75rem; gap: 0.5rem;">
      <span class="material-symbols-rounded" style="font-size: 18px;">person</span>
      Mi Perfil
    </button>
    @if($perfil->IsAdmin)
    <button onclick="switchTab('ajustes')" id="tab-btn-ajustes" class="flex items-center text-sm font-semibold transition-all whitespace-nowrap text-slate-400 hover:text-white hover:bg-white/5" style="padding: 0.5rem 1rem; border-radius: 0.75rem; gap: 0.5rem;">
      <span class="material-symbols-rounded" style="font-size: 18px;">store</span>
      Ajustes de Negocio
    </button>
    <button onclick="switchTab('impuestos')" id="tab-btn-impuestos" class="flex items-center text-sm font-semibold transition-all whitespace-nowrap text-slate-400 hover:text-white hover:bg-white/5" style="padding: 0.5rem 1rem; border-radius: 0.75rem; gap: 0.5rem;">
      <span class="material-symbols-rounded" style="font-size: 18px;">receipt_long</span>
      Impuestos
    </button>
    @endif
  </div>

  <!-- TAB: PERFIL -->
  <div id="tab-perfil" class="grid grid-cols-1 md:grid-cols-2 animate-page-content" style="gap: 1.5rem;">
    <!-- Session Info -->
    <div class="glass-panel flex flex-col" style="padding: 1.75rem; border-radius: 1.5rem; gap: 1.25rem;">
      <h3 class="text-sm font-bold text-white flex items-center gap-2 border-b border-white/10" style="padding-bottom: 0.85rem;">
        <span class="material-symbols-rounded text-amber-500" style="font-size: 18px;">cookie</span>
        Sesión Activa
      </h3>
      <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center text-sm">
          <span class="text-slate-400 font-medium">Identificador</span>
          <span class="text-white font-mono text-xs">{{ $perfil->SessionId }}</span>
        </div>
        <div class="flex justify-between items-center text-sm">
          <span class="text-slate-400 font-medium">Esquema</span>
          <span class="text-white font-semibold">Cookie Auth</span>
        </div>
        <div class="flex justify-between items-center text-sm">
          <span class="text-slate-400 font-medium">Proveedor</span>
          <span class="text-white font-semibold">Laravel Sanctum</span>
        </div>
      </div>
    </div>

    <!-- Security -->
    <div class="glass-panel flex flex-col" style="padding: 1.75rem; border-radius: 1.5rem; gap: 1.25rem;">
      <h3 class="text-sm font-bold text-white flex items-center gap-2 border-b border-white/10" style="padding-bottom: 0.85rem;">
        <span class="material-symbols-rounded text-emerald-500" style="font-size: 18px;">security</span>
        Seguridad
      </h3>
      <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center text-sm">
          <span class="text-slate-400 font-medium">Anti-Caché</span>
          <span class="text-white font-semibold">Habilitado</span>
        </div>
        <div class="flex justify-between items-center text-sm">
          <span class="text-slate-400 font-medium">Inventario</span>
          <span class="text-white font-semibold">Solo Admin</span>
        </div>
        <div class="flex justify-between items-center text-sm">
          <span class="text-slate-400 font-medium">Conexión DB</span>
          <span class="text-emerald-400 font-semibold flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Activo
          </span>
        </div>
      </div>
    </div>

    @if($perfil->IsAdmin)
    <!-- Edit Profile -->
    <div class="glass-panel md:col-span-2 flex flex-col" style="padding: 1.75rem; border-radius: 1.5rem; gap: 1.5rem;">
      <h3 class="text-sm font-bold text-white flex items-center gap-2 border-b border-white/10" style="padding-bottom: 0.85rem;">
        <span class="material-symbols-rounded text-amber-500" style="font-size: 18px;">manage_accounts</span>
        Editar Perfil
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="flex flex-col gap-5">
          <div class="flex flex-col gap-2">
            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nombre Completo</label>
            <input type="text" value="{{ $perfil->Name }}" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
          </div>
          <div class="flex flex-col gap-2">
            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Foto de Perfil</label>
            <button class="flex items-center justify-center gap-2 w-full text-slate-300 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg transition-colors font-bold text-sm" style="padding: 0.75rem 1rem;" onclick="toast('Carga de imagen Próximamente')">
              <span class="material-symbols-rounded" style="font-size: 18px;">cloud_upload</span> Examinar Foto
            </button>
          </div>
        </div>
        <div class="flex flex-col gap-5">
          <div class="flex flex-col gap-2">
            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nueva Contraseña</label>
            <input type="password" placeholder="Dejar en blanco para no cambiar" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
          </div>
          <div class="flex flex-col gap-2">
            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Confirmar Contraseña</label>
            <input type="password" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
          </div>
        </div>
      </div>
      <div class="border-t border-white/10 flex justify-end" style="margin-top: 1.5rem; padding-top: 1.5rem;">
        <button class="font-bold text-slate-950 transition-all rounded-xl flex items-center justify-center hover:brightness-110" style="background-color: #c79c5e; padding: 0.75rem 2rem; box-shadow: 0 4px 15px rgba(199,156,94,0.2);" onclick="toast('Perfil actualizado')">
          Guardar Cambios
        </button>
      </div>
    </div>
    @else
    <div class="md:col-span-2 flex items-center gap-4" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2); border-radius: 1rem; padding: 1.5rem;">
      <span class="material-symbols-rounded text-amber-500 text-3xl">warning</span>
      <div>
        <h4 class="font-bold text-amber-500">Modo Cajero</h4>
        <p class="text-sm text-amber-500/80 mt-1">Las opciones de edición de perfil están reservadas para administradores.</p>
      </div>
    </div>
    @endif
  </div>

  <!-- TAB: AJUSTES NEGOCIO -->
  <div id="tab-ajustes" class="hidden animate-page-content">
    @if($perfil->IsAdmin)
    <div class="glass-panel flex flex-col" style="padding: 1.75rem; border-radius: 1.5rem; max-width: 800px; margin: 0 auto; width: 100%; gap: 1.5rem;">
      <h3 class="text-sm font-bold text-white flex items-center gap-2 border-b border-white/10" style="padding-bottom: 0.85rem;">
        <span class="material-symbols-rounded text-amber-500" style="font-size: 18px;">store</span>
        Ajustes Generales del Restaurante
      </h3>
      <div class="flex flex-col gap-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div class="flex flex-col gap-2">
            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nombre Comercial</label>
            <input type="text" value="{{ $ajustes->RestaurantName }}" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
          </div>
          <div class="flex flex-col gap-2">
            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Teléfono de Soporte</label>
            <input type="text" value="{{ $ajustes->RestaurantPhone }}" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
          </div>
        </div>
        <div class="flex flex-col gap-2">
          <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Email de Contacto</label>
          <input type="email" value="{{ $ajustes->RestaurantEmail }}" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
        </div>
        <div class="flex flex-col gap-2">
          <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dirección Matriz</label>
          <input type="text" value="{{ $ajustes->RestaurantAddress }}" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div class="flex flex-col gap-2">
            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Moneda Base</label>
            <select class="w-full text-white outline-none transition-all appearance-none" style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
              <option class="text-slate-900" selected>Peso Mexicano (MXN)</option>
              <option class="text-slate-900">Dólar Americano (USD)</option>
            </select>
          </div>
          <div class="flex flex-col gap-2">
            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Porcentaje de IVA (%)</label>
            <input type="number" value="{{ $ajustes->DefaultTaxRate }}" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
          </div>
        </div>
        <div class="border-t border-white/10 flex justify-end" style="margin-top: 1.5rem; padding-top: 1.5rem;">
          <button class="font-bold text-slate-950 transition-all rounded-xl flex items-center justify-center hover:brightness-110" style="background-color: #c79c5e; padding: 0.75rem 2rem; box-shadow: 0 4px 15px rgba(199,156,94,0.2);" onclick="toast('Ajustes guardados')">
            Guardar Ajustes
          </button>
        </div>
      </div>
    </div>
    @else
    <div class="flex flex-col items-center justify-center text-center" style="min-height: 40vh; gap: 1rem;">
      <span class="material-symbols-rounded text-red-500" style="font-size: 3.5rem; font-variation-settings: 'FILL' 1;">lock</span>
      <h2 class="text-xl font-bold text-white">Acceso Restringido</h2>
      <p class="text-sm text-slate-400">Solo administradores pueden gestionar ajustes del restaurante.</p>
    </div>
    @endif
  </div>

  <!-- TAB: IMPUESTOS -->
  <div id="tab-impuestos" class="hidden animate-page-content">
    @if($perfil->IsAdmin)
    <div class="glass-panel overflow-hidden" style="border-radius: 1.5rem;">
      <div class="flex items-center justify-between" style="padding: 1.75rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
        <h2 class="text-lg font-bold text-white flex items-center gap-2">
          <span class="material-symbols-rounded text-rose-500">receipt_long</span>
          Impuestos y Tasas
        </h2>
        <button class="inline-flex items-center text-slate-950 font-bold rounded-lg hover:brightness-110 transition-transform hover:-translate-y-px" style="background-color: #c79c5e; gap: 0.5rem; padding: 0.6rem 1.25rem;" onclick="toast('Función Próximamente')">
          <span class="material-symbols-rounded" style="font-size: 20px;">add</span>
          Nuevo Impuesto
        </button>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1.25rem 1.75rem;">Impuesto</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1.25rem 1.75rem;">Tipo</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1.25rem 1.75rem;">Porcentaje</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1.25rem 1.75rem;">Precio Incluido</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1.25rem 1.75rem;">Estado</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5 text-sm">
            @foreach($impuestos as $tax)
            <tr class="hover:bg-white/5 transition-colors">
              <td class="font-bold text-white" style="padding: 1.25rem 1.75rem;">{{ $tax->Nombre }}</td>
              <td style="padding: 1.25rem 1.75rem;">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/5 text-slate-300">
                  {{ $tax->Tipo }}
                </span>
              </td>
              <td class="font-bold text-amber-500" style="padding: 1.25rem 1.75rem;">{{ number_format($tax->Porcentaje, 1) }}%</td>
              <td style="padding: 1.25rem 1.75rem;">
                @if($tax->IncluidoEnPrecio)
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-500">Sí</span>
                @else
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/5 text-slate-400">Adicional</span>
                @endif
              </td>
              <td style="padding: 1.25rem 1.75rem;">
                @if($tax->Activo)
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-500">Activo</span>
                @else
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/5 text-slate-400">Inactivo</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @else
    <div class="flex flex-col items-center justify-center text-center" style="min-height: 40vh; gap: 1rem;">
      <span class="material-symbols-rounded text-red-500" style="font-size: 3.5rem; font-variation-settings: 'FILL' 1;">lock</span>
      <h2 class="text-xl font-bold text-white">Acceso Restringido</h2>
      <p class="text-sm text-slate-400">Solo administradores pueden gestionar impuestos.</p>
    </div>
    @endif
  </div>
</div>

@push('scripts')
<script>
  function switchTab(tabName) {
    // Esconder todo
    document.getElementById('tab-perfil').classList.add('hidden');
    document.getElementById('tab-ajustes').classList.add('hidden');
    document.getElementById('tab-impuestos').classList.add('hidden');
    
    // Restablecer estilos de botones
    ['perfil', 'ajustes', 'impuestos'].forEach(name => {
      const btn = document.getElementById('tab-btn-' + name);
      btn.style.backgroundColor = 'transparent';
      btn.className = 'flex items-center text-sm font-semibold transition-all whitespace-nowrap text-slate-400 hover:text-white hover:bg-white/5';
      btn.style.padding = '0.5rem 1rem';
      btn.style.borderRadius = '0.75rem';
      btn.style.gap = '0.5rem';
    });

    // Mostrar panel activo
    document.getElementById('tab-' + tabName).classList.remove('hidden');

    // Estilo activo al botón
    const activeBtn = document.getElementById('tab-btn-' + tabName);
    activeBtn.style.backgroundColor = '#c79c5e';
    activeBtn.className = 'flex items-center text-sm font-semibold transition-all whitespace-nowrap text-slate-950 shadow-md';
  }
</script>
@endpush
@endsection
