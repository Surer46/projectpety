@extends('layouts.app')
@section('title', 'Cafeteria PETY - Finalizar Venta')

@section('content')

<div class="flex flex-col md:flex-row w-full max-w-7xl mx-auto h-full" style="gap: 1.5rem;">

  <!-- Columna Izquierda: Lista de Carrito -->
  <div class="flex-1 flex flex-col bg-[#1e2638] rounded-[2.5rem] shadow-xl border border-white/5 h-full overflow-hidden" style="padding: 1.5rem;">
    <div class="flex items-center justify-between border-b border-white/10 shrink-0" style="margin-bottom: 1.5rem; padding-bottom: 1rem;">
      <h1 class="text-3xl font-serif font-medium text-white flex items-center" style="gap: 0.75rem;">
        <span class="material-symbols-rounded" style="color: var(--accent); font-size: 32px;">shopping_cart</span>
        Tu Pedido
      </h1>
      <button onclick="clearCart()" class="text-sm font-bold text-red-400 hover:text-red-300 transition-colors bg-red-500/10 hover:bg-red-500/20 rounded-xl flex items-center" style="padding: 0.5rem 1rem; gap: 0.5rem;">
        <span class="material-symbols-rounded" style="font-size: 18px;">delete</span>
        Vaciar
      </button>
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar" style="padding-right: 0.5rem; display: flex; flex-direction: column; gap: 1rem;" id="cart-container">
      @forelse($cart as $item)
        <div class="flex items-start bg-white/5 rounded-2xl border border-white/5 relative" style="padding: 1rem; gap: 1rem;" id="line-{{ $item['line_id'] }}">
          
          {{-- Botón Eliminar --}}
          <button onclick="removeLine('{{ $item['line_id'] }}')" class="absolute top-3 right-3 text-slate-500 hover:text-red-400 transition-colors">
            <span class="material-symbols-rounded" style="font-size: 20px;">close</span>
          </button>

          {{-- Imagen / Emoji --}}
          <div class="flex items-center justify-center bg-gradient-to-b from-white/10 to-transparent rounded-xl border border-white/5 shadow-inner shrink-0 overflow-hidden" style="width: 4rem; height: 4rem;">
              @if(!empty($item['image']))
                  <img src="{{ str_starts_with($item['image'], 'http') ? $item['image'] : asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover" />
              @else
                  <span style="font-size: 2rem;">{{ $item['emoji'] ?? '☕' }}</span>
              @endif
          </div>

          {{-- Contenido --}}
          <div class="flex-1 flex flex-col justify-between min-h-[4rem]" style="padding-right: 1.5rem;">
            <div>
              <h3 class="text-base font-bold text-slate-100 leading-tight">{{ $item['name'] }}</h3>
              @if(!empty($item['modifiers']))
                <ul class="text-xs text-slate-400" style="margin-top: 0.25rem; display: flex; flex-direction: column; gap: 0.15rem;">
                  @if(isset($item['modifiers']['size'])) <li>Tamaño: {{ ucfirst($item['modifiers']['size']) }}</li> @endif
                  @if(isset($item['modifiers']['milk'])) <li>Leche: {{ ucfirst($item['modifiers']['milk']) }}</li> @endif
                  @if(isset($item['modifiers']['extra_shot'])) <li>+ Shot de Espresso</li> @endif
                  @if(isset($item['modifiers']['syrup'])) <li>+ Jarabe: {{ ucfirst($item['modifiers']['syrup']) }}</li> @endif
                </ul>
              @endif
            </div>
            
            {{-- Precios y Cantidad (Todo en una línea) --}}
            <div class="flex items-center justify-between" style="margin-top: 0.5rem;">
              <div class="font-bold text-sm" style="color: var(--accent);">${{ number_format($item['total_price'], 2) }} c/u</div>
              
              <div class="flex items-center gap-3">
                <div class="bg-slate-900 rounded-md font-bold text-white border border-white/10" style="padding: 0.15rem 0.5rem; font-size: 0.8rem;">
                  x{{ $item['quantity'] }}
                </div>
                <div class="text-base font-bold text-white">
                  ${{ number_format($item['total_price'] * $item['quantity'], 2) }}
                </div>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="flex flex-col items-center justify-center h-full text-slate-500">
          <span class="material-symbols-rounded opacity-50" style="font-size: 64px; margin-bottom: 1rem;">remove_shopping_cart</span>
          <p class="text-xl font-medium">El carrito está vacío</p>
          <a href="{{ route('pos') }}" class="underline underline-offset-4" style="color: var(--accent); text-decoration-color: rgba(199, 156, 94, 0.5); margin-top: 1.5rem;" onmouseover="this.style.filter='brightness(1.2)'" onmouseout="this.style.filter='none'">Regresar al Menú</a>
        </div>
      @endforelse
    </div>
  </div>

  <!-- Columna Derecha: Panel de Checkout -->
  <div class="w-full md:w-96 flex flex-col bg-[#1e2638] rounded-[2.5rem] shadow-xl border border-white/5 shrink-0 h-full" style="padding: 1.5rem;">
    <h2 class="text-xl font-bold text-slate-300 border-b border-white/10" style="margin-bottom: 1.5rem; padding-bottom: 1rem;">Resumen de Cobro</h2>
    
    <div class="flex-1" style="display: flex; flex-direction: column; gap: 1rem;">
      <!-- Selector de Cliente (Sprint 5) -->
      <div style="margin-bottom: 0.5rem;">
        <label for="customer_id" class="block text-sm font-medium text-slate-400" style="margin-bottom: 0.5rem;">Cliente Frecuente</label>
        <div class="relative">
            <select id="customer_id" onchange="onCustomerChange()" class="w-full bg-[#111827] border border-white/10 rounded-xl text-white outline-none focus:border-[var(--accent)] transition-colors cursor-pointer" style="padding: 0.75rem 1rem; appearance: none; -webkit-appearance: none;">
                <option value="" data-points="0">Público General</option>
                @if(isset($customers))
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" data-points="{{ $customer->loyalty_points }}">{{ $customer->name }} ({{ $customer->loyalty_points }} pts)</option>
                    @endforeach
                @endif
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center" style="padding-right: 1rem;">
                <span class="material-symbols-rounded text-slate-400" style="font-size: 1.2rem;">expand_more</span>
            </div>
        </div>
      </div>

      <!-- Box de Puntos de Lealtad (Sprint 5 - Redención y Descuento) -->
      <div id="loyalty-points-container" class="hidden rounded-xl p-3 my-1 text-slate-200 border" style="background-color: rgba(199,156,94,0.1); border-color: rgba(199,156,94,0.3);">
          <div class="flex items-center justify-between">
              <label for="use_loyalty_points" class="flex items-center gap-2 text-xs font-bold cursor-pointer" style="color: #c79c5e;">
                  <input type="checkbox" id="use_loyalty_points" onchange="updateCartTotals()" class="w-4 h-4 rounded cursor-pointer" style="accent-color: #c79c5e;">
                  <span class="material-symbols-rounded text-sm">stars</span>
                  Redimir Puntos de Lealtad
              </label>
              <span class="text-xs font-medium text-slate-400" id="available-points-label">0 pts disponibles</span>
          </div>
          <div id="points-input-wrapper" class="hidden mt-2 pt-2 border-t border-white/10 flex items-center justify-between gap-2">
              <span class="text-xs text-slate-400">Puntos a canjear:</span>
              <div class="flex items-center gap-1">
                  <input type="number" id="points_to_redeem" value="0" min="1" max="0" step="1" oninput="updateCartTotals()" class="w-20 bg-slate-900 border rounded-lg px-2 py-1 text-right font-bold text-sm outline-none" style="border-color: rgba(199,156,94,0.4); color: #c79c5e;">
                  <span class="text-xs font-bold text-emerald-400" id="points-discount-label">(-$0.00)</span>
              </div>
          </div>
      </div>

      <div class="flex justify-between items-center text-slate-400">
        <span>Subtotal</span>
        <span id="summary-subtotal">${{ number_format($total / 1.16, 2) }}</span>
      </div>
      <div id="summary-discount-row" class="hidden flex justify-between items-center text-amber-400 font-medium text-sm">
        <span class="flex items-center gap-1"><span class="material-symbols-rounded text-sm">stars</span> Descuento Puntos</span>
        <span id="summary-discount">-$0.00</span>
      </div>
      <div class="flex justify-between items-center text-slate-400">
        <span>IVA (16%)</span>
        <span id="summary-tax">${{ number_format($total - ($total / 1.16), 2) }}</span>
      </div>
      <div class="border-t border-white/10 my-4"></div>
      <div class="flex justify-between items-center text-2xl font-bold" style="color: var(--accent);">
        <span>Total</span>
        <span id="summary-total">${{ number_format($total, 2) }}</span>
      </div>
    </div>

    <!-- Botones de Pago -->
    <!-- Botones de Pago -->
    <div style="margin-top: 2rem;">
      <h3 class="text-xs font-bold tracking-widest text-slate-500 uppercase text-center" style="margin-bottom: 1rem;">Método de Pago</h3>
      
      <div class="grid grid-cols-2" style="gap: 0.75rem;">
        <!-- Efectivo ocupa las dos columnas para darle jerarquía principal -->
        <button onclick="abrirCheckout('cash')" class="col-span-2 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-500 border border-emerald-500/30 rounded-2xl font-bold flex flex-col items-center justify-center transition-all transform active:scale-95 shadow-lg shadow-emerald-500/5 hover:shadow-emerald-500/20" style="padding: 1.25rem; gap: 0.25rem;" {{ $total == 0 ? 'disabled' : '' }}>
          <span class="material-symbols-rounded" style="font-size: 30px;">payments</span>
          <span class="tracking-wide">Efectivo</span>
        </button>
        
        <!-- Tarjeta y Mixto en media columna -->
        <button onclick="procesarPago('card')" class="bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-2xl font-bold flex flex-col items-center justify-center transition-all transform active:scale-95 shadow-lg shadow-blue-500/5 hover:shadow-blue-500/20" style="padding: 1rem; gap: 0.25rem;" {{ $total == 0 ? 'disabled' : '' }}>
          <span class="material-symbols-rounded" style="font-size: 24px;">credit_card</span>
          <span class="text-sm tracking-wide">Tarjeta</span>
        </button>

        <button onclick="toast('Pago Mixto Próximamente')" class="bg-purple-500/10 hover:bg-purple-500/20 text-purple-400 border border-purple-500/30 rounded-2xl font-bold flex flex-col items-center justify-center transition-all transform active:scale-95 shadow-lg shadow-purple-500/5 hover:shadow-purple-500/20" style="padding: 1rem; gap: 0.25rem;" {{ $total == 0 ? 'disabled' : '' }}>
          <span class="material-symbols-rounded" style="font-size: 24px;">splitscreen</span>
          <span class="text-sm tracking-wide">Mixto</span>
        </button>
      </div>
    </div>
  </div>

