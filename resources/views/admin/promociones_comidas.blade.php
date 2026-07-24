@extends('layouts.app')

@section('title', 'Cafeteria PETY | Gestión de Ofertas, Comidas & Mesas')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-8 pb-12">

  <!-- Header Principal -->
  <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 border-b border-white/10 pb-6">
    <div class="flex flex-col gap-1.5">
      <h1 class="text-3xl font-bold text-white flex items-center gap-3" style="font-family: 'Playfair Display', Georgia, serif; line-height: 1.2;">
        <span class="material-symbols-rounded text-3xl" style="color: #c79c5e;">table_restaurant</span>
        Gestión de <span class="italic font-normal" style="color: #c79c5e;">Ofertas, Comidas & Mesas</span>
      </h1>
      <p class="text-slate-400 text-sm max-w-3xl leading-relaxed">
        Administra de forma centralizada las promociones activas, el menú ejecutivo del día y el control administrativo del estado de las mesas.
      </p>
    </div>

    <!-- Botones de Acción Superior -->
    <div class="flex flex-wrap items-center gap-3 shrink-0">
      <button onclick="document.getElementById('modal-comida-dia').classList.remove('hidden')" 
              class="font-bold text-xs flex items-center gap-2 shadow-xl transition-all hover:brightness-110 active:scale-95 whitespace-nowrap cursor-pointer" 
              style="background-color: #c79c5e; color: #0a0f18; padding: 0.85rem 1.5rem; border-radius: 1rem; border: none;">
        <span class="material-symbols-rounded text-lg">restaurant</span>
        <span>+ Agregar / Crear Platillo del Día</span>
      </button>
      <button onclick="document.getElementById('modal-promocion').classList.remove('hidden')" 
              class="font-bold text-xs flex items-center gap-2 shadow-xl border transition-all hover:bg-white/10 active:scale-95 whitespace-nowrap cursor-pointer" 
              style="background-color: rgba(255,255,255,0.05); color: #ffffff; border-color: rgba(255,255,255,0.15); padding: 0.85rem 1.5rem; border-radius: 1rem;">
        <span class="material-symbols-rounded text-lg" style="color: #c79c5e;">loyalty</span>
        <span>+ Nueva Promoción</span>
      </button>
    </div>
  </div>

  @if(session('success'))
    <div class="w-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-4 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-lg">
      <span class="material-symbols-rounded text-xl">check_circle</span>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Subnavegación de Pestañas -->
  <div class="flex border-b-2 border-white/10 overflow-x-auto shrink-0" style="gap: 0.5rem;">
    <a href="?tab=mesas" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'mesas' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'mesas' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">table_bar</span>
      Control de Mesas
    </a>
    <a href="?tab=comidas" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'comidas' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'comidas' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">restaurant</span>
      Comidas del Día (Menú Ejecutivo)
    </a>
    <a href="?tab=promociones" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'promociones' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'promociones' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">loyalty</span>
      Promociones & Descuentos
    </a>
  </div>

  @if($tab == 'mesas')
  <!-- ================= SUBSECCIÓN 1: CONTROL DE MESAS ================= -->
  <div class="flex flex-col gap-6 rounded-[2.5rem] border shadow-2xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 2rem;">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b pb-5" style="border-color: rgba(255,255,255,0.08);">
      <div class="flex items-center gap-3.5">
        <div class="w-11 h-11 rounded-2xl flex items-center justify-center font-bold shadow-md shrink-0 border" style="background: rgba(199,156,94,0.15); border-color: rgba(199,156,94,0.3); color: #c79c5e;">
          <span class="material-symbols-rounded text-2xl">table_bar</span>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-white tracking-wide" style="font-family: 'Playfair Display', Georgia, serif;">
            Control & Estado de Mesas en Tiempo Real
          </h2>
          <p class="text-xs text-slate-400 mt-0.5">Monitorea y cambia la ocupación o liberación de mesas del comedor.</p>
        </div>
      </div>
      <span class="text-xs font-bold text-slate-300 bg-slate-900/80 px-4 py-1.5 rounded-full border border-white/10">
        {{ count($tables ?? []) }} mesas configuradas
      </span>
    </div>

    <!-- Grid de Tarjetas de Mesas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse ($tables ?? [] as $t)
        @php
          $isLibre = $t->status === 'libre';
          $isReservada = $t->status === 'reservada';
          $isOcupada = $t->status === 'ocupada';

          $statusBadge = 'background-color: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399;';
          if ($isReservada) {
              $statusBadge = 'background-color: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); color: #fbbf24;';
          } elseif ($isOcupada) {
              $statusBadge = 'background-color: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171;';
          }
        @endphp
        
        <div class="rounded-3xl border flex flex-col justify-between shadow-xl transition-all duration-300" style="background-color: #101725; border-color: rgba(255,255,255,0.1); padding: 1.5rem; gap: 1rem;">
          
          <div class="flex items-start justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0 flex-1">
              <div class="rounded-2xl border flex items-center justify-center shrink-0 shadow-inner" style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); width: 2.75rem; height: 2.75rem; color: #c79c5e;">
                <span class="material-symbols-rounded text-xl">event_seat</span>
              </div>
              <div class="min-w-0 flex-1">
                <h3 class="font-bold text-base text-white leading-snug">{{ $t->table_number }}</h3>
                <div class="font-bold text-xs mt-0.5 text-slate-400">{{ $t->area }}</div>
              </div>
            </div>
            
            <span class="shrink-0 font-bold text-[0.65rem] transition-all shadow uppercase tracking-widest whitespace-nowrap" 
                  style="padding: 0.35rem 0.75rem; border-radius: 999px; {{ $statusBadge }}">
              {{ strtoupper($t->status) }}
            </span>
          </div>

          @if($isReservada)
            <div class="text-xs text-slate-300 bg-slate-900/60 p-3 rounded-xl border border-white/5 flex flex-col gap-1">
              <div><strong class="text-white">Cliente:</strong> {{ $t->customer_name }}</div>
              <div><strong class="text-white">Hora:</strong> {{ $t->reservation_time }} ({{ $t->party_size ?? 2 }} px)</div>
              @if(!empty($t->notes))
                <div class="text-slate-400 italic text-[0.75rem]">"{{ $t->notes }}"</div>
              @endif
            </div>
          @else
            <div class="text-xs text-slate-400">
              Capacidad: <strong class="text-white font-bold">{{ $t->capacity }} personas</strong>
            </div>
          @endif

          <div class="border-t flex items-center justify-between gap-2 pt-3" style="border-color: rgba(255,255,255,0.08);">
            @if($isLibre)
              <form action="{{ route('promotions-meals.tables.occupy', $t->id) }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full text-xs font-bold text-rose-400 bg-rose-500/10 border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center gap-1.5 cursor-pointer" style="padding: 0.65rem 1rem; border-radius: 0.75rem;">
                  <span class="material-symbols-rounded text-sm">person_check</span>
                  <span>Ocupar Mesa</span>
                </button>
              </form>
            @elseif($isReservada)
              <form action="{{ route('promotions-meals.tables.occupy', $t->id) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full text-xs font-bold text-amber-950 bg-amber-500 hover:brightness-110 transition-all flex items-center justify-center gap-1 cursor-pointer" style="padding: 0.65rem 1rem; border-radius: 0.75rem; border: none;">
                  <span class="material-symbols-rounded text-sm">login</span>
                  <span>Ingresar</span>
                </button>
              </form>
              <form action="{{ route('promotions-meals.tables.release', $t->id) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full text-xs font-bold text-slate-300 bg-slate-800 hover:bg-slate-700 transition-all flex items-center justify-center gap-1 cursor-pointer" style="padding: 0.65rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.1);">
                  <span class="material-symbols-rounded text-sm">cancel</span>
                  <span>Liberar</span>
                </button>
              </form>
            @else
              <form action="{{ route('promotions-meals.tables.release', $t->id) }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full text-xs font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 hover:bg-emerald-500 hover:text-slate-950 transition-all flex items-center justify-center gap-1.5 cursor-pointer" style="padding: 0.65rem 1rem; border-radius: 0.75rem;">
                  <span class="material-symbols-rounded text-sm">cleaning_services</span>
                  <span>Liberar Mesa</span>
                </button>
              </form>
            @endif
          </div>

        </div>
      @empty
        <div class="col-span-full py-8 text-center text-slate-500 text-sm font-medium">
          No hay mesas registradas en el sistema.
        </div>
      @endforelse
    </div>
  </div>
  @endif

  @if($tab == 'comidas')
  <!-- ================= SUBSECCIÓN 2: COMIDAS DEL DÍA ================= -->
  <div class="flex flex-col gap-6 rounded-[2.5rem] border shadow-2xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 2rem;">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b pb-5" style="border-color: rgba(255,255,255,0.08);">
      <div class="flex items-center gap-3.5">
        <div class="w-11 h-11 rounded-2xl flex items-center justify-center font-bold shadow-md shrink-0 border" style="background: rgba(199,156,94,0.15); border-color: rgba(199,156,94,0.3); color: #c79c5e;">
          <span class="material-symbols-rounded text-2xl">restaurant</span>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-white tracking-wide" style="font-family: 'Playfair Display', Georgia, serif;">
            Comidas del Día &amp; Menú Ejecutivo
          </h2>
          <p class="text-xs text-slate-400 mt-0.5">Agrega, edita o remueve platillos especiales visibles en el Menú Ejecutivo del POS.</p>
        </div>
      </div>
      <button onclick="document.getElementById('modal-comida-dia').classList.remove('hidden')" 
              class="font-bold text-xs flex items-center gap-2 shadow-xl transition-all hover:brightness-110 cursor-pointer" 
              style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.25rem; border-radius: 1rem; border: none;">
        <span class="material-symbols-rounded text-base">add_circle</span>
        <span>+ Agregar / Crear Platillo</span>
      </button>
    </div>

    <!-- Grid de Tarjetas de Comidas del Día -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      @forelse ($dailyMeals ?? [] as $meal)
        <div class="rounded-3xl border flex flex-col justify-between shadow-xl transition-all duration-300" style="background-color: #101725; border-color: rgba(255,255,255,0.1); padding: 1.75rem; gap: 1.25rem;">
          
          <div class="flex items-start justify-between gap-4">
            <div class="flex items-center gap-3.5 min-w-0 flex-1">
              @if(!empty($meal->image_path))
                <img src="{{ $meal->image_path }}" alt="{{ $meal->name }}" class="w-14 h-14 rounded-2xl object-cover border border-white/10 shrink-0 shadow-md"/>
              @else
                <div class="w-14 h-14 rounded-2xl border flex items-center justify-center shrink-0 shadow-inner" style="background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); font-size: 1.75rem;">
                  🍽️
                </div>
              @endif
              <div class="min-w-0 flex-1">
                <h3 class="font-bold text-base text-white leading-snug" style="word-break: break-word;">{{ $meal->name }}</h3>
                <div class="font-extrabold text-sm mt-1" style="color: #c79c5e;">${{ number_format($meal->base_price, 2) }}</div>
              </div>
            </div>
            
            <button onclick="toggleDailyMeal({{ $meal->id }}, this)" 
                    class="shrink-0 font-bold text-xs transition-all shadow cursor-pointer" 
                    style="padding: 0.4rem 0.85rem; border-radius: 999px; {{ $meal->is_active ? 'background-color: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399;' : 'background-color: rgba(51, 65, 85, 0.5); border: 1px solid rgba(71, 85, 105, 0.5); color: #94a3b8;' }}">
              {{ $meal->is_active ? 'Activo' : 'Inactivo' }}
            </button>
          </div>

          <p class="text-xs leading-relaxed" style="color: #cbd5e1; font-size: 0.825rem; line-height: 1.6;">
            {{ $meal->description ?? 'Sin descripción adicional disponible.' }}
          </p>

          <!-- Footer con Botones Amplios -->
          <div class="flex items-center justify-between gap-3" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 1rem;">
            <span class="text-xs text-slate-400">Stock: <strong class="text-white font-bold">{{ $meal->stock ?? 99 }} uds</strong></span>
            
            <div class="flex items-center gap-2">
              <button onclick="abrirModalEditarComida({{ json_encode($meal) }})" 
                      class="font-bold text-xs flex items-center gap-1.5 transition-all hover:brightness-110 cursor-pointer" 
                      style="background-color: rgba(199, 156, 94, 0.15); border: 1px solid rgba(199, 156, 94, 0.3); color: #c79c5e; padding: 0.65rem 1.1rem; border-radius: 0.75rem;">
                <span class="material-symbols-rounded text-sm">edit</span>
                <span>Editar</span>
              </button>

              <form action="{{ route('promotions-meals.daily-meals.delete', $meal->id) }}" method="POST" onsubmit="return confirm('¿Remover este platillo de las Comidas del Día?')">
                @csrf
                <button type="submit" 
                        class="font-bold text-xs flex items-center gap-1.5 transition-all hover:brightness-110 cursor-pointer" 
                        style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; padding: 0.65rem 1.1rem; border-radius: 0.75rem;">
                  <span class="material-symbols-rounded text-sm">delete</span>
                  <span>Remover</span>
                </button>
              </form>
            </div>
          </div>

        </div>
      @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-slate-500">
          <span class="material-symbols-rounded text-5xl mb-2 opacity-40">restaurant</span>
          <p class="text-sm font-medium">No hay platillos del día configurados actualmente.</p>
        </div>
      @endforelse
    </div>
  </div>
  @endif

  @if($tab == 'promociones')
  <!-- ================= SUBSECCIÓN 3: PROMOCIONES & DESCUENTOS ================= -->
  <div class="flex flex-col gap-6 rounded-[2.5rem] border shadow-2xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 2rem;">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b pb-5" style="border-color: rgba(255,255,255,0.08);">
      <div class="flex items-center gap-3.5">
        <div class="w-11 h-11 rounded-2xl flex items-center justify-center font-bold shadow-md shrink-0 border" style="background: rgba(199,156,94,0.15); border-color: rgba(199,156,94,0.3); color: #c79c5e;">
          <span class="material-symbols-rounded text-2xl">loyalty</span>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-white tracking-wide" style="font-family: 'Playfair Display', Georgia, serif;">
            Promociones &amp; Descuentos Configurables
          </h2>
          <p class="text-xs text-slate-400 mt-0.5">Ofertas automáticas aplicadas en el catálogo y punto de venta.</p>
        </div>
      </div>
      <span class="text-xs font-bold text-slate-300 bg-slate-900/80 px-4 py-1.5 rounded-full border border-white/10">
        {{ count($promotions ?? []) }} promociones configuradas
      </span>
    </div>

    <!-- Grid de Tarjetas de Promociones -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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
        
        <div class="rounded-3xl border flex flex-col justify-between shadow-xl transition-all duration-300" style="background-color: #101725; border-color: rgba(255,255,255,0.1); padding: 1.75rem; gap: 1.25rem;">
          
          <div class="flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
              <span class="inline-block font-extrabold text-slate-950 text-xs shadow" style="background-color: #c79c5e; padding: 0.35rem 0.85rem; border-radius: 999px; margin-bottom: 0.5rem;">
                {{ $badge }}
              </span>
              <h3 class="font-bold text-base text-white leading-snug" style="word-break: break-word; margin-top: 0.35rem;">{{ $promo->name }}</h3>
            </div>
            <button onclick="togglePromo({{ $promo->id }}, this)" 
                    class="shrink-0 font-bold text-xs transition-all shadow cursor-pointer" 
                    style="padding: 0.4rem 0.85rem; border-radius: 999px; {{ $promo->is_active ? 'background-color: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399;' : 'background-color: rgba(51, 65, 85, 0.5); border: 1px solid rgba(71, 85, 105, 0.5); color: #94a3b8;' }}">
              {{ $promo->is_active ? 'Activa' : 'Inactiva' }}
            </button>
          </div>

          <p class="text-xs leading-relaxed" style="color: #cbd5e1; font-size: 0.825rem; line-height: 1.6;">
            {{ $promo->description ?? 'Sin descripción adicional disponible.' }}
          </p>

          <div class="border-t flex items-center justify-between text-xs text-slate-400" style="border-color: rgba(255,255,255,0.08); padding-top: 1rem; margin-top: 0.5rem;">
            <span class="flex items-center gap-1.5 text-slate-400 font-medium">
              <span class="material-symbols-rounded text-sm" style="color: #c79c5e;">label</span> 
              <span>{{ $appliesText }}</span>
            </span>
          </div>
        </div>
      @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-slate-500">
          <span class="material-symbols-rounded text-5xl mb-2 opacity-40">loyalty</span>
          <p class="text-sm font-medium">No hay promociones registradas actualmente.</p>
        </div>
      @endforelse
    </div>
  </div>
  @endif

  <!-- MODAL 1: Agregar o Crear Platillo del Día -->
  <div id="modal-comida-dia" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-4" style="background-color: rgba(15, 23, 42, 0.75); backdrop-filter: blur(8px);">
    <div class="border shadow-2xl w-full max-w-2xl flex flex-col gap-6" style="background-color: #1e2638; border-color: rgba(255,255,255,0.1); padding: 2rem; border-radius: 2rem;">
      <div class="flex items-center justify-between border-b pb-4" style="border-color: rgba(255,255,255,0.08);">
        <h3 class="text-xl font-bold text-white flex items-center gap-2.5" style="font-family: 'Playfair Display', Georgia, serif;">
          <span class="material-symbols-rounded text-2xl" style="color: #c79c5e;">restaurant</span>
          Agregar / Crear Platillo del Día
        </h3>
        <button onclick="document.getElementById('modal-comida-dia').classList.add('hidden')" class="text-slate-400 hover:text-white transition-colors cursor-pointer">
          <span class="material-symbols-rounded text-2xl">close</span>
        </button>
      </div>

      <form action="{{ route('promotions-meals.daily-meals.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
        @csrf
        
        <!-- Opción 1: Seleccionar Producto Existente -->
        <div class="p-4 rounded-2xl border flex flex-col gap-2" style="background: rgba(15, 23, 42, 0.5); border-color: rgba(199, 156, 94, 0.2);">
          <label class="block text-xs font-bold uppercase tracking-wider" style="color: #c79c5e;">A) Agregar Producto Existente del Catálogo</label>
          <select name="existing_product_id" class="w-full text-white outline-none transition-all appearance-none" style="background: rgba(15, 23, 42, 0.8); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); cursor: pointer;">
            <option value="" style="background: #0f172a; color: white;">-- Seleccionar de la lista de productos del sistema --</option>
            @foreach($products ?? [] as $prod)
              <option value="{{ $prod->id }}" style="background: #0f172a; color: white;">
                {{ $prod->name }} — ${{ number_format($prod->base_price, 2) }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="text-center text-xs font-bold text-slate-400 uppercase tracking-widest">&mdash; o crear platillo nuevo &mdash;</div>

        <!-- Opción 2: Crear Platillo Nuevo con Imagen / URL -->
        <div class="flex items-center gap-4 bg-slate-900/50 p-4 rounded-2xl border border-white/10">
          <div class="w-16 h-16 rounded-2xl bg-slate-800 border border-white/10 flex items-center justify-center text-2xl shrink-0 overflow-hidden shadow-inner">
            🍽️
          </div>
          <div class="flex flex-col gap-2 flex-1 min-w-0">
            <label class="block text-xs font-bold text-slate-400 uppercase">Subir Foto del Platillo</label>
            <input type="file" name="image_file" accept="image/*" class="text-xs text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#c79c5e] file:text-slate-950 hover:file:brightness-110"/>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">o URL de Imagen Externa</label>
          <input type="text" name="image_url" placeholder="https://ejemplo.com/platillo.jpg" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre del Platillo</label>
          <input type="text" name="name" placeholder="Ej. Pechuga Cordon Bleu con Ensalada" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Precio Base ($ MXN)</label>
            <input type="number" name="base_price" step="0.50" min="0" placeholder="Ej. 135.00" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Stock Disponible</label>
            <input type="number" name="stock" value="99" min="1" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Descripción / Incluye</label>
          <textarea name="description" rows="3" placeholder="Ej. Sopa del día + Platillo Fuerte + Arroz/Ensalada" class="w-full text-white outline-none transition-all resize-none" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); min-height: 90px;"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t" style="border-color: rgba(255,255,255,0.08);">
          <button type="button" onclick="document.getElementById('modal-comida-dia').classList.add('hidden')" class="px-5 py-3 rounded-xl text-slate-300 hover:bg-white/5 text-sm font-bold cursor-pointer">Cancelar</button>
          <button type="submit" class="font-bold text-sm shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.85rem 1.5rem; border-radius: 1rem; border: none;">Guardar Platillo</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL 2: Editar Platillo del Día (Con Previsualización de Foto y URL) -->
  <div id="modal-editar-comida-dia" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-4" style="background-color: rgba(15, 23, 42, 0.75); backdrop-filter: blur(8px);">
    <div class="border shadow-2xl w-full max-w-2xl flex flex-col gap-6" style="background-color: #1e2638; border-color: rgba(255,255,255,0.1); padding: 2rem; border-radius: 2rem;">
      <div class="flex items-center justify-between border-b pb-4" style="border-color: rgba(255,255,255,0.08);">
        <h3 class="text-xl font-bold text-white flex items-center gap-2.5" style="font-family: 'Playfair Display', Georgia, serif;">
          <span class="material-symbols-rounded text-2xl" style="color: #c79c5e;">edit_note</span>
          Editar Platillo del Día
        </h3>
        <button onclick="document.getElementById('modal-editar-comida-dia').classList.add('hidden')" class="text-slate-400 hover:text-white transition-colors cursor-pointer">
          <span class="material-symbols-rounded text-2xl">close</span>
        </button>
      </div>

      <form action="{{ route('promotions-meals.daily-meals.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
        @csrf
        <input type="hidden" name="id" id="edit_meal_id"/>

        <!-- Foto Actual / Previsualización / Carga de Archivo -->
        <div class="flex items-center gap-4 bg-slate-900/50 p-4 rounded-2xl border border-white/10">
          <div id="edit_meal_image_preview" class="w-16 h-16 rounded-2xl bg-slate-800 border border-white/10 flex items-center justify-center text-2xl shrink-0 overflow-hidden shadow-inner">
            🍽️
          </div>
          <div class="flex flex-col gap-2 flex-1 min-w-0">
            <label class="block text-xs font-bold text-slate-400 uppercase">Subir Nueva Foto / Imagen</label>
            <input type="file" name="image_file" accept="image/*" class="text-xs text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#c79c5e] file:text-slate-950 hover:file:brightness-110"/>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">o URL de Imagen Externa</label>
          <input type="text" name="image_url" id="edit_meal_image_url" placeholder="https://ejemplo.com/platillo.jpg" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre del Platillo</label>
          <input type="text" name="name" id="edit_meal_name" required class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Precio Base ($ MXN)</label>
            <input type="number" name="base_price" id="edit_meal_price" step="0.50" min="0" required class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Stock Disponible</label>
            <input type="number" name="stock" id="edit_meal_stock" min="0" required class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Descripción / Incluye</label>
          <textarea name="description" id="edit_meal_description" rows="3" class="w-full text-white outline-none transition-all resize-none" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); min-height: 100px;"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t" style="border-color: rgba(255,255,255,0.08);">
          <button type="button" onclick="document.getElementById('modal-editar-comida-dia').classList.add('hidden')" class="px-5 py-3 rounded-xl text-slate-300 hover:bg-white/5 text-sm font-bold cursor-pointer">Cancelar</button>
          <button type="submit" class="font-bold text-sm shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.85rem 1.5rem; border-radius: 1rem; border: none;">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL 3: Crear Promoción -->
  <div id="modal-promocion" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-4" style="background-color: rgba(15, 23, 42, 0.75); backdrop-filter: blur(8px);">
    <div class="border shadow-2xl w-full max-w-2xl flex flex-col gap-6" style="background-color: #1e2638; border-color: rgba(255,255,255,0.1); padding: 2rem; border-radius: 2rem;">
      <div class="flex items-center justify-between border-b pb-4" style="border-color: rgba(255,255,255,0.08);">
        <h3 class="text-xl font-bold text-white flex items-center gap-2.5" style="font-family: 'Playfair Display', Georgia, serif;">
          <span class="material-symbols-rounded text-2xl" style="color: #c79c5e;">loyalty</span>
          Crear Nueva Promoción
        </h3>
        <button onclick="document.getElementById('modal-promocion').classList.add('hidden')" class="text-slate-400 hover:text-white transition-colors cursor-pointer">
          <span class="material-symbols-rounded text-2xl">close</span>
        </button>
      </div>

      <form action="{{ route('promotions-meals.promotions.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre de la Promoción</label>
          <input type="text" name="name" required placeholder="Ej. Descuento de Verano 20%" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Tipo de Descuento</label>
            <select name="discount_type" required class="w-full text-white outline-none transition-all appearance-none" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); cursor: pointer;">
              <option value="percentage" style="background: #0f172a; color: white;">Porcentaje (%)</option>
              <option value="fixed_amount" style="background: #0f172a; color: white;">Monto Fijo ($ MXN)</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Valor del Descuento</label>
            <input type="number" name="discount_value" step="0.01" min="0.01" required placeholder="Ej. 20 o 15.00" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Aplicable a</label>
          <select name="applies_to" id="promo_applies_to" onchange="togglePromoTargetInputs()" class="w-full text-white outline-none transition-all appearance-none" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); cursor: pointer;">
            <option value="all" style="background: #0f172a; color: white;">Todo el Catálogo</option>
            <option value="category" style="background: #0f172a; color: white;">Categoría Específica</option>
            <option value="product" style="background: #0f172a; color: white;">Producto Específico</option>
          </select>
        </div>

        <div id="promo_category_wrapper" class="hidden">
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Seleccionar Categoría</label>
          <select name="category_id" class="w-full text-white outline-none transition-all appearance-none" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); cursor: pointer;">
            @foreach($categories ?? [] as $cat)
              <option value="{{ $cat->id }}" style="background: #0f172a; color: white;">{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>

        <div id="promo_product_wrapper" class="hidden">
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Seleccionar Producto</label>
          <select name="product_id" class="w-full text-white outline-none transition-all appearance-none" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); cursor: pointer;">
            @foreach($products ?? [] as $prod)
              <option value="{{ $prod->id }}" style="background: #0f172a; color: white;">{{ $prod->name }} (${{ number_format($prod->base_price, 2) }})</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Descripción</label>
          <textarea name="description" rows="2" placeholder="Detalles visibles para el personal o clientes" class="w-full text-white outline-none transition-all resize-none" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); min-height: 90px;"></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t" style="border-color: rgba(255,255,255,0.08);">
          <button type="button" onclick="document.getElementById('modal-promocion').classList.add('hidden')" class="px-5 py-3 rounded-xl text-slate-300 hover:bg-white/5 text-sm font-bold cursor-pointer">Cancelar</button>
          <button type="submit" class="font-bold text-sm shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.85rem 1.5rem; border-radius: 1rem; border: none;">Guardar Promoción</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
