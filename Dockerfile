FROM php:8.2-apache

# Configurar Apache para usar el puerto dinámico de Render (CRÍTICO)
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Habilitar mod_rewrite para URLs limpias
RUN a2enmod rewrite

# Instalar y habilitar extensiones necesarias para MySQL/MariaDB
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

# Copiar archivos de la aplicación al DocumentRoot
COPY . /var/www/html/

# Configurar permisos para Apache
RUN chown -R www-data:www-data /var/www/html/