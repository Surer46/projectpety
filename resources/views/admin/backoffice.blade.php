@extends('layouts.app')

@section('title', 'Cafeteria PETY | Backoffice')

@section('content')
<div class="flex flex-col" style="padding: 1.5rem; gap: 1.5rem;">
  <div class="flex items-center justify-between flex-wrap" style="gap: 1rem;">
    <div>
      <div class="text-2xl font-bold tracking-tight text-white flex items-center gap-2">
        <span class="material-symbols-rounded" style="color: #c79c5e;">admin_panel_settings</span>
        Backoffice
      </div>
      <div class="text-sm text-slate-400 mt-1">Administración del sistema — panel de control</div>
    </div>
  </div>

  <!-- Stats -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4" style="gap: 1.5rem;">
    <div class="rounded-2xl border transition-all shadow-lg flex items-center" style="background-color: #1e2638; border-color: rgba(255,255,255,0.05); padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-xl bg-blue-500/15 text-blue-400 flex items-center justify-center shrink-0">
        <span class="material-symbols-rounded">group</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white">{{ count($users) }}</div>
        <div class="text-xs text-slate-400">Usuarios activos</div>
      </div>
    </div>

    <div class="rounded-2xl border transition-all shadow-lg flex items-center" style="background-color: #1e2638; border-color: rgba(255,255,255,0.05); padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-xl bg-purple-500/15 text-purple-400 flex items-center justify-center shrink-0">
        <span class="material-symbols-rounded">shield_person</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white">{{ count($roles) }}</div>
        <div class="text-xs text-slate-400">Roles definidos</div>
      </div>
    </div>

    <div class="rounded-2xl border transition-all shadow-lg flex items-center" style="background-color: #1e2638; border-color: rgba(255,255,255,0.05); padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-xl bg-amber-500/15 text-amber-400 flex items-center justify-center shrink-0">
        <span class="material-symbols-rounded">location_on</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white">{{ count($areas ?? []) }}</div>
        <div class="text-xs text-slate-400">Zonas Físicas</div>
      </div>
    </div>

    <div class="rounded-2xl border transition-all shadow-lg flex items-center" style="background-color: #1e2638; border-color: rgba(255,255,255,0.05); padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center shrink-0">
        <span class="material-symbols-rounded">table_restaurant</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white">{{ count($tables ?? []) }}</div>
        <div class="text-xs text-slate-400">Mesas Registradas</div>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="w-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-4 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-lg">
      <span class="material-symbols-rounded text-xl">check_circle</span>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div class="w-full bg-rose-500/10 border border-rose-500/30 text-rose-400 p-4 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-lg">
      <span class="material-symbols-rounded text-xl">error</span>
      <span>{{ session('error') }}</span>
    </div>
  @endif

  <!-- Tabs -->
  <div class="flex border-b-2 border-white/10 overflow-x-auto shrink-0 mt-4" style="gap: 0.5rem;">
    <a href="?tab=usuarios" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'usuarios' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'usuarios' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">group</span>
      Usuarios
    </a>
    <a href="?tab=roles" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'roles' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'roles' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">shield_person</span>
      Roles y Permisos
    </a>
    <a href="?tab=sucursales" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'sucursales' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'sucursales' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">store</span>
      Sucursales
    </a>
    <a href="?tab=areas" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'areas' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'areas' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">location_on</span>
      Zonas / Áreas Físicas
    </a>
    <a href="?tab=pedidos" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'pedidos' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'pedidos' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">local_shipping</span>
      Preparación & Logística (Pedidos)
    </a>
  </div>

  @if($tab == 'usuarios')
  <!-- =========== TAB: USUARIOS =========== -->
  <div class="flex flex-col" style="gap: 1rem;">
    <div class="flex items-center justify-between">
      <span class="font-semibold text-sm text-white">{{ count($users) }} usuarios registrados</span>
      <button class="inline-flex items-center text-slate-950 font-bold rounded-lg hover:brightness-110 transition-transform hover:-translate-y-px" style="background-color: #c79c5e; gap: 0.5rem; padding: 0.5rem 1.25rem;" onclick="abrirModalUsuario()">
        <span class="material-symbols-rounded text-[18px]">person_add</span>Nuevo Usuario
      </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 mt-2" style="gap: 1.5rem;">
      @foreach ($users as $user)
        @php
          $esDueno = $user->role_name === 'dueño';
          $disabledClass = $esDueno ? 'opacity-50 pointer-events-none cursor-not-allowed' : '';
          $inicial = strtoupper(substr($user->name, 0, 1));
          $bgBadge = $user->is_active ? 'bg-emerald-500/20 text-emerald-400' : 'bg-slate-500/20 text-slate-400';
          $textStatus = $user->is_active ? 'Activo' : 'Inactivo';
        @endphp
        
        <div class="rounded-2xl text-white flex flex-col shadow-lg hover:shadow-2xl hover:-translate-y-1 transition-all border" style="background-color: {{ $esDueno ? 'rgba(199,156,94,0.1)' : '#1e2638' }}; padding: 1.5rem; gap: 1rem; border-color: {{ $esDueno ? 'rgba(199,156,94,0.4)' : 'rgba(255,255,255,0.05)' }};">
          <div class="flex items-center" style="gap: 0.75rem;">
            <div class="rounded-full flex items-center justify-center font-bold text-lg text-slate-950 shadow-md shrink-0" style="background-color: #c79c5e; width: 3rem; height: 3rem;">
              {{ $inicial }}
            </div>
            <div class="flex-1 min-w-0">
              <div class="font-bold text-[0.95rem] flex items-center" style="gap: 0.25rem;">
                {{ $user->name }}
                @if($esDueno)
                  <span class="material-symbols-rounded text-[18px]" style="color: #c79c5e;" title="Propietario supremo del sistema">crown</span>
                @endif
              </div>
              <div class="text-sm text-slate-400">{{ '@' . $user->username }}</div>
            </div>
            <span class="rounded-full text-[0.7rem] font-bold {{ $bgBadge }}" style="padding: 0.25rem 0.6rem;">
              {{ $textStatus }}
            </span>
          </div>

          <div class="text-sm text-slate-300 flex items-center mt-1" style="gap: 0.5rem;">
            <span class="material-symbols-rounded text-[16px] text-white/70">mail</span>
            <span>{{ $user->email }}</span>
          </div>

          <div class="flex items-center justify-between border-t border-white/5" style="margin-top: 0.75rem; padding-top: 0.75rem;">
            <div>
              <span class="rounded-lg text-[0.75rem] font-semibold bg-white/5 border border-white/10 text-slate-300" style="padding: 0.35rem 0.65rem;">
                {{ ucfirst($user->role_name ?? 'Sin Rol') }}
              </span>
            </div>
            <div class="flex" style="gap: 0.5rem;">
              <button class="rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 hover:text-white transition-colors text-slate-400" 
                      style="width: 2.25rem; height: 2.25rem;"
                      title="Editar usuario"
                      onclick="abrirModalUsuario({{ $user->id }}, '{{ $user->name }}', '{{ $user->username }}', '{{ $user->email }}', '{{ $user->role_name }}', {{ $esDueno ? 'true' : 'false' }})">
                <span class="material-symbols-rounded text-[16px]">edit</span>
              </button>
              <button class="rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 hover:text-white transition-colors text-slate-400 {{ $disabledClass }}" 
                      style="width: 2.25rem; height: 2.25rem;"
                      title="Suspender">
                <span class="material-symbols-rounded text-[16px]">block</span>
              </button>
              <button class="rounded-lg border flex items-center justify-center transition-colors {{ $disabledClass }}" 
                      style="width: 2.25rem; height: 2.25rem; background-color: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2); color: #ef4444;"
                      onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.2)'; this.style.color='#fca5a5';"
                      onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.1)'; this.style.color='#ef4444';"
                      title="Eliminar">
                <span class="material-symbols-rounded text-[16px]">delete</span>
              </button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  @endif

  @if($tab == 'promociones')
  <!-- =========== TAB: PROMOCIONES, DESCUENTOS & COMIDAS DEL DÍA =========== -->
  <div class="flex flex-col gap-10">

    <!-- SECCIÓN 1: COMIDAS DEL DÍA & MENÚ EJECUTIVO -->
    <div class="flex flex-col gap-4 bg-[#1e2638] border border-white/5 rounded-3xl p-6 shadow-xl">
      <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-white/10 pb-4">
        <div>
          <h2 class="text-xl font-bold text-white flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
            <span class="material-symbols-rounded text-xl" style="color: #c79c5e;">restaurant</span>
            Comidas del Día & Menú Ejecutivo
          </h2>
          <p class="text-xs text-slate-400 mt-1">Configura los platillos especiales visibles en la sección dedicada del POS.</p>
        </div>
        <button class="inline-flex items-center text-slate-950 font-bold rounded-xl hover:brightness-110 transition-all text-xs" style="background-color: #c79c5e; gap: 0.5rem; padding: 0.65rem 1.25rem;" onclick="document.getElementById('modal-comida-dia').classList.remove('hidden')">
          <span class="material-symbols-rounded text-[18px]">add_circle</span>Nuevo Platillo del Día
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mt-2">
        @forelse ($dailyMeals ?? [] as $meal)
          <div class="rounded-2xl text-white flex flex-col shadow-lg border relative overflow-hidden bg-[#101725] p-5 gap-3 border-white/10">
            <div class="flex items-start justify-between">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-2xl">
                  {{ $meal->emoji ?? '🍽️' }}
                </div>
                <div>
                  <h3 class="font-bold text-base text-white leading-tight">{{ $meal->name }}</h3>
                  <span class="font-extrabold text-sm text-[#c79c5e]">${{ number_format($meal->base_price, 2) }}</span>
                </div>
              </div>
              <button onclick="toggleDailyMeal({{ $meal->id }}, this)" class="px-3 py-1 rounded-full text-xs font-bold transition-all {{ $meal->is_active ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-slate-700 text-slate-400 border border-slate-600' }}">
                {{ $meal->is_active ? 'Activo' : 'Inactivo' }}
              </button>
            </div>

            <p class="text-xs text-slate-400 leading-relaxed">{{ $meal->description ?? 'Sin descripción' }}</p>

            <div class="mt-auto border-t border-white/5 pt-3 flex items-center justify-between text-xs text-slate-400">
              <span>Stock: <strong class="text-white">{{ $meal->stock ?? 99 }} uds</strong></span>
              <span class="text-emerald-400 font-bold">Menú Ejecutivo</span>
            </div>
          </div>
        @empty
          <div class="col-span-full py-8 flex flex-col items-center justify-center text-slate-500">
            <span class="material-symbols-rounded text-4xl mb-2 opacity-40">restaurant</span>
            <p class="text-sm">No hay platillos del día configurados.</p>
          </div>
        @endforelse
      </div>
    </div>

    <!-- SECCIÓN 2: PROMOCIONES & DESCUENTOS -->
    <div class="flex flex-col gap-4 bg-[#1e2638] border border-white/5 rounded-3xl p-6 shadow-xl">
      <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-white/10 pb-4">
        <div>
          <h2 class="text-xl font-bold text-white flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
            <span class="material-symbols-rounded text-xl" style="color: #c79c5e;">loyalty</span>
            Promociones & Descuentos Configurables
          </h2>
          <p class="text-xs text-slate-400 mt-1">Aplica descuentos automáticos a productos, categorías o a todo el catálogo.</p>
        </div>
        <button class="inline-flex items-center text-slate-950 font-bold rounded-xl hover:brightness-110 transition-all text-xs" style="background-color: #c79c5e; gap: 0.5rem; padding: 0.65rem 1.25rem;" onclick="document.getElementById('modal-promocion').classList.remove('hidden')">
          <span class="material-symbols-rounded text-[18px]">add_circle</span>Nueva Promoción
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mt-2">
        @forelse ($promotions ?? [] as $promo)
          @php
            $badge = $promo->discount_type === 'percentage' ? intval($promo->discount_value) . '% OFF' : '-$' . number_format($promo->discount_value, 0) . ' OFF';
            $appliesText = 'Todo el catálogo';
            if ($promo->applies_to === 'product') {
                $pName = DB::table('products')->where('id', $promo->target_id)->value('name');
                $appliesText = 'Producto: ' . ($pName ?? '#' . $promo->target_id);
            } elseif ($promo->applies_to === 'category') {
                $cName = DB::table('categories')->where('id', $promo->target_id)->value('name');
                $appliesText = 'Categoría: ' . ($cName ?? '#' . $promo->target_id);
            }
          @endphp
          
          <div class="rounded-2xl text-white flex flex-col shadow-lg border relative overflow-hidden bg-[#101725] p-5 gap-3 border-white/10">
            <div class="flex items-start justify-between">
              <div>
                <span class="inline-block font-bold text-slate-950 text-xs px-2.5 py-0.5 rounded-full mb-2" style="background-color: #c79c5e;">
                  {{ $badge }}
                </span>
                <h3 class="font-bold text-base text-white leading-tight">{{ $promo->name }}</h3>
              </div>
              <button onclick="togglePromo({{ $promo->id }}, this)" class="px-3 py-1 rounded-full text-xs font-bold transition-all {{ $promo->is_active ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-slate-700 text-slate-400 border border-slate-600' }}">
                {{ $promo->is_active ? 'Activa' : 'Inactiva' }}
              </button>
            </div>

            <p class="text-xs text-slate-400 leading-relaxed">{{ $promo->description ?? 'Sin descripción' }}</p>

            <div class="mt-auto border-t border-white/5 pt-3 flex items-center justify-between text-xs text-slate-300">
              <span class="flex items-center gap-1"><span class="material-symbols-rounded text-sm" style="color: #c79c5e;">label</span> {{ $appliesText }}</span>
            </div>
          </div>
        @empty
          <div class="col-span-full py-8 flex flex-col items-center justify-center text-slate-500">
            <span class="material-symbols-rounded text-4xl mb-2 opacity-40">loyalty</span>
            <p class="text-sm">No hay promociones registradas actualmente.</p>
          </div>
        @endforelse
      </div>
    </div>

  </div>  </div>

  <!-- Modal Crear Promoción -->
  <div id="modal-promocion" class="hidden fixed inset-0 z-[9999] flex items-center justify-center" style="background-color: rgba(0,0,0,0.8); backdrop-filter: blur(8px);">
    <div class="bg-[#0f172a] border border-white/10 rounded-3xl w-full max-w-lg p-6 flex flex-col gap-4 shadow-2xl">
      <div class="flex items-center justify-between border-b border-white/10 pb-4">
        <h3 class="text-xl font-bold text-white flex items-center gap-2">
          <span class="material-symbols-rounded" style="color: #c79c5e;">loyalty</span>
          Crear Nueva Promoción
        </h3>
        <button onclick="document.getElementById('modal-promocion').classList.add('hidden')" class="text-slate-400 hover:text-white">
          <span class="material-symbols-rounded">close</span>
        </button>
      </div>

      <form action="{{ route('backoffice.promotions.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre de la Promoción</label>
          <input type="text" name="name" required placeholder="Ej. Descuento de Verano 20%" class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white text-sm outline-none focus:border-[#c79c5e]"/>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Tipo de Descuento</label>
            <select name="discount_type" required class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white text-sm outline-none focus:border-[#c79c5e]">
              <option value="percentage">Porcentaje (%)</option>
              <option value="fixed_amount">Monto Fijo ($ MXN)</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Valor del Descuento</label>
            <input type="number" name="discount_value" step="0.01" min="0.01" required placeholder="Ej. 20 o 15.00" class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white text-sm outline-none focus:border-[#c79c5e]"/>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Aplicable a</label>
          <select name="applies_to" id="promo_applies_to" onchange="togglePromoTargetInputs()" class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white text-sm outline-none focus:border-[#c79c5e]">
            <option value="all">Todo el Catálogo</option>
            <option value="category">Categoría Específica</option>
            <option value="product">Producto Específico</option>
          </select>
        </div>

        <div id="promo_category_wrapper" class="hidden">
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Seleccionar Categoría</label>
          <select name="category_id" class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white text-sm outline-none focus:border-[#c79c5e]">
            @foreach($categories ?? [] as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>

        <div id="promo_product_wrapper" class="hidden">
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Seleccionar Producto</label>
          <select name="product_id" class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white text-sm outline-none focus:border-[#c79c5e]">
            @foreach($products ?? [] as $prod)
              <option value="{{ $prod->id }}">{{ $prod->name }} (${{ number_format($prod->base_price, 2) }})</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Descripción</label>
          <textarea name="description" rows="2" placeholder="Detalles visibles para el personal o clientes" class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white text-sm outline-none focus:border-[#c79c5e]"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2 border-t border-white/10">
          <button type="button" onclick="document.getElementById('modal-promocion').classList.add('hidden')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5 text-sm font-bold">Cancelar</button>
          <button type="submit" class="px-5 py-2 rounded-xl text-slate-950 font-bold text-sm shadow-lg" style="background-color: #c79c5e;">Guardar Promoción</button>
        </div>
      </form>
    </div>
  </div>

  <script>
  function togglePromoTargetInputs() {
      const val = document.getElementById('promo_applies_to').value;
      const catWrap = document.getElementById('promo_category_wrapper');
      const prodWrap = document.getElementById('promo_product_wrapper');
      
      catWrap.classList.add('hidden');
      prodWrap.classList.add('hidden');
      
      if (val === 'category') catWrap.classList.remove('hidden');
      if (val === 'product') prodWrap.classList.remove('hidden');
  }

  function togglePromo(id, btn) {
      fetch(`/backoffice/promotions/${id}/toggle`, {
          method: 'POST',
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
      })
      .then(res => res.json())
      .then(data => {
          if (data.success) {
              if (data.is_active) {
                  btn.className = 'px-3 py-1 rounded-full text-xs font-bold transition-all bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
                  btn.textContent = 'Activa';
              } else {
                  btn.className = 'px-3 py-1 rounded-full text-xs font-bold transition-all bg-slate-700 text-slate-400 border border-slate-600';
                  btn.textContent = 'Inactiva';
              }
              if (typeof toast === 'function') toast('Estado de promoción actualizado', 'info');
          }
      });
  }
  </script>
  @endif

  @if($tab == 'roles')
  <!-- =========== TAB: ROLES =========== -->
  <div class="flex flex-col" style="gap: 1rem;">
    <div class="flex items-center justify-between">
      <span class="font-semibold text-sm text-white">{{ count($roles) }} roles definidos en el sistema</span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-2" style="gap: 1.5rem;">
      @foreach ($roles as $role)
        <div class="rounded-2xl text-white flex flex-col shadow-lg hover:shadow-2xl hover:-translate-y-1 transition-all border" style="background-color: #1e2638; padding: 1.5rem; gap: 0.75rem; border-color: rgba(255,255,255,0.05);">
          <div class="font-bold text-lg text-white capitalize">{{ $role->name }}</div>
          <div class="text-sm text-slate-400">{{ $role->description ?? 'Sin descripción' }}</div>
        </div>
      @endforeach
    </div>
  </div>
  </div>
  @endif

  @if($tab == 'sucursales')
  <!-- =========== TAB: SUCURSALES =========== -->
  <div class="flex flex-col" style="gap: 1rem;">
    <div class="flex items-center justify-between">
      <span class="font-semibold text-sm text-white">{{ count($branches ?? []) }} sucursales registradas</span>
      <button class="text-slate-950 font-bold rounded-xl transition-all flex items-center shadow-lg" style="background-color: #c79c5e; padding: 0.5rem 1rem; gap: 0.5rem; font-size: 0.875rem;" onclick="abrirModalSucursal()">
        <span class="material-symbols-rounded text-[18px]">add_business</span>Nueva Sucursal
      </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-6 w-full" style="gap: 1.5rem;">
      @foreach ($branches ?? [] as $branch)
        <div class="rounded-2xl text-white flex flex-col justify-between relative shadow-xl transition-all border" style="background-color: #1e2638; border-color: rgba(255,255,255,0.05); padding: 1.5rem;" onmouseover="this.style.borderColor='#c79c5e'" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)'">
          
          <span class="absolute top-4 right-4 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-xs px-2.5 py-1 rounded-full font-medium">
            {{ $branch->is_active ? 'Activa' : 'Inactiva' }}
          </span>

          <div class="flex items-start mb-4 pr-20" style="gap: 0.75rem;">
            <span class="material-symbols-rounded text-[28px]" style="color: #c79c5e;">store</span>
            <div class="flex-1 min-w-0">
              <div class="text-lg font-bold text-white leading-tight truncate">{{ $branch->name }}</div>
              <div class="text-sm text-slate-400 truncate">{{ $branch->legal_name }}</div>
            </div>
          </div>

          <div class="flex flex-col gap-2 mt-2">
            @if(!empty($branch->address) || !empty($branch->city))
              <div class="text-[0.85rem] text-slate-300 flex items-start gap-2">
                <span class="material-symbols-rounded text-[16px] text-white/70 mt-0.5 shrink-0">location_on</span>
                <span class="leading-snug">{{ $branch->address }}{{ (!empty($branch->address) && !empty($branch->city)) ? ', ' : '' }}{{ $branch->city }}</span>
              </div>
            @else
              <div class="text-[0.85rem] text-slate-400 italic">
                Dirección no registrada
              </div>
            @endif

            @if(!empty($branch->phone))
              <div class="text-[0.85rem] text-slate-300 flex items-center gap-2">
                <span class="material-symbols-rounded text-[16px] text-white/70">phone</span>
                {{ $branch->phone }}
              </div>
            @endif

            <div class="text-[0.85rem] text-slate-300 flex items-center gap-2">
              <span class="material-symbols-rounded text-[16px] text-white/70">payments</span>
              Moneda: <strong class="text-white">{{ $branch->currency_code }}</strong>
            </div>
            <div class="text-[0.85rem] text-slate-300 flex items-center gap-2">
              <span class="material-symbols-rounded text-[16px] text-white/70">public</span>
              Zona: <span class="font-mono text-[0.75rem]">{{ $branch->timezone }}</span>
            </div>
          </div>

          <div class="mt-6 pt-4 border-t border-white/5 flex items-center justify-between">
            <button class="flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white text-xs px-3 py-2 rounded-xl border border-white/5 transition-all" 
                    onclick="abrirModalSucursal({{ $branch->id }}, '{{ addslashes($branch->name) }}', '{{ addslashes($branch->legal_name) }}', '{{ $branch->phone }}', '{{ $branch->email }}', '{{ addslashes($branch->address) }}', '{{ addslashes($branch->city) }}', '{{ $branch->currency_code }}', '{{ $branch->timezone }}', {{ $branch->is_active ? 'true' : 'false' }})">
              <span class="material-symbols-rounded text-[16px]">edit</span> Editar
            </button>
            <button class="bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white p-2 rounded-xl border border-rose-500/20 transition-all flex items-center justify-center" 
                    title="Eliminar">
              <span class="material-symbols-rounded text-[18px]">delete</span>
            </button>
          </div>
        </div>
      @endforeach
  </div>
  @elseif($tab == 'areas')
  <!-- =========== TAB: ZONAS / ÁREAS FÍSICAS =========== -->
  <div class="flex flex-col gap-6 rounded-[2.5rem] border shadow-2xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 2rem;">

    <!-- Encabezado y Botones de Acción -->
    <div class="flex items-center justify-between flex-wrap border-b pb-5" style="border-color: rgba(255,255,255,0.08); gap: 1rem;">
      <div>
        <h2 class="font-bold text-xl text-white flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
          <span class="material-symbols-rounded" style="color: #c79c5e;">location_on</span>
          Gestión de Zonas y Espacios Físicos
        </h2>
        <p class="text-xs text-slate-400" style="margin-top: 0.25rem;">Agrega nuevas áreas por expansión asignadas a sucursales específicas o desactiva zonas por remodelación.</p>
      </div>

      <div class="flex items-center gap-3">
        <button onclick="abrirModalMesa()" 
                class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" 
                style="background-color: rgba(255,255,255,0.08); color: #ffffff; padding: 0.65rem 1.25rem; border-radius: 0.85rem; border: 1px solid rgba(255,255,255,0.12);">
          <span class="material-symbols-rounded text-base">add_circle</span>
          <span>Agregar Mesa</span>
        </button>

        <button onclick="abrirModalArea()" 
                class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" 
                style="background-color: #c79c5e; color: #0a0f18; padding: 0.65rem 1.25rem; border-radius: 0.85rem; border: none;">
          <span class="material-symbols-rounded text-base">domain_add</span>
          <span>Nueva Zona / Área</span>
        </button>
      </div>
    </div>

    <!-- Filtro por Sucursal para Áreas y Mesas (Estilizado y Espacioso) -->
    <div class="flex items-center justify-between flex-wrap gap-3" style="margin-bottom: 1.25rem; background: rgba(15, 23, 42, 0.4); padding: 0.75rem 1.25rem; border-radius: 1.25rem; border: 1px solid rgba(255,255,255,0.06);">
      <div class="flex items-center gap-2 shrink-0">
        <span class="material-symbols-rounded text-sm" style="color: #c79c5e;">store</span>
        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Sucursal Activa:</span>
      </div>
      <div class="flex items-center gap-2 flex-wrap">
        <button type="button" onclick="filtrarSucursal('todas', this)" class="branch-filter-btn font-bold text-xs px-4 py-2 rounded-xl transition-all cursor-pointer shadow-md" style="background-color: #c79c5e; color: #0a0f18; border: 1px solid #c79c5e;">
          Todas las Sucursales
        </button>
        @foreach($branches as $b)
          <button type="button" onclick="filtrarSucursal({{ $b->id }}, this)" class="branch-filter-btn font-semibold text-xs text-slate-400 hover:text-white px-4 py-2 rounded-xl transition-all cursor-pointer" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
            🏢 {{ $b->name }}
          </button>
        @endforeach
      </div>
    </div>

    <!-- Tabla Compacta de Áreas Registradas (Perfectamente Calibrada sin Overflow) -->
    <div class="rounded-2xl border overflow-x-auto shadow-xl" style="background-color: #101725; border-color: rgba(255,255,255,0.08);">
      <table class="w-full text-left text-xs text-slate-300 table-auto min-w-[850px]">
        <thead class="text-[0.68rem] uppercase tracking-wider text-slate-400 border-b border-white/10" style="background-color: rgba(15,23,42,0.8);">
          <tr>
            <th scope="col" style="padding: 0.65rem 0.75rem;">Zona / Área</th>
            <th scope="col" style="padding: 0.65rem 0.5rem;">Sucursal</th>
            <th scope="col" style="padding: 0.65rem 0.5rem;">Piso</th>
            <th scope="col" style="padding: 0.65rem 0.5rem;">Horario</th>
            <th scope="col" class="text-center" style="padding: 0.65rem 0.5rem;">Mesas / Cap.</th>
            <th scope="col" class="text-center" style="padding: 0.65rem 0.5rem;">Características</th>
            <th scope="col" class="text-center" style="padding: 0.65rem 0.5rem;">Estado</th>
            <th scope="col" class="text-center" style="padding: 0.65rem 0.75rem;">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-white/5 text-[0.75rem]">
          @forelse($areas ?? [] as $area)
            <tr class="area-row hover:bg-white/[0.02] transition-colors" data-branch-id="{{ $area->branch_id }}">
              <td style="padding: 0.65rem 0.75rem;" class="font-medium text-white">
                <div class="flex items-center gap-2">
                  <span class="text-lg rounded-lg flex items-center justify-center shrink-0" style="background: rgba(255,255,255,0.05); width: 2rem; height: 2rem;">{{ $area->emoji ?? '🪑' }}</span>
                  <div>
                    <div class="font-bold text-xs text-white leading-tight">{{ $area->name }}</div>
                    <div class="text-[0.6rem] text-slate-400 font-mono" style="margin-top: 0.1rem;">{{ $area->slug }}</div>
                  </div>
                </div>
              </td>
              <td style="padding: 0.65rem 0.5rem;" class="whitespace-nowrap">
                <span class="text-[0.65rem] font-bold text-amber-300 bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded-md inline-flex items-center gap-1">
                  🏢 {{ $area->branch->name ?? 'Central' }}
                </span>
              </td>
              <td style="padding: 0.65rem 0.5rem;" class="whitespace-nowrap">
                <span class="text-[0.65rem] text-slate-300 font-bold bg-slate-900 px-2 py-0.5 rounded-md border border-white/10">
                  📍 {{ $area->floor ?? 'Planta Baja' }}
                </span>
              </td>
              <td style="padding: 0.65rem 0.5rem;" class="text-[0.68rem] text-slate-300 whitespace-nowrap">
                🕒 {{ substr($area->schedule_open ?? '07:00', 0, 5) }} – {{ substr($area->schedule_close ?? '22:00', 0, 5) }}
              </td>
              <td style="padding: 0.65rem 0.5rem;" class="text-center whitespace-nowrap">
                <span class="font-bold text-white text-xs">{{ $area->tables_count }} mesas</span>
                <span class="text-[0.6rem] text-slate-400 block">{{ $area->total_capacity }} pers.</span>
              </td>
              <td style="padding: 0.65rem 0.5rem;">
                <div class="flex flex-wrap items-center justify-center gap-1">
                  @if($area->is_outdoor)
                    <span class="font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 rounded-lg inline-flex items-center gap-1 whitespace-nowrap" style="padding: 0.25rem 0.5rem; font-size: 0.6rem;">☀️ Exterior</span>
                  @endif
                  @if($area->requires_reservation)
                    <span class="font-bold text-purple-400 bg-purple-500/10 border border-purple-500/30 rounded-lg inline-flex items-center gap-1 whitespace-nowrap" style="padding: 0.25rem 0.5rem; font-size: 0.6rem;">🔒 Reserva</span>
                  @endif
                  @if($area->min_consumption > 0)
                    <span class="font-bold text-amber-400 bg-amber-500/10 border border-amber-500/30 rounded-lg inline-flex items-center gap-1 whitespace-nowrap" style="padding: 0.25rem 0.5rem; font-size: 0.6rem;">💰 Min ${{ number_format($area->min_consumption, 0) }}</span>
                  @endif
                </div>
              </td>
              <td style="padding: 0.65rem 0.5rem;" class="text-center whitespace-nowrap">
                <button onclick="toggleEstadoArea({{ $area->id }}, this)" 
                        class="rounded-full font-bold transition-all shadow cursor-pointer border inline-flex items-center justify-center whitespace-nowrap"
                        style="padding: 0.3rem 0.65rem; font-size: 0.65rem; {{ $area->is_active ? 'background-color: rgba(16, 185, 129, 0.15); border-color: rgba(16, 185, 129, 0.3); color: #34d399;' : 'background-color: rgba(148, 163, 184, 0.15); border-color: rgba(148, 163, 184, 0.3); color: #94a3b8;' }}">
                  {{ $area->is_active ? '● ACTIVA' : '○ REMODELACIÓN' }}
                </button>
              </td>
              <td style="padding: 0.65rem 0.75rem;" class="text-center whitespace-nowrap">
                <div class="flex items-center justify-center">
                  <button type="button" onclick="editarArea({{ json_encode($area) }})" class="p-1.5 rounded-xl bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-white border border-amber-500/20 transition-all cursor-pointer inline-flex items-center justify-center mr-1" title="Editar Zona">
                    <span class="material-symbols-rounded text-sm">edit</span>
                  </button>
                  <form action="{{ route('backoffice.areas.destroy', $area->id) }}" method="POST" onsubmit="return confirm('¿Eliminar la zona {{ $area->name }}?')" class="inline-flex">
                    @csrf
                    <button type="submit" class="p-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white border border-rose-500/20 transition-all cursor-pointer inline-flex items-center justify-center" title="Eliminar Zona">
                      <span class="material-symbols-rounded text-sm">delete</span>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-8 text-slate-500" style="padding: 2rem;">
                No hay zonas físicas registradas.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- SECCIÓN MESAS ASIGNADAS CON ESTILO POS (FILTROS, BUSCADOR Y PAGINACIÓN 2x2) -->
    <div class="flex flex-col gap-5" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 2rem; margin-top: 1.5rem;">
      
      <!-- Encabezado de Mesas con Buscador y Paginación Acomodada -->
      <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
          <h3 class="text-base font-bold text-white flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
            <span class="material-symbols-rounded" style="color: #c79c5e;">grid_view</span>
            Mesas Asignadas (Modo Terminal / POS)
          </h3>
          <p class="text-xs text-slate-400" style="margin-top: 0.25rem;">Busca por nombre/código, filtra por zona física y navega en vista 2x2.</p>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
          <!-- Cuadro de texto para buscar mesas por nombre o código -->
          <div class="relative flex items-center">
            <input type="text" 
                   id="buscar-mesa-input" 
                   placeholder="🔍 Buscar por mesa o código..." 
                   onkeyup="buscarMesas(this.value)"
                   class="text-xs text-white outline-none transition-all border"
                   style="background: rgba(15, 23, 42, 0.6); padding: 0.65rem 1rem 0.65rem 2.25rem; border-radius: 0.75rem; border-color: rgba(255,255,255,0.1); width: 230px;"
                   onfocus="this.style.borderColor='#c79c5e';"
                   onblur="this.style.borderColor='rgba(255,255,255,0.1)';" />
            <span class="material-symbols-rounded absolute left-2.5 text-slate-400 text-base pointer-events-none">search</span>
          </div>

          <!-- Controles de Paginación Perfectamente Alineados -->
          <div class="flex items-center border border-white/10 rounded-xl bg-slate-900" style="padding: 0.35rem 0.85rem; gap: 0.75rem;">
            <span id="paginacion-info" class="text-xs text-slate-300 font-bold whitespace-nowrap">
              Cargando...
            </span>
            <div style="width: 1px; height: 1.25rem; background-color: rgba(255,255,255,0.12);"></div>
            <div class="flex items-center gap-1.5">
              <button id="btn-prev-page" onclick="cambiarPaginaMesa(-1)" 
                      class="rounded-lg border text-white disabled:opacity-30 disabled:cursor-not-allowed hover:bg-white/10 transition-colors flex items-center justify-center cursor-pointer"
                      style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); width: 28px; height: 28px;" title="Página Anterior">
                <span class="material-symbols-rounded text-sm">chevron_left</span>
              </button>
              <button id="btn-next-page" onclick="cambiarPaginaMesa(1)" 
                      class="rounded-lg border text-white disabled:opacity-30 disabled:cursor-not-allowed hover:bg-white/10 transition-colors flex items-center justify-center cursor-pointer"
                      style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); width: 28px; height: 28px;" title="Página Siguiente">
                <span class="material-symbols-rounded text-sm">chevron_right</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Barra de Filtros por Área (Diseño de Subnavegación Plano de AGENTS.md) -->
      <div class="flex border-b-2 border-white/10 overflow-x-auto shrink-0" style="gap: 0.5rem;">
        <button onclick="filtrarMesasPorArea('todas', this)" 
                class="filter-area-btn flex items-center border-b-2 font-bold text-xs transition-colors rounded-t-lg" 
                style="padding: 0.6rem 1rem; gap: 0.4rem; color: #c79c5e; border-color: #c79c5e;">
          <span class="material-symbols-rounded text-sm">apps</span>
          <span>Todas ({{ count($tables ?? []) }})</span>
        </button>
        @foreach($areas ?? [] as $a)
          <button onclick="filtrarMesasPorArea({{ $a->id }}, this)" 
                  class="filter-area-btn flex items-center border-b-2 font-medium text-xs transition-colors text-slate-400 border-transparent hover:text-white hover:bg-white/5 rounded-t-lg" 
                  style="padding: 0.6rem 1rem; gap: 0.4rem;">
            <span>{{ $a->emoji }}</span>
            <span>{{ $a->name }} ({{ $a->tables_count }})</span>
          </button>
        @endforeach
      </div>

      <!-- Grid de Mesas en 2x2 (4 Cuadros Holgados por Página) -->
      <div id="grid-mesas-pos" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="gap: 1.25rem;">
        @forelse($tables ?? [] as $t)
          @php
            $isLibre    = $t->status === 'libre';
            $isReserva  = $t->status === 'reservada';
            $isOcupada  = $t->status === 'ocupada';

            if ($isLibre)       { $statusBg = 'rgba(16,185,129,0.15)'; $statusColor = '#34d399'; $statusTxt = 'LIBRE'; }
            elseif($isReserva)  { $statusBg = 'rgba(245,158,11,0.15)'; $statusColor = '#fbbf24'; $statusTxt = 'RESERVADA'; }
            elseif($isOcupada)  { $statusBg = 'rgba(239,68,68,0.15)'; $statusColor = '#f87171'; $statusTxt = 'OCUPADA'; }
            else                { $statusBg = 'rgba(148,163,184,0.1)'; $statusColor = '#94a3b8'; $statusTxt = 'LIMPIEZA'; }
          @endphp

          <div data-area-id="{{ $t->area_id }}" 
               data-search-text="{{ strtolower($t->table_number . ' ' . ($t->area->name ?? $t->area) . ' ' . $t->notes) }}"
               class="mesa-card-item rounded-2xl border flex items-center justify-between shadow-md transition-all hover:border-[#c79c5e] cursor-pointer" 
               style="background-color: #101725; border-color: rgba(255,255,255,0.08); padding: 1.25rem 1.5rem; gap: 1rem;"
               onclick="verDetalleMesa({{ json_encode([
                 'id' => $t->id,
                 'table_number' => $t->table_number,
                 'area_id' => $t->area_id,
                 'area_name' => $t->area->name ?? $t->area,
                 'area_emoji' => $t->area->emoji ?? '🪑',
                 'capacity' => $t->capacity,
                 'status' => $t->status,
                 'customer_name' => $t->customer_name,
                 'customer_phone' => $t->customer_phone,
                 'reservation_time' => $t->reservation_time,
                 'party_size' => $t->party_size,
                 'notes' => $t->notes,
               ]) }})">
            
            <div class="flex items-center gap-3.5 min-w-0 flex-1">
              <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 font-bold text-lg shadow-inner" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                {{ $t->area->emoji ?? '🪑' }}
              </div>
              <div class="min-w-0 flex-1">
                <div class="font-bold text-white text-sm truncate flex items-center gap-2">
                  <span>{{ $t->table_number }}</span>
                  <span class="font-bold rounded-full uppercase shrink-0 whitespace-nowrap" 
                        style="background: {{ $statusBg }}; color: {{ $statusColor }}; border: 1px solid {{ $statusColor }}40; padding: 0.3rem 0.75rem; font-size: 0.65rem; letter-spacing: 0.04em;">
                    {{ $statusTxt }}
                  </span>
                </div>
                <div class="text-[0.7rem] text-slate-400 truncate" style="margin-top: 0.35rem;">
                  {{ $t->area->name ?? $t->area }} · <strong class="text-slate-300">{{ $t->capacity }} pers.</strong>
                </div>
              </div>
            </div>

            <!-- Acciones Editar y Eliminar -->
            <div class="flex items-center gap-1 shrink-0" onclick="event.stopPropagation()">
              <button type="button" 
                      onclick="abrirModalEditarMesa({{ json_encode([
                        'id' => $t->id,
                        'table_number' => $t->table_number,
                        'area_id' => $t->area_id,
                        'capacity' => $t->capacity,
                        'status' => $t->status,
                        'notes' => $t->notes,
                      ]) }})" 
                      class="text-slate-400 hover:text-amber-400 p-1.5 rounded-lg hover:bg-amber-500/10 transition-colors cursor-pointer flex items-center justify-center" 
                      title="Editar mesa">
                <span class="material-symbols-rounded text-base">edit</span>
              </button>

              <form action="{{ route('backoffice.tables.destroy', $t->id) }}" method="POST" onsubmit="return confirm('¿Eliminar la mesa {{ $t->table_number }}?')" class="inline-block">
                @csrf
                <button type="submit" class="text-slate-500 hover:text-rose-400 p-1.5 rounded-lg hover:bg-rose-500/10 transition-colors cursor-pointer flex items-center justify-center" title="Eliminar mesa">
                  <span class="material-symbols-rounded text-base">delete</span>
                </button>
              </form>
            </div>

          </div>
        @empty
          <div class="col-span-full py-8 text-center text-slate-500 text-sm" style="padding: 2rem;">
            No hay mesas registradas en ninguna zona.
          </div>
        @endforelse
      </div>

    </div>

  </div>
  @endif

  @if($tab == 'pedidos')
  <!-- =========== TAB: GESTIÓN DE PREPARACIÓN Y ENTREGAS (AMAZON-STYLE FULFILLMENT) =========== -->
  <div class="flex flex-col gap-6 rounded-[2.5rem] border shadow-2xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 2rem;">

    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b pb-5" style="border-color: rgba(255,255,255,0.08);">
      <div>
        <h2 class="text-xl font-bold text-white flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
          <span class="material-symbols-rounded text-2xl" style="color: #c79c5e;">local_shipping</span>
          <span>Gestor de Preparación y Logística de Pedidos (Estilo Amazon)</span>
        </h2>
        <p class="text-xs text-slate-400 mt-1">Controla en tiempo real el pipeline de producción: desde la recepción de la orden hasta la cocina, despacho y entrega al cliente.</p>
      </div>

      <!-- Resumen de Contadores en la parte superior -->
      <div class="flex items-center gap-2 flex-wrap shrink-0">
        <span class="text-xs font-bold px-3 py-1.5 rounded-xl border bg-slate-900 text-slate-300 border-white/10">
          📥 Pendientes: {{ count(array_filter($backofficeOrders->toArray(), fn($o) => $o->status === 'pending')) }}
        </span>
        <span class="text-xs font-bold px-3 py-1.5 rounded-xl border bg-amber-500/10 text-amber-400 border-amber-500/30">
          👨‍🍳 En Cocina: {{ count(array_filter($backofficeOrders->toArray(), fn($o) => $o->status === 'in_preparation')) }}
        </span>
        <span class="text-xs font-bold px-3 py-1.5 rounded-xl border bg-blue-500/10 text-blue-400 border-blue-500/30">
          🛵 En Ruta / Listos: {{ count(array_filter($backofficeOrders->toArray(), fn($o) => $o->status === 'on_delivery' || $o->status === 'ready')) }}
        </span>
      </div>
    </div>

    <!-- Grid de Comandas y Pedidos Activos (Regla AGENTS.md: Paneles estilo #1e2638 o #101725) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
      @forelse($backofficeOrders as $ord)
        @php
          $statusColors = [
            'pending' => '#94a3b8',
            'in_preparation' => '#fbbf24',
            'on_delivery' => '#60a5fa',
            'ready' => '#34d399',
            'completed' => '#34d399',
            'cancelled' => '#f87171'
          ];
          $color = $statusColors[$ord->status] ?? '#c79c5e';

          $statusLabels = [
            'pending' => '● RECIBIDO',
            'in_preparation' => '● EN COCINA',
            'on_delivery' => '● EN RUTA',
            'ready' => '● LISTO EN BARRA',
            'completed' => '● ENTREGADO',
            'cancelled' => '○ CANCELADO'
          ];

          $typeIcons = [
            'delivery' => 'two_wheeler',
            'dine_in' => 'table_restaurant',
            'takeout' => 'shopping_bag'
          ];

          $typeNames = [
            'delivery' => 'Domicilio',
            'dine_in' => 'En Mesa',
            'takeout' => 'Para Llevar'
          ];
        @endphp

        <div class="rounded-2xl border flex flex-col justify-between shadow-xl transition-all hover:border-white/20" style="background-color: #101725; border-color: rgba(255,255,255,0.08); padding: 1.5rem; gap: 1rem;">
          
          <!-- Encabezado de la Tarjeta del Pedido -->
          <div>
            <div class="flex items-start justify-between gap-2 border-b border-white/5 pb-3">
              <div class="flex items-center gap-2.5 min-w-0">
                <span class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-slate-950 shadow shrink-0" style="background-color: #c79c5e;">
                  <span class="material-symbols-rounded text-lg">{{ $typeIcons[$ord->order_type] ?? 'receipt_long' }}</span>
                </span>
                <div class="min-w-0">
                  <div class="font-bold text-white text-sm truncate">{{ $ord->order_number }}</div>
                  <span class="text-[0.65rem] font-bold text-amber-300 bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded-md inline-block mt-0.5">
                    {{ $typeNames[$ord->order_type] ?? 'Pedido' }}
                  </span>
                </div>
              </div>

              <!-- Status Badge (Limpio y alineado sin desbordamientos) -->
              <span class="text-[0.65rem] font-bold tracking-wider rounded-full border shrink-0 whitespace-nowrap" style="padding: 0.35rem 0.75rem; background-color: {{ $color }}15; color: {{ $color }}; border-color: {{ $color }}30;">
                {{ $statusLabels[$ord->status] ?? strtoupper($ord->status) }}
              </span>
            </div>

            <!-- Separación Obligatoria de Etiquetas y Subtítulos conforme a AGENTS.md -->
            <div class="text-xs text-slate-400 flex items-center gap-3 flex-wrap" style="margin-top: 0.65rem;">
              <span>👤 Cliente: <strong class="text-white">{{ $ord->customer_name ?? 'Cliente' }}</strong></span>
            </div>
          </div>

          <!-- Listado de Productos -->
          <div class="flex flex-col gap-2 my-1">
            <label class="block text-xs font-bold text-slate-400 uppercase">Productos en esta orden:</label>
            <div class="flex flex-col gap-1.5 max-h-36 overflow-y-auto pr-1">
              @foreach($ord->items as $it)
                <div class="flex items-center justify-between text-xs bg-slate-900/60 p-2 rounded-lg border border-white/5">
                  <span class="text-white font-medium truncate">{{ (int)$it->quantity }}x {{ $it->product_name }}</span>
                  <span class="text-amber-400 font-bold ml-2 shrink-0">${{ number_format($it->total_price, 2) }}</span>
                </div>
              @endforeach
            </div>
            <div class="flex items-center justify-between text-xs font-bold text-slate-300 mt-1 pt-2 border-t border-white/5">
              <span>Monto Total:</span>
              <span class="text-amber-400 text-sm font-extrabold">${{ number_format($ord->total_amount, 2) }} MXN</span>
            </div>
          </div>

          <!-- Contenedor Inferior de Acciones con Separación Obligatoria (AGENTS.md) -->
          <form action="{{ route('backoffice.orders.status', $ord->id) }}" method="POST" class="flex flex-col gap-3" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 1rem;">
            @csrf
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Acción de Logística / Preparación</label>

            @if($ord->order_type === 'delivery' && ($ord->status === 'in_preparation' || $ord->status === 'pending'))
              <input type="text" name="driver_name" value="{{ $ord->driver_name ?? '' }}" placeholder="Nombre del Repartidor (opcional)" 
                     class="w-full text-white outline-none transition-all" 
                     style="background: rgba(15, 23, 42, 0.5); padding: 0.65rem 0.85rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); font-size: 0.75rem;" />
            @endif

            <div class="flex items-center gap-2">
              @if($ord->status === 'pending')
                <button type="submit" name="status" value="in_preparation" 
                        class="w-full font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" 
                        style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;">
                  <span class="material-symbols-rounded text-base">soup_kitchen</span>
                  <span>Iniciar Preparación en Cocina</span>
                </button>
              @elseif($ord->status === 'in_preparation')
                @if($ord->order_type === 'delivery')
                  <button type="submit" name="status" value="on_delivery" 
                          class="w-full font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" 
                          style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;">
                    <span class="material-symbols-rounded text-base">two_wheeler</span>
                    <span>Despachar a Domicilio</span>
                  </button>
                @else
                  <button type="submit" name="status" value="ready" 
                          class="w-full font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" 
                          style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;">
                    <span class="material-symbols-rounded text-base">check_circle</span>
                    <span>Marcar Listo en Barra</span>
                  </button>
                @endif
              @elseif($ord->status === 'on_delivery' || $ord->status === 'ready')
                <button type="submit" name="status" value="completed" 
                        class="w-full font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" 
                        style="background-color: #10b981; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;">
                  <span class="material-symbols-rounded text-base">task_alt</span>
                  <span>Confirmar Entrega al Cliente</span>
                </button>
              @else
                <div class="w-full text-center text-xs text-slate-400 font-bold py-2 rounded-xl" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                  ✓ Pedido Finalizado y Entregado
                </div>
              @endif
            </div>
          </form>

        </div>
      @empty
        <div class="col-span-full text-center text-slate-500 py-12">
          No hay comandas o pedidos registrados para procesar en este momento.
        </div>
      @endforelse
    </div>

  </div>
  @endif
</div>

<!-- ===== MODAL DE USUARIO ===== -->
<div id="modal-usuario" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 transition-opacity">
  <div class="rounded-2xl text-white w-full max-w-lg relative shadow-2xl flex flex-col border" style="background-color: #101725; border-color: rgba(255,255,255,0.1); padding: 1.5rem; gap: 1rem;" id="modal-usuario-content">
    
    <div class="flex items-center justify-between">
      <h2 class="text-lg font-bold flex items-center gap-2">
        <span class="material-symbols-rounded" style="color: #c79c5e;">manage_accounts</span>
        <span id="modal-title-text">Usuario</span>
      </h2>
      <button onclick="cerrarModalUsuario()" class="text-slate-400 hover:text-white transition-colors">
        <span class="material-symbols-rounded">close</span>
      </button>
    </div>

    <!-- Warning Dueño -->
    <div id="warning-dueno" class="hidden bg-amber-500/10 border border-amber-500/30 rounded-xl p-3 flex items-start gap-3">
      <span class="material-symbols-rounded text-amber-500 mt-0.5">crown</span>
      <div>
        <div class="font-bold text-sm text-amber-500">Propietario Supremo del Sistema</div>
        <div class="text-xs text-amber-500/80 mt-1">El rol de este usuario está protegido por reglas de negocio. No puede modificarse ni eliminarse.</div>
      </div>
    </div>

    <input type="hidden" id="form-user-id" value="">

    <div class="flex flex-col" style="gap: 0.35rem;">
      <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nombre Completo</label>
      <input type="text" id="form-name" class="w-full rounded-lg text-white outline-none transition-all border" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.6rem 0.75rem;" onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 0 1px #c79c5e';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.boxShadow='none';">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 w-full" style="gap: 1rem;">
      <div class="flex flex-col min-w-0" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Username</label>
        <input type="text" id="form-username" class="w-full rounded-lg text-white outline-none transition-all border" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.6rem 0.75rem;" onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 0 1px #c79c5e';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.boxShadow='none';">
      </div>
      <div class="flex flex-col min-w-0" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</label>
        <input type="email" id="form-email" class="w-full rounded-lg text-white outline-none transition-all border" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.6rem 0.75rem;" onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 0 1px #c79c5e';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.boxShadow='none';">
      </div>
    </div>

    <div class="flex flex-col relative" style="gap: 0.35rem;">
      <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Rol del Sistema</label>
      
      <!-- Custom Select -->
      <div class="relative w-full">
        <input type="hidden" id="form-role" value="cajero">
        <button type="button" id="custom-select-button" class="w-full rounded-lg text-white outline-none transition-all border flex items-center justify-between text-left" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.75rem 1rem; font-size: 1rem;" onclick="toggleRoleDropdown(event)">
          <span id="custom-select-text" class="flex items-center" style="gap: 0.5rem;">🏧 Cajero</span>
          <span class="material-symbols-rounded text-slate-400 transition-transform duration-200" id="custom-select-arrow" style="font-size: 20px;">expand_more</span>
        </button>
        
        <!-- Dropdown Menu -->
        <div id="custom-select-dropdown" class="absolute w-full mt-2 rounded-xl shadow-2xl border hidden z-[100] overflow-hidden opacity-0 transition-opacity duration-200" style="background-color: #1e2638; border-color: rgba(255, 255, 255, 0.1); top: 100%; box-shadow: 0 10px 40px rgba(0,0,0,0.5); padding: 0.5rem 0;">
          <div class="flex flex-col">
            <div class="cursor-pointer transition-colors text-white flex items-center" style="padding: 0.75rem 1rem; gap: 0.75rem; font-size: 0.95rem;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.05)'" onmouseout="this.style.backgroundColor='transparent'" onclick="selectRole('dueño', '👑 Dueño')">👑 Dueño</div>
            <div class="cursor-pointer transition-colors text-white flex items-center" style="padding: 0.75rem 1rem; gap: 0.75rem; font-size: 0.95rem;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.05)'" onmouseout="this.style.backgroundColor='transparent'" onclick="selectRole('administrador', '⚙️ Administrador')">⚙️ Administrador</div>
            <div class="cursor-pointer transition-colors text-white flex items-center" style="padding: 0.75rem 1rem; gap: 0.75rem; font-size: 0.95rem;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.05)'" onmouseout="this.style.backgroundColor='transparent'" onclick="selectRole('gerente', '📊 Gerente')">📊 Gerente</div>
            <div class="cursor-pointer transition-colors text-white flex items-center" style="padding: 0.75rem 1rem; gap: 0.75rem; font-size: 0.95rem;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.05)'" onmouseout="this.style.backgroundColor='transparent'" onclick="selectRole('cajero', '🏧 Cajero')">🏧 Cajero</div>
            <div class="cursor-pointer transition-colors text-white flex items-center" style="padding: 0.75rem 1rem; gap: 0.75rem; font-size: 0.95rem;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.05)'" onmouseout="this.style.backgroundColor='transparent'" onclick="selectRole('cocina', '👨‍🍳 Cocina')">👨‍🍳 Cocina</div>
            <div class="cursor-pointer transition-colors text-white flex items-center" style="padding: 0.75rem 1rem; gap: 0.75rem; font-size: 0.95rem;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.05)'" onmouseout="this.style.backgroundColor='transparent'" onclick="selectRole('almacen', '📦 Almacén')">📦 Almacén</div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-end border-t border-white/10" style="gap: 0.75rem; margin-top: 0.5rem; padding-top: 1rem;">
      <button type="button" class="rounded-lg border text-white transition-colors text-sm font-semibold" style="padding: 0.5rem 1rem; background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'" onmouseout="this.style.backgroundColor='rgba(255,255,255,0.05)'" onclick="cerrarModalUsuario()">Cancelar</button>
      <button type="button" class="rounded-lg text-slate-950 transition-colors text-sm font-bold flex items-center shadow-lg" style="padding: 0.5rem 1rem; gap: 0.5rem; background-color: #c79c5e;" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='none'">
        <span class="material-symbols-rounded text-[18px]">save</span>
        Guardar
      </button>
    </div>

  </div>
</div>

<!-- ===== MODAL DE SUCURSAL ===== -->
<div id="modal-sucursal" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 transition-opacity">
  <div class="rounded-2xl text-white w-full max-w-2xl relative shadow-2xl flex flex-col max-h-[90vh] overflow-y-auto border" style="background-color: #101725; border-color: rgba(255,255,255,0.1); padding: 1.5rem; gap: 1rem;" id="modal-sucursal-content">
    
    <div class="flex items-center justify-between">
      <h2 class="text-lg font-bold flex items-center gap-2">
        <span class="material-symbols-rounded" style="color: #c79c5e;">store</span>
        <span id="modal-sucursal-title-text">Sucursal</span>
      </h2>
      <button onclick="cerrarModalSucursal()" class="text-slate-400 hover:text-white transition-colors">
        <span class="material-symbols-rounded">close</span>
      </button>
    </div>

    <input type="hidden" id="form-sucursal-id" value="">

    <div class="grid grid-cols-1 md:grid-cols-2 w-full" style="gap: 1rem;">
      <div class="flex flex-col min-w-0" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nombre</label>
        <input type="text" id="form-sucursal-name" class="w-full rounded-lg text-white outline-none transition-all border" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.6rem 0.75rem;" onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 0 1px #c79c5e';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.boxShadow='none';">
      </div>
      <div class="flex flex-col min-w-0" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Razón Social</label>
        <input type="text" id="form-sucursal-legal" class="w-full rounded-lg text-white outline-none transition-all border" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.6rem 0.75rem;" onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 0 1px #c79c5e';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.boxShadow='none';">
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 w-full" style="gap: 1rem;">
      <div class="flex flex-col min-w-0" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Teléfono</label>
        <input type="text" id="form-sucursal-phone" class="w-full rounded-lg text-white outline-none transition-all border" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.6rem 0.75rem;" onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 0 1px #c79c5e';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.boxShadow='none';">
      </div>
      <div class="flex flex-col min-w-0" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</label>
        <input type="email" id="form-sucursal-email" class="w-full rounded-lg text-white outline-none transition-all border" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.6rem 0.75rem;" onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 0 1px #c79c5e';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.boxShadow='none';">
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 w-full" style="gap: 1rem;">
      <div class="flex flex-col min-w-0" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dirección</label>
        <input type="text" id="form-sucursal-address" class="w-full rounded-lg text-white outline-none transition-all border" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.6rem 0.75rem;" onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 0 1px #c79c5e';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.boxShadow='none';">
      </div>
      <div class="flex flex-col min-w-0" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ciudad</label>
        <input type="text" id="form-sucursal-city" class="w-full rounded-lg text-white outline-none transition-all border" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.6rem 0.75rem;" onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 0 1px #c79c5e';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.boxShadow='none';">
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 w-full" style="gap: 1rem;">
      <div class="flex flex-col min-w-0" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Moneda</label>
        <input type="text" id="form-sucursal-currency" class="w-full rounded-lg text-white outline-none transition-all border" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.6rem 0.75rem;" placeholder="MXN" onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 0 1px #c79c5e';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.boxShadow='none';">
      </div>
      <div class="flex flex-col min-w-0" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Zona Horaria</label>
        <input type="text" id="form-sucursal-timezone" class="w-full rounded-lg text-white outline-none transition-all border" style="background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); padding: 0.6rem 0.75rem;" placeholder="America/Mexico_City" onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 0 1px #c79c5e';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.1)'; this.style.boxShadow='none';">
      </div>
    </div>

    <div class="flex items-center mt-2" style="gap: 0.75rem;">
      <input type="checkbox" id="form-sucursal-active" class="rounded border outline-none transition-all" style="width: 1rem; height: 1rem; background-color: rgba(15, 23, 42, 0.5); border-color: rgba(255, 255, 255, 0.1); accent-color: #c79c5e;">
      <label for="form-sucursal-active" class="text-sm font-semibold text-slate-300">Sucursal Activa</label>
    </div>

    <div class="flex justify-end border-t border-white/10" style="gap: 0.75rem; margin-top: 0.5rem; padding-top: 1rem;">
      <button type="button" class="rounded-lg border text-white transition-colors text-sm font-semibold" style="padding: 0.5rem 1rem; background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'" onmouseout="this.style.backgroundColor='rgba(255,255,255,0.05)'" onclick="cerrarModalSucursal()">Cancelar</button>
      <button type="button" class="rounded-lg text-slate-950 transition-colors text-sm font-bold flex items-center shadow-lg" style="padding: 0.5rem 1rem; gap: 0.5rem; background-color: #c79c5e;" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='none'">
        <span class="material-symbols-rounded text-[18px]">save</span>
        Guardar
      </button>
    </div>

  </div>
  <!-- Modal Crear Platillo del Día -->
  <div id="modal-comida-dia" class="hidden fixed inset-0 z-[9999] flex items-center justify-center" style="background-color: rgba(0,0,0,0.8); backdrop-filter: blur(8px);">
    <div class="bg-[#0f172a] border border-white/10 rounded-3xl w-full max-w-lg p-6 flex flex-col gap-4 shadow-2xl">
      <div class="flex items-center justify-between border-b border-white/10 pb-4">
        <h3 class="text-xl font-bold text-white flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
          <span class="material-symbols-rounded" style="color: #c79c5e;">restaurant</span>
          Nuevo Platillo del Día / Menú Ejecutivo
        </h3>
        <button onclick="document.getElementById('modal-comida-dia').classList.add('hidden')" class="text-slate-400 hover:text-white">
          <span class="material-symbols-rounded">close</span>
        </button>
      </div>

      <form action="{{ route('backoffice.daily-meals.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        <div class="grid grid-cols-4 gap-3">
          <div class="col-span-1">
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Emoji</label>
            <input type="text" name="emoji" value="🍽️" required class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-center text-xl text-white outline-none focus:border-[#c79c5e]"/>
          </div>
          <div class="col-span-3">
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre del Platillo</label>
            <input type="text" name="name" required placeholder="Ej. Pechuga Cordon Bleu con Ensalada" class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white text-sm outline-none focus:border-[#c79c5e]"/>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Precio Base ($ MXN)</label>
            <input type="number" name="base_price" step="0.50" min="1" required placeholder="Ej. 135.00" class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white text-sm outline-none focus:border-[#c79c5e]"/>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Stock Disponible</label>
            <input type="number" name="stock" value="99" min="1" required class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white text-sm outline-none focus:border-[#c79c5e]"/>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Descripción / Incluye</label>
          <textarea name="description" rows="3" placeholder="Ej. Sopa del día + Platillo Fuerte + Arroz/Ensalada + Bebida fresca a elegir" class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white text-sm outline-none focus:border-[#c79c5e]"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2 border-t border-white/10">
          <button type="button" onclick="document.getElementById('modal-comida-dia').classList.add('hidden')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5 text-sm font-bold">Cancelar</button>
          <button type="submit" class="px-5 py-2 rounded-xl text-slate-950 font-bold text-sm shadow-lg" style="background-color: #c79c5e;">Guardar Platillo del Día</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
function toggleDailyMeal(id, btn) {
    fetch('/backoffice/daily-meals/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            if(data.is_active) {
                btn.className = 'px-3 py-1 rounded-full text-xs font-bold transition-all bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
                btn.textContent = 'Activo';
            } else {
                btn.className = 'px-3 py-1 rounded-full text-xs font-bold transition-all bg-slate-700 text-slate-400 border border-slate-600';
                btn.textContent = 'Inactivo';
            }
            if(typeof toast === 'function') toast('Estado del platillo actualizado', 'success');
        }
    });
}

function togglePromo(id, btn) {
    fetch('/backoffice/promotions/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            if(data.is_active) {
                btn.className = 'px-3 py-1 rounded-full text-xs font-bold transition-all bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
                btn.textContent = 'Activa';
            } else {
                btn.className = 'px-3 py-1 rounded-full text-xs font-bold transition-all bg-slate-700 text-slate-400 border border-slate-600';
                btn.textContent = 'Inactiva';
            }
            if(typeof toast === 'function') toast('Estado de la promoción actualizado', 'success');
        }
    });
}

