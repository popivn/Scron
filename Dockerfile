# Sử dụng image PHP chính thức
FROM php:8.2-apache

# Cập nhật danh sách gói
RUN apt-get update

# Cài đặt các thư viện cần thiết
RUN apt-get install -y \
    libzip-dev \
    zip \
    libmysqlclient-dev

# Dọn dẹp cache
RUN rm -rf /var/lib/apt/lists/*

# Cài đặt các extension PHP
RUN docker-php-ext-install pdo pdo_mysql zip

# Các bước khác...
WORKDIR /var/www/html
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html
RUN a2enmod rewrite
EXPOSE 80