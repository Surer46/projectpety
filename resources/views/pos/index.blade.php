@extends('layouts.app')

@section('title', 'Cafeteria PETY | Ventas')

@php
    $cats = [
        ['id' => 'todos',           'icon' => 'grid_view',           'label' => 'Todos'],
        ['id' => 'comidas-del-dia', 'icon' => 'restaurant',          'label' => 'Comidas del Día'],
        ['id' => 'cafes',           'icon' => 'local_cafe',          'label' => 'Cafés'],
        ['id' => 'tes',             'icon' => 'emoji_food_beverage', 'label' => 'Tés &amp; Infusiones'],
        ['id' => 'especiales',      'icon' => 'restaurant_menu',     'label' => 'Especialidades'],
        ['id' => 'pasteles',        'icon' => 'cake',                'label' => 'Pasteles &amp; Dulces'],
    ];
    $categoriaActiva = request('cat', 'todos');
    $busqueda = request('q', '');
@endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet"/>
<style>
.cats{display:flex;gap:.6rem;flex-wrap:wrap;}
.cat-btn{
  display:flex;flex-direction:column;align-items:center;gap:4px;
  padding:.6rem 1.1rem;border-radius:14px;
  border:1px solid rgba(255,255,255,0.08);
  background:rgba(255,255,255,0.05);
  cursor:pointer;font-family:inherit;
  font-size:.75rem;font-weight:500;color:var(--muted);
  transition:all .18s;text-decoration:none;
}
.cat-btn:hover{background:rgba(255,255,255,0.10);color:#fff;}
.cat-btn.active{
  background:#c79c5e;color:#0a0f18;
  border-color:#c79c5e;
  box-shadow:0 4px 14px rgba(199,156,94,0.25);
  font-weight:700;
}
.cat-btn .material-symbols-rounded{font-size:22px;font-variation-settings:'FILL' 1;}
</style>
@endpush

@section('content')

<!-- ===== SECCIÓN DE VENTAS (PANTALLA COMPLETA) ===== -->
<div id="pos-grid-view" class="w-full flex flex-col gap-4 h-full transition-opacity duration-300">
  <div class="flex flex-wrap gap-4 items-center justify-between">
    <h1 class="text-3xl font-bold text-white flex items-center gap-4" style="font-family: 'Playfair Display', Georgia, serif;">
      <span class="material-symbols-rounded text-3xl" style="color: #c79c5e;">point_of_sale</span>
      Catálogo de <span class="italic font-medium ml-1" style="color: #c79c5e;">Productos</span>
    </h1>
    <div class="flex items-center gap-3">
      <form method="get" action="/ventas" style="display:contents">
        <input type="hidden" name="cat" value="{{ $categoriaActiva }}"/>
        <div class="flex items-center border border-white/5 transition-colors shadow-lg" style="background-color: #1e2638; padding: 0.75rem 1.25rem; gap: 0.75rem; border-radius: 1rem;">
          <span class="material-symbols-rounded text-slate-400" style="font-size: 22px;">search</span>
          <input id="input-buscar" type="text" name="q" value="{{ $busqueda }}"
                 placeholder="Buscar productos..." autocomplete="off" 
                 class="bg-transparent border-none outline-none text-white placeholder-slate-500" style="width: 14rem; font-size: 1rem;"/>
        </div>
        <div style="position: relative;">
          <button type="button" onclick="document.getElementById('filtro-avanzado').classList.toggle('hidden')" id="btn-filtros" title="Filtros Avanzados" class="flex items-center justify-center border border-white/5 text-slate-400 hover:text-white transition-colors shadow-lg" style="background-color: #1e2638; width: 3.25rem; height: 3.25rem; border-radius: 1rem;" onmouseover="this.style.backgroundColor='#2a3449'" onmouseout="this.style.backgroundColor='#1e2638'">
            <span class="material-symbols-rounded" style="font-size: 24px;">tune</span>
          </button>
          <!-- Menú desplegable de filtros avanzados -->
          <div id="filtro-avanzado" class="hidden" style="position: absolute; right: 0; top: 100%; margin-top: 0.75rem; width: 18rem; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); padding: 1.25rem; z-index: 50; text-align: left; cursor: default;">
            <div style="margin-bottom: 1.25rem;">
              <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Ordenar Por</label>
              <select name="sort" class="transition-colors" style="width: 100%; background-color: #1e293b; font-size: 0.875rem; color: white; border: 1px solid rgba(255,255,255,0.1); border-radius: 0.5rem; padding: 0.6rem 0.75rem; outline: none; cursor: pointer;">
                <option value="name_asc" {{ isset($sort) && $sort == 'name_asc' ? 'selected' : '' }}>Alfabetico (A - Z)</option>
                <option value="price_asc" {{ isset($sort) && $sort == 'price_asc' ? 'selected' : '' }}>Precio (Menor a Mayor)</option>
                <option value="price_desc" {{ isset($sort) && $sort == 'price_desc' ? 'selected' : '' }}>Precio (Mayor a Menor)</option>
              </select>
            </div>
            <div style="margin-bottom: 1.5rem;">
              <label class="transition-colors hover:text-white" style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; font-size: 0.875rem; color: #cbd5e1; padding: 0.5rem; border-radius: 0.5rem;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.05)'" onmouseout="this.style.backgroundColor='transparent'">
                <input type="checkbox" name="featured" value="1" {{ isset($featured) && $featured == '1' ? 'checked' : '' }} class="cursor-pointer" style="width: 1.25rem; height: 1.25rem; accent-color: #c79c5e;">
                Mostrar solo destacados
              </label>
            </div>
            <button type="submit" class="transition-colors flex items-center justify-center gap-2" style="width: 100%; background-color: #c79c5e; color: #0a0f18; font-weight: 700; border-radius: 0.5rem; padding: 0.65rem; box-shadow: 0 4px 15px rgba(199,156,94,0.25);" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='none'">
              <span class="material-symbols-rounded" style="font-size: 20px;">check</span>
              Aplicar Filtros
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="glass-panel w-full flex-1 flex flex-col min-h-0" style="padding: 2rem;">

    <div class="cats shrink-0" style="margin-bottom: 2.5rem;">
      @foreach ($cats as $cat)
        @php $active = $cat['id'] == $categoriaActiva ? "active" : ""; @endphp
        <a id="cat-{{ $cat['id'] }}" class="cat-btn {{ $active }}"
           href="/ventas?cat={{ $cat['id'] }}&q={{ urlencode($busqueda) }}">
          <span class="material-symbols-rounded">{{ $cat['icon'] }}</span>
          {!! $cat['label'] !!}
        </a>
      @endforeach
    </div>

    <!-- Grid de productos a pantalla completa (4 Tarjetas Holgadas por Fila) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 w-full overflow-y-auto" style="gap: 2rem; padding: 0.5rem 1rem 4rem 1rem;">

        <!-- APARTADO DEDICADO: COMIDAS DEL DÍA & MENÚ EJECUTIVO -->
        @if(isset($dailyMeals) && count($dailyMeals) > 0 && ($categoriaActiva === 'todos' || $categoriaActiva === 'comidas-del-dia') && !$busqueda)
            <div class="col-span-full border-b border-white/10 pb-3 mb-2 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-extrabold shadow-lg shrink-0 border border-white/10" style="background: rgba(199,156,94,0.15); color: #c79c5e;">
                        <span class="material-symbols-rounded text-2xl">restaurant</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white tracking-wide flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
                            Comidas del Día <span class="italic font-normal" style="color: #c79c5e;">&amp; Menú Ejecutivo</span>
                        </h2>
                    </div>
                </div>
                <span class="text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow border inline-flex items-center justify-center" style="background-color: rgba(199,156,94,0.12); border-color: rgba(199,156,94,0.3); color: #c79c5e; padding-left: 1.25rem; padding-right: 1.25rem; padding-top: 0.4rem; padding-bottom: 0.4rem; line-height: 1.3;">
                    Platillos del Día
                </span>
            </div>

            @foreach($dailyMeals as $meal)
                @php
                    $mealImgUrl = null;
                    if (!empty($meal->image_path)) {
                        $mealImgUrl = str_starts_with($meal->image_path, 'http') ? $meal->image_path : asset($meal->image_path);
                    }
                @endphp

                <div class="group flex flex-col justify-between border border-white/5 shadow-xl transition-all duration-300 {{ $meal->is_out_of_stock ? 'opacity-60 cursor-not-allowed' : 'hover:scale-[1.02] cursor-pointer hover:border-[#c79c5e]/40' }} relative overflow-hidden" 
                     style="background-color: #1e2638; border-radius: 1.75rem; padding: 1.25rem; min-height: 390px; {{ $meal->is_out_of_stock ? 'filter: grayscale(80%);' : '' }}"
                     @if(!$meal->is_out_of_stock) onclick="abrirVistaDetalle(this)" @endif
                     data-id="{{ $meal->id }}"
                     data-name="{{ addslashes($meal->name) }}"
                     data-description="{{ addslashes($meal->description ?? '') }}"
                     data-price="{{ $meal->base_price }}"
                     data-stock="{{ $meal->stock ?? 99 }}"
                     data-image="{{ $mealImgUrl ?? '' }}"
                     data-emoji="{{ $meal->emoji ?? '🍽️' }}"
                     data-gallery="{{ json_encode($meal->gallery ?? []) }}"
                     data-allow-modifiers="{{ $meal->allow_modifiers ?? 0 }}">
                    
                    {{-- Banner Superior Rectangular de Imagen Taller (h-52) --}}
                    <div class="w-full h-52 rounded-2xl overflow-hidden relative mb-3.5 bg-slate-900/80 border border-white/5 shrink-0 flex items-center justify-center">
                        @if($mealImgUrl)
                            <img src="{{ $mealImgUrl }}" alt="{{ $meal->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-amber-950/40 to-slate-950 flex items-center justify-center text-5xl">
                                {{ $meal->emoji ?? '🍽️' }}
                            </div>
                        @endif

                        <div class="absolute top-2.5 left-2.5 z-10">
                            @if($meal->is_out_of_stock)
                                <span class="inline-block uppercase tracking-wider font-bold text-red-400 bg-red-950/80 backdrop-blur-md border border-red-500/30 shadow-lg text-[0.65rem]" style="padding: 0.3rem 0.75rem; border-radius: 0.75rem;">
                                    AGOTADO
                                </span>
                            @else
                                <span class="inline-block uppercase tracking-wider font-bold text-emerald-400 bg-emerald-950/80 backdrop-blur-md border border-emerald-500/30 shadow-lg text-[0.65rem]" style="padding: 0.3rem 0.75rem; border-radius: 0.75rem;">
                                    Disponible
                                </span>
                            @endif
                        </div>
                    </div>

                          {{-- Info del Platillo Alineada Simétricamente --}}
                <div class="flex-1 flex flex-col justify-between items-center text-center w-full px-1 my-2">
                    <div class="w-full flex items-center justify-center min-h-[3rem]">
                        <h3 class="font-serif text-base font-bold tracking-wide text-white leading-snug line-clamp-2 text-center">
                            {{ $meal->name }}
                        </h3>
                    </div>
                    <div class="flex items-center justify-center gap-2 mt-2 mb-1">
                        <span class="font-bold text-xl tracking-tight" style="color: #c79c5e;">${{ number_format($meal->base_price, 2) }}</span>
                    </div>
                </div>

                {{-- Bottom: Botón Separado Espaciosamente --}}
                <div class="w-full" style="margin-top: 1rem;">
                    <button onclick="event.stopPropagation(); abrirVistaDetalle(this.closest('.group'))" 
                            class="w-full text-slate-950 font-bold transition-all duration-300 flex items-center justify-center transform active:scale-95 text-xs tracking-wide cursor-pointer" 
                            style="background-color: #c79c5e; padding: 0.75rem 1rem; border-radius: 0.85rem; gap: 0.4rem; box-shadow: 0 4px 15px rgba(199,156,94,0.25);" 
                            onmouseover="this.style.backgroundColor='#d9b275';" 
                            onmouseout="this.style.backgroundColor='#c79c5e';">
                        <span class="material-symbols-rounded text-base">restaurant</span>
                        <span>Ordenar Comida</span>
                    </button>
                </div>
                </div>
            @endforeach

            <!-- Encabezado de Productos del Catálogo General (Bebidas y Repostería) -->
            @if($categoriaActiva === 'todos')
            <div class="col-span-full border-b border-white/10 pb-3 mt-6 mb-2 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center gap-2" style="font-family: 'Playfair Display', Georgia, serif;">
                    Catálogo General de Productos <span class="text-slate-400 font-normal text-base">(Bebidas &amp; Repostería)</span>
                </h2>
            </div>
            @endif
        @endif

        @foreach ($products as $p)
            @if($categoriaActiva === 'todos' && isset($dailyMealsCategory) && $p->category_id == $dailyMealsCategory->id)
                @continue
            @endif

            @php
                $imgUrl = null;
                if (!empty($p->image_path)) {
                    $imgUrl = str_starts_with($p->image_path, 'http') ? $p->image_path : asset($p->image_path);
                }
            @endphp

            <div class="group flex flex-col justify-between border border-white/5 shadow-xl transition-all duration-300 {{ $p->is_out_of_stock ? 'opacity-60 cursor-not-allowed' : 'hover:scale-[1.02] cursor-pointer hover:border-[#c79c5e]/40' }} relative overflow-hidden" 
                 style="background-color: #1e2638; border-radius: 1.75rem; padding: 1.25rem; min-height: 390px; {{ $p->is_out_of_stock ? 'filter: grayscale(80%);' : '' }}"
                 @if(!$p->is_out_of_stock) onclick="abrirVistaDetalle(this)" @endif
                 data-id="{{ $p->id }}"
                 data-name="{{ addslashes($p->name) }}"
                 data-description="{{ addslashes($p->description ?? '') }}"
                 data-price="{{ $p->discounted_price ?? $p->base_price }}"
                 data-stock="{{ $p->stock ?? 0 }}"
                 data-image="{{ $imgUrl ?? '' }}"
                 data-emoji="{{ $p->emoji ?? '☕' }}"
                 data-gallery="{{ json_encode($p->gallery ?? []) }}"
                 data-allow-modifiers="{{ $p->allow_modifiers ?? 0 }}">
                
                {{-- Banner Superior Rectangular de Imagen Taller (h-52) --}}
                <div class="w-full h-52 rounded-2xl overflow-hidden relative mb-3.5 bg-slate-900/80 border border-white/5 shrink-0 flex items-center justify-center">
                    @if($imgUrl)
                        <img src="{{ $imgUrl }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-slate-800 to-slate-950 flex items-center justify-center text-5xl">
                            {{ $p->emoji ?? '☕' }}
                        </div>
                    @endif

                    {{-- Badges Sobre la Imagen (Backdrop Blur) --}}
                    <div class="absolute top-2.5 right-2.5 z-10 flex flex-col gap-1 items-end">
                        @if(isset($p->has_promotion) && $p->has_promotion)
                            <span class="inline-block font-bold text-slate-950 text-[0.65rem] uppercase tracking-wider px-2.5 py-1 rounded-lg shadow-lg" style="background-color: #c79c5e;">
                                {{ $p->promotion_badge }}
                            </span>
                        @endif
                    </div>

                    <div class="absolute top-2.5 left-2.5 z-10">
                        @if($p->is_out_of_stock)
                            <span class="inline-block uppercase tracking-wider font-bold text-red-400 bg-red-950/80 backdrop-blur-md border border-red-500/30 shadow-lg text-[0.65rem]" style="padding: 0.3rem 0.75rem; border-radius: 0.75rem;">
                                AGOTADO
                            </span>
                        @else
                            <span class="inline-block uppercase tracking-wider font-bold text-emerald-400 bg-emerald-950/80 backdrop-blur-md border border-emerald-500/30 shadow-lg text-[0.65rem]" style="padding: 0.3rem 0.75rem; border-radius: 0.75rem;">
                                Disponible
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Info del Producto Alineada Simétricamente --}}
                <div class="flex-1 flex flex-col justify-between items-center text-center w-full px-1 my-2">
                    <div class="w-full flex items-center justify-center min-h-[3rem]">
                        <h3 class="font-serif text-base font-bold tracking-wide text-white leading-snug line-clamp-2 text-center">
                            {{ $p->name }}
                        </h3>
                    </div>
                    <div class="flex items-center justify-center gap-2 mt-2 mb-1">
                        @if(isset($p->has_promotion) && $p->has_promotion)
                            <span class="line-through text-slate-400 text-xs font-semibold">${{ number_format($p->base_price, 2) }}</span>
                            <span class="font-bold text-xl tracking-tight text-amber-400">${{ number_format($p->discounted_price, 2) }}</span>
                        @else
                            <span class="font-bold text-xl tracking-tight" style="color: #c79c5e;">${{ number_format($p->base_price, 2) }}</span>
                        @endif
                    </div>
                </div>

                {{-- Bottom: Botón Separado Espaciosamente --}}
                <div class="w-full" style="margin-top: 1rem;">
                    <button onclick="event.stopPropagation(); abrirVistaDetalle(this.closest('.group'))" 
                            class="w-full text-slate-950 font-bold transition-all duration-300 flex items-center justify-center transform active:scale-95 text-xs tracking-wide cursor-pointer" 
                            style="background-color: #c79c5e; padding: 0.75rem 1rem; border-radius: 0.85rem; gap: 0.4rem; box-shadow: 0 4px 15px rgba(199,156,94,0.25);" 
                            onmouseover="this.style.backgroundColor='#d9b275';" 
                            onmouseout="this.style.backgroundColor='#c79c5e';">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 110 4 2 2 0 010-4z" />
                        </svg>
                        <span>Agregar</span>
                    </button>
                </div>

            </div>
        @endforeach
    </div>
  </div>
