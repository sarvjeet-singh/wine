# Use the official PHP image with Apache
FROM php:8.2-apache

# Update and install required dependencies
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    libexif-dev \
    imagemagick \
    libmagickwand-dev \
    git \
    unzip \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd exif zip \
    && pecl install imagick \
    && docker-php-ext-enable imagick

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 775 /var/www/html

# Set Git to trust the repository
RUN git config --global --add safe.directory /var/www/html

# Copy application files
COPY . /var/www/html

# Install Laravel dependencies
RUN composer install

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
