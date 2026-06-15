FROM php:8.2-cli

# Combine all system dependencies into one layer and clean up cache
RUN apt-get update && apt-get install -y \
    sudo \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    libbz2-dev \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    ca-certificates \
    gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
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

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Optimization: Copy dependency files first to leverage Docker cache
COPY composer.json composer.lock package.json package-lock.json* ./

# Install dependencies without copying whole project yet
RUN composer install --no-dev --no-scripts --no-autoloader \
    && npm ci

# Now copy the rest of the application
COPY . .

# Finish composer autoload optimization and build frontend assets
RUN composer dump-autoload --no-dev --optimize \
    && npm run build

# Recommended startup sequence
CMD php artisan optimize:clear && \
    php artisan migrate --force && \
    php artisan storage:link && \
    php artisan config:cache && \
    php artisan serve --host=0.0.0.0 --port=10000