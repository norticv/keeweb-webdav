FROM ubuntu:16.04
MAINTAINER Anthony PAUSE <anthony.pause@gmail.com>

# Install Packages
RUN apt-get update && \
    apt-get -y install software-properties-common locales && \
    apt-get -y upgrade  && \
    add-apt-repository -y ppa:nginx/stable && \
    apt-get -y install nginx php-fpm php-cli git curl php-xml php-mbstring unzip

# Install Gosu
RUN set -x \
    && add-apt-repository -y ppa:tianon/gosu \
    && apt-get update \
    && apt-get install -y --no-install-recommends gosu

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=bin --filename=composer

# Locale
RUN locale-gen en_US.UTF-8

# Env
ENV LANG=en_US.UTF-8 \
    LANGUAGE=en_US:en \
    LC_ALL=en_US.UTF-8 \
    WEBDAV_USERNAME=admin \
    WEBDAV_PASSWORD=admin \
    WEBDAV_BASEURI=/ \
    UID=1000 \
    GID=1000 \
    BRUTEFORCE_PROTECTION_MAXRETRY=10 \
    DEV_COMPOSER=false

# Prepare
COPY docker/prod/prepare /prepare
COPY docker/prod/template /template
COPY docker/prod/vendor /vendor
COPY app /app

RUN chmod +x /prepare/*

EXPOSE 80

VOLUME ["/app/files/files"]

ENTRYPOINT ["/prepare/run.sh"]