</div>

<!-- BOTÓN FLOTANTE DEL CARRITO (FAB) -->
<a href="{{ route('cart.index') }}" id="fab-carrito" class="fixed z-50 text-slate-950 rounded-full shadow-2xl transition-all flex items-center justify-center border border-white/10" style="background-color: #c79c5e; bottom: 2rem; right: 2rem; padding: 1rem;" onmouseover="this.style.backgroundColor='#d9b275'; this.style.transform='scale(1.05)';" onmouseout="this.style.backgroundColor='#c79c5e'; this.style.transform='scale(1)';">
  <span class="material-symbols-rounded" style="font-size: 1.5rem;">shopping_cart</span>
  <!-- Indicador de items (opcional) -->
  <span id="fab-badge" class="absolute bg-red-500 text-white font-bold rounded-full flex items-center justify-center border-2 border-slate-900 {{ ($cartCount ?? 0) > 0 ? '' : 'hidden' }}" style="top: -0.25rem; right: -0.25rem; font-size: 0.7rem; width: 1.25rem; height: 1.25rem;">{{ $cartCount ?? 0 }}</span>
</a>

<!-- ===== VISTA DE DETALLES DEL PRODUCTO (A PANTALLA COMPLETA) ===== -->
<div id="pos-detail-view" class="hidden w-full flex flex-col gap-6 h-full transition-opacity duration-300 overflow-y-auto custom-scrollbar" style="padding-bottom: 4rem;">
  
  <!-- Header de Detalles -->
  <div class="flex items-center justify-between">
    <button onclick="cerrarVistaDetalle()" class="flex items-center gap-2 text-slate-400 hover:text-white transition-colors" style="background-color: #1e2638; padding: 0.75rem 1.5rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.05);">
      <span class="material-symbols-rounded">arrow_back</span>
      <span class="font-bold">Volver al Menú</span>
    </button>
  </div>

  <div class="flex flex-col lg:flex-row gap-6 w-full h-full min-h-0">
    <!-- Columna Izquierda: Galería e Información -->
    <div class="flex-1 flex flex-col glass-panel overflow-y-auto custom-scrollbar" style="padding: 2.5rem;">
      <!-- Galería -->
      <div id="detail-gallery-container" class="w-full flex items-center justify-center bg-gradient-to-b from-white/5 to-transparent border border-white/5 rounded-3xl relative overflow-hidden shrink-0" style="height: 350px; margin-bottom: 2rem;">
        <div id="detail-gallery-slider" class="w-full h-full flex transition-transform duration-500">
          <!-- Imágenes inyectadas por JS -->
        </div>
        <!-- Controles Galería -->
        <button id="gallery-prev" onclick="moveGallery(-1)" class="hidden absolute left-4 bg-slate-900/80 text-white rounded-full p-2 hover:bg-slate-800 transition-colors border border-white/10 z-10"><span class="material-symbols-rounded">chevron_left</span></button>
        <button id="gallery-next" onclick="moveGallery(1)" class="hidden absolute right-4 bg-slate-900/80 text-white rounded-full p-2 hover:bg-slate-800 transition-colors border border-white/10 z-10"><span class="material-symbols-rounded">chevron_right</span></button>
        <div id="gallery-indicators" class="hidden absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-10">
          <!-- Indicadores -->
        </div>
      </div>

      <!-- Información Base -->
      <div class="flex flex-col gap-4 shrink-0 pb-4">
        <h2 id="detail-nombre" class="text-4xl font-bold text-white" style="font-family: 'Playfair Display', Georgia, serif; line-height: 1.1;">Nombre Producto</h2>
        <div class="flex flex-wrap gap-4 items-center">
          <span id="detail-precio" class="text-2xl font-bold" style="color: var(--accent);">$0.00</span>
          <span class="w-2 h-2 rounded-full bg-slate-600"></span>
          <span class="text-slate-400 font-medium">Stock: <span id="detail-stock" class="text-white">0 uds</span></span>
        </div>
        <p id="detail-descripcion" class="text-slate-300 leading-relaxed text-lg" style="margin-top: 1rem;">
          Descripción detallada del producto.
        </p>
      </div>
    </div>

    <!-- Columna Derecha: Modificadores y Compra -->
    <div class="w-full lg:w-[400px] flex flex-col shrink-0 gap-6">
      <div id="detail-modifiers-container" class="flex flex-col gap-6 glass-panel flex-1 overflow-y-auto custom-scrollbar" style="padding: 2rem;">
        
        <!-- Opciones de modificadores (se inyectan por JS si el producto las tiene) -->
        <div id="modifiers-content" class="flex flex-col gap-6">
          <div class="text-slate-400 text-center italic">Cargando opciones...</div>
        </div>

      </div>

      <!-- Resumen y Agregar al carrito -->
      <div class="glass-panel" style="padding: 1.5rem;">
        <button onclick="confirmarCompraDesdeDetalle()" class="w-full text-slate-950 font-bold transition-all duration-300 flex items-center justify-center rounded-2xl shadow-lg hover:shadow-xl" style="background-color: #c79c5e; padding: 1rem; gap: 0.75rem;" onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='none'">
          <span class="material-symbols-rounded" style="font-size: 28px;">add_shopping_cart</span>
          <span style="font-size: 1.1rem;">Agregar al Carrito - <span id="detail-total-price">$0.00</span></span>
        </button>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