function setRoleDisplay(val) {
  const roles = {
    'dueño': '👑 Dueño',
    'administrador': '⚙️ Administrador',
    'gerente': '📊 Gerente',
    'cajero': '🏧 Cajero',
    'cocina': '👨‍🍳 Cocina',
    'almacen': '📦 Almacén'
  };
  document.getElementById('form-role').value = val;
  document.getElementById('custom-select-text').textContent = roles[val] || roles['cajero'];
}

function selectRole(val, text) {
  document.getElementById('form-role').value = val;
  document.getElementById('custom-select-text').textContent = text;
  
  // Close dropdown
  const dropdown = document.getElementById('custom-select-dropdown');
  const arrow = document.getElementById('custom-select-arrow');
  const btn = document.getElementById('custom-select-button');
  
  dropdown.classList.add('opacity-0');
  setTimeout(() => dropdown.classList.add('hidden'), 200);
  arrow.style.transform = 'rotate(0deg)';
  btn.style.borderColor = 'rgba(255, 255, 255, 0.1)';
  btn.style.boxShadow = 'none';
}

function toggleRoleDropdown(e) {
  e.stopPropagation();
  const dropdown = document.getElementById('custom-select-dropdown');
  const arrow = document.getElementById('custom-select-arrow');
  const btn = document.getElementById('custom-select-button');
  
  if (dropdown.classList.contains('hidden')) {
    dropdown.classList.remove('hidden');
    // slight delay for transition
    setTimeout(() => dropdown.classList.remove('opacity-0'), 10);
    arrow.style.transform = 'rotate(180deg)';
    btn.style.borderColor = '#c79c5e';
    btn.style.boxShadow = '0 0 0 1px #c79c5e';
  } else {
    dropdown.classList.add('opacity-0');
    setTimeout(() => dropdown.classList.add('hidden'), 200);
    arrow.style.transform = 'rotate(0deg)';
    btn.style.borderColor = 'rgba(255, 255, 255, 0.1)';
    btn.style.boxShadow = 'none';
  }
}