</div>

<!-- Modal de Confirmación para Vaciar Carrito -->
<div id="modal-confirm-clear" class="hidden fixed inset-0 z-[9999] flex items-center justify-center transition-opacity duration-300 opacity-0" style="background-color: rgba(0,0,0,0.8); backdrop-filter: blur(8px);">
  <div id="modal-confirm-clear-card" class="text-white transform transition-all duration-300 scale-95 opacity-0" style="background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 1.5rem; width: 100%; max-width: 24rem; display: flex; flex-direction: column; padding: 2.5rem 2rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7); align-items: center; text-align: center;">
    
    <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem; margin-bottom: 2.5rem;">
      <div style="width: 4rem; height: 4rem; border-radius: 50%; background-color: rgba(239,68,68,0.1); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(239,68,68,0.3); color: #ef4444; box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);">
        <span class="material-symbols-rounded" style="font-size: 2rem;">delete_sweep</span>
      </div>
      <h2 style="font-weight: bold; font-size: 1.5rem; color: white; margin: 0; font-family: 'Playfair Display', Georgia, serif; line-height: 1.1;">¿Vaciar el carrito?</h2>
      <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.5; margin: 0;">Estás a punto de eliminar todos los productos seleccionados. Esta acción no se puede deshacer.</p>
    </div>
    
    <div style="display: flex; align-items: center; gap: 1rem; width: 100%;">
      <button onclick="hideClearCartModal()" style="flex: 1; background-color: rgba(255,255,255,0.05); color: white; font-weight: bold; padding: 0.875rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; transition: background-color 0.2s;">Cancelar</button>
      <button onclick="confirmClearCart()" style="flex: 1; background-color: rgba(239,68,68,0.9); color: white; font-weight: bold; padding: 0.875rem; border-radius: 1rem; border: none; box-shadow: 0 4px 15px rgba(239,68,68,0.2); cursor: pointer; transition: background-color 0.2s;">Sí, vaciar</button>
    </div>
    
  </div>
