<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <meta name="description" content="Cafeteria PETY — Café de especialidad con el mejor sabor. Explora nuestro menú o inicia sesión en el sistema."/>
  <title>Cafeteria PETY — Bienvenido</title>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --gold: #c8a96e;
      --white: #ffffff;
    }

    html, body {
      width: 100%; min-height: 100%;
      overflow-y: auto; overflow-x: hidden;
      font-family: 'Inter', system-ui, sans-serif;
      background: #0f172a;
    }

    .hero {
      position: relative;
      width: 100%; min-height: 100vh;
      display: flex; flex-direction: column;
      align-items: center; justify-content: flex-start;
      gap: 3rem; padding: 3rem 1rem;
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }

    .hero::before {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(
        160deg,
        rgba(15,23,42,0.65) 0%,
        rgba(15,23,42,0.35) 40%,
        rgba(15,23,42,0.78) 100%
      );
      z-index: 0;
      pointer-events: none;
    }

    .hero-overlay {
      display: none; /* Reemplazado por ::before */
    }

    .hero-content {
      position: relative; z-index: 1;
      display: flex; flex-direction: column;
      align-items: center; text-align: center;
      padding: 3.5rem 4rem;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.18);
      border-radius: 32px;
      backdrop-filter: blur(28px) saturate(160%);
      -webkit-backdrop-filter: blur(28px) saturate(160%);
      box-shadow: 0 24px 80px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.25);
      max-width: 580px; width: 90vw;
      animation: panelIn .9s cubic-bezier(.22,1,.36,1) both;
    }
    @keyframes panelIn {
      from { opacity: 0; transform: translateY(32px) scale(.96); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .logo-area {
      margin-bottom: 1.75rem;
      animation: fadeDown .7s .15s ease both;
    }
    .logo-area img {
      height: 70px;
      object-fit: contain;
      filter: brightness(0) invert(1);
    }
    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .ornament {
      display: flex; align-items: center; gap: .75rem;
      margin-bottom: 1.5rem;
      animation: fadeDown .7s .25s ease both;
    }
    .ornament-line {
      height: 1px; width: 80px;
      background: linear-gradient(90deg, transparent, rgba(200,169,110,0.7), transparent);
    }
    .ornament-icon {
      color: var(--gold); font-size: 18px;
      font-variation-settings: 'FILL' 1;
    }

    .headline {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: clamp(1.8rem, 4vw, 2.5rem);
      font-weight: 700;
      color: var(--white);
      line-height: 1.25;
      letter-spacing: -.4px;
      margin-bottom: .75rem;
      animation: fadeDown .7s .35s ease both;
    }
    .headline em { font-style: normal; color: var(--gold); }

    .subtitle {
      font-size: clamp(.84rem, 1.8vw, .97rem);
      color: rgba(255,255,255,0.72);
      line-height: 1.65;
      max-width: 360px;
      margin-bottom: 2.25rem;
      animation: fadeDown .7s .45s ease both;
    }

    .cta-group {
      display: flex; gap: 1rem; flex-wrap: wrap;
      justify-content: center;
      animation: fadeDown .7s .55s ease both;
    }

    .btn-cta {
      display: inline-flex; align-items: center; gap: .5rem;
      padding: .85rem 2rem;
      border-radius: 14px;
      font-family: 'Inter', sans-serif;
      font-size: .93rem; font-weight: 600;
      text-decoration: none;
      cursor: pointer; border: none;
      transition: transform .2s, filter .2s, box-shadow .2s;
    }
    .btn-cta:hover  { transform: translateY(-3px); filter: brightness(1.08); }
    .btn-cta:active { transform: translateY(-1px) scale(.97); }
    .btn-cta .material-symbols-rounded { font-size: 20px; font-variation-settings: 'FILL' 1; }

    .btn-primary-hero {
      position: relative;
      display: inline-flex; align-items: center; justify-content: center; gap: .75rem;
      padding: 1.1rem 2.8rem;
      border-radius: 99px;
      font-family: 'Inter', sans-serif;
      font-size: 1.1rem; font-weight: 800;
      letter-spacing: .02em;
      text-decoration: none;
      color: #0a0f18;
      background: linear-gradient(135deg, #e5c07b 0%, #c8a96e 50%, #b88b4a 100%);
      box-shadow: 0 12px 35px rgba(200, 169, 110, 0.45), inset 0 2px 0 rgba(255, 255, 255, 0.5);
      border: 1px solid rgba(255, 255, 255, 0.3);
      cursor: pointer;
      overflow: hidden;
      transition: all .35s cubic-bezier(.175, .885, .32, 1.275);
    }
    .btn-primary-hero::after {
      content: '';
      position: absolute; top: -50%; left: -60%;
      width: 50%; height: 200%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
      transform: rotate(30deg);
      transition: all .75s ease;
    }
    .btn-primary-hero:hover {
      transform: translateY(-4px) scale(1.03);
      box-shadow: 0 18px 45px rgba(200, 169, 110, 0.65), inset 0 2px 0 rgba(255, 255, 255, 0.7);
      background: linear-gradient(135deg, #ebd090 0%, #d8b87c 50%, #c89b5a 100%);
    }
    .btn-primary-hero:hover::after {
      left: 120%;
    }
    .btn-primary-hero:active {
      transform: translateY(-1px) scale(0.98);
      box-shadow: 0 8px 24px rgba(200, 169, 110, 0.5);
    }
    .btn-primary-hero .btn-arrow {
      transition: transform 0.3s ease;
    }
    .btn-primary-hero:hover .btn-arrow {
      transform: translateX(5px);
    }

    .hero-footer {
      position: absolute; bottom: 1.75rem; left: 50%;
      transform: translateX(-50%);
      z-index: 2;
      display: flex; align-items: center; gap: .5rem;
      color: rgba(255,255,255,0.42);
      font-size: .7rem; font-weight: 500;
      letter-spacing: .09em; text-transform: uppercase;
      animation: fadeUp .8s .8s ease both;
      white-space: nowrap;
    }
    .hero-footer .material-symbols-rounded { font-size: 13px; }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateX(-50%) translateY(12px); }
      to   { opacity: 1; transform: translateX(-50%) translateY(0); }
    }

    .particle {
      position: absolute; border-radius: 50%;
      background: rgba(200,169,110,0.22);
      animation: floatUp linear infinite;
      pointer-events: none; z-index: 1;
    }
    @keyframes floatUp {
      0%   { transform: translateY(100vh) scale(0); opacity: 0; }
      10%  { opacity: .8; }
      90%  { opacity: .4; }
      100% { transform: translateY(-15vh) scale(1); opacity: 0; }
    }

    @media (max-width: 480px) {
      .hero-content { padding: 2.5rem 1.75rem; }
      .cta-group    { flex-direction: column; width: 100%; }
      .btn-cta      { justify-content: center; }
    }

    /* ── Featured Card Hover ── */
    .featured-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.3) !important;
      border-color: var(--gold) !important;
    }
  </style>
