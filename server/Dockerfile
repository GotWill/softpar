FROM php:8.4-fpm
# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copia os arquivos primeiro
COPY . .

# Se a pasta storage/cache não existir (projeto novo), o chown vai falhar. 
# O Laravel precisa delas.
RUN mkdir -p storage bootstrap/cache && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000

# IMPORTANTE: Mudei para 0.0.0.0 e garanti que o caminho é absoluto para evitar erros
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/public"]