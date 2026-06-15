FROM php:8.2-cli

RUN apt-get update

# Install system dependencies
RUN apt-get install -y \
    sudo \
    git \
    curl \
    zip \
    unzip

RUN apt-get update && apt-get install -y \
    nodejs \
    libzip-dev \
    libicu-dev \
    libbz2-dev \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    pdo_pgsql \
    gd \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# Install Node deps and build Vite assets
RUN npm install
RUN npm run build

# Clear any stale defaults before packaging the image
RUN php artisan config:clear && php artisan cache:clear

# Recommended startup sequence
CMD php artisan optimize:clear && \
    php artisan migrate --force && \
    php artisan storage:link && \
    php artisan config:cache && \
    php artisan serve --host=0.0.0.0 --port=10000