// Cierra el dropdown al hacer clic fuera
document.addEventListener('click', function(event) {
  const dropdown = document.getElementById('custom-select-dropdown');
  const btn = document.getElementById('custom-select-button');
  if (dropdown && !dropdown.classList.contains('hidden') && !btn.contains(event.target) && !dropdown.contains(event.target)) {
    const arrow = document.getElementById('custom-select-arrow');
    dropdown.classList.add('opacity-0');
    setTimeout(() => dropdown.classList.add('hidden'), 200);
    arrow.style.transform = 'rotate(0deg)';
    btn.style.borderColor = 'rgba(255, 255, 255, 0.1)';
    btn.style.boxShadow = 'none';
  }
});

function abrirModalUsuario(id = null, name = '', username = '', email = '', role = 'cajero', esDueno = false) {
  const modal = document.getElementById('modal-usuario');
  const content = document.getElementById('modal-usuario-content');
  
  modal.classList.remove('hidden', 'modal-exit');
  content.classList.remove('modal-exit-content');
  modal.classList.add('modal-enter');
  content.classList.add('modal-enter-content');
  
  document.getElementById('modal-title-text').textContent = id ? 'Editar Usuario' : 'Nuevo Usuario';
  document.getElementById('form-user-id').value = id || '';
  document.getElementById('form-name').value = name;
  document.getElementById('form-username').value = username;
  document.getElementById('form-email').value = email;
  
  setRoleDisplay(role);

  const warning = document.getElementById('warning-dueno');
  const selectBtn = document.getElementById('custom-select-button');

  // Bloqueo estricto para el dueño
  if (esDueno) {
    warning.classList.remove('hidden');
    selectBtn.classList.add('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
  } else {
    warning.classList.add('hidden');
    selectBtn.classList.remove('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
  }
}

function cerrarModalUsuario() {
  const modal = document.getElementById('modal-usuario');
  const content = document.getElementById('modal-usuario-content');
  
  modal.classList.remove('modal-enter');
  content.classList.remove('modal-enter-content');
  modal.classList.add('modal-exit');
  content.classList.add('modal-exit-content');
  
  setTimeout(() => {
    modal.classList.add('hidden');
  }, 180);
}

function abrirModalSucursal(id = null, name = '', legal = '', phone = '', email = '', address = '', city = '', currency = 'MXN', timezone = 'America/Mexico_City', active = true) {
  const modal = document.getElementById('modal-sucursal');
  const content = document.getElementById('modal-sucursal-content');
  
  modal.classList.remove('hidden', 'modal-exit');
  content.classList.remove('modal-exit-content');
  modal.classList.add('modal-enter');
  content.classList.add('modal-enter-content');
  
  document.getElementById('modal-sucursal-title-text').textContent = id ? 'Editar Sucursal' : 'Nueva Sucursal';
  document.getElementById('form-sucursal-id').value = id || '';
  document.getElementById('form-sucursal-name').value = name;
  document.getElementById('form-sucursal-legal').value = legal;
  document.getElementById('form-sucursal-phone').value = phone;
  document.getElementById('form-sucursal-email').value = email;
  document.getElementById('form-sucursal-address').value = address;
  document.getElementById('form-sucursal-city').value = city;
  document.getElementById('form-sucursal-currency').value = currency;
  document.getElementById('form-sucursal-timezone').value = timezone;
  document.getElementById('form-sucursal-active').checked = active;
}

function cerrarModalSucursal() {
  const modal = document.getElementById('modal-sucursal');
  const content = document.getElementById('modal-sucursal-content');
  
  modal.classList.remove('modal-enter');
  content.classList.remove('modal-enter-content');
  modal.classList.add('modal-exit');
  content.classList.add('modal-exit-content');
  
  setTimeout(() => {
    modal.classList.add('hidden');
  }, 180);
}

function abrirModalArea(area = null) {
  const modal = document.getElementById('modal-area');
  const form = document.getElementById('form-area');
  const title = document.getElementById('modal-area-title-text');

  if (area) {
    title.textContent = 'Editar Zona / Área Física';
    form.action = `/backoffice/areas/${area.id}/update`;
    document.getElementById('form-area-branch-id').value = area.branch_id || (document.getElementById('form-area-branch-id').options[0]?.value ?? 1);
    document.querySelector('#modal-area input[name="name"]').value = area.name || '';
    document.querySelector('#modal-area input[name="emoji"]').value = area.emoji || '🪑';
    document.querySelector('#modal-area textarea[name="description"]').value = area.description || '';
    document.querySelector('#modal-area input[name="floor"]').value = area.floor || 'Planta Baja';
    document.querySelector('#modal-area input[name="color"]').value = area.color || '#c79c5e';
    document.querySelector('#modal-area input[name="schedule_open"]').value = area.schedule_open || '07:00';
    document.querySelector('#modal-area input[name="schedule_close"]').value = area.schedule_close || '22:00';
    document.querySelector('#modal-area input[name="min_consumption"]').value = area.min_consumption || 0;
    document.querySelector('#modal-area input[name="sort_order"]').value = area.sort_order || 0;
    document.querySelector('#modal-area input[name="is_outdoor"]').checked = !!area.is_outdoor;
    document.querySelector('#modal-area input[name="requires_reservation"]').checked = !!area.requires_reservation;
  } else {
    title.textContent = 'Nueva Zona / Área Física';
    form.action = "{{ route('backoffice.areas.store') }}";
    form.reset();
  }

  modal.classList.remove('hidden');
}

function editarArea(area) {
  abrirModalArea(area);
}

function filtrarSucursal(branchId, btn) {
  document.querySelectorAll('.branch-filter-btn').forEach(b => {
    b.style.backgroundColor = 'transparent';
    b.style.color = '#94a3b8';
    b.style.borderColor = 'transparent';
  });
  btn.style.backgroundColor = '#c79c5e';
  btn.style.color = '#0a0f18';
  btn.style.borderColor = '#c79c5e';

  document.querySelectorAll('.area-row').forEach(row => {
    if (branchId === 'todas' || row.getAttribute('data-branch-id') == branchId) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}

function cerrarModalArea() {
  const modal = document.getElementById('modal-area');
  modal.classList.add('hidden');
}

function abrirModalMesa() {
  const modal = document.getElementById('modal-mesa');
  modal.classList.remove('hidden');
}

function cerrarModalMesa() {
  const modal = document.getElementById('modal-mesa');
  modal.classList.add('hidden');
}

function toggleEstadoArea(areaId, btn) {
  fetch(`/backoffice/areas/${areaId}/toggle`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Content-Type': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      if (data.is_active) {
        btn.textContent = '● ACTIVA';
        btn.style.backgroundColor = 'rgba(16, 185, 129, 0.15)';
        btn.style.borderColor = 'rgba(16, 185, 129, 0.3)';
        btn.style.color = '#34d399';
      } else {
        btn.textContent = '○ REMODELACIÓN';
        btn.style.backgroundColor = 'rgba(148, 163, 184, 0.15)';
        btn.style.borderColor = 'rgba(148, 163, 184, 0.3)';
        btn.style.color = '#94a3b8';
      }
    }
  });
}

// Lógica de Paginación y Filtrado estilo POS para Mesas Asignadas
let currentAreaFilter = 'todas';
let currentMesaPage = 1;
let searchMesaQuery = '';
const mesasPerPage = 4; // 2x2 grid (4 mesas holgadas por página)

function buscarMesas(query) {
  searchMesaQuery = (query || '').toLowerCase().trim();
  currentMesaPage = 1;
  renderMesasPaginadas();
}

function filtrarMesasPorArea(areaId, btn) {
  currentAreaFilter = areaId;
  currentMesaPage = 1;

  document.querySelectorAll('.filter-area-btn').forEach(b => {
    b.style.color = '#94a3b8';
    b.style.borderColor = 'transparent';
    b.classList.remove('font-bold');
  });

  btn.style.color = '#c79c5e';
  btn.style.borderColor = '#c79c5e';
  btn.classList.add('font-bold');

  renderMesasPaginadas();
}

function renderMesasPaginadas() {
  const cards = Array.from(document.querySelectorAll('.mesa-card-item'));
  if (cards.length === 0) return;

  const visibleCards = cards.filter(card => {
    const areaMatch = (currentAreaFilter === 'todas') || (card.dataset.areaId === String(currentAreaFilter));
    const searchMatch = !searchMesaQuery || (card.dataset.searchText && card.dataset.searchText.includes(searchMesaQuery));
    return areaMatch && searchMatch;
  });

  const totalPages = Math.ceil(visibleCards.length / mesasPerPage) || 1;
  if (currentMesaPage > totalPages) currentMesaPage = totalPages;
  if (currentMesaPage < 1) currentMesaPage = 1;

  const startIdx = (currentMesaPage - 1) * mesasPerPage;
  const endIdx = startIdx + mesasPerPage;

  cards.forEach(card => card.style.display = 'none');

  visibleCards.forEach((card, idx) => {
    if (idx >= startIdx && idx < endIdx) {
      card.style.display = 'flex';
    }
  });

  const infoText = document.getElementById('paginacion-info');
  if (infoText) {
    infoText.textContent = `Pág. ${currentMesaPage} de ${totalPages} (${visibleCards.length} mesas)`;
  }

  const btnPrev = document.getElementById('btn-prev-page');
  const btnNext = document.getElementById('btn-next-page');

  if (btnPrev) btnPrev.disabled = (currentMesaPage === 1);
  if (btnNext) btnNext.disabled = (currentMesaPage >= totalPages);
}

function cambiarPaginaMesa(delta) {
  currentMesaPage += delta;
  renderMesasPaginadas();
}

// Ver detalle modal de mesa
let mesaActualParaEditar = null;

function verDetalleMesa(mesa) {
  mesaActualParaEditar = mesa;
  const modal = document.getElementById('modal-detalle-mesa');

  document.getElementById('det-mesa-emoji').textContent = mesa.area_emoji || '🪑';
  document.getElementById('det-mesa-title').textContent = mesa.table_number;
  document.getElementById('det-mesa-area').textContent = mesa.area_name || 'Área General';
  document.getElementById('det-mesa-capacity').textContent = `${mesa.capacity} personas`;

  const badge = document.getElementById('det-mesa-status-badge');
  const statusUpper = (mesa.status || 'libre').toUpperCase();
  badge.textContent = statusUpper;

  if (mesa.status === 'libre') {
    badge.style.backgroundColor = 'rgba(16,185,129,0.15)';
    badge.style.borderColor = 'rgba(16,185,129,0.3)';
    badge.style.color = '#34d399';
  } else if (mesa.status === 'reservada') {
    badge.style.backgroundColor = 'rgba(245,158,11,0.15)';
    badge.style.borderColor = 'rgba(245,158,11,0.3)';
    badge.style.color = '#fbbf24';
  } else if (mesa.status === 'ocupada') {
    badge.style.backgroundColor = 'rgba(239,68,68,0.15)';
    badge.style.borderColor = 'rgba(239,68,68,0.3)';
    badge.style.color = '#f87171';
  } else {
    badge.style.backgroundColor = 'rgba(148,163,184,0.1)';
    badge.style.borderColor = 'rgba(148,163,184,0.2)';
    badge.style.color = '#94a3b8';
  }

  const clienteBox = document.getElementById('det-mesa-cliente-box');
  if (mesa.customer_name || mesa.reservation_time) {
    clienteBox.classList.remove('hidden');
    document.getElementById('det-mesa-cliente-nombre').textContent = mesa.customer_name || 'Sin especificar';
    document.getElementById('det-mesa-cliente-phone').textContent = mesa.customer_phone || 'Sin número';
    document.getElementById('det-mesa-time').textContent = mesa.reservation_time || '--:--';
    document.getElementById('det-mesa-party').textContent = `${mesa.party_size || 1} pers.`;
  } else {
    clienteBox.classList.add('hidden');
  }

  const notesBox = document.getElementById('det-mesa-notes-box');
  if (mesa.notes) {
    notesBox.classList.remove('hidden');
    document.getElementById('det-mesa-notes').textContent = `"${mesa.notes}"`;
  } else {
    notesBox.classList.add('hidden');
  }

  modal.classList.remove('hidden');
}

function cerrarModalDetalleMesa() {
  document.getElementById('modal-detalle-mesa').classList.add('hidden');
}

function abrirEditarDesdeDetalle() {
  cerrarModalDetalleMesa();
  if (mesaActualParaEditar) {
    abrirModalEditarMesa(mesaActualParaEditar);
  }
}

function abrirModalEditarMesa(mesa) {
  const modal = document.getElementById('modal-editar-mesa');
  const form = document.getElementById('form-editar-mesa');

  form.action = `/backoffice/tables/${mesa.id}/update`;
  document.getElementById('edit-mesa-number').value = mesa.table_number;
  document.getElementById('edit-mesa-area-id').value = mesa.area_id || '';
  document.getElementById('edit-mesa-capacity').value = mesa.capacity;
  document.getElementById('edit-mesa-status').value = mesa.status || 'libre';
  document.getElementById('edit-mesa-notes').value = mesa.notes || '';

  modal.classList.remove('hidden');
}

function cerrarModalEditarMesa() {
  document.getElementById('modal-editar-mesa').classList.add('hidden');
}

// Inicialización incondicional e inmediata de la paginación 2x2
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', renderMesasPaginadas);
} else {
  renderMesasPaginadas();
}
window.addEventListener('load', renderMesasPaginadas);
setTimeout(renderMesasPaginadas, 50);
</script>

