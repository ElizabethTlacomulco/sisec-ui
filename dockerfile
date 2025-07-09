FROM php:8.2-apache

# Instala extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia el código fuente al contenedor
COPY . /var/www/html/

# Da permisos a la carpeta de trabajo
RUN chown -R www-data:www-data /var/www/html/

# Habilita el módulo rewrite (importante para rutas amigables)
RUN a2enmod rewrite

# Configura el DocumentRoot (ajusta si usas otra carpeta como `public`)
ENV APACHE_DOCUMENT_ROOT /var/www/html

# Expón el puerto 80 (Render lo mapeará automáticamente)
EXPOSE 80