let cartCount = {{ $cartCount ?? 0 }};
let currentProduct = null;
let currentBtn = null;

let currentGallery = [];
let currentGalleryIndex = 0;

function abrirVistaDetalle(el) {
  const id = el.getAttribute('data-id');
  const name = el.getAttribute('data-name');
  const desc = el.getAttribute('data-description');
  const price = parseFloat(el.getAttribute('data-price'));
  const stock = el.getAttribute('data-stock');
  const mainImage = el.getAttribute('data-image');
  const emoji = el.getAttribute('data-emoji');
  let gallery = [];
  try {
    gallery = JSON.parse(el.getAttribute('data-gallery')) || [];
  } catch(e) {}
  const allowModifiers = parseInt(el.getAttribute('data-allow-modifiers')) === 1;

  currentProduct = { id, name, basePrice: price, allowModifiers };

  // Setup UI
  document.getElementById('detail-nombre').textContent = name;
  document.getElementById('detail-descripcion').textContent = desc || 'No hay información adicional disponible para este producto.';
  document.getElementById('detail-precio').textContent = '$' + price.toFixed(2);
  document.getElementById('detail-stock').textContent = stock + ' uds';
  document.getElementById('detail-total-price').textContent = '$' + price.toFixed(2);

  // Setup Gallery
  currentGallery = [];
  if (mainImage) currentGallery.push(mainImage);
  if (gallery.length > 0) currentGallery = currentGallery.concat(gallery);
  
  const slider = document.getElementById('detail-gallery-slider');
  const indicators = document.getElementById('gallery-indicators');
  const prevBtn = document.getElementById('gallery-prev');
  const nextBtn = document.getElementById('gallery-next');

  slider.innerHTML = '';
  indicators.innerHTML = '';

  if (currentGallery.length > 0) {
    currentGallery.forEach((imgSrc, index) => {
      // Create image element
      const div = document.createElement('div');
      div.className = 'w-full h-full flex-shrink-0 flex items-center justify-center';
      const img = document.createElement('img');
      img.src = (imgSrc.startsWith('http') || imgSrc.startsWith('/')) ? imgSrc : (imgSrc.startsWith('img/') ? '/' + imgSrc : '/storage/' + imgSrc);
      img.className = 'w-full h-full object-cover';
      div.appendChild(img);
      slider.appendChild(div);

      // Create indicator
      const dot = document.createElement('div');
      dot.className = `w-2 h-2 rounded-full transition-colors ${index === 0 ? 'bg-white' : 'bg-white/30'}`;
      indicators.appendChild(dot);
    });
  } else {
    // Fallback to emoji
    const div = document.createElement('div');
    div.className = 'w-full h-full flex-shrink-0 flex items-center justify-center';
    const span = document.createElement('span');
    span.style.fontSize = '8rem';
    span.textContent = emoji || '☕';
    div.appendChild(span);
    slider.appendChild(div);
  }

  currentGalleryIndex = 0;
  slider.style.transform = `translateX(0%)`;

  if (currentGallery.length > 1) {
    prevBtn.classList.remove('hidden');
    nextBtn.classList.remove('hidden');
    indicators.classList.remove('hidden');
  } else {
    prevBtn.classList.add('hidden');
    nextBtn.classList.add('hidden');
    indicators.classList.add('hidden');
  }

  // Modifiers
  const modifiersContent = document.getElementById('modifiers-content');
  if (allowModifiers) {
    // Inject the hardcoded modifiers HTML for now
    modifiersContent.innerHTML = getModifiersHTML();
    // Add event listeners for price update
    const inputs = modifiersContent.querySelectorAll('input');
    inputs.forEach(input => {
      input.addEventListener('change', calcularPrecioModificadores);
    });
  } else {
    modifiersContent.innerHTML = `<div class="text-slate-400 text-center flex flex-col items-center justify-center gap-4 py-12 h-full"><span class="material-symbols-rounded text-5xl opacity-50">info</span> <span>Este producto no cuenta con opciones de personalización. Se preparará con su receta original.</span></div>`;
  }

  // Transitions
  document.getElementById('pos-grid-view').classList.add('hidden');
  document.getElementById('pos-detail-view').classList.remove('hidden');
}

