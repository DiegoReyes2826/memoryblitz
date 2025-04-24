# Usamos una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala las extensiones necesarias para PostgreSQL y otras utilidades
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# Copia todos los archivos del proyecto al directorio raíz de Apache
COPY . /var/www/html/

# Da permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Habilita el módulo de reescritura de Apache (útil si usas URLs amigables)
RUN a2enmod rewrite

# Exponemos el puerto 80 (el que usa Apache)
EXPOSE 80