<!-- ===== MODAL DE NUEVA ZONA / ÁREA FÍSICA ===== -->
<div id="modal-area" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
  <div class="rounded-3xl text-white w-full max-w-xl relative shadow-2xl flex flex-col border max-h-[90vh] overflow-y-auto" style="background-color: #101725; border-color: rgba(255,255,255,0.1); padding: 2rem; gap: 1.25rem;">
    
    <div class="flex items-center justify-between border-b pb-4" style="border-color: rgba(255,255,255,0.08);">
      <h2 class="text-xl font-bold flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
        <span class="material-symbols-rounded" style="color: #c79c5e;">domain_add</span>
        <span id="modal-area-title-text">Nueva Zona / Área Física</span>
      </h2>
      <button onclick="cerrarModalArea()" class="text-slate-400 hover:text-white transition-colors">
        <span class="material-symbols-rounded">close</span>
      </button>
    </div>

    <form id="form-area" action="{{ route('backoffice.areas.store') }}" method="POST" class="flex flex-col gap-4">
      @csrf

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Sucursal Pertenezca *</label>
        <select id="form-area-branch-id" name="branch_id" required class="w-full text-white outline-none transition-all cursor-pointer" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);">
          @foreach($branches as $b)
            <option value="{{ $b->id }}" style="background-color: #0f172a; color: white;">🏢 {{ $b->name }} ({{ $b->city ?? 'Sucursal' }})</option>
          @endforeach
        </select>
      </div>

      <div class="grid grid-cols-3 gap-4">
        <div class="col-span-2">
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre de la Zona *</label>
          <input type="text" name="name" required placeholder="Ej. Segunda Planta / Terraza Norte" 
                 class="w-full text-white outline-none transition-all" 
                 style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Emoji *</label>
          <input type="text" name="emoji" value="🪑" required 
                 class="w-full text-center text-white outline-none transition-all text-xl" 
                 style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Descripción del Ambiente</label>
        <textarea name="description" rows="2" placeholder="Ej. Salón privado con aire acondicionado y luz ambiental..." 
                  class="w-full text-white outline-none transition-all resize-none" 
                  style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"></textarea>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Piso / Ubicación</label>
          <input type="text" name="floor" value="Planta Baja" placeholder="Ej. Primer Piso / Exterior" 
                 class="w-full text-white outline-none transition-all" 
                 style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Color Identificador</label>
          <input type="color" name="color" value="#c79c5e" 
                 class="w-full h-12 rounded-xl border border-white/10 cursor-pointer bg-slate-900 p-1" />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Hora Apertura Zona</label>
          <input type="time" name="schedule_open" value="07:00" 
                 class="w-full text-white outline-none transition-all" 
                 style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Hora Cierre Zona</label>
          <input type="time" name="schedule_close" value="22:00" 
                 class="w-full text-white outline-none transition-all" 
                 style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Consumo Mínimo ($)</label>
          <input type="number" name="min_consumption" step="0.01" value="0.00" 
                 class="w-full text-white outline-none transition-all" 
                 style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Orden de Visualización</label>
          <input type="number" name="sort_order" value="1" min="0" 
                 class="w-full text-white outline-none transition-all" 
                 style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
        </div>
      </div>

      <div class="flex items-center gap-6 py-2">
        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-300">
          <input type="checkbox" name="is_outdoor" value="1" class="w-4 h-4 rounded accent-emerald-500" />
          <span>Es área al aire libre (Exterior)</span>
        </label>

        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-300">
          <input type="checkbox" name="requires_reservation" value="1" class="w-4 h-4 rounded accent-purple-500" />
          <span>Requiere reserva previa obligatoria</span>
        </label>
      </div>

      <div class="flex items-center justify-end gap-3" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 1rem;">
        <button type="button" onclick="cerrarModalArea()" class="font-bold text-xs px-4 py-3 rounded-xl border border-white/10 text-slate-400 hover:text-white transition-all">
          Cancelar
        </button>
        <button type="submit" 
                class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" 
                style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;">
          <span class="material-symbols-rounded text-base">save</span>
          <span>Guardar Zona</span>
        </button>
      </div>
    </form>

  </div>
