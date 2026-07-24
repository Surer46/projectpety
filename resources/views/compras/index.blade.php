@extends('layouts.app')

@section('title', 'Cafeteria PETY | Mis Compras & Historial')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-8 pb-12" style="padding: 1.5rem;">

  <!-- Header Principal -->
  <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 border-b border-white/10 pb-6">
    <div class="flex flex-col gap-1.5">
      <h1 class="text-3xl font-bold text-white flex items-center gap-3" style="font-family: 'Playfair Display', Georgia, serif; line-height: 1.2;">
        <span class="material-symbols-rounded text-3xl" style="color: #c79c5e;">history_edu</span>
        Mis Compras <span class="italic font-normal" style="color: #c79c5e;">e Historial</span>
      </h1>
      <p class="text-slate-400 text-sm max-w-3xl leading-relaxed">
        Consulta el registro histórico de todas tus compras finalizadas, descarga tus comprobantes de facturación o repite tus pedidos favoritos.
      </p>
    </div>

    <!-- Buscador Integrado de Compras -->
    <form action="{{ route('compras.index') }}" method="GET" class="flex items-center gap-3 shrink-0">
      <input type="hidden" name="tab" value="{{ $tab }}"/>
      <input type="text" name="search" value="{{ $search }}" placeholder="Buscar ticket u producto..." class="text-white outline-none transition-all text-xs" style="background: rgba(15, 23, 42, 0.6); padding: 0.75rem 1.25rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.1); width: 16rem;"/>
      <button type="submit" class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap" style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.25rem; border-radius: 0.75rem; border: none;">
        <span class="material-symbols-rounded text-base">search</span>
        <span>Buscar</span>
      </button>
    </form>
  </div>

  <!-- KPI Row -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <!-- Total Invertido -->
    <div class="flex items-center shadow-2xl" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); border-radius: 1.75rem; padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(199,156,94,0.15);">
        <span class="material-symbols-rounded" style="color: #c79c5e; font-size: 26px;">payments</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">${{ number_format($stats->total_spent, 2) }}</div>
        <div class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">Total Invertido</div>
      </div>
    </div>
    <!-- Compras Realizadas -->
    <div class="flex items-center shadow-2xl" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); border-radius: 1.75rem; padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(16,185,129,0.15);">
        <span class="material-symbols-rounded text-emerald-500" style="font-size: 26px;">receipt_long</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ $stats->total_orders }}</div>
        <div class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">Compras Realizadas</div>
      </div>
    </div>
    <!-- Puntos Acumulados -->
    <div class="flex items-center shadow-2xl" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); border-radius: 1.75rem; padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(245,158,11,0.15);">
        <span class="material-symbols-rounded text-amber-500" style="font-size: 26px;">stars</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">+{{ $stats->points_earned }} pts</div>
        <div class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">Puntos Generados</div>
      </div>
    </div>
    <!-- Platillo Favorito -->
    <div class="flex items-center shadow-2xl" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); border-radius: 1.75rem; padding: 1.25rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(139,92,246,0.15);">
        <span class="material-symbols-rounded text-purple-400" style="font-size: 26px;">favorite</span>
      </div>
      <div class="min-w-0">
        <div class="text-sm font-bold text-white leading-tight truncate">{{ $stats->favorite_item }}</div>
        <div class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">Favorito Frecuente</div>
      </div>
    </div>
  </div>

  <!-- Subnavegación de Pestañas conforme a AGENTS.md -->
  <div class="flex border-b-2 border-white/10 overflow-x-auto shrink-0 mt-2" style="gap: 0.5rem;">
    <a href="?tab=todas" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'todas' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'todas' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">history</span>
      Todas las Compras ({{ count($history) }})
    </a>
    <a href="?tab=completadas" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'completadas' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'completadas' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">verified</span>
      Compras Exitosas
    </a>
    <a href="?tab=facturadas" class="flex items-center border-b-2 font-medium transition-colors {{ $tab == 'facturadas' ? 'font-bold' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} rounded-t-lg" style="padding: 0.75rem 1.25rem; gap: 0.5rem; {{ $tab == 'facturadas' ? 'color: #c79c5e; border-color: #c79c5e;' : '' }}">
      <span class="material-symbols-rounded text-[18px]">description</span>
      Con Factura Fiscal
    </a>
  </div>

  <!-- Lista de Compras Históricas -->
  <div class="flex flex-col gap-6">
    @forelse($history as $purchase)
    <div class="flex flex-col gap-6 border shadow-2xl transition-all hover:border-white/20" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 2rem; border-radius: 2.5rem;">
      
      <!-- Header de la Compra -->
      <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-white/10 pb-5">
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-slate-950 font-bold shadow-lg shrink-0" style="background-color: #c79c5e;">
            <span class="material-symbols-rounded text-2xl">{{ $purchase->type_icon }}</span>
          </div>
          <div>
            <div class="flex items-center flex-wrap gap-3">
              <span class="text-xl font-bold text-white">{{ $purchase->order_number }}</span>
              <span class="text-xs font-bold uppercase tracking-wider whitespace-nowrap" style="background-color: rgba(255,255,255,0.05); color: #94a3b8; border: 1px solid rgba(255,255,255,0.1); padding: 0.4rem 0.85rem; border-radius: 9999px;">
                {{ $purchase->type_label }}
              </span>
              @if($purchase->is_invoiced)
                <span class="text-xs font-bold uppercase tracking-wider whitespace-nowrap" style="background-color: rgba(16,185,129,0.1); color: #10b981; border: 1px solid rgba(16,185,129,0.2); padding: 0.4rem 0.85rem; border-radius: 9999px;">
                  ✓ Facturado (CFDI 4.0)
                </span>
              @endif
            </div>
            <div class="text-xs text-slate-400 flex items-center gap-4 flex-wrap" style="margin-top: 0.65rem;">
              <span>📅 {{ $purchase->date_formatted }}</span>
              <span>💳 {{ $purchase->payment_method }}</span>
              <span class="text-amber-400 font-bold">🌟 +{{ $purchase->points_earned }} pts abonados</span>
            </div>
          </div>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <span class="text-2xl font-bold text-amber-400">${{ number_format($purchase->total_amount, 2) }}</span>
        </div>
      </div>

      <!-- Desglose de Productos Comprados -->
      <div class="flex flex-col gap-3">
        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Productos adquiridos</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          @foreach($purchase->items as $item)
          <div class="flex items-center gap-3" style="background: rgba(15, 23, 42, 0.4); border: 1px solid rgba(255,255,255,0.05); padding: 0.85rem 1.15rem; border-radius: 1rem;">
            <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-lg shrink-0">
              ☕
            </div>
            <div class="flex-1 min-w-0">
              <div class="font-bold text-white text-xs truncate">{{ $item->product_name }}</div>
              <div class="text-xs text-slate-400 mt-0.5">Cant: <strong class="text-amber-400">{{ $item->quantity }}</strong> • ${{ number_format($item->unit_price, 2) }} c/u</div>
            </div>
            <div class="text-xs font-bold text-white shrink-0">
              ${{ number_format($item->quantity * $item->unit_price, 2) }}
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Acciones de Reordenar y Comprobante conforme a AGENTS.md (separación de 20px) -->
      <div class="flex items-center justify-between flex-wrap gap-4" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 1rem;">
        <div class="flex items-center gap-1 text-amber-400 text-xs font-bold">
          <span>Calificación:</span>
          @for($i = 1; $i <= 5; $i++)
            <span class="material-symbols-rounded text-sm" style="font-size: 16px;">{{ $i <= $purchase->rating ? 'star' : 'star_outline' }}</span>
          @endfor
        </div>

        <div class="flex items-center gap-3 flex-wrap">
          <button onclick="alert('Descargando comprobante fiscal PDF de {{ $purchase->order_number }}...')" class="text-slate-300 hover:bg-white/5 text-xs font-bold flex items-center gap-2 transition-colors cursor-pointer" style="border: 1px solid rgba(255,255,255,0.1); padding: 0.75rem 1.25rem; border-radius: 1rem;">
            <span class="material-symbols-rounded text-sm">download</span>
            <span>Descargar Ticket / Factura</span>
          </button>
          
          <button onclick="alert('Productos de {{ $purchase->order_number }} agregados al carrito actual.')" class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;">
            <span class="material-symbols-rounded text-sm">replay</span>
            <span>Repetir este Pedido</span>
          </button>
        </div>
      </div>

    </div>
    @empty
    <div class="flex flex-col items-center justify-center p-12 text-center rounded-[2.5rem] border shadow-2xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08);">
      <div class="w-20 h-20 rounded-full bg-slate-900 flex items-center justify-center text-4xl mb-4 border border-white/10">
        📜
      </div>
      <h3 class="text-xl font-bold text-white">No se encontraron compras en tu historial</h3>
      <p class="text-slate-400 text-sm max-w-md mt-2">
        Aún no has registrado compras o la búsqueda actual no coincide con ningún registro.
      </p>
      <a href="{{ route('pos') }}" class="mt-6 font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer" style="background-color: #c79c5e; color: #0a0f18; padding: 0.85rem 1.75rem; border-radius: 1rem; border: none;">
        <span class="material-symbols-rounded text-base">restaurant_menu</span>
        <span>Ir al Menú a Comprar</span>
      </a>
    </div>
    @endforelse
  </div>

</div>
@endsection
