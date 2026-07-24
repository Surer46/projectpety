@extends('layouts.app')

@section('title', 'Cafeteria PETY | Reservación de Mesas por Área')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-8 pb-12">

  <!-- Header Principal -->
  <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 border-b border-white/10 pb-6">
    <div class="flex flex-col gap-1.5">
      <h1 class="text-3xl font-bold text-white flex items-center gap-3" style="font-family: 'Playfair Display', Georgia, serif; line-height: 1.2;">
        <span class="material-symbols-rounded text-3xl" style="color: #c79c5e;">event_seat</span>
        Reserva tu <span class="italic font-normal" style="color: #c79c5e;">Mesa por Área Física</span>
      </h1>
      <p class="text-slate-400 text-sm max-w-3xl leading-relaxed">
        Elige tu ambiente preferido entre nuestras <strong class="text-white">Zonas Físicas</strong> y aparta tu mesa ideal con fecha y hora confirmadas.
      </p>
    </div>
    <div class="flex flex-wrap items-center gap-3 shrink-0">
      <a href="{{ route('pos') }}" class="font-bold text-xs flex items-center gap-2 shadow-xl transition-all hover:brightness-110 active:scale-95 whitespace-nowrap cursor-pointer"
         style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.25rem; border-radius: 1rem; border: none;">
        <span class="material-symbols-rounded text-lg">restaurant_menu</span>
        <span>Ver Menú Digital</span>
      </a>
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

  <!-- KPIs Globales de Disponibilidad -->
  @php
    $allTables = $tables ?? collect();
    $libres    = $allTables->where('status','libre')->count();
    $reservadas= $allTables->where('status','reservada')->count();
    $ocupadas  = $allTables->where('status','ocupada')->count();
    $limpieza  = $allTables->where('status','limpieza')->count();
  @endphp

  <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
    <div class="flex items-center gap-4 rounded-2xl border shadow-xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 1.25rem;">
      <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(52,211,153,0.15);">
        <span class="material-symbols-rounded" style="color: #34d399; font-size:22px;">check_circle</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ $libres }}</div>
        <div class="text-xs text-slate-400 font-bold uppercase mt-0.5">Disponibles</div>
      </div>
    </div>

    <div class="flex items-center gap-4 rounded-2xl border shadow-xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 1.25rem;">
      <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(245,158,11,0.15);">
        <span class="material-symbols-rounded" style="color: #fbbf24; font-size:22px;">event</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ $reservadas }}</div>
        <div class="text-xs text-slate-400 font-bold uppercase mt-0.5">Reservadas</div>
      </div>
    </div>

    <div class="flex items-center gap-4 rounded-2xl border shadow-xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 1.25rem;">
      <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(239,68,68,0.15);">
        <span class="material-symbols-rounded" style="color: #f87171; font-size:22px;">group</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ $ocupadas }}</div>
        <div class="text-xs text-slate-400 font-bold uppercase mt-0.5">Ocupadas</div>
      </div>
    </div>

    <div class="flex items-center gap-4 rounded-2xl border shadow-xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 1.25rem;">
      <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(148,163,184,0.12);">
        <span class="material-symbols-rounded" style="color: #94a3b8; font-size:22px;">cleaning_services</span>
      </div>
      <div>
        <div class="text-2xl font-bold text-white leading-none">{{ $limpieza }}</div>
        <div class="text-xs text-slate-400 font-bold uppercase mt-0.5">En Limpieza</div>
      </div>
    </div>
  </div>

  <!-- Grid Principal 12 Columnas -->
  <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">

    <!-- SECCIÓN 1: FORMULARIO DE RESERVACIÓN -->
    <div id="contenedor-formulario-reserva" class="xl:col-span-4 flex flex-col gap-6 rounded-[2.5rem] border shadow-2xl h-fit" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 2rem;">

      <div class="flex items-center gap-3.5 border-b pb-5" style="border-color: rgba(255,255,255,0.08);">
        <div class="w-11 h-11 rounded-2xl flex items-center justify-center font-bold shadow-md shrink-0 border" style="background: rgba(199,156,94,0.15); border-color: rgba(199,156,94,0.3); color: #c79c5e;">
          <span class="material-symbols-rounded text-2xl">person_add</span>
        </div>
        <div>
          <h2 class="text-xl font-bold text-white" style="font-family: 'Playfair Display', Georgia, serif;">Nueva Reservación</h2>
          <p class="text-xs text-slate-400" style="margin-top: 0.25rem;">Selecciona tu área y mesa deseada.</p>
        </div>
      </div>

      <form action="{{ route('reservaciones.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf

        <!-- Selector de Área Física -->
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">1. Seleccionar Zona / Área Física *</label>
          <select id="select_area_id" class="w-full text-white outline-none transition-all appearance-none"
                  style="background: rgba(15,23,42,0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); cursor: pointer;">
            <option value="" style="background:#0f172a;">— Todas las Áreas —</option>
            @foreach($areas ?? [] as $a)
              <option value="{{ $a->id }}" style="background:#0f172a;">
                {{ $a->emoji }} {{ $a->name }} ({{ $a->tables->where('status','libre')->count() }} disponibles)
              </option>
            @endforeach
          </select>
        </div>

        <!-- Selector de Mesa (filtrado dinámicamente) -->
        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">2. Seleccionar Mesa *</label>
          <select name="table_id" id="select_table_id" required class="w-full text-white outline-none transition-all appearance-none"
                  style="background: rgba(15,23,42,0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); cursor: pointer;">
            <option value="" style="background:#0f172a;">— Selecciona primero la mesa —</option>
            @foreach($tables ?? [] as $tb)
              @if($tb->status === 'libre')
                <option value="{{ $tb->id }}" data-area-id="{{ $tb->area_id }}" style="background:#0f172a; color: white;">
                  {{ $tb->table_number }} — {{ $tb->area->name ?? $tb->area }} ({{ $tb->capacity }} pers.)
                </option>
              @endif
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre Completo del Cliente *</label>
          <input type="text" name="customer_name" required placeholder="Ej. Ana María Torres"
                 class="w-full text-white outline-none transition-all"
                 style="background: rgba(15,23,42,0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Teléfono / WhatsApp *</label>
          <input type="text" name="customer_phone" required placeholder="444-987-6543"
                 class="w-full text-white outline-none transition-all"
                 style="background: rgba(15,23,42,0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Fecha Reserva *</label>
            <input type="date" name="reservation_date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required
                   class="w-full text-white outline-none transition-all"
                   style="background: rgba(15,23,42,0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Hora Reserva *</label>
            <input type="time" name="reservation_time" value="15:00" required
                   class="w-full text-white outline-none transition-all"
                   style="background: rgba(15,23,42,0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Número de Acompañantes *</label>
          <input type="number" name="party_size" value="2" min="1" max="20" required
                 class="w-full text-white outline-none transition-all"
                 style="background: rgba(15,23,42,0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);" />
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Notas u Ocasión Especial</label>
          <textarea name="notes" rows="2" placeholder="Ej. Cumpleaños, aniversario, silla para bebé..."
                    class="w-full text-white outline-none transition-all resize-none"
                    style="background: rgba(15,23,42,0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"></textarea>
        </div>

        <button type="submit"
                class="w-full mt-2 font-bold text-sm shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer"
                style="background-color: #c79c5e; color: #0a0f18; padding: 0.85rem 1.5rem; border-radius: 1rem; border: none;">
          <span class="material-symbols-rounded text-base">check</span>
          <span>Confirmar Reservación</span>
        </button>
      </form>
    </div>

    <!-- SECCIÓN 2: PLANO DE ÁREAS FÍSICAS Y MESAS -->
    <div class="xl:col-span-8 flex flex-col gap-8">

      <!-- Leyenda de colores -->
      <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4 text-xs font-bold">
          <span class="flex items-center gap-2" style="color:#34d399;"><span class="w-3 h-3 rounded-full inline-block" style="background:#34d399;"></span>Libre</span>
          <span class="flex items-center gap-2" style="color:#fbbf24;"><span class="w-3 h-3 rounded-full inline-block" style="background:#fbbf24;"></span>Reservada</span>
          <span class="flex items-center gap-2" style="color:#f87171;"><span class="w-3 h-3 rounded-full inline-block" style="background:#f87171;"></span>Ocupada</span>
          <span class="flex items-center gap-2" style="color:#94a3b8;"><span class="w-3 h-3 rounded-full inline-block" style="background:#94a3b8;"></span>En Limpieza</span>
        </div>
      </div>

      <!-- ÁREAS FÍSICAS -->
      @forelse($areas ?? [] as $area)
        @php
          $mesasArea = $area->tables ?? collect();
          $libresArea = $mesasArea->where('status','libre')->count();
          $totalArea = $mesasArea->count();
          $capacidadTotal = $area->total_capacity;
        @endphp

        <div class="flex flex-col gap-5 rounded-[2.5rem] border shadow-2xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 2rem;">

          <!-- Encabezado del Área -->
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b pb-5" style="border-color: rgba(255,255,255,0.08);">
            <div class="flex items-center gap-4">
              <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 border" style="background: rgba(255,255,255,0.05); border-color: {{ $area->color }}40; font-size: 1.75rem;">
                {{ $area->emoji ?? '🪑' }}
              </div>
              <div>
                <h2 class="text-xl font-bold text-white flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
                  <span>{{ $area->name }}</span>
                </h2>
                <div class="flex items-center gap-3 text-xs text-slate-400" style="margin-top: 0.65rem;">
                  <span>📍 <strong class="text-white">{{ $area->floor ?? 'Planta Baja' }}</strong></span>
                  <span>🕒 <strong>{{ $area->schedule_open ?? '07:00' }} – {{ $area->schedule_close ?? '22:00' }}</strong></span>
                  <span>👥 Aforo max: <strong class="text-white">{{ $capacidadTotal }} pers.</strong></span>
                  <span>✅ <strong style="color: #34d399;">{{ $libresArea }}</strong> libres</span>
                </div>
                @if($area->description)
                  <p class="text-xs text-slate-400 mt-2 italic">{{ $area->description }}</p>
                @endif
              </div>
            </div>

            <div class="flex flex-col items-end gap-2">
              @if($libresArea === 0)
                <span class="text-xs font-bold uppercase tracking-wider whitespace-nowrap" style="background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.3); padding: 0.4rem 1rem; border-radius: 999px;">Sin Disponibilidad</span>
              @elseif($libresArea < ($totalArea / 2))
                <span class="text-xs font-bold uppercase tracking-wider whitespace-nowrap" style="background: rgba(245,158,11,0.15); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); padding: 0.4rem 1rem; border-radius: 999px;">Disponibilidad Limitada</span>
              @else
                <span class="text-xs font-bold uppercase tracking-wider whitespace-nowrap" style="background: rgba(52,211,153,0.15); color: #34d399; border: 1px solid rgba(52,211,153,0.3); padding: 0.4rem 1rem; border-radius: 999px;">Disponible</span>
              @endif

              <div class="flex flex-wrap items-center gap-1">
                @if($area->is_outdoor)
                  <span class="text-[0.6rem] font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-2 py-0.5 rounded-md">☀️ Exterior</span>
                @endif
                @if($area->requires_reservation)
                  <span class="text-[0.6rem] font-bold text-purple-400 bg-purple-500/10 border border-purple-500/30 px-2 py-0.5 rounded-md">🔒 Reserva Previa</span>
                @endif
                @if($area->min_consumption > 0)
                  <span class="text-[0.6rem] font-bold text-amber-400 bg-amber-500/10 border border-amber-500/30 px-2 py-0.5 rounded-md">💰 Min ${{ number_format($area->min_consumption,2) }}</span>
                @endif
              </div>
            </div>
          </div>

          <!-- Grid de Mesas del Área -->
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($mesasArea as $t)
              @php
                $isLibre    = $t->status === 'libre';
                $isReserva  = $t->status === 'reservada';
                $isOcupada  = $t->status === 'ocupada';
                $isLimpieza = $t->status === 'limpieza';

                if ($isLibre)       { $dotColor = '#34d399'; $badgeBg = 'rgba(52,211,153,0.15)'; $badgeBorder = 'rgba(52,211,153,0.3)'; $label = 'Libre'; }
                elseif($isReserva)  { $dotColor = '#fbbf24'; $badgeBg = 'rgba(245,158,11,0.15)'; $badgeBorder = 'rgba(245,158,11,0.3)'; $label = 'Reservada'; }
                elseif($isOcupada)  { $dotColor = '#f87171'; $badgeBg = 'rgba(239,68,68,0.15)'; $badgeBorder = 'rgba(239,68,68,0.3)'; $label = 'Ocupada'; }
                else                { $dotColor = '#94a3b8'; $badgeBg = 'rgba(148,163,184,0.1)'; $badgeBorder = 'rgba(148,163,184,0.2)'; $label = 'Limpieza'; }

                $clickable = $isLibre ? 'cursor-pointer hover:border-[#c79c5e]' : 'cursor-not-allowed opacity-60';
              @endphp

              <div onclick="{{ $isLibre ? 'seleccionarMesaConArea('.$t->id.', '.$area->id.')' : 'void(0)' }}"
                   class="flex flex-col rounded-2xl border transition-all duration-200 shadow-lg {{ $clickable }}"
                   style="background-color: #101725; border-color: rgba(255,255,255,0.1); padding: 1.25rem; gap: 0.85rem;">

                <div class="flex items-center justify-between gap-2">
                  <span class="font-bold text-white text-sm leading-tight">{{ $t->table_number }}</span>
                  <span class="w-2.5 h-2.5 rounded-full shrink-0 animate-pulse" style="background: {{ $dotColor }};"></span>
                </div>

                <div class="flex items-center gap-1 text-slate-400 text-xs">
                  <span class="material-symbols-rounded text-sm">group</span>
                  <span>{{ $t->capacity }} personas</span>
                </div>

                <div class="flex items-center justify-between border-t border-white/5 pt-2">
                  <span class="text-[0.6rem] font-bold uppercase tracking-widest"
                        style="background: {{ $badgeBg }}; color: {{ $dotColor }}; border: 1px solid {{ $badgeBorder }}; padding: 0.25rem 0.6rem; border-radius: 999px;">
                    {{ $label }}
                  </span>
                  @if($isLibre)
                    <span class="text-[0.6rem] text-slate-500 font-bold">Elegir →</span>
                  @endif
                </div>

                @if($isReserva && $t->customer_name)
                  <div class="text-[0.65rem] text-slate-400 leading-snug border-t border-white/5 pt-2">
                    <strong class="text-amber-400">{{ $t->customer_name }}</strong><br>
                    🕒 {{ $t->reservation_time }} · 👥 {{ $t->party_size }} pers.
                  </div>
                @endif
              </div>
            @endforeach
          </div>

        </div>
      @empty
        <div class="col-span-full py-16 text-center text-slate-500">
          No hay zonas físicas registradas en el sistema.
        </div>
      @endforelse

      <!-- RESERVACIONES CONFIRMADAS DE LA SESIÓN -->
      @if(isset($activeReservations) && count($activeReservations) > 0)
        <div class="flex flex-col gap-4 rounded-[2.5rem] border shadow-2xl" style="background-color: #1e2638; border-color: rgba(255,255,255,0.08); padding: 2rem;">
          <h3 class="text-lg font-bold text-white flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
            <span class="material-symbols-rounded" style="color: #fbbf24;">bookmark_check</span>
            Reservaciones Confirmadas
          </h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($activeReservations as $res)
              <div class="rounded-2xl border p-4 flex flex-col gap-2 shadow" style="background-color: #101725; border-color: rgba(255,255,255,0.08);">
                <div class="flex items-center justify-between">
                  <span class="font-bold text-white text-sm">{{ $res->customer_name }}</span>
                  <span class="text-[0.65rem] font-bold text-amber-400 bg-amber-500/10 border border-amber-500/30 px-2 py-0.5 rounded-full">
                    #{{ $res->id }} · {{ strtoupper($res->status) }}
                  </span>
                </div>
                <div class="text-xs text-slate-400">
                  🪑 <strong>{{ $res->table->table_number ?? 'Mesa' }}</strong> ({{ $res->area->name ?? 'Área' }})<br>
                  📅 {{ $res->reservation_date ? \Carbon\Carbon::parse($res->reservation_date)->format('d/m/Y') : 'Hoy' }} · 🕒 {{ $res->reservation_time }} · 👥 {{ $res->party_size }} pers.
                </div>
                @if($res->notes)
                  <div class="text-[0.7rem] text-slate-400 italic">"{{ $res->notes }}"</div>
                @endif
                <div class="flex justify-end border-t border-white/5 pt-2 mt-1">
                  <form action="{{ route('reservaciones.cancel', $res->id) }}" method="POST" onsubmit="return confirm('¿Cancelar esta reservación?')">
                    @csrf
                    <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 font-bold flex items-center gap-1">
                      <span class="material-symbols-rounded text-sm">cancel</span>
                      Cancelar Reserva
                    </button>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Filtrado dinámico de mesas por área seleccionada
document.getElementById('select_area_id').addEventListener('change', function() {
    const areaId = this.value;
    const options = document.querySelectorAll('#select_table_id option[data-area-id]');

    options.forEach(opt => {
        if (!areaId || opt.dataset.areaId === areaId) {
            opt.style.display = '';
        } else {
            opt.style.display = 'none';
        }
    });

    document.getElementById('select_table_id').value = '';
});

// Selección automática al hacer click en una mesa del mapa
function seleccionarMesaConArea(tableId, areaId) {
    const areaSelect = document.getElementById('select_area_id');
    const tableSelect = document.getElementById('select_table_id');

    areaSelect.value = areaId;
    areaSelect.dispatchEvent(new Event('change'));

    tableSelect.value = tableId;

    document.getElementById('contenedor-formulario-reserva').scrollIntoView({ behavior: 'smooth', block: 'center' });
}
</script>
@endpush
