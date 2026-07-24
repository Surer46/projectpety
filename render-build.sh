#!/usr/bin/env bash

# =============================================================================
#  render-build.sh — Script de Construcción para Render.com
#  Proyecto: Cafeteria PETY (Laravel 12 + Vite + Tailwind)
#  Autor: DevOps Auto-generado por Antigravity
# =============================================================================

set -o errexit   # Abortar inmediatamente si cualquier comando falla

echo "======================================================="
echo "  🚀  INICIO DE BUILD — Cafeteria PETY (Render.com)"
echo "======================================================="

# -----------------------------------------------------------------------------
# PASO 1: Instalar dependencias PHP (sin paquetes de desarrollo)
# -----------------------------------------------------------------------------
echo ""
echo "📦  [1/5] Instalando dependencias PHP con Composer..."
composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

echo "✅  Composer completado."

# -----------------------------------------------------------------------------
# PASO 2: Instalar dependencias Node (npm ci es más rápido y reproducible en CI)
# -----------------------------------------------------------------------------
echo ""
echo "🟢  [2/5] Instalando dependencias Node.js..."
npm ci

echo "✅  npm ci completado."

# -----------------------------------------------------------------------------
# PASO 3: Compilar assets Vite (Tailwind CSS v4 + JS)
# -----------------------------------------------------------------------------
echo ""
echo "⚡  [3/5] Compilando assets con Vite (Tailwind v4 + JS)..."
npm run build

echo "✅  Build de Vite completado. Assets generados en /public/build"

# -----------------------------------------------------------------------------
# PASO 4: Generar APP_KEY si no existe en variables de entorno
# -----------------------------------------------------------------------------
echo ""
echo "🔑  [4/5] Verificando APP_KEY de Laravel..."
php artisan key:generate --force --no-interaction

echo "✅  APP_KEY verificada."

# -----------------------------------------------------------------------------
# PASO 5: Ejecutar migraciones de base de datos
# -----------------------------------------------------------------------------
echo ""
echo "🗄️   [5/5] Ejecutando migraciones de base de datos..."
php artisan migrate --force --no-interaction

echo ""
echo "======================================================="
echo "  🎉  BUILD COMPLETADO EXITOSAMENTE"
echo "======================================================="
