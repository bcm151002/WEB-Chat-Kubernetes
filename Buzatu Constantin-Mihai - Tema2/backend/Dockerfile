FROM php:8.1-apache

# Update and install dependencies
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    lsb-release \
    wget \
    zlib1g-dev \
    build-essential \
    git

# Download and install CMake 3.27.0
RUN wget -q https://github.com/Kitware/CMake/releases/download/v3.27.0/cmake-3.27.0-Linux-x86_64.tar.gz \
    && tar -xzf cmake-3.27.0-Linux-x86_64.tar.gz -C /usr/local --strip-components=1 \
    && rm cmake-3.27.0-Linux-x86_64.tar.gz

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Couchbase PHP extension
RUN pecl install couchbase \
    && docker-php-ext-enable couchbase

EXPOSE 80 443

COPY index.php /var/www/html

CMD ["apachectl", "-D", "FOREGROUND"]

