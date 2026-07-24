# ══════════════════════════════════════════════════════════════════════════════
#  Dockerfile — Cafeteria PETY (Laravel 12 + Vite + Tailwind v4)
#  Plataforma objetivo: Render.com (Docker runtime)
# ══════════════════════════════════════════════════════════════════════════════

# ── Etapa 1: Base PHP 8.3 con Apache ──────────────────────────────────────────
FROM php:8.3-apache AS base

LABEL maintainer="Cafeteria PETY DevOps"
LABEL description="Laravel 12 + Vite + Tailwind v4 para Render.com"

# Habilitar mod_rewrite (obligatorio para rutas Laravel)
RUN a2enmod rewrite headers

# Instalar dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
    && rm -rf /var/lib/apt/lists/*

# Instalar Node.js 20 LTS (para compilar Vite + Tailwind v4)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer desde imagen oficial
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# ── Configurar Apache para apuntar a /public ──────────────────────────────────
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/apache2.conf \
        /etc/apache2/conf-available/*.conf

# Configuración Apache para permitir .htaccess de Laravel
RUN echo '<Directory "${APACHE_DOCUMENT_ROOT}">\n\
    AllowOverride All\n\
    Options -Indexes +FollowSymLinks\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# ── Copiar código fuente ───────────────────────────────────────────────────────
WORKDIR /var/www/html

# Copiar primero archivos de dependencias (mejor uso de caché de Docker)
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# Instalar dependencias PHP (producción)
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist \
    --no-scripts

# Instalar dependencias Node
RUN npm ci

# Copiar el resto del código fuente
COPY . .

# Ejecutar scripts de descubrimiento de paquetes Laravel post-copia
RUN php artisan package:discover --ansi

# Compilar assets con Vite (Tailwind v4 + JS)
RUN npm run build

# Dar permisos correctos al script de build y directorios de Laravel
RUN chmod +x render-build.sh \
    && chown -R www-data:www-data \
        storage \
        bootstrap/cache \
        public \
    && chmod -R 775 storage bootstrap/cache

# ── Exponer puerto 80 (Apache) ─────────────────────────────────────────────────
EXPOSE 80

# El CMD por defecto ejecuta Apache en primer plano
CMD ["apache2-foreground"]
