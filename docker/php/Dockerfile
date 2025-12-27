FROM php:8.4-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libpq-dev libonig-dev libxml2-dev libicu-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo pdo_mysql bcmath intl zip gd opcache pcntl posix

# Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# --- XDEBUG (DEV) ---
# instala só se não existir; habilita sempre
RUN (pecl list | grep -qi xdebug) || pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && { \
      echo "zend_extension=xdebug"; \
      echo "xdebug.mode=develop,debug"; \
      echo "xdebug.client_host=host.docker.internal"; \
      echo "xdebug.client_port=9003"; \
      echo "xdebug.start_with_request=yes"; \
      echo "xdebug.idekey=VSCODE"; \
      echo "xdebug.log=/tmp/xdebug.log"; \
    } > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# OPCache (dev)
RUN { \
  echo "opcache.enable=1"; \
  echo "opcache.validate_timestamps=1"; \
  echo "opcache.revalidate_freq=0"; \
} > /usr/local/etc/php/conf.d/opcache.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Ajuste do usuário (dev)
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# PsySH (tinker) – diretório de config gravável
ENV HOME=/var/www
RUN mkdir -p /var/www/.config/psysh && chown -R www-data:www-data /var/www/.config && chmod -R 700 /var/www/.config

USER www-data

CMD ["php-fpm"]
