# Sử dụng image PHP chính thức
FROM php:8.2-apache

# Cài đặt các thư viện cần thiết, bao gồm cả libmysqlclient-dev cho pdo_mysql
# Lệnh 'rm -rf /var/lib/apt/lists/*' giúp dọn dẹp cache của apt
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    libmysqlclient-dev \
    && rm -rf /var/lib/apt/lists/*

# Cài đặt các extension PHP
RUN docker-php-ext-install pdo pdo_mysql zip

# Sao chép code vào container
WORKDIR /var/www/html
COPY . /var/www/html

# Phân quyền
RUN chown -R www-data:www-data /var/www/html

# Cấu hình Apache
RUN a2enmod rewrite

EXPOSE 80