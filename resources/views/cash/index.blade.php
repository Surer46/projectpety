@extends('layouts.app')
@section('title', 'Cafeteria PETY - Caja y Flujos')

@section('content')
<div style="display: flex; flex-direction: column; width: 100%; height: 100%; padding: 2rem; gap: 2rem; box-sizing: border-box;">
    <!-- Header -->
    <div style="display: flex; align-items: center; justify-between; flex-wrap: wrap; gap: 1rem;">
        <h1 style="font-size: 2.25rem; font-family: 'Playfair Display', Georgia, serif; color: white; font-weight: 500; display: flex; align-items: center; gap: 1rem; margin: 0;">
            <span class="material-symbols-rounded" style="color: var(--accent); font-size: 40px;">point_of_sale</span>
            Control de Caja y Turnos
        </h1>
        <div>
            @if($activeSession)
                <div style="display: flex; align-items: center; background-color: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.3); border-radius: 1rem; padding: 0.5rem 1rem; gap: 0.5rem;">
                    <div style="width: 0.75rem; height: 0.75rem; border-radius: 50%; background-color: #10b981; box-shadow: 0 0 8px rgba(16,185,129,0.8);"></div>
                    <span style="font-weight: bold; letter-spacing: 0.025em;">Caja Abierta</span>
                </div>
            @else
                <div style="display: flex; align-items: center; background-color: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.3); border-radius: 1rem; padding: 0.5rem 1rem; gap: 0.5rem;">
                    <div style="width: 0.75rem; height: 0.75rem; border-radius: 50%; background-color: #ef4444; box-shadow: 0 0 8px rgba(239,68,68,0.8);"></div>
                    <span style="font-weight: bold; letter-spacing: 0.025em;">Caja Cerrada</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        
        <!-- Panel Izquierdo: Info de Turno -->
        <div style="display: flex; flex-direction: column; background-color: #1e2638; border-radius: 2.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.05); padding: 2.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: bold; color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1); margin: 0 0 2rem 0; padding-bottom: 1rem;">Estado del Turno Actual</h2>
            
            @if($activeSession)
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; color: #94a3b8;">
                        <span>Fondo Inicial</span>
                        <span style="color: white; font-weight: bold; font-size: 1.25rem;">${{ number_format($activeSession->opening_amount, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; color: #94a3b8;">
                        <span>Ventas Totales del Turno</span>
                        <span style="color: white; font-weight: bold; font-size: 1.25rem;">${{ number_format($totalSales, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; color: #94a3b8;">
                        <span>Ventas en Efectivo</span>
                        <span style="color: white; font-weight: bold; font-size: 1.25rem;">${{ number_format($totalCash, 2) }}</span>
                    </div>
                    
                    <div style="border-top: 1px solid rgba(255,255,255,0.1); margin: 0.5rem 0;"></div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #cbd5e1; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em;">Efectivo Esperado en Caja</span>
                        <span style="font-size: 1.875rem; font-weight: bold; color: var(--accent);">${{ number_format($expectedAmount, 2) }}</span>
                    </div>
                    
                    <button onclick="document.getElementById('modal-corte').classList.remove('hidden')" style="margin-top: 2rem; background-color: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.3); border-radius: 1rem; font-weight: bold; padding: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 15px -3px rgba(239,68,68,0.05);" onmouseover="this.style.backgroundColor='rgba(239,68,68,0.2)'" onmouseout="this.style.backgroundColor='rgba(239,68,68,0.1)'">
                        <span class="material-symbols-rounded">lock_clock</span>
                        Realizar Corte y Cerrar Turno
                    </button>
                </div>
            @else
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #64748b; min-height: 250px;">
                    <span class="material-symbols-rounded" style="opacity: 0.5; margin-bottom: 1rem; font-size: 4rem;">lock_clock</span>
                    <p style="font-size: 1.25rem; font-weight: 500; margin: 0 0 1.5rem 0;">No hay turno activo</p>
                    
                    <button onclick="document.getElementById('modal-apertura').classList.remove('hidden')" style="background-color: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.3); border-radius: 1rem; font-weight: bold; padding: 0.75rem 2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.3s;" onmouseover="this.style.backgroundColor='rgba(16,185,129,0.2)'" onmouseout="this.style.backgroundColor='rgba(16,185,129,0.1)'">
                        <span class="material-symbols-rounded">key</span>
                        Abrir Caja
                    </button>
                </div>
            @endif
        </div>
        
        <!-- Panel Derecho: Instrucciones -->
        <div class="flex flex-col bg-[#1e2638] rounded-[2.5rem] shadow-xl border border-white/5" style="padding: 2.5rem;">
            <h2 class="text-xl font-bold text-slate-300 border-b border-white/10" style="margin-bottom: 2rem; padding-bottom: 1rem;">Instrucciones de Caja</h2>
            <p class="text-slate-400 leading-relaxed mb-4">
                El sistema de caja garantiza que los flujos de dinero se registren de manera auditable.
            </p>
            <ul class="list-disc list-inside text-slate-400 space-y-2">
                <li>Es obligatorio abrir caja antes de poder usar el Punto de Venta (POS).</li>
                <li>El sistema calcula el efectivo esperado basado en las ventas cobradas en efectivo.</li>
                <li>Al cerrar el turno, debes declarar físicamente cuánto efectivo hay en la gaveta.</li>
                <li>Cualquier diferencia (faltante o sobrante) quedará registrada permanentemente en el corte.</li>
            </ul>
        </div>
    </div>
</div>

<!-- ===== MODAL DE APERTURA DE CAJA ===== -->
<div id="modal-apertura" class="fixed inset-0 z-[9999] flex items-center justify-center hidden" style="background-color: rgba(0,0,0,0.8); backdrop-filter: blur(8px);">
  <div style="background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 1.5rem; width: 100%; max-width: 28rem; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7); overflow: hidden;">
    <div style="border-bottom: 1px solid rgba(255,255,255,0.05); padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
      <div style="width: 3rem; height: 3rem; background-color: rgba(16,185,129,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #10b981;">
        <span class="material-symbols-rounded" style="font-size: 1.5rem;">key</span>
      </div>
      <h3 style="font-size: 1.25rem; font-weight: bold; color: white; margin: 0;">Apertura de Caja</h3>
    </div>
    <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
      <div style="display: flex; flex-direction: column; gap: 0.5rem;">
        <label style="font-size: 0.875rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Fondo Inicial en Efectivo</label>
        <div style="position: relative; display: flex; align-items: center;">
          <span style="position: absolute; left: 1rem; color: #10b981; font-weight: bold; font-size: 1.25rem;">$</span>
          <input type="number" id="opening_amount" value="0.00" step="0.5" style="width: 100%; background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 1rem 1rem 1rem 2.5rem; color: white; font-size: 1.5rem; font-weight: bold; font-family: monospace; outline: none; box-sizing: border-box;">
        </div>
        <p style="font-size: 0.75rem; color: #64748b; margin: 0; margin-top: 0.25rem;">Este es el dinero con el que inicia el cajón antes de vender.</p>
      </div>
      <div style="display: flex; align-items: center; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05); gap: 1rem;">
        <button onclick="document.getElementById('modal-apertura').classList.add('hidden')" style="background: transparent; border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: bold; padding: 0.75rem 1.5rem; border-radius: 0.75rem; cursor: pointer;">Cancelar</button>
        <button onclick="abrirCaja()" style="background-color: #10b981; border: none; color: #020617; font-weight: bold; padding: 0.75rem 1.5rem; border-radius: 0.75rem; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; box-shadow: 0 4px 15px rgba(16,185,129,0.2);">
            <span class="material-symbols-rounded" style="font-size: 1.25rem;">check</span>
            Abrir Caja
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ===== MODAL DE CORTE DE CAJA ===== -->
<div id="modal-corte" class="fixed inset-0 z-[9999] flex items-center justify-center hidden" style="background-color: rgba(0,0,0,0.8); backdrop-filter: blur(8px);">
  <div style="background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 1.5rem; width: 100%; max-width: 28rem; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7); overflow: hidden;">
    <div style="border-bottom: 1px solid rgba(255,255,255,0.05); padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
      <div style="width: 3rem; height: 3rem; background-color: rgba(239,68,68,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ef4444;">
        <span class="material-symbols-rounded" style="font-size: 1.5rem;">lock_clock</span>
      </div>
      <h3 style="font-size: 1.25rem; font-weight: bold; color: white; margin: 0;">Corte de Caja (Cierre)</h3>
    </div>
    <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
      <div style="display: flex; flex-direction: column; gap: 0.5rem;">
        <label style="font-size: 0.875rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Efectivo Físico Contado</label>
        <div style="position: relative; display: flex; align-items: center;">
          <span style="position: absolute; left: 1rem; color: #10b981; font-weight: bold; font-size: 1.25rem;">$</span>
          <input type="number" id="closing_amount" value="0.00" step="0.5" style="width: 100%; background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 1rem 1rem 1rem 2.5rem; color: white; font-size: 1.5rem; font-weight: bold; font-family: monospace; outline: none; box-sizing: border-box;">
        </div>
        <p style="font-size: 0.75rem; color: #64748b; margin: 0; margin-top: 0.25rem;">Declara cuánto dinero físico tienes en este momento. El sistema registrará sobrantes o faltantes automáticamente.</p>
      </div>
      <div style="display: flex; align-items: center; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05); gap: 1rem;">
        <button onclick="document.getElementById('modal-corte').classList.add('hidden')" style="background: transparent; border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: bold; padding: 0.75rem 1.5rem; border-radius: 0.75rem; cursor: pointer;">Cancelar</button>
        <button onclick="cerrarCaja()" style="background-color: #ef4444; border: none; color: white; font-weight: bold; padding: 0.75rem 1.5rem; border-radius: 0.75rem; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; box-shadow: 0 4px 15px rgba(239,68,68,0.2);">
            <span class="material-symbols-rounded" style="font-size: 1.25rem;">verified</span>
            Cerrar Turno
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function abrirCaja() {
    const amount = document.getElementById('opening_amount').value;
    fetch('{{ route("caja.abrir") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ opening_amount: amount })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            toast(data.message, 'success');
            setTimeout(() => location.reload(), 800);
        } else {
            toast(data.message || 'Error al abrir caja', 'danger');
        }
    });
}

function cerrarCaja() {
    const amount = document.getElementById('closing_amount').value;
    fetch('{{ route("caja.cerrar") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ closing_amount: amount })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            toast(data.message, 'success');
            setTimeout(() => location.reload(), 800);
        } else {
            toast(data.message || 'Error al cerrar caja', 'danger');
        }
    });
}
</script>
@endpush
