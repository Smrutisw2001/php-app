# Use the official PHP image
FROM php:7.4-apache

# Copy the current directory contents into the container at /var/www/html/
COPY . /var/www/html/

# Install MySQL extension for PHP
RUN docker-php-ext-install mysqli

# Expose port 80
EXPOSE 80