function moveGallery(dir) {
  if (currentGallery.length <= 1) return;
  currentGalleryIndex += dir;
  if (currentGalleryIndex < 0) currentGalleryIndex = currentGallery.length - 1;
  if (currentGalleryIndex >= currentGallery.length) currentGalleryIndex = 0;

  const slider = document.getElementById('detail-gallery-slider');
  slider.style.transform = `translateX(-${currentGalleryIndex * 100}%)`;

  const indicators = document.getElementById('gallery-indicators').children;
  Array.from(indicators).forEach((dot, index) => {
    dot.className = `w-2 h-2 rounded-full transition-colors ${index === currentGalleryIndex ? 'bg-white' : 'bg-white/30'}`;
  });
}

function cerrarVistaDetalle() {
  document.getElementById('pos-detail-view').classList.add('hidden');
  document.getElementById('pos-grid-view').classList.remove('hidden');
}

function getModifiersHTML() {
  return `
      <!-- Opción: Tamaño -->
      <div>
        <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider flex items-center gap-2" style="margin-bottom: 0.75rem;"><span class="material-symbols-rounded text-lg" style="color: var(--accent);">local_cafe</span> Tamaño</h3>
        <div class="grid grid-cols-3" style="gap: 0.75rem;">
          <label class="border rounded-xl flex flex-col items-center cursor-pointer transition-colors text-center" style="padding: 0.75rem; border-color: rgba(199, 156, 94, 0.5); background-color: rgba(199, 156, 94, 0.1);" onmouseover="this.style.backgroundColor='rgba(199, 156, 94, 0.2)'" onmouseout="this.style.backgroundColor='rgba(199, 156, 94, 0.1)'">
            <input type="radio" name="mod_size" value="chico" class="hidden">
            <span class="font-bold mb-1">Chico</span>
            <span class="text-xs text-slate-400">8 oz</span>
          </label>
          <label class="border border-white/10 bg-white/5 rounded-xl flex flex-col items-center cursor-pointer transition-colors hover:bg-white/10 text-center" style="padding: 0.75rem;">
            <input type="radio" name="mod_size" value="mediano" checked class="hidden">
            <span class="font-bold mb-1" style="color: var(--accent);">Mediano</span>
            <span class="text-xs text-slate-400">12 oz</span>
          </label>
          <label class="border border-white/10 bg-white/5 rounded-xl flex flex-col items-center cursor-pointer transition-colors hover:bg-white/10 text-center" style="padding: 0.75rem;">
            <input type="radio" name="mod_size" value="grande" class="hidden">
            <span class="font-bold mb-1">Grande</span>
            <span class="text-xs" style="color: var(--accent);">+ $15.00</span>
          </label>
        </div>
      </div>

      <!-- Opción: Tipo de Leche -->
      <div>
        <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider flex items-center gap-2" style="margin-bottom: 0.75rem;"><span class="material-symbols-rounded text-lg" style="color: var(--accent);">water_drop</span> Tipo de Leche</h3>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
          <label class="flex items-center justify-between rounded-lg border border-white/5 hover:bg-white/5 cursor-pointer transition-colors" style="padding: 0.75rem;">
            <div class="flex items-center gap-3">
              <input type="radio" name="mod_milk" value="entera" checked style="width: 1rem; height: 1rem; accent-color: var(--accent);">
              <span class="font-medium text-slate-200">Entera</span>
            </div>
          </label>
          <label class="flex items-center justify-between rounded-lg border border-white/5 hover:bg-white/5 cursor-pointer transition-colors" style="padding: 0.75rem;">
            <div class="flex items-center gap-3">
              <input type="radio" name="mod_milk" value="deslactosada" style="width: 1rem; height: 1rem; accent-color: var(--accent);">
              <span class="font-medium text-slate-200">Deslactosada</span>
            </div>
            <span class="text-sm font-bold" style="color: var(--accent);">+ $8.00</span>
          </label>
          <label class="flex items-center justify-between rounded-lg border border-white/5 hover:bg-white/5 cursor-pointer transition-colors" style="padding: 0.75rem;">
            <div class="flex items-center gap-3">
              <input type="radio" name="mod_milk" value="almendra" style="width: 1rem; height: 1rem; accent-color: var(--accent);">
              <span class="font-medium text-slate-200">Almendra</span>
            </div>
            <span class="text-sm font-bold" style="color: var(--accent);">+ $12.00</span>
          </label>
        </div>
      </div>
      
      <!-- Opción: Extras -->
      <div>
        <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider flex items-center gap-2" style="margin-bottom: 0.75rem;"><span class="material-symbols-rounded text-lg" style="color: var(--accent);">add_circle</span> Extras</h3>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
          <label class="flex items-center justify-between rounded-lg border border-white/5 hover:bg-white/5 cursor-pointer transition-colors" style="padding: 0.75rem;">
            <div class="flex items-center gap-3">
              <input type="checkbox" name="mod_extra_shot" value="1" class="rounded" style="width: 1rem; height: 1rem; accent-color: var(--accent);">
              <span class="font-medium text-slate-200">Shot Extra de Espresso</span>
            </div>
            <span class="text-sm font-bold" style="color: var(--accent);">+ $15.00</span>
          </label>
          <label class="flex items-center justify-between rounded-lg border border-white/5 hover:bg-white/5 cursor-pointer transition-colors" style="padding: 0.75rem;">
            <div class="flex items-center gap-3">
              <input type="checkbox" name="mod_syrup" value="vainilla" class="rounded" style="width: 1rem; height: 1rem; accent-color: var(--accent);">
              <span class="font-medium text-slate-200">Jarabe de Vainilla</span>
            </div>
            <span class="text-sm font-bold" style="color: var(--accent);">+ $10.00</span>
          </label>
        </div>
      </div>
  `;
}

