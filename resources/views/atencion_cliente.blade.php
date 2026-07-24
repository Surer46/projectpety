@extends('layouts.app')

@section('title', 'Cafeteria PETY | Atención al Cliente')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-8" style="padding: 1.5rem 1.5rem 3rem 1.5rem;">

  <!-- Hero Header -->
  <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 shadow-2xl" style="background-color: #1e2638; border: 1px solid rgba(255, 255, 255, 0.08); padding: 2.25rem; border-radius: 2.5rem;">
    <div class="flex flex-col gap-3 z-10">
      <div class="inline-flex items-center text-xs font-bold uppercase tracking-wider w-fit whitespace-nowrap" style="background-color: rgba(199,156,94,0.1); color: #c79c5e; border: 1px solid rgba(199,156,94,0.3); padding: 0.4rem 0.9rem; border-radius: 9999px; gap: 0.5rem;">
        <span class="material-symbols-rounded text-sm">support_agent</span>
        Centro de Ayuda PETY
      </div>
      <h1 class="text-3xl md:text-4xl font-bold text-white flex items-center gap-3" style="font-family: 'Playfair Display', Georgia, serif; line-height: 1.2;">
        Atención al <span class="italic font-normal" style="color: #c79c5e;">Cliente &amp; Soporte</span>
      </h1>
      <p class="text-slate-400 text-sm max-w-2xl leading-relaxed" style="margin-top: 0.25rem;">
        Estamos dedicados a brindarte la mejor experiencia. Escríbenos directamente, consulta nuestras Preguntas Frecuentes o comunícate por nuestros canales oficiales.
      </p>
    </div>
    
    <div class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 shadow-inner hidden md:flex" style="background: rgba(199, 156, 94, 0.15); color: #c79c5e; border: 1px solid rgba(199,156,94,0.3);">
      <span class="material-symbols-rounded text-4xl">headset_mic</span>
    </div>
  </div>

  <!-- Cards de Contacto Directo (4 columnas con diseño glassmorphism) -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    
    <!-- Teléfono -->
    <div class="group flex items-center shadow-xl transition-all duration-300 hover:-translate-y-1" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); padding: 1.25rem; border-radius: 1.75rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 text-emerald-400 border border-emerald-500/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
        <span class="material-symbols-rounded text-2xl">call</span>
      </div>
      <div class="min-w-0 flex-1">
        <div class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest">Teléfono Directo</div>
        <div class="text-white font-bold text-base tracking-tight truncate mt-0.5">555-010-0202</div>
      </div>
    </div>

    <!-- WhatsApp -->
    <div class="group flex items-center shadow-xl transition-all duration-300 hover:-translate-y-1" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); padding: 1.25rem; border-radius: 1.75rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl bg-green-500/15 text-green-400 border border-green-500/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
        <span class="material-symbols-rounded text-2xl">chat</span>
      </div>
      <div class="min-w-0 flex-1">
        <div class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest">WhatsApp Soporte</div>
        <div class="text-white font-bold text-base tracking-tight truncate mt-0.5">+52 55 1234 5678</div>
      </div>
    </div>

    <!-- Email -->
    <div class="group flex items-center shadow-xl transition-all duration-300 hover:-translate-y-1" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); padding: 1.25rem; border-radius: 1.75rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl bg-blue-500/15 text-blue-400 border border-blue-500/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
        <span class="material-symbols-rounded text-2xl">mail</span>
      </div>
      <div class="min-w-0 flex-1">
        <div class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest">Correo Electrónico</div>
        <div class="text-white font-bold text-xs tracking-tight truncate mt-0.5">contacto@cafeteriapety.com</div>
      </div>
    </div>

    <!-- Horarios -->
    <div class="group flex items-center shadow-xl transition-all duration-300 hover:-translate-y-1" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); padding: 1.25rem; border-radius: 1.75rem; gap: 1rem;">
      <div class="w-12 h-12 rounded-2xl bg-amber-500/15 border border-amber-500/20 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform" style="color: #c79c5e;">
        <span class="material-symbols-rounded text-2xl">schedule</span>
      </div>
      <div class="min-w-0 flex-1">
        <div class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest">Horario de Atención</div>
        <div class="text-white font-bold text-xs tracking-tight truncate mt-0.5">Lun - Dom: 7:00 - 22:00</div>
      </div>
    </div>

  </div>

  <!-- Formulario y FAQ Grid (2 Columnas estilizadas) -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Formulario de Mensaje -->
    <div class="lg:col-span-7 shadow-2xl flex flex-col gap-6" style="background-color: #1e2638; border: 1px solid rgba(255,255,255,0.08); padding: 2rem; border-radius: 2.5rem;">
      <div class="border-b border-white/10 pb-4">
        <h2 class="text-2xl font-bold text-white flex items-center gap-3" style="font-family: 'Playfair Display', Georgia, serif;">
          <span class="material-symbols-rounded text-2xl" style="color: #c79c5e;">send</span>
          Envíanos un Mensaje
        </h2>
        <p class="text-xs text-slate-400 mt-1">Completa el formulario y te responderemos a la brevedad posible.</p>
      </div>

      <form id="contact-form" onsubmit="enviarMensajeSoporte(event)" class="flex flex-col gap-5">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div class="flex flex-col gap-1.5">
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre Completo</label>
            <input type="text" id="contact-name" required placeholder="Tu nombre" 
                   class="w-full text-white text-sm outline-none transition-all"
                   style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"
                   onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 12px rgba(199,156,94,0.2)';" 
                   onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"/>
          </div>
          <div class="flex flex-col gap-1.5">
            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Correo Electrónico</label>
            <input type="email" id="contact-email" required placeholder="tu@email.com" 
                   class="w-full text-white text-sm outline-none transition-all"
                   style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"
                   onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 12px rgba(199,156,94,0.2)';" 
                   onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"/>
          </div>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Asunto / Motivo</label>
          <div class="relative">
            <select id="contact-subject" required 
                    class="w-full text-white text-sm outline-none cursor-pointer transition-all"
                    style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08); appearance: none; -webkit-appearance: none;"
                    onfocus="this.style.borderColor='#c79c5e';" 
                    onblur="this.style.borderColor='rgba(255,255,255,0.08)';">
              <option value="Sugerencia u Opinión">Sugerencia u Opinión</option>
              <option value="Consulta sobre Pedido">Consulta sobre Pedido</option>
              <option value="Facturación Electrónica">Facturación Electrónica</option>
              <option value="Servicio de Catering">Servicio de Catering / Eventos</option>
              <option value="Otro">Otro</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
              <span class="material-symbols-rounded">expand_more</span>
            </div>
          </div>
        </div>

        <div class="flex flex-col gap-1.5">
          <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Mensaje</label>
          <textarea id="contact-message" rows="4" required placeholder="Escribe aquí tu mensaje o solicitud..." 
                    class="w-full text-white text-sm outline-none transition-all custom-scrollbar resize-none"
                    style="background: rgba(15, 23, 42, 0.5); padding: 0.85rem 1rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.08);"
                    onfocus="this.style.borderColor='#c79c5e'; this.style.boxShadow='0 0 12px rgba(199,156,94,0.2)';" 
                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"></textarea>
        </div>

        <div class="flex items-center justify-end" style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; margin-top: 1rem;">
          <button type="submit" id="btn-submit-contact" 
                  class="font-bold text-xs shadow-xl transition-all hover:brightness-110 active:scale-95 flex items-center justify-center gap-2 cursor-pointer"
                  style="background-color: #c79c5e; color: #0a0f18; padding: 0.75rem 1.5rem; border-radius: 1rem; border: none;">
            <span class="material-symbols-rounded text-sm">send</span>
            <span>Enviar Mensaje</span>
          </button>
        </div>
      </form>
    </div>

    <!-- FAQ Accordion -->
    <div class="lg:col-span-5 flex flex-col gap-4">
      <div class="border-b border-white/10 pb-4">
        <h2 class="text-2xl font-bold text-white flex items-center gap-3" style="font-family: 'Playfair Display', Georgia, serif;">
          <span class="material-symbols-rounded text-2xl" style="color: #c79c5e;">help_outline</span>
          Preguntas Frecuentes
        </h2>
        <p class="text-xs text-slate-400 mt-1">Respuesta rápida a las dudas más habituales.</p>
      </div>

      <div class="flex flex-col gap-3.5">
        
        <div class="border border-white/5 rounded-2xl overflow-hidden transition-all duration-300" style="background-color: #1e2638;">
          <button onclick="toggleFaq(this)" class="w-full text-left font-bold text-white text-sm flex items-center justify-between hover:bg-white/5 transition-colors" style="padding: 1.25rem; cursor: pointer; border: none; background: transparent;">
            <span class="pr-2">¿Cómo funciona el programa de Puntos de Lealtad?</span>
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-transform duration-300" style="background: rgba(199,156,94,0.1); color: #c79c5e;">
              <span class="material-symbols-rounded text-lg">expand_more</span>
            </div>
          </button>
          <div class="hidden text-slate-400 text-xs leading-relaxed border-t border-white/5" style="padding: 1.25rem; background-color: #161c2a;">
            Acumulas 1 punto por cada $10.00 pesos en tus compras. Puedes seleccionar el cliente en el POS y redimir tus puntos acumulados como descuento directo ($1 peso por punto).
          </div>
        </div>

        <div class="border border-white/5 rounded-2xl overflow-hidden transition-all duration-300" style="background-color: #1e2638;">
          <button onclick="toggleFaq(this)" class="w-full text-left font-bold text-white text-sm flex items-center justify-between hover:bg-white/5 transition-colors" style="padding: 1.25rem; cursor: pointer; border: none; background: transparent;">
            <span class="pr-2">¿Tienen servicio a domicilio o pedidos en línea?</span>
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-transform duration-300" style="background: rgba(199,156,94,0.1); color: #c79c5e;">
              <span class="material-symbols-rounded text-lg">expand_more</span>
            </div>
          </button>
          <div class="hidden text-slate-400 text-xs leading-relaxed border-t border-white/5" style="padding: 1.25rem; background-color: #161c2a;">
            ¡Sí! Puedes realizar tus pedidos desde nuestra plataforma web incluso en modo Offline. Tus órdenes se guardan localmente y se sincronizan cuando recuperes conexión.
          </div>
        </div>

        <div class="border border-white/5 rounded-2xl overflow-hidden transition-all duration-300" style="background-color: #1e2638;">
          <button onclick="toggleFaq(this)" class="w-full text-left font-bold text-white text-sm flex items-center justify-between hover:bg-white/5 transition-colors" style="padding: 1.25rem; cursor: pointer; border: none; background: transparent;">
            <span class="pr-2">¿Cómo solicito factura electrónica de mi compra?</span>
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-transform duration-300" style="background: rgba(199,156,94,0.1); color: #c79c5e;">
              <span class="material-symbols-rounded text-lg">expand_more</span>
            </div>
          </button>
          <div class="hidden text-slate-400 text-xs leading-relaxed border-t border-white/5" style="padding: 1.25rem; background-color: #161c2a;">
            Puedes solicitar tu factura al momento de pagar en caja proporcionando tus datos fiscales, o enviando un mensaje mediante el formulario de soporte con tu número de orden.
          </div>
        </div>

        <div class="border border-white/5 rounded-2xl overflow-hidden transition-all duration-300" style="background-color: #1e2638;">
          <button onclick="toggleFaq(this)" class="w-full text-left font-bold text-white text-sm flex items-center justify-between hover:bg-white/5 transition-colors" style="padding: 1.25rem; cursor: pointer; border: none; background: transparent;">
            <span class="pr-2">¿Ofrecen opciones sin lácteos o sustitutos veganos?</span>
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-transform duration-300" style="background: rgba(199,156,94,0.1); color: #c79c5e;">
              <span class="material-symbols-rounded text-lg">expand_more</span>
            </div>
          </button>
          <div class="hidden text-slate-400 text-xs leading-relaxed border-t border-white/5" style="padding: 1.25rem; background-color: #161c2a;">
            Contamos con modificadores opcionales como leche deslactosada, leche de almendras y leche de avena para todas nuestras bebidas preparadas.
          </div>
        </div>

      </div>
    </div>

  </div>

</div>

@push('scripts')
<script>
function toggleFaq(btn) {
    const content = btn.nextElementSibling;
    const iconContainer = btn.querySelector('div');
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        if (iconContainer) iconContainer.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        if (iconContainer) iconContainer.style.transform = 'rotate(0deg)';
    }
}

function enviarMensajeSoporte(e) {
    e.preventDefault();
    const btn = document.getElementById('btn-submit-contact');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-rounded animate-spin">sync</span> Enviando...';

    const payload = {
        name: document.getElementById('contact-name').value,
        email: document.getElementById('contact-email').value,
        subject: document.getElementById('contact-subject').value,
        message: document.getElementById('contact-message').value
    };

    fetch('{{ route("atencion-cliente.message") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (typeof toast === 'function') toast(data.message, 'success');
        document.getElementById('contact-form').reset();
    })
    .catch(err => {
        if (typeof toast === 'function') toast('Error al enviar el mensaje', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<span class="material-symbols-rounded">send</span> <span>Enviar Mensaje</span>';
    });
}
</script>
@endpush
@endsection