function abrirModalEditarComida(meal) {
  document.getElementById('edit_meal_id').value = meal.id;
  document.getElementById('edit_meal_name').value = meal.name || '';
  document.getElementById('edit_meal_price').value = meal.base_price || 0;
  document.getElementById('edit_meal_stock').value = meal.stock || 99;
  document.getElementById('edit_meal_description').value = meal.description || '';
  document.getElementById('edit_meal_image_url').value = meal.image_path || '';

  const prev = document.getElementById('edit_meal_image_preview');
  if (meal.image_path) {
    prev.innerHTML = `<img src="${meal.image_path}" class="w-full h-full object-cover"/>`;
  } else {
    prev.innerHTML = '🍽️';
  }

  document.getElementById('modal-editar-comida-dia').classList.remove('hidden');
}

function toggleDailyMeal(id, btn) {
    fetch('/promociones-comidas/daily-meals/' + id + '/toggle', {
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
                btn.style.backgroundColor = 'rgba(16, 185, 129, 0.15)';
                btn.style.borderColor = 'rgba(16, 185, 129, 0.3)';
                btn.style.color = '#34d399';
                btn.textContent = 'Activo';
            } else {
                btn.style.backgroundColor = 'rgba(51, 65, 85, 0.5)';
                btn.style.borderColor = 'rgba(71, 85, 105, 0.5)';
                btn.style.color = '#94a3b8';
                btn.textContent = 'Inactivo';
            }
            if(typeof toast === 'function') toast('Estado del platillo actualizado', 'success');
        }
    });
}

function togglePromo(id, btn) {
    fetch('/promociones-comidas/promotions/' + id + '/toggle', {
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
                btn.style.backgroundColor = 'rgba(16, 185, 129, 0.15)';
                btn.style.borderColor = 'rgba(16, 185, 129, 0.3)';
                btn.style.color = '#34d399';
                btn.textContent = 'Activa';
            } else {
                btn.style.backgroundColor = 'rgba(51, 65, 85, 0.5)';
                btn.style.borderColor = 'rgba(71, 85, 105, 0.5)';
                btn.style.color = '#94a3b8';
                btn.textContent = 'Inactiva';
            }
            if(typeof toast === 'function') toast('Estado de la promoción actualizado', 'success');
        }
    });
}

function togglePromoTargetInputs() {
    const val = document.getElementById('promo_applies_to').value;
    const catWrap = document.getElementById('promo_category_wrapper');
    const prodWrap = document.getElementById('promo_product_wrapper');
    
    if (val === 'category') {
        catWrap.classList.remove('hidden');
        prodWrap.classList.add('hidden');
    } else if (val === 'product') {
        prodWrap.classList.remove('hidden');
        catWrap.classList.add('hidden');
    } else {
        catWrap.classList.add('hidden');
        prodWrap.classList.add('hidden');
    }
}
</script>
@endpush
