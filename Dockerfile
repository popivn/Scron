# Sử dụng image PHP chính thức
FROM php:8.2-apache

# Cập nhật danh sách gói và cài đặt các thư viện cần thiết trong một RUN duy nhất để tránh lỗi và đảm bảo các dependency được cập nhật
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        libzip-dev \
        zip \
        default-mysql-client \
        libmysqlclient-dev && \
    rm -rf /var/lib/apt/lists/*

# Cài đặt các extension PHP
RUN docker-php-ext-install pdo pdo_mysql zip

# Các bước khác...
WORKDIR /var/www/html
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html
RUN a2enmod rewrite
EXPOSE 80