</div>

<!-- ===== MODAL DE COBRO EFECTIVO ===== -->
<div id="modal-checkout-cash" class="fixed inset-0 z-[9999] flex items-center justify-center hidden" style="background-color: rgba(0,0,0,0.8); backdrop-filter: blur(8px);">
  <div style="background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 1.5rem; width: 100%; max-width: 28rem; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7); overflow: hidden; background: linear-gradient(180deg, #101725 0%, #0a0f18 100%);">
    
    <div style="border-bottom: 1px solid rgba(255,255,255,0.05); padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between;">
      <div style="display: flex; align-items: center; gap: 0.75rem;">
        <div style="width: 2.75rem; height: 2.75rem; background-color: rgba(16,185,129,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
          <span class="material-symbols-rounded" style="color: #10b981;">payments</span>
        </div>
        <h3 style="font-size: 1.125rem; font-weight: bold; color: white; margin: 0; letter-spacing: 0.025em;">Cobro en Efectivo</h3>
      </div>
      <button onclick="cerrarCheckout()" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; width: 2.25rem; height: 2.25rem; display: flex; align-items: center; justify-content: center; color: #94a3b8; cursor: pointer; transition: background-color 0.2s;">
        <span class="material-symbols-rounded" style="font-size: 1.125rem;">close</span>
      </button>
    </div>

    <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
      <!-- Totales -->
      <div style="background-color: rgba(255,255,255,0.05); border-radius: 1rem; border: 1px solid rgba(255,255,255,0.05); padding: 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <span style="font-size: 0.875rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; font-weight: bold; margin-bottom: 0.25rem;">Total a Pagar</span>
        <span style="font-size: 2.25rem; font-weight: bold; color: white; line-height: 1;">${{ number_format($total, 2) }}</span>
      </div>

      <!-- Input Monto Recibido -->
      <div style="display: flex; flex-direction: column; gap: 0.5rem;">
        <label style="font-size: 0.75rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Efectivo Recibido</label>
        <div style="position: relative; display: flex; align-items: center;">
          <span style="position: absolute; left: 1rem; color: #10b981; font-weight: bold; font-size: 1.25rem;">$</span>
          <input type="number" id="monto_recibido" value="{{ $total }}" step="0.5" style="width: 100%; background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(16,185,129,0.3); border-radius: 1rem; padding: 1rem 1rem 1rem 2.5rem; color: white; font-size: 1.25rem; font-weight: bold; font-family: monospace; outline: none; box-sizing: border-box;" oninput="calcularCambio()">
        </div>
      </div>

      <!-- Cambio Sugerido -->
      <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0;">
        <span style="color: #94a3b8; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.875rem;">Cambio Sugerido</span>
        <span id="cambio_sugerido" style="font-size: 1.5rem; font-weight: bold; color: #34d399;">$0.00</span>
      </div>

      <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 0.5rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05); gap: 0.75rem;">
        <button type="button" onclick="cerrarCheckout()" style="background: transparent; border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; color: #cbd5e1; font-weight: bold; padding: 0.75rem 1.5rem; cursor: pointer;">Cancelar</button>
        <button type="button" onclick="procesarPago('cash')" id="btn-procesar-pago" style="background-color: #10b981; border: none; border-radius: 0.75rem; color: #020617; font-weight: bold; padding: 0.75rem 1.5rem; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 15px rgba(16,185,129,0.2); cursor: pointer;">
          <span class="material-symbols-rounded" style="font-size: 1.25rem;">check_circle</span>
          Procesar Venta
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ticket Éxito -->
<div id="modal-success" class="fixed inset-0 z-[9999] flex items-center justify-center hidden" style="background-color: rgba(0,0,0,0.8); backdrop-filter: blur(8px);">
  <div style="background-color: #0f172a; border: 1px solid rgba(16,185,129,0.3); border-radius: 1.5rem; width: 100%; max-width: 24rem; display: flex; flex-direction: column; align-items: center; text-align: center; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7); padding: 3rem 2rem;">
    <div style="width: 5rem; height: 5rem; background-color: rgba(16,185,129,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
      <span class="material-symbols-rounded" style="color: #10b981; font-size: 3rem;">check_circle</span>
    </div>
    <h2 style="font-size: 1.5rem; font-weight: bold; color: white; margin-bottom: 0.5rem; margin-top: 0;">¡Venta Exitosa!</h2>
    <p style="color: #94a3b8; margin-bottom: 1.5rem; margin-top: 0;" id="success-message">La orden ha sido registrada correctamente.</p>
    
    <div style="background-color: rgba(255,255,255,0.05); border-radius: 1rem; border: 1px solid rgba(255,255,255,0.05); display: flex; flex-direction: column; gap: 0.75rem; padding: 1.5rem; width: 100%; margin-bottom: 2rem; box-sizing: border-box;">
      <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.875rem;">
        <span style="color: #94a3b8;">Orden</span>
        <span style="color: white; font-weight: bold; font-family: monospace;" id="success-order-id">#000</span>
      </div>
      <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.875rem;">
        <span style="color: #94a3b8;">Cambio</span>
        <span style="color: #34d399; font-weight: bold;" id="success-change">$0.00</span>
      </div>
    </div>

    <button onclick="window.location.href='{{ route('pos') }}'" style="width: 100%; background-color: #10b981; border: none; border-radius: 0.75rem; color: #020617; font-weight: bold; padding: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 4px 15px rgba(16,185,129,0.2); cursor: pointer;">
      <span class="material-symbols-rounded" style="font-size: 1.25rem;">arrow_forward</span>
      Nueva Orden
    </button>
  </div>
