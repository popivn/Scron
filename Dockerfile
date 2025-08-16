# Sử dụng image PHP chính thức
FROM php:8.2-apache

# Sửa lỗi cài đặt: cập nhật ca-certificates và apt-transport-https, fix missing, và kiểm tra lỗi
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        apt-transport-https \
        ca-certificates && \
    apt-get update --fix-missing && \
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