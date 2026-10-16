FROM php:8.2-cli

# Install dependensi sistem dan ekstensi PHP yang dibutuhkan Laravel & SQLite
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install zip pdo pdo_sqlite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja di dalam container
WORKDIR /var/www

# Salin seluruh file proyek
COPY . .

# Install dependensi Laravel (Composer)
RUN composer install --no-dev --optimize-autoloader

# Pastikan folder database dan storage memiliki izin akses
RUN mkdir -p database storage bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 777 database storage bootstrap/cache

# Port default yang akan diekspos
EXPOSE 8080

# Jalankan migrasi, seeder otomatis, lalu nyalakan server
CMD php artisan migrate:fresh --force --seed && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}