</head>
<body>

<section class="hero" id="hero-section" style="background-image: url('{{ asset('img/presentacion.png') }}');">

  <!-- Floating gold particles -->
  <div class="particle" style="width:6px;height:6px;left:8%;animation-duration:12s;animation-delay:0s;"></div>
  <div class="particle" style="width:4px;height:4px;left:22%;animation-duration:16s;animation-delay:3s;"></div>
  <div class="particle" style="width:7px;height:7px;left:58%;animation-duration:14s;animation-delay:1.5s;"></div>
  <div class="particle" style="width:5px;height:5px;left:75%;animation-duration:18s;animation-delay:5s;"></div>
  <div class="particle" style="width:3px;height:3px;left:91%;animation-duration:11s;animation-delay:2s;"></div>

  <!-- Main card -->
  <div class="hero-content">

    <!-- Logo completo -->
    <div class="logo-area">
      <img src="/img/logo-completo.png" alt="Cafeteria PETY" id="main-logo"/>
    </div>

    <!-- Gold ornament divider -->
    <div class="ornament">
      <div class="ornament-line"></div>
      <span class="material-symbols-rounded ornament-icon">local_cafe</span>
      <div class="ornament-line"></div>
    </div>

    <!-- Headline -->
    <h1 class="headline">
      Café de <em>especialidad</em>,<br/>servido con pasión
    </h1>

    <!-- Subtitle -->
    <p class="subtitle">
      Descubre nuestra selección de bebidas artesanales, pasteles de autor
      y especialidades de temporada. ¡Haz tu pedido o explora nuestro menú en línea!
    </p>

    <!-- CTAs -->
    <div class="cta-group">
      <a href="{{ route('pos') }}" class="btn-cta btn-primary-hero" id="btn-ver-menu">
        <span class="material-symbols-rounded" style="font-size: 24px;">restaurant_menu</span>
        <span>Explorar Menú & Ordenar</span>
        <span class="material-symbols-rounded btn-arrow" style="font-size: 20px;">arrow_forward</span>
      </a>
    </div>

  </div>

  <!-- SECCIÓN 1: OBJETIVO Y PROPUESTA DE VALOR -->
  <div class="landing-section" style="max-width: 900px; width: 90vw; padding: 3rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 28px; backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); box-shadow: 0 20px 50px rgba(0,0,0,0.25); text-align: center; color: #fff; position: relative; z-index: 2;">
    <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 2rem; color: var(--gold); margin-bottom: 1rem; font-weight: 700;">Nuestra Pasión por el Café</h2>
    <p style="font-size: .95rem; color: rgba(255,255,255,0.8); line-height: 1.7; max-width: 700px; margin: 0 auto;">
      En <strong>Cafetería PETY</strong>, creemos que una gran taza de café no es solo una rutina de la mañana, sino una experiencia artesanal única. Seleccionamos granos de especialidad de fincas sustentables, tostados a la perfección para resaltar sus notas de sabor más delicadas. Cada extracción es cuidada con precisión milimétrica para ofrecerte una bebida de calidad excepcional en un ambiente moderno y acogedor.
    </p>
  </div>

  <!-- SECCIÓN 2: PRODUCTOS DESTACADOS -->
  <div class="landing-section" style="max-width: 1000px; width: 90vw; display: flex; flex-direction: column; gap: 2rem; align-items: center; color: #fff; position: relative; z-index: 2;">
    <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 2rem; color: var(--gold); text-align: center; margin-bottom: 0; font-weight: 700; display:flex; align-items:center; gap:.5rem; justify-content:center;">
      <span class="material-symbols-rounded" style="color:var(--gold); font-variation-settings:'FILL' 1;">star</span> Los Favoritos de PETY
    </h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1.5rem; width: 100%;">
      @forelse($featuredProducts ?? [] as $prod)
        <div class="featured-card" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 24px; padding: 1.25rem; backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); display: flex; flex-direction: column; gap: .75rem; text-align: center; align-items: center; transition: all 0.3s ease;">
          @if(!empty($prod->image_path))
            <div style="width: 100%; height: 140px; border-radius: 16px; overflow: hidden; position: relative; border: 1px solid rgba(255,255,255,0.15);">
              <img src="{{ $prod->image_path }}" alt="{{ $prod->name }}" style="width: 100%; height: 100%; object-fit: cover;" />
              <span style="position: absolute; bottom: 8px; right: 8px; font-size: 1.1rem; background: rgba(15,23,42,0.7); width: 32px; height: 32px; display: grid; place-items: center; border-radius: 50%; backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.2);">{{ $prod->emoji ?? '☕' }}</span>
            </div>
          @else
            <div style="width: 72px; height: 72px; border-radius: 50%; background: rgba(200,169,110,0.15); display: grid; place-items: center; font-size: 2.2rem; border: 1px solid rgba(200,169,110,0.3);">{{ $prod->emoji ?? '☕' }}</div>
          @endif
          
          <span class="badge" style="font-size: .65rem; background: var(--gold); color: #1a2332; font-weight: 700; padding: 2px 10px; border-radius: 99px; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.2rem;">
            {{ $prod->category->name ?? 'Especialidad' }}
          </span>
          <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0; color:#fff;">{{ $prod->name }}</h3>
          <p style="font-size: .78rem; color: rgba(255,255,255,0.65); line-height: 1.5; margin: 0; min-height: 45px;">
            {{ Str::limit($prod->description, 85) }}
          </p>
          <div style="font-size: 1.2rem; font-weight: 800; color: var(--gold); margin-top: auto;">
            ${{ number_format($prod->base_price, 2) }} MXN
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; color: rgba(255,255,255,0.6); padding: 2rem;">
          No hay productos disponibles por el momento.
        </div>
      @endforelse
    </div>
  </div>

  <!-- SECCIÓN 3: HORARIOS Y FOOTER OPERATIVO -->
  <div style="width: 100vw; padding: 3rem 1.5rem; background: rgba(15,23,42,0.92); border-top: 1px solid rgba(255,255,255,0.08); display: flex; flex-direction: column; gap: 1.25rem; align-items: center; color: rgba(255,255,255,0.5); font-size: .8rem; text-align: center; margin-top: 2rem; position: relative; z-index: 2;">
    <div style="display:flex; align-items:center; gap:.5rem; font-size:.85rem; color:rgba(255,255,255,0.85); font-weight:600;">
      <span class="material-symbols-rounded" style="color:var(--gold); font-size:18px;">schedule</span>
      Horario Operativo: Lunes a Domingo &mdash; 7:00 AM a 10:00 PM
    </div>
    <div style="font-size:.75rem; color:rgba(255,255,255,0.35); max-width:600px; line-height:1.4;">
      Cafetería PETY utiliza tecnología de punta para la administración centralizada de inventarios, comandas y control de sucursales operativas.
    </div>
    <div style="display:flex; gap:1.5rem; font-size:.72rem; flex-wrap:wrap; justify-content:center;">
      <span>📍 Sucursal Centro Histórico</span>
      <span>📍 Sucursal Polanco</span>
      <span>📍 Sucursal Roma</span>
    </div>
    <div style="font-size:.7rem; color:rgba(255,255,255,0.25); letter-spacing:.09em; text-transform:uppercase; margin-top:.5rem;">
      © 2026 Cafetería PETY S.A. de C.V. &mdash; Todos los derechos reservados.
    </div>
  </div>

</section>

<script>
  // Mouse parallax on background-position of hero section
  const heroSection = document.getElementById('hero-section');
  document.addEventListener('mousemove', (e) => {
    const x = 50 + (e.clientX / window.innerWidth  - 0.5) * 5;
    const y = 50 + (e.clientY / window.innerHeight - 0.5) * 5;
    heroSection.style.backgroundPosition = `${x}% ${y}%`;
  });
</script>

</body>
</html>
