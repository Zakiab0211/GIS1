# # Menggunakan image resmi PHP dengan PHP-FPM 8.0
# FROM php:8.1-fpm

# # Menetapkan direktori kerja di dalam container
# WORKDIR /var/www

# # Menyalin file composer untuk mengunduh dependensi proyek Laravel
# COPY composer.json composer.lock ./

# # Install dependensi yang diperlukan untuk Laravel dan PHP extensions
# RUN apt-get update && apt-get install -y \
#     build-essential \
#     libmcrypt-dev \
#     mariadb-client \
#     libpng-dev \
#     libjpeg62-turbo-dev \
#     libfreetype6-dev \
#     locales \
#     jpegoptim \
#     optipng \
#     pngquant \
#     gifsicle \
#     vim \
#     unzip \
#     git \
#     curl \
#     libzip-dev \
#     zip \
#     && apt-get clean && rm -rf /var/lib/apt/lists/*

# # Menginstal ekstensi PHP yang diperlukan
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install gd \
#     && docker-php-ext-install pdo pdo_mysql zip

# # Menginstal Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Menyalin semua file aplikasi ke dalam container
# COPY . .

# # Install dependensi Laravel
# RUN composer install --optimize-autoloader --no-dev

# # Mengatur hak akses untuk file yang disalin
# RUN chown -R www-data:www-data /var/www/GIS \
#     && chmod -R 755 /var/www/GIS

# # Membuka port 9000 untuk PHP-FPM
# EXPOSE 9000

# # Menjalankan PHP-FPM saat container dimulai
# CMD ["php-fpm"]

# Use the official PHP image as a base image
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the existing application directory contents to the working directory
COPY . /var/www

# Copy the existing application directory permissions to the working directory
COPY --chown=www-data:www-data . /var/www

# Change current user to www
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]