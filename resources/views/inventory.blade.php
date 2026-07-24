@extends('layouts.app')

@section('title', 'Cafeteria PETY | Inventario')

@section('content')
@php
    $tab = $tabActiva ?? 'productos';
@endphp

<div class="flex flex-col" style="padding: 1.5rem; gap: 1.5rem;">
  <div class="flex items-center justify-between flex-wrap" style="gap: 1rem;">
    <div>
      <div class="text-2xl font-bold tracking-tight text-white flex items-center gap-2">
        <span class="material-symbols-rounded text-amber-500" style="font-size: 28px;">inventory_2</span>
        Gestión de Inventario
      </div>
      <p class="text-sm text-slate-400 mt-1">Control de stock, insumos, recetas y proveedores.</p>
    </div>
  </div>

  <!-- KPI Row -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4" style="gap: 1.5rem;">
    <!-- KPI 1 -->
    <div class="glass-panel flex items-center shadow-lg" style="padding: 1.5rem; gap: 1rem; border-radius: 1.5rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(199,156,94,0.15);">
        <span class="material-symbols-rounded" style="color: #c79c5e; font-size: 26px;">shopping_bag</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ count($productos) }}</div>
        <div class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wide">Productos en catálogo</div>
      </div>
    </div>
    <!-- KPI 2 -->
    <div class="glass-panel flex items-center shadow-lg" style="padding: 1.5rem; gap: 1rem; border-radius: 1.5rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(16,185,129,0.15);">
        <span class="material-symbols-rounded text-emerald-500" style="font-size: 26px;">category</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ count($ingredientes) }}</div>
        <div class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wide">Ingredientes registrados</div>
      </div>
    </div>
    <!-- KPI 3 -->
    <div class="glass-panel flex items-center shadow-lg" style="padding: 1.5rem; gap: 1rem; border-radius: 1.5rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: {{ $alertasBajoStock > 0 ? 'rgba(255,126,2,0.15)' : 'rgba(16,185,129,0.15)' }};">
        <span class="material-symbols-rounded {{ $alertasBajoStock == 0 ? 'text-emerald-500' : '' }}" style="font-size: 26px; {{ $alertasBajoStock > 0 ? 'color: #FF7E02;' : '' }}">warning</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ $alertasBajoStock }}</div>
        <div class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wide">Alertas de bajo stock</div>
      </div>
    </div>
    <!-- KPI 4 -->
    <div class="glass-panel flex items-center shadow-lg" style="padding: 1.5rem; gap: 1rem; border-radius: 1.5rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(139,92,246,0.15);">
        <span class="material-symbols-rounded text-violet-500" style="font-size: 26px;">menu_book</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ count($recetas) }}</div>
        <div class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wide">Recetas configuradas</div>
      </div>
    </div>
  </div>

  <!-- Subnavegación de Pestañas (Subsecciones) -->
  <div class="flex border-b-2 border-white/10 overflow-x-auto shrink-0 mt-2" style="gap: 0.5rem;">
    <a href="?tab=productos" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'productos' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'productos' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">inventory</span>
      Productos (POS)
    </a>
    <a href="?tab=ingredientes" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'ingredientes' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'ingredientes' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">grocery</span>
      Insumos
    </a>
    <a href="?tab=recetas" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'recetas' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'recetas' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">menu_book</span>
      Recetas
    </a>
    <a href="?tab=movimientos" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'movimientos' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'movimientos' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">tune</span>
      Movimientos
    </a>
    <a href="?tab=conteos" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'conteos' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'conteos' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">fact_check</span>
      Conteos
    </a>
    <a href="?tab=proveedores" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'proveedores' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'proveedores' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">local_shipping</span>
      Proveedores
    </a>
  </div>

  @if($tab == 'productos')
  <!-- =========== TAB: PRODUCTOS =========== -->
  <div class="flex flex-col" style="gap: 1rem;">
    <div class="glass-panel overflow-hidden" style="border-radius: 1.5rem;">
      <div class="flex items-center justify-between" style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
        <h2 class="text-lg font-bold text-white flex items-center gap-2">
          <span class="material-symbols-rounded text-amber-500">list</span>
          Productos Finales (POS)
        </h2>
        <button onclick="document.getElementById('modal-nuevo-producto').classList.remove('hidden')" class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;">
          <span class="material-symbols-rounded" style="font-size: 18px;">add_circle</span>
          <span>Nuevo Producto</span>
        </button>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Producto</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Precio</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Stock disp.</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Categoría</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Estado</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5 text-sm">
            @foreach($productos as $p)
            <tr class="hover:bg-white/5 transition-colors">
              <td style="padding: 1rem 1.5rem;">
                <div class="flex items-center gap-3">
                  @if(!empty($p->image_path))
                    <img src="{{ $p->image_path }}" alt="{{ $p->name }}" class="w-10 h-10 rounded-xl object-cover border border-white/10 shrink-0"/>
                  @else
                    <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-xl shrink-0">
                      {{ $p->emoji ?? '☕' }}
                    </div>
                  @endif
                  <div>
                    <div class="font-bold text-white">{{ $p->name }}</div>
                    @if(!empty($p->image_path))
                      <div class="text-[0.65rem] text-emerald-400 font-semibold">📷 Imagen adjunta</div>
                    @endif
                  </div>
                </div>
              </td>
              <td class="font-bold text-amber-500" style="padding: 1rem 1.5rem;">${{ number_format($p->base_price, 2) }}</td>
              <td class="font-bold text-white" style="padding: 1rem 1.5rem;">{{ $p->stock ?? 0 }} uds.</td>
              <td style="padding: 1rem 1.5rem;">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background-color: rgba(255,255,255,0.05); color: #94a3b8;">
                  {{ $p->category ?? 'General' }}
                </span>
              </td>
              <td style="padding: 1rem 1.5rem;">
                @if($p->is_active)
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background-color: rgba(16,185,129,0.1); color: #10b981;">Activo</span>
                @else
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background-color: rgba(239,68,68,0.1); color: #ef4444;">Inactivo</span>
                @endif
              </td>
              <td style="padding: 1rem 1.5rem;">
                <button onclick="abrirModalEditarProducto({{ json_encode($p) }})" class="font-bold text-xs flex items-center justify-center transition-all hover:bg-amber-500 hover:text-slate-950 cursor-pointer" style="background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.5rem 1rem; border-radius: 0.75rem; gap: 0.5rem;">
                  <span class="material-symbols-rounded" style="font-size: 16px;">edit</span>
                  <span>Editar</span>
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif

  @if($tab == 'ingredientes')
  <!-- =========== TAB: INGREDIENTES =========== -->
  <div class="flex flex-col" style="gap: 1rem;">
    <div class="glass-panel overflow-hidden" style="border-radius: 1.5rem;">
      <div class="flex items-center justify-between" style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
        <h2 class="text-lg font-bold text-white flex items-center gap-2">
          <span class="material-symbols-rounded text-emerald-500">grocery</span>
          Insumos e Ingredientes en Stock
        </h2>
        <button class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;" onclick="toast('Función de Insumo Nueva Próximamente')">
          <span class="material-symbols-rounded" style="font-size: 18px;">add</span>
          <span>Nuevo Insumo</span>
        </button>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Nombre del Insumo</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Categoría</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Stock Actual</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Costo/Ud.</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Alerta</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5 text-sm">
            @foreach($ingredientes as $ing)
            <tr class="hover:bg-white/5 transition-colors">
              <td class="font-bold text-white" style="padding: 1rem 1.5rem;">{{ $ing->Nombre }}</td>
              <td style="padding: 1rem 1.5rem;">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background-color: rgba(199,156,94,0.1); color: #c79c5e;">
                  {{ $ing->Categoria }}
                </span>
              </td>
              <td class="font-medium text-slate-300" style="padding: 1rem 1.5rem;">
                {{ $ing->StockActual }} {{ $ing->UnitAbreviatura }}
              </td>
              <td class="font-medium text-slate-300" style="padding: 1rem 1.5rem;">${{ number_format($ing->PrecioPorUnidad, 2) }}</td>
              <td style="padding: 1rem 1.5rem;">
                @if($ing->AlertaBajoStock)
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background-color: rgba(239,68,68,0.1); color: #ef4444; gap: 0.25rem;">
                    <span class="material-symbols-rounded" style="font-size: 14px;">warning</span> Bajo Stock
                  </span>
                @else
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background-color: rgba(16,185,129,0.1); color: #10b981;">OK</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif

  @if($tab == 'recetas')
  <!-- =========== TAB: RECETAS =========== -->
  <div class="flex flex-col" style="gap: 1rem;">
    <div class="flex items-center justify-between">
      <h2 class="text-lg font-bold text-white flex items-center gap-2">
        <span class="material-symbols-rounded text-violet-500">menu_book</span>
        Recetas Configuradas
      </h2>
      <button class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;" onclick="toast('Función Próximamente')">
        <span class="material-symbols-rounded" style="font-size: 18px;">add</span>
        <span>Nueva Receta</span>
      </button>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3" style="gap: 1.5rem;">
      @foreach($recetas as $rec)
      <div class="glass-panel flex flex-col" style="padding: 1.5rem; border-radius: 1.5rem; gap: 1rem;">
        <div class="flex items-center justify-between border-b border-white/5 pb-3">
          <div class="flex items-center gap-3">
            <span class="text-3xl">{{ $rec->Emoji }}</span>
            <div class="font-bold text-white text-lg">{{ $rec->Nombre }}</div>
          </div>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background-color: rgba(199,156,94,0.1); color: #c79c5e;">{{ $rec->Porciones }} porciones</span>
        </div>
        
        <div class="flex items-center justify-between bg-slate-900/50 rounded-xl" style="padding: 0.75rem 1rem;">
          <div class="text-xs font-semibold text-slate-400 uppercase">Costo Receta</div>
          <div class="text-sm font-bold text-emerald-400">${{ number_format($rec->CostoEstimado, 2) }}</div>
        </div>

        <div class="flex flex-col gap-2">
          <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Desglose de Insumos</div>
          @foreach($rec->Ingredientes as $ri)
          <div class="flex items-center justify-between text-sm">
            <span class="text-slate-300">{{ $ri->IngredienteNombre }}</span>
            <span class="font-bold text-white">{{ $ri->Cantidad }} {{ $ri->Unidad }}</span>
          </div>
          <div class="border-b border-white/5 w-full h-px"></div>
          @endforeach
        </div>

        <button class="mt-auto border border-white/10 rounded-xl font-bold text-sm text-slate-300 hover:bg-white/5 transition-colors flex items-center justify-center" style="padding: 0.6rem; gap: 0.5rem;" onclick="toast('Función Editar Próximamente')">
          <span class="material-symbols-rounded" style="font-size: 18px;">edit</span>
          Editar Receta
        </button>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  @if($tab == 'movimientos')
  <!-- =========== TAB: MOVIMIENTOS =========== -->
  <div class="flex flex-col" style="gap: 1rem;">
    <div class="glass-panel overflow-hidden" style="border-radius: 1.5rem;">
      <div class="flex items-center justify-between" style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
        <h2 class="text-lg font-bold text-white flex items-center gap-2">
          <span class="material-symbols-rounded text-sky-500">tune</span>
          Historial de Movimientos
        </h2>
        <button class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;" onclick="abrirModalMovimiento()">
          <span class="material-symbols-rounded" style="font-size: 18px;">add</span>
          <span>Registrar Movimiento</span>
        </button>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Tipo</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Ingrediente</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Cantidad</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Motivo</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Usuario / Fecha</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5 text-sm">
            @foreach($movimientos as $mv)
            <tr class="hover:bg-white/5 transition-colors">
              <td style="padding: 1rem 1.5rem;">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold gap-1" style="background-color: {{ $mv->ColorTipo }}20; color: {{ $mv->ColorTipo }};">
                  <span class="material-symbols-rounded" style="font-size: 14px;">{{ $mv->IconTipo }}</span>
                  {{ $mv->Tipo }}
                </span>
              </td>
              <td class="font-bold text-white" style="padding: 1rem 1.5rem;">{{ $mv->IngredienteNombre }}</td>
              <td class="font-bold" style="padding: 1rem 1.5rem; color: {{ $mv->ColorTipo }};">
                {{ $mv->Cantidad > 0 ? '+' : '' }}{{ $mv->Cantidad }} {{ $mv->Unidad }}
              </td>
              <td class="text-slate-400" style="padding: 1rem 1.5rem;">{{ $mv->Motivo }}</td>
              <td style="padding: 1rem 1.5rem;">
                <div class="text-white font-semibold">{{ $mv->UsuarioNombre }}</div>
                <div class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($mv->Fecha)->format('d/m/Y H:i') }}</div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif

  @if($tab == 'conteos')
  <!-- =========== TAB: CONTEOS =========== -->
  <div class="flex flex-col" style="gap: 1rem;">
    <div class="glass-panel overflow-hidden" style="border-radius: 1.5rem;">
      <div class="flex items-center justify-between" style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
        <h2 class="text-lg font-bold text-white flex items-center gap-2">
          <span class="material-symbols-rounded text-fuchsia-500">fact_check</span>
          Conteos Físicos
        </h2>
        <button class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;" onclick="toast('Nuevo conteo iniciado', 'success')">
          <span class="material-symbols-rounded" style="font-size: 18px;">add</span>
          <span>Nuevo Conteo</span>
        </button>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Nombre del Conteo</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Estado</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Responsable</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Progreso</th>
              <th class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-900/50" style="padding: 1rem 1.5rem;">Fecha</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5 text-sm">
            @foreach($conteos as $cnt)
            <tr class="hover:bg-white/5 transition-colors">
              <td class="font-bold text-white" style="padding: 1rem 1.5rem;">{{ $cnt->Nombre }}</td>
              <td style="padding: 1rem 1.5rem;">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold gap-1" style="background-color: {{ $cnt->ColorEstado }}20; color: {{ $cnt->ColorEstado }};">
                  {{ $cnt->Estado }}
                </span>
              </td>
              <td class="text-slate-300 font-medium" style="padding: 1rem 1.5rem;">{{ $cnt->UsuarioNombre }}</td>
              <td style="padding: 1rem 1.5rem; min-width: 200px;">
                <div class="flex items-center gap-3">
                  <div class="flex-1 h-2 rounded-full bg-slate-800 overflow-hidden">
                    <div class="h-full rounded-full transition-all" style="width: {{ $cnt->Progreso }}%; background-color: {{ $cnt->ColorEstado }};"></div>
                  </div>
                  <span class="text-xs font-bold text-slate-400">{{ $cnt->ItemsContados }}/{{ $cnt->TotalItems }}</span>
                </div>
              </td>
              <td class="text-slate-400" style="padding: 1rem 1.5rem;">{{ \Carbon\Carbon::parse($cnt->Fecha)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif

  @if($tab == 'proveedores')
  <!-- =========== TAB: PROVEEDORES =========== -->
  <div class="flex flex-col" style="gap: 1rem;">
    <div class="flex items-center justify-between">
      <h2 class="text-lg font-bold text-white flex items-center gap-2">
        <span class="material-symbols-rounded text-rose-500">local_shipping</span>
        Proveedores
      </h2>
      <button class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;" onclick="toast('Función Próximamente')">
        <span class="material-symbols-rounded" style="font-size: 18px;">add</span>
        <span>Nuevo Proveedor</span>
      </button>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3" style="gap: 1.5rem;">
      @foreach($proveedores as $sup)
      <div class="glass-panel flex items-start" style="padding: 1.5rem; border-radius: 1.5rem; gap: 1.25rem; {{ !$sup->Activo ? 'opacity: 0.6; filter: grayscale(1);' : '' }}">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 text-xl font-bold text-slate-950" style="background-color: {{ $sup->Activo ? '#c79c5e' : '#94a3b8' }};">
          {{ substr($sup->Nombre, 0, 1) }}
        </div>
        <div class="flex-1 min-w-0">
          <div class="font-bold text-white text-lg truncate">{{ $sup->Nombre }}</div>
          <div class="text-sm text-slate-400 mt-1">{{ $sup->Contacto }} &mdash; {{ $sup->Ciudad }}</div>
          
          <div class="mt-4 flex flex-col gap-2 text-sm text-slate-300">
            <div class="flex items-center gap-2">
              <span class="material-symbols-rounded text-slate-500" style="font-size: 16px;">call</span>
              {{ $sup->Telefono }}
            </div>
            <div class="flex items-center gap-2">
              <span class="material-symbols-rounded text-slate-500" style="font-size: 16px;">mail</span>
              {{ $sup->Email }}
            </div>
          </div>

          <div class="mt-5 flex items-center gap-3">
            @if($sup->Activo)
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background-color: rgba(16,185,129,0.1); color: #10b981;">Activo</span>
            @else
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background-color: rgba(148,163,184,0.1); color: #94a3b8;">Inactivo</span>
            @endif
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" style="background-color: rgba(59,130,246,0.1); color: #3b82f6;">{{ $sup->IngredientesProveidos }} insumos</span>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif
</div>

<!-- ===== MODAL: REGISTRAR MOVIMIENTO ===== -->
<div id="modal-movimiento" class="fixed inset-0 z-[9999] flex items-center justify-center hidden">
  <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
  <div class="bg-slate-900 border border-white/10 rounded-3xl w-full relative shadow-2xl overflow-hidden flex flex-col" id="modal-movimiento-content" style="max-width: 28rem; background: linear-gradient(180deg, #101725 0%, #0a0f18 100%); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7), 0 0 0 1px rgba(199,156,94,0.1) inset;">
    
    <div class="border-b border-white/5 flex items-center justify-between" style="padding: 1.25rem 1.5rem;">
      <div class="flex items-center" style="gap: 0.75rem;">
        <div class="rounded-full flex items-center justify-center" style="width: 2.75rem; height: 2.75rem; background-color: rgba(199,156,94,0.15);">
          <span class="material-symbols-rounded text-amber-500">tune</span>
        </div>
        <h3 class="text-lg font-bold text-white tracking-wide">Registrar Movimiento</h3>
      </div>
      <button onclick="cerrarModalMovimiento()" class="text-slate-400 hover:text-white transition-colors bg-white/5 border border-white/10 rounded-full flex items-center justify-center hover:bg-white/10" style="width: 2.25rem; height: 2.25rem;">
        <span class="material-symbols-rounded" style="font-size: 18px;">close</span>
      </button>
    </div>

    <form class="flex flex-col" style="padding: 1.5rem; gap: 1.25rem;" onsubmit="event.preventDefault(); guardarMovimiento();">
      
      <!-- Tipo -->
      <div class="flex flex-col" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tipo de Movimiento</label>
        <select class="w-full text-white outline-none transition-all appearance-none" required style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
          <option value="purchase" class="text-slate-900">Compra (purchase)</option>
          <option value="waste" class="text-slate-900">Merma/Desperdicio (waste)</option>
          <option value="adjustment" class="text-slate-900">Ajuste Físico (adjustment)</option>
        </select>
      </div>

      <!-- Ingrediente -->
      <div class="flex flex-col" style="gap: 0.35rem;">
        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ingrediente</label>
        <select class="w-full text-white outline-none transition-all appearance-none" required style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
          @foreach($ingredientes as $ing)
            <option value="{{ $ing->Id }}" class="text-slate-900">{{ $ing->Nombre }} ({{ $ing->StockActual }} {{ $ing->UnitAbreviatura }})</option>
          @endforeach
        </select>
      </div>

      <!-- Cantidad & Motivo -->
      <div class="flex items-start" style="gap: 1rem;">
        <div class="flex flex-col flex-1" style="gap: 0.35rem;">
          <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Cantidad</label>
          <input type="number" step="0.01" class="w-full text-white outline-none transition-all" required placeholder="Ej: 10.0" style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
        </div>
        <div class="flex flex-col flex-[2]" style="gap: 0.35rem;">
          <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Motivo</label>
          <input type="text" class="w-full text-white outline-none transition-all" required placeholder="Justificación" style="background: rgba(15, 23, 42, 0.5); padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.08);">
        </div>
      </div>

      <div class="flex items-center justify-end mt-2 pt-4 border-t border-white/5" style="gap: 0.75rem;">
        <button type="button" onclick="cerrarModalMovimiento()" class="font-bold text-slate-300 hover:text-white transition-colors border border-white/10 rounded-xl hover:bg-white/5" style="padding: 0.75rem 1.5rem;">
          Cancelar
        </button>
        <button type="submit" class="font-bold text-slate-950 transition-all rounded-xl flex items-center justify-center hover:brightness-110" style="background-color: #c79c5e; padding: 0.75rem 1.5rem; gap: 0.5rem; box-shadow: 0 4px 15px rgba(199,156,94,0.2);">
          <span class="material-symbols-rounded" style="font-size: 20px;">save</span>
          Registrar
        </button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDITAR PRODUCTO -->
<div id="modal-editar-producto" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-4" style="background-color: rgba(15, 23, 42, 0.75); backdrop-filter: blur(8px);">
  <div class="border shadow-2xl w-full max-w-2xl flex flex-col gap-6" style="background-color: #1e2638; border-color: rgba(255,255,255,0.1); padding: 2rem; border-radius: 2rem;">
    <div class="flex items-center justify-between border-b pb-4" style="border-color: rgba(255,255,255,0.08);">
      <h3 class="text-xl font-bold text-white flex items-center gap-2.5" style="font-family: 'Playfair Display', Georgia, serif;">
        <span class="material-symbols-rounded text-2xl" style="color: #c79c5e;">edit_note</span>
        Editar Producto &amp; Imagen
      </h3>
      <button type="button" onclick="document.getElementById('modal-editar-producto').classList.add('hidden')" class="text-slate-400 hover:text-white transition-colors cursor-pointer">
        <span class="material-symbols-rounded text-2xl">close</span>
      </button>
    </div>

    <form action="{{ route('inventory.products.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
      @csrf
      <input type="hidden" name="id" id="edit_product_id"/>

      <!-- Imagen Preview / URL / File -->
      <div class="flex items-center gap-4 bg-slate-900/50 p-4 rounded-2xl border border-white/10">
        <div id="edit_product_image_preview" class="w-16 h-16 rounded-2xl bg-slate-800 border border-white/10 flex items-center justify-center text-2xl overflow-hidden shrink-0 shadow-inner">
          ☕
        </div>
        <div class="flex flex-col gap-2 flex-1 min-w-0">
          <label class="block text-xs font-bold text-slate-400 uppercase">Subir Nueva Foto / Imagen</label>
          <input type="file" name="image_file" accept="image/*" class="text-xs text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#c79c5e] file:text-slate-950 hover:file:brightness-110"/>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">o URL de Imagen Externa</label>
        <input type="text" name="image_url" id="edit_product_image_url" placeholder="https://ejemplo.com/imagen.jpg" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre del Producto</label>
        <input type="text" name="name" id="edit_product_name" required class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Precio Base ($ MXN)</label>
          <input type="number" name="base_price" id="edit_product_price" step="0.50" min="0" required class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Stock Disponible</label>
          <input type="number" name="stock" id="edit_product_stock" min="0" required class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Descripción / Ingredientes</label>
        <textarea name="description" id="edit_product_description" rows="3" class="w-full text-white outline-none transition-all resize-none" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); min-height: 90px;"></textarea>
      </div>

      <div class="flex items-center gap-2 pt-1">
        <input type="checkbox" name="is_active" id="edit_product_active" value="1" class="w-4 h-4 accent-[#c79c5e] cursor-pointer"/>
        <label for="edit_product_active" class="text-xs font-bold text-slate-300 cursor-pointer">Producto Activo en el POS</label>
      </div>

      <div class="flex items-center justify-end gap-3" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 1rem;">
        <button type="button" onclick="document.getElementById('modal-editar-producto').classList.add('hidden')" class="px-5 py-3 rounded-xl text-slate-300 hover:bg-white/5 text-sm font-bold cursor-pointer">Cancelar</button>
        <button type="submit" class="font-bold text-sm shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.85rem 1.5rem; border-radius: 1rem; border: none;">Guardar Cambios</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL NUEVO PRODUCTO -->
<div id="modal-nuevo-producto" class="hidden fixed inset-0 z-[9999] flex items-center justify-center p-4" style="background-color: rgba(15, 23, 42, 0.75); backdrop-filter: blur(8px);">
  <div class="border shadow-2xl w-full max-w-2xl flex flex-col gap-6" style="background-color: #1e2638; border-color: rgba(255,255,255,0.1); padding: 2rem; border-radius: 2rem;">
    <div class="flex items-center justify-between border-b pb-4" style="border-color: rgba(255,255,255,0.08);">
      <h3 class="text-xl font-bold text-white flex items-center gap-2.5" style="font-family: 'Playfair Display', Georgia, serif;">
        <span class="material-symbols-rounded text-2xl" style="color: #c79c5e;">add_circle</span>
        Nuevo Producto
      </h3>
      <button type="button" onclick="document.getElementById('modal-nuevo-producto').classList.add('hidden')" class="text-slate-400 hover:text-white transition-colors cursor-pointer">
        <span class="material-symbols-rounded text-2xl">close</span>
      </button>
    </div>

    <form action="{{ route('inventory.products.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
      @csrf
      
      <div class="flex items-center gap-4 bg-slate-900/50 p-4 rounded-2xl border border-white/10">
        <div class="w-16 h-16 rounded-2xl bg-slate-800 border border-white/10 flex items-center justify-center text-2xl shrink-0 overflow-hidden shadow-inner">
          ☕
        </div>
        <div class="flex flex-col gap-2 flex-1 min-w-0">
          <label class="block text-xs font-bold text-slate-400 uppercase">Subir Imagen / Foto del Producto</label>
          <input type="file" name="image_file" accept="image/*" class="text-xs text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#c79c5e] file:text-slate-950 hover:file:brightness-110"/>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">o URL de Imagen Externa</label>
        <input type="text" name="image_url" placeholder="https://ejemplo.com/imagen.jpg" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre del Producto</label>
        <input type="text" name="name" required placeholder="Ej. Frappé Moka Especial" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Precio Base ($ MXN)</label>
          <input type="number" name="base_price" step="0.50" min="0" required placeholder="Ej. 65.00" class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Stock Inicial</label>
          <input type="number" name="stock" value="50" min="0" required class="w-full text-white outline-none transition-all" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"/>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Descripción</label>
        <textarea name="description" rows="3" placeholder="Detalles de preparación o alérgenos" class="w-full text-white outline-none transition-all resize-none" style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); min-height: 90px;"></textarea>
      </div>

      <div class="flex items-center justify-end gap-3" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 1rem;">
        <button type="button" onclick="document.getElementById('modal-nuevo-producto').classList.add('hidden')" class="px-5 py-3 rounded-xl text-slate-300 hover:bg-white/5 text-sm font-bold cursor-pointer">Cancelar</button>
        <button type="submit" class="font-bold text-sm shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.85rem 1.5rem; border-radius: 1rem; border: none;">Crear Producto</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
function abrirModalEditarProducto(p) {
  document.getElementById('edit_product_id').value = p.id;
  document.getElementById('edit_product_name').value = p.name || '';
  document.getElementById('edit_product_price').value = p.base_price || 0;
  document.getElementById('edit_product_stock').value = p.stock || 0;
  document.getElementById('edit_product_emoji').value = p.emoji || '☕';
  document.getElementById('edit_product_description').value = p.description || '';
  document.getElementById('edit_product_image_url').value = p.image_path || '';
  document.getElementById('edit_product_active').checked = p.is_active ? true : false;

  const prev = document.getElementById('edit_product_image_preview');
  if (p.image_path) {
    prev.innerHTML = `<img src="${p.image_path}" class="w-full h-full object-cover"/>`;
  } else {
    prev.innerHTML = p.emoji || '☕';
  }

  document.getElementById('modal-editar-producto').classList.remove('hidden');
}

function abrirModalMovimiento() {
  const modal = document.getElementById('modal-movimiento');
  const content = document.getElementById('modal-movimiento-content');
  
  modal.classList.remove('hidden', 'modal-exit');
  content.classList.remove('modal-exit-content');
  modal.classList.add('modal-enter');
  content.classList.add('modal-enter-content');
}

function cerrarModalMovimiento() {
  const modal = document.getElementById('modal-movimiento');
  const content = document.getElementById('modal-movimiento-content');
  
  modal.classList.remove('modal-enter');
  content.classList.remove('modal-enter-content');
  modal.classList.add('modal-enter');
  content.classList.add('modal-exit-content');
  
  setTimeout(() => {
    modal.classList.add('hidden');
  }, 180);
}

function guardarMovimiento() {
  cerrarModalMovimiento();
  toast('Movimiento registrado en base de datos (Simulado)', 'success');
}
</script>
@endpush
