# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Instala dependencias necesarias para PostgreSQL y otras herramientas comunes
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Copiar el contenido del proyecto al directorio de Apache
COPY . /var/www/html/

# Habilita mod_rewrite para Apache (opcional, útil si usas rutas amigables)
RUN a2enmod rewrite

# Establece el directorio de trabajo
WORKDIR /var/www/html/

# Asigna permisos adecuados
RUN chown -R www-data:www-data /var/www/html
