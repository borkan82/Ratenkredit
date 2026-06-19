FROM php:8.2-apache

# Enable mod_rewrite (useful for frameworks)
RUN a2enmod rewrite

# Copy source files into Apache's web root
COPY src/ /var/www/html/