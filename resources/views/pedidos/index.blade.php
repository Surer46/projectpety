@extends('layouts.app')

@section('title', 'Cafeteria PETY | Mis Pedidos Activos')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-8 pb-12" style="padding: 1.5rem;">

  <!-- Header Principal -->
  <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 border-b border-white/10 pb-6">
    <div class="flex flex-col gap-1.5">
      <h1 class="text-3xl font-bold text-white flex items-center gap-3" style="font-family: 'Playfair Display', Georgia, serif; line-height: 1.2;">
        <span class="material-symbols-rounded text-3xl" style="color: #c79c5e;">radar</span>
        Mis Pedidos <span class="italic font-normal" style="color: #c79c5e;">en Tiempo Real</span>
      </h1>
      <p class="text-slate-400 text-sm max-w-3xl leading-relaxed">
        Sigue el estado en vivo de tus pedidos en preparación por nuestros baristas o en ruta de reparto a domicilio.
      </p>
    </div>

    <!-- Indicador de En vivo -->
    <div class="flex items-center shrink-0" style="background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255,255,255,0.1); padding: 0.75rem 1.25rem; border-radius: 1rem; gap: 0.75rem;">
      <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
      <span class="text-xs font-bold text-slate-300">Rastreador en vivo activo</span>
    </div>
  </div>

  <!-- KPI Row -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <!-- Active Total -->
    <div class="flex items-center shadow-2xl" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); border-radius: 1.75rem; padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(199,156,94,0.15);">
        <span class="material-symbols-rounded" style="color: #c79c5e; font-size: 26px;">bolt</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ $stats->total_active }}</div>
        <div class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">Pedidos Activos</div>
      </div>
    </div>
    <!-- In Prep -->
    <div class="flex items-center shadow-2xl" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); border-radius: 1.75rem; padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(245,158,11,0.15);">
        <span class="material-symbols-rounded text-amber-500" style="font-size: 26px;">soup_kitchen</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ $stats->in_preparation }}</div>
        <div class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">En Preparación</div>
      </div>
    </div>
    <!-- Delivery -->
    <div class="flex items-center shadow-2xl" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); border-radius: 1.75rem; padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(59,130,246,0.15);">
        <span class="material-symbols-rounded text-blue-500" style="font-size: 26px;">two_wheeler</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ $stats->on_delivery }}</div>
        <div class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">En Reparto</div>
      </div>
    </div>
    <!-- Ready -->
    <div class="flex items-center shadow-2xl" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); border-radius: 1.75rem; padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(16,185,129,0.15);">
        <span class="material-symbols-rounded text-emerald-500" style="font-size: 26px;">check_circle</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ $stats->ready }}</div>
        <div class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">Listos para Entrega</div>
      </div>
    </div>
  </div>

  <!-- Subnavegación de Subsecciones (Pestañas) conforme a AGENTS.md -->
  <div class="flex border-b-2 border-white/10 overflow-x-auto shrink-0 mt-2" style="gap: 0.5rem;">
    <a href="?tab=activos" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'activos' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'activos' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">view_list</span>
      Todos los Pedidos Activos ({{ $stats->total_active }})
    </a>
    <a href="?tab=preparacion" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'preparacion' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'preparacion' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">soup_kitchen</span>
      En Preparación ({{ $stats->in_preparation }})
    </a>
    <a href="?tab=reparto" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'reparto' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'reparto' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">two_wheeler</span>
      A Domicilio en Reparto ({{ $stats->on_delivery }})
    </a>
  </div>

  <!-- Lista de Tarjetas de Pedidos Activos -->
  <div class="flex flex-col gap-6">
    @forelse($filteredOrders as $ord)
    <div class="flex flex-col gap-6 border shadow-2xl transition-all hover:border-white/20" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 2rem; border-radius: 2.5rem;">
      
      <!-- Top Header de la Tarjeta -->
      <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-white/10 pb-5">
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-slate-950 font-bold shadow-lg shrink-0" style="background-color: #c79c5e;">
            <span class="material-symbols-rounded text-2xl">{{ $ord->type_icon }}</span>
          </div>
          <div>
            <div class="flex items-center flex-wrap gap-3">
              <span class="text-xl font-bold text-white">{{ $ord->order_number }}</span>
              <span class="text-xs font-bold uppercase tracking-wider whitespace-nowrap" style="background-color: rgba(255,255,255,0.05); color: #94a3b8; border: 1px solid rgba(255,255,255,0.1); padding: 0.4rem 0.85rem; border-radius: 9999px;">
                {{ $ord->type_label }}
              </span>
            </div>
            <div class="text-xs text-slate-400 flex items-center gap-3" style="margin-top: 0.65rem;">
              <span>🕒 Solicitado: <strong class="text-white">{{ $ord->created_at }}</strong></span>
              @if($ord->table_name)
                <span>• 📍 Ubicación: <strong class="text-amber-400">{{ $ord->table_name }}</strong></span>
              @endif
            </div>
          </div>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <span class="inline-flex items-center text-xs font-bold gap-2 shadow-inner whitespace-nowrap" style="background-color: {{ $ord->status_color }}20; color: {{ $ord->status_color }}; border: 1px solid {{ $ord->status_color }}40; padding: 0.5rem 1rem; border-radius: 1rem;">
            <span class="w-2 h-2 rounded-full animate-pulse" style="background-color: {{ $ord->status_color }};"></span>
            {{ $ord->status_label }}
          </span>
          <span class="text-lg font-bold text-amber-400 ml-2">${{ number_format($ord->total_amount, 2) }}</span>
        </div>
      </div>

      <!-- Barra de Progreso del Pedido (Timeline) -->
      <div class="flex flex-col" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255,255,255,0.08); padding: 1.25rem; border-radius: 1.25rem; gap: 0.75rem;">
        <div class="flex items-center justify-between text-xs font-bold text-slate-400 mb-1">
          <span class="uppercase tracking-wider flex items-center gap-2">
            <span class="material-symbols-rounded text-sm text-amber-500">sync</span>
            Progreso del Pedido
          </span>
          <span class="text-amber-400 font-bold">{{ $ord->progress_percentage }}% Completado</span>
        </div>

        <div class="w-full bg-slate-800 h-3 rounded-full overflow-hidden p-0.5 border border-white/5">
          <div class="h-full rounded-full transition-all duration-700" style="width: {{ $ord->progress_percentage }}%; background: linear-gradient(90deg, #c79c5e 0%, #10b981 100%);"></div>
        </div>

        <!-- Pasos visuales del timeline -->
        <div class="grid grid-cols-4 text-center text-[0.7rem] font-bold pt-3 text-slate-400">
          <div class="{{ $ord->progress_percentage >= 20 ? 'text-amber-400' : '' }}">1. Confirmado</div>
          <div class="{{ $ord->progress_percentage >= 55 ? 'text-amber-400' : '' }}">2. En Cocina</div>
          <div class="{{ $ord->progress_percentage >= 80 ? 'text-emerald-400' : '' }}">
            {{ $ord->order_type == 'delivery' ? '3. En Ruta' : '3. Embalado' }}
          </div>
          <div class="{{ $ord->progress_percentage >= 100 ? 'text-emerald-400' : '' }}">4. Entregado</div>
        </div>
      </div>

      <!-- Detalles Específicos de Reparto o Mesa -->
      @if($ord->order_type == 'delivery' && $ord->driver_name)
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Tarjeta del Repartidor -->
        <div class="flex items-center justify-between" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); padding: 1.25rem; border-radius: 1.25rem; gap: 1rem;">
          <div class="flex items-center gap-3.5 min-w-0">
            <div class="w-12 h-12 rounded-2xl bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0">
              <span class="material-symbols-rounded text-2xl">sports_motorsports</span>
            </div>
            <div class="flex-1 min-w-0">
              <div class="text-xs font-bold text-blue-400 uppercase tracking-wider">Repartidor Asignado</div>
              <div class="font-bold text-white text-base truncate">{{ $ord->driver_name }}</div>
              <div class="text-xs text-slate-300 mt-0.5 truncate">{{ $ord->driver_vehicle }}</div>
            </div>
          </div>
          <a href="tel:{{ $ord->driver_phone }}" class="font-bold text-xs flex items-center gap-1.5 transition-all hover:brightness-110 shrink-0 cursor-pointer whitespace-nowrap shadow-md" style="background-color: #3b82f6; color: #0a0f18; padding: 0.6rem 1.25rem; border-radius: 0.75rem; border: none;">
            <span class="material-symbols-rounded text-sm">call</span>
            <span>Llamar</span>
          </a>
        </div>

        <!-- Dirección de Entrega & Tiempo -->
        <div class="flex items-center" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.08); padding: 1.25rem; border-radius: 1.25rem; gap: 1rem;">
          <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center shrink-0">
            <span class="material-symbols-rounded text-2xl">distance</span>
          </div>
          <div class="flex-1 min-w-0">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dirección de Entrega</div>
            <div class="font-bold text-white text-xs truncate">{{ $ord->delivery_address }}</div>
            <div class="text-xs text-emerald-400 font-bold mt-1">⏱ LLegada estimada: ~{{ $ord->estimated_minutes }} mins</div>
          </div>
        </div>
      </div>
      @endif

      <!-- Items del Pedido -->
      <div class="flex flex-col gap-3">
        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Productos en este pedido</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          @foreach($ord->items as $item)
          <div class="flex items-center gap-3" style="background: rgba(15, 23, 42, 0.4); border: 1px solid rgba(255,255,255,0.05); padding: 0.85rem 1.15rem; border-radius: 1rem;">
            <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-lg shrink-0">
              ☕
            </div>
            <div class="flex-1 min-w-0">
              <div class="font-bold text-white text-xs truncate">{{ $item->product_name }}</div>
              <div class="text-xs text-slate-400 mt-0.5">Cant: <strong class="text-amber-400">{{ $item->quantity }}</strong> • ${{ number_format($item->unit_price, 2) }} c/u</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Acciones Inferiores conforme a AGENTS.md (separación de 20px) -->
      <div class="flex items-center justify-between flex-wrap gap-4" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 1rem;">
        <span class="text-xs text-slate-400">¿Dudas con tu pedido? Ponte en contacto con nuestra central de atención.</span>
        <div class="flex items-center gap-3">
          <a href="{{ route('atencion-cliente') }}" class="text-slate-300 hover:bg-white/5 text-xs font-bold flex items-center gap-2 transition-colors" style="border: 1px solid rgba(255,255,255,0.1); padding: 0.75rem 1.25rem; border-radius: 1rem;">
            <span class="material-symbols-rounded text-sm">support_agent</span>
            <span>Soporte en Vivo</span>
          </a>
          <button onclick="avanzarEstadoPedido({{ $ord->id }})" class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;">
            <span class="material-symbols-rounded text-sm">refresh</span>
            <span>Avanzar / Actualizar Estado</span>
          </button>
        </div>
      </div>

    </div>
    @empty
    <div class="flex flex-col items-center justify-center p-12 text-center rounded-[2.5rem] border shadow-2xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08);">
      <div class="w-20 h-20 rounded-full bg-slate-900 flex items-center justify-center text-4xl mb-4 border border-white/10">
        🍽️
      </div>
      <h3 class="text-xl font-bold text-white">No tienes pedidos activos en este momento</h3>
      <p class="text-slate-400 text-sm max-w-md mt-2">
        Todos tus pedidos anteriores han sido entregados. Explora nuestro menú para realizar una nueva orden.
      </p>
      <a href="{{ route('pos') }}" class="mt-6 font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.85rem 1.75rem; border-radius: 1rem; border: none;">
        <span class="material-symbols-rounded text-base">restaurant_menu</span>
        <span>Ver Menú & Ordenar</span>
      </a>
    </div>
    @endforelse
  </div>

</div>

@push('scripts')
<script>
function avanzarEstadoPedido(orderId) {
    fetch('/mis-pedidos/' + orderId + '/update-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message || 'Error al actualizar');
        }
    })
    .catch(err => {
        alert('Error al conectar con la cocina');
    });
}
</script>
@endpush
@endsection