function calcularPrecioModificadores() {
  if (!currentProduct) return;
  let total = currentProduct.basePrice;
  
  if (currentProduct.allowModifiers) {
    const size = document.querySelector('input[name="mod_size"]:checked');
    if (size && size.value === 'grande') total += 15;
    
    const milk = document.querySelector('input[name="mod_milk"]:checked');
    if (milk && milk.value === 'deslactosada') total += 8;
    if (milk && milk.value === 'almendra') total += 12;
    
    const extraShot = document.querySelector('input[name="mod_extra_shot"]');
    if (extraShot && extraShot.checked) total += 15;
    
    const syrup = document.querySelector('input[name="mod_syrup"]');
    if (syrup && syrup.checked) total += 10;
  }
  
  document.getElementById('detail-total-price').textContent = '$' + total.toFixed(2);
}

function confirmarCompraDesdeDetalle() {
  if (!currentProduct) return;
  
  let modifiers = {};
  
  if (currentProduct.allowModifiers) {
    const size = document.querySelector('input[name="mod_size"]:checked');
    if (size) modifiers.size = size.value;
    
    const milk = document.querySelector('input[name="mod_milk"]:checked');
    if (milk) modifiers.milk = milk.value;
    
    const extraShot = document.querySelector('input[name="mod_extra_shot"]');
    if (extraShot && extraShot.checked) modifiers.extra_shot = true;
    
    const syrup = document.querySelector('input[name="mod_syrup"]');
    if (syrup && syrup.checked) modifiers.syrup = syrup.value;
  }
  
  let totalPriceText = document.getElementById('detail-total-price').textContent;
  let totalPrice = parseFloat(totalPriceText.replace('$', ''));
  
  const btn = document.querySelector('#pos-detail-view button[onclick="confirmarCompraDesdeDetalle()"]');
  const originalHtml = btn.innerHTML;
  btn.innerHTML = `<span class="material-symbols-rounded">check</span> Agregando...`;
  
  sendAddToCartRequest(currentProduct.id, modifiers, totalPrice, null)
    .then(() => {
      btn.innerHTML = `<span class="material-symbols-rounded">done_all</span> Agregado!`;
      setTimeout(() => {
        btn.innerHTML = originalHtml;
        cerrarVistaDetalle();
      }, 700);
    });
}

function sendAddToCartRequest(productId, modifiers, totalPrice, btn) {
  return fetch('{{ route("cart.add") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      product_id: productId,
      modifiers: modifiers,
      total_price: totalPrice
    })
  })
  .then(res => res.json())
  .then(data => {
    if(data.success) {
      updateCartUI(data.cart, btn);
      if(typeof toast === 'function') toast('Producto agregado al carrito', 'success');
    }
  })
  .catch(err => {
    console.error(err);
    if(typeof toast === 'function') toast('Error al agregar al carrito', 'error');
  });
}

function updateCartUI(cart, btn) {
  let count = 0;
  cart.forEach(item => { count += item.quantity; });
  
  cartCount = count;
  const badge = document.getElementById('fab-badge');
  badge.textContent = cartCount;
  badge.classList.remove('hidden');
  
  // Animación del botón flotante
  const fab = document.getElementById('fab-carrito');
  if(fab) {
      fab.classList.add('scale-110');
      setTimeout(() => fab.classList.remove('scale-110'), 200);
  }

  // Animación visual en el botón de la tarjeta
  if(btn) {
      const originalHtml = btn.innerHTML;
      btn.innerHTML = `<span class="material-symbols-rounded">check</span> Agregado`;
      const originalBg = btn.style.backgroundColor;
      btn.style.backgroundColor = '#10b981'; // success (emerald)
      
      setTimeout(() => {
        btn.innerHTML = originalHtml;
        btn.style.backgroundColor = originalBg;
      }, 800);
  }
}

// Cerrar dropdown de filtros al hacer clic fuera
window.addEventListener('click', function(e) {
  const filterBtn = document.getElementById('btn-filtros');
  const filterDropdown = document.getElementById('filtro-avanzado');
  if (filterBtn && filterDropdown && !filterBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
    filterDropdown.classList.add('hidden');
  }
});
</script>
@endpush