</div>

<!-- ===== MODAL DE AGREGAR MESA ===== -->
<div id="modal-mesa" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
  <div class="rounded-3xl text-white w-full max-w-md relative shadow-2xl flex flex-col border" style="background-color: #101725; border-color: rgba(255,255,255,0.1); padding: 2rem; gap: 1.25rem;">
    
    <div class="flex items-center justify-between border-b pb-4" style="border-color: rgba(255,255,255,0.08);">
      <h2 class="text-xl font-bold flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
        <span class="material-symbols-rounded" style="color: #c79c5e;">add_circle</span>
        <span>Agregar Mesa a Zona</span>
      </h2>
      <button onclick="cerrarModalMesa()" class="text-slate-400 hover:text-white transition-colors">
        <span class="material-symbols-rounded">close</span>
      </button>
    </div>

    <form action="{{ route('backoffice.tables.store') }}" method="POST" class="flex flex-col gap-4">
      @csrf

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Zona / Área Física *</label>
        <select name="area_id" required class="w-full text-white outline-none transition-all appearance-none" 
                style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); cursor: pointer;">
          @foreach($areas ?? [] as $a)
            <option value="{{ $a->id }}" style="background:#0f172a;">{{ $a->emoji }} {{ $a->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Identificador de la Mesa *</label>
        <input type="text" name="table_number" required placeholder="Ej. Mesa 08 / Terraza T-06" 
               class="w-full text-white outline-none transition-all" 
               style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Capacidad (Número de Personas) *</label>
        <input type="number" name="capacity" value="4" min="1" max="50" required 
               class="w-full text-white outline-none transition-all" 
               style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
      </div>

      <div class="flex items-center justify-end gap-3" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 1rem;">
        <button type="button" onclick="cerrarModalMesa()" class="font-bold text-xs px-4 py-3 rounded-xl border border-white/10 text-slate-400 hover:text-white transition-all">
          Cancelar
        </button>
        <button type="submit" 
                class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" 
                style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;">
          <span class="material-symbols-rounded text-base">save</span>
          <span>Guardar Mesa</span>
        </button>
      </div>
    </form>

  <!-- ===== MODAL DE DETALLE DE MESA ===== -->
<div id="modal-detalle-mesa" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
  <div class="rounded-3xl text-white w-full max-w-md relative shadow-2xl flex flex-col border" style="background-color: #101725; border-color: rgba(255,255,255,0.1); padding: 2rem; gap: 1.25rem;">
    
    <div class="flex items-center justify-between border-b pb-4" style="border-color: rgba(255,255,255,0.08);">
      <div class="flex items-center gap-3">
        <span class="text-3xl p-2 rounded-2xl bg-white/5" id="det-mesa-emoji">🪑</span>
        <div>
          <h2 class="text-xl font-bold text-white leading-tight" id="det-mesa-title" style="font-family: 'Playfair Display', Georgia, serif;">Mesa 01</h2>
          <span class="text-xs text-slate-400" id="det-mesa-area">Comedor Principal</span>
        </div>
      </div>
      <button onclick="cerrarModalDetalleMesa()" class="text-slate-400 hover:text-white transition-colors">
        <span class="material-symbols-rounded">close</span>
      </button>
    </div>

    <!-- Detalle Grid -->
    <div class="flex flex-col gap-3 text-xs">
      <div class="flex items-center justify-between p-3 rounded-xl bg-slate-900/60 border border-white/5">
        <span class="text-slate-400 font-bold">Estado Actual:</span>
        <span id="det-mesa-status-badge" class="font-bold px-3 py-1 rounded-full text-[0.7rem] uppercase border">LIBRE</span>
      </div>

      <div class="flex items-center justify-between p-3 rounded-xl bg-slate-900/60 border border-white/5">
        <span class="text-slate-400 font-bold">Capacidad Máxima:</span>
        <strong id="det-mesa-capacity" class="text-white">4 personas</strong>
      </div>

      <!-- Datos de Reserva/Cliente si aplica -->
      <div id="det-mesa-cliente-box" class="hidden flex flex-col gap-2 p-3.5 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-300">
        <div class="font-bold text-xs flex items-center gap-1.5 text-amber-400">
          <span class="material-symbols-rounded text-base">person</span>
          <span>Información de Reservación / Cliente</span>
        </div>
        <div class="text-slate-300">Cliente: <strong id="det-mesa-cliente-nombre" class="text-white">Ana Torres</strong></div>
        <div class="text-slate-300">Teléfono: <span id="det-mesa-cliente-phone">444-987-6543</span></div>
        <div class="text-slate-300">Hora / Personas: <span id="det-mesa-time">15:00</span> · <span id="det-mesa-party">2 pers.</span></div>
      </div>

      <div id="det-mesa-notes-box" class="hidden p-3 rounded-xl bg-slate-900/60 border border-white/5">
        <span class="text-slate-400 block mb-1 font-bold">Notas u Observaciones:</span>
        <p id="det-mesa-notes" class="text-slate-300 italic"></p>
      </div>
    </div>

    <div class="flex items-center justify-end gap-3" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 0.5rem;">
      <button type="button" onclick="cerrarModalDetalleMesa()" class="font-bold text-xs px-4 py-2.5 rounded-xl border border-white/10 text-slate-400 hover:text-white transition-all">
        Cerrar
      </button>
      <button type="button" onclick="abrirEditarDesdeDetalle()"
              class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" 
              style="background-color: #c79c5e; color: #0a0f18; padding: 0.65rem 1.25rem; border-radius: 0.85rem; border: none;">
        <span class="material-symbols-rounded text-base">edit</span>
        <span>Editar Mesa</span>
      </button>
    </div>

  </div>
</div>

<!-- ===== MODAL DE EDITAR MESA ===== -->
<div id="modal-editar-mesa" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
  <div class="rounded-3xl text-white w-full max-w-md relative shadow-2xl flex flex-col border" style="background-color: #101725; border-color: rgba(255,255,255,0.1); padding: 2rem; gap: 1.25rem;">
    
    <div class="flex items-center justify-between border-b pb-4" style="border-color: rgba(255,255,255,0.08);">
      <h2 class="text-xl font-bold flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
        <span class="material-symbols-rounded" style="color: #c79c5e;">edit_note</span>
        <span>Editar Mesa</span>
      </h2>
      <button onclick="cerrarModalEditarMesa()" class="text-slate-400 hover:text-white transition-colors">
        <span class="material-symbols-rounded">close</span>
      </button>
    </div>

    <form id="form-editar-mesa" action="" method="POST" class="flex flex-col gap-4">
      @csrf

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Zona / Área Física *</label>
        <select name="area_id" id="edit-mesa-area-id" required class="w-full text-white outline-none transition-all appearance-none" 
                style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); cursor: pointer;">
          @foreach($areas ?? [] as $a)
            <option value="{{ $a->id }}" style="background:#0f172a;">{{ $a->emoji }} {{ $a->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Identificador de la Mesa *</label>
        <input type="text" name="table_number" id="edit-mesa-number" required 
               class="w-full text-white outline-none transition-all" 
               style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Capacidad *</label>
          <input type="number" name="capacity" id="edit-mesa-capacity" min="1" max="50" required 
                 class="w-full text-white outline-none transition-all" 
                 style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Estado de Mesa *</label>
          <select name="status" id="edit-mesa-status" required class="w-full text-white outline-none transition-all appearance-none" 
                  style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); cursor: pointer;">
            <option value="libre" style="background:#0f172a;">🟢 Libre</option>
            <option value="reservada" style="background:#0f172a;">🟡 Reservada</option>
            <option value="ocupada" style="background:#0f172a;">🔴 Ocupada</option>
            <option value="limpieza" style="background:#0f172a;">🔘 Limpieza</option>
          </select>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Notas u Observaciones</label>
        <textarea name="notes" id="edit-mesa-notes" rows="2" placeholder="Notas internas..." 
                  class="w-full text-white outline-none transition-all resize-none" 
                  style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"></textarea>
      </div>

      <div class="flex items-center justify-end gap-3" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 1rem;">
        <button type="button" onclick="cerrarModalEditarMesa()" class="font-bold text-xs px-4 py-3 rounded-xl border border-white/10 text-slate-400 hover:text-white transition-all">
          Cancelar
        </button>
        <button type="submit" 
                class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" 
                style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;">
          <span class="material-symbols-rounded text-base">save</span>
          <span>Actualizar Mesa</span>
        </button>
      </div>
    </form>

  </div>
</div>
@endpush