</div>
@endsection

@push('scripts')
<script>
function removeLine(lineId) {
    fetch('{{ route("cart.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ line_id: lineId })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            window.location.reload();
        }
    });
}

function clearCart() {
    const modal = document.getElementById('modal-confirm-clear');
    const card = document.getElementById('modal-confirm-clear-card');
    
    modal.classList.remove('hidden');
    // Animación de entrada
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        card.classList.remove('scale-95', 'opacity-0');
    }, 10);
}

function hideClearCartModal() {
    const modal = document.getElementById('modal-confirm-clear');
    const card = document.getElementById('modal-confirm-clear-card');
    
    // Animación de salida
    modal.classList.add('opacity-0');
    card.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function confirmClearCart() {
    hideClearCartModal();
    
    fetch('{{ route("cart.clear") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            // Trigger the new aesthetic toast
            if(typeof toast === 'function') toast('Vaciado correctamente', 'info');
            
            // Delay reload so the toast is visible to the user
            setTimeout(() => {
                window.location.reload();
            }, 1200);
        }
    });
}

const baseCartTotal = {{ $total }};
let currentTotalVenta = {{ $total }};

function onCustomerChange() {
    const select = document.getElementById('customer_id');
    const selectedOption = select ? select.options[select.selectedIndex] : null;
    const points = selectedOption ? parseInt(selectedOption.getAttribute('data-points') || '0') : 0;
    
    const container = document.getElementById('loyalty-points-container');
    const pointsLabel = document.getElementById('available-points-label');
    const pointsInput = document.getElementById('points_to_redeem');
    const checkbox = document.getElementById('use_loyalty_points');

    if (points > 0 && baseCartTotal > 0) {
        container.classList.remove('hidden');
        pointsLabel.textContent = `${points} pts ($${points}.00 MXN)`;
        const maxRedeemable = Math.min(points, Math.floor(baseCartTotal));
        pointsInput.max = maxRedeemable;
        if (parseInt(pointsInput.value) > maxRedeemable || parseInt(pointsInput.value) === 0) {
            pointsInput.value = maxRedeemable;
        }
    } else {
        container.classList.add('hidden');
        if (checkbox) checkbox.checked = false;
        if (pointsInput) pointsInput.value = 0;
    }
    updateCartTotals();
}

function updateCartTotals() {
    const select = document.getElementById('customer_id');
    const selectedOption = select ? select.options[select.selectedIndex] : null;
    const points = selectedOption ? parseInt(selectedOption.getAttribute('data-points') || '0') : 0;
    
    const checkbox = document.getElementById('use_loyalty_points');
    const inputWrapper = document.getElementById('points-input-wrapper');
    const pointsInput = document.getElementById('points_to_redeem');
    const discountRow = document.getElementById('summary-discount-row');
    const discountText = document.getElementById('summary-discount');
    const pointsDiscountLabel = document.getElementById('points-discount-label');

    let discountAmount = 0;
    let pointsRedeemed = 0;

    if (checkbox && checkbox.checked && points > 0) {
        if (inputWrapper) inputWrapper.classList.remove('hidden');
        const maxRedeemable = Math.min(points, Math.floor(baseCartTotal));
        pointsRedeemed = Math.min(maxRedeemable, Math.max(0, parseInt(pointsInput.value) || 0));
        pointsInput.value = pointsRedeemed;
        discountAmount = pointsRedeemed;
        
        if (pointsDiscountLabel) pointsDiscountLabel.textContent = `(-$${discountAmount.toFixed(2)})`;
        if (discountRow) discountRow.classList.remove('hidden');
        if (discountText) discountText.textContent = `-$${discountAmount.toFixed(2)}`;
    } else {
        if (inputWrapper) inputWrapper.classList.add('hidden');
        if (discountRow) discountRow.classList.add('hidden');
    }

    currentTotalVenta = Math.max(0, baseCartTotal - discountAmount);

    const netSubtotal = currentTotalVenta / 1.16;
    const netTax = currentTotalVenta - netSubtotal;

    const elSubtotal = document.getElementById('summary-subtotal');
    const elTax = document.getElementById('summary-tax');
    const elTotal = document.getElementById('summary-total');

    if (elSubtotal) elSubtotal.textContent = '$' + netSubtotal.toFixed(2);
    if (elTax) elTax.textContent = '$' + netTax.toFixed(2);
    if (elTotal) elTotal.textContent = '$' + currentTotalVenta.toFixed(2);
}

function abrirCheckout(metodo) {
    if(metodo === 'cash') {
        document.getElementById('modal-checkout-cash').classList.remove('hidden');
        const inputRecibido = document.getElementById('monto_recibido');
        if (inputRecibido) inputRecibido.value = currentTotalVenta.toFixed(2);
        calcularCambio();
    }
}

function cerrarCheckout() {
    document.getElementById('modal-checkout-cash').classList.add('hidden');
}

function calcularCambio() {
    const recibido = parseFloat(document.getElementById('monto_recibido').value) || 0;
    const cambio = recibido - currentTotalVenta;
    const elCambio = document.getElementById('cambio_sugerido');
    const btn = document.getElementById('btn-procesar-pago');
    
    if (cambio >= -0.01) {
        elCambio.textContent = '$' + Math.max(0, cambio).toFixed(2);
        elCambio.classList.remove('text-red-400');
        elCambio.classList.add('text-emerald-400');
        btn.disabled = false;
        btn.style.opacity = '1';
    } else {
        elCambio.textContent = 'Monto insuficiente';
        elCambio.classList.remove('text-emerald-400');
        elCambio.classList.add('text-red-400');
        btn.disabled = true;
        btn.style.opacity = '0.5';
    }
}

function procesarPago(method) {
    let amountTendered = currentTotalVenta;
    if(method === 'cash') {
        amountTendered = parseFloat(document.getElementById('monto_recibido').value);
        cerrarCheckout();
    }

    const btn = document.querySelector('button[onclick="procesarPago(\'' + method + '\')"]');
    if(btn) {
        btn.innerHTML = '<span class="material-symbols-rounded animate-spin">sync</span> Procesando...';
        btn.disabled = true;
    }

    const customerId = document.getElementById('customer_id') ? document.getElementById('customer_id').value : '';
    const pointsCheckbox = document.getElementById('use_loyalty_points');
    const pointsInput = document.getElementById('points_to_redeem');
    const pointsRedeemed = (pointsCheckbox && pointsCheckbox.checked && pointsInput) ? (parseInt(pointsInput.value) || 0) : 0;

    function procesarOffline() {
        const cartData = @json(array_values($cart));
        const offlineOrder = {
            id: 'OFFLINE-' + Date.now(),
            total: currentTotalVenta,
            original_total: baseCartTotal,
            points_redeemed: pointsRedeemed,
            customer_id: customerId,
            payment: {
                method: method,
                amount_tendered: amountTendered
            },
            cart: cartData,
            created_at: new Date().toISOString()
        };

        const pending = JSON.parse(localStorage.getItem('pending_offline_orders') || '[]');
        pending.push(offlineOrder);
        localStorage.setItem('pending_offline_orders', JSON.stringify(pending));

        document.getElementById('success-order-id').textContent = 'OFFLINE (Pendiente)';
        document.getElementById('success-change').textContent = '$' + Math.max(0, amountTendered - currentTotalVenta).toFixed(2);
        document.getElementById('modal-success').classList.remove('hidden');

        fetch('{{ route("cart.clear") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
    }

    if (!navigator.onLine) {
        procesarOffline();
        return;
    }

    fetch('{{ route("orders.checkout") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            payment: {
                method: method,
                amount_tendered: amountTendered
            },
            customer_id: customerId,
            points_redeemed: pointsRedeemed
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            document.getElementById('success-order-id').textContent = 'ORD-' + data.order_id;
            document.getElementById('success-change').textContent = '$' + parseFloat(data.change).toFixed(2);
            document.getElementById('modal-success').classList.remove('hidden');
        } else {
            alert(data.message || 'Error procesando el pago');
            window.location.reload();
        }
    })
    .catch(err => {
        console.warn('Falla de conexión, cambiando a modo Offline local:', err);
        procesarOffline();
    });
}

</script>
@endpush
