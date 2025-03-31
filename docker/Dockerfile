# Dockerfile para Laravel
FROM php:8.2-fpm

# Instalar extensões PHP e dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_pgsql zip


# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuração do diretório de trabalho
WORKDIR /var/www

# Copia todos os arquivos do projeto (dois níveis acima) para o contêiner na raiz
COPY ../../ .

# Instalar dependências do Laravel
# RUN composer install --optimize-autoloader --no-dev


# Expor a porta do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
