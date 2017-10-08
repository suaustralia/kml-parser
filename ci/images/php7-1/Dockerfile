FROM php:7.1-fpm

RUN \
 apt-get update && \
 apt-get install -y vim git curl

# Install PHP extensions
# mbstring
#RUN docker-php-ext-install mbstring
# zip
RUN apt-get install -y zlib1g-dev && \
 docker-php-ext-install zip

# Clean up
RUN rm -rf \
    /tmp/* \
    /var/lib/apt/lists/* \
    /var/tmp/*

# Install composer system-wide
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /project

WORKDIR /project
