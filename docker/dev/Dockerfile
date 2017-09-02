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
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8
ENV WEBDAV_USERNAME=admin
ENV WEBDAV_PASSWORD=admin
ENV WEBDAV_BASEURI=/
ENV UID=1000
ENV GID=1000
ENV BRUTEFORCE_PROTECTION_MAXRETRY=10
ENV DEV_COMPOSER=true

# Prepare
COPY docker/prod/prepare /prepare
COPY docker/prod/template /template
COPY docker/prod/vendor /vendor

RUN chmod +x /prepare/* 

EXPOSE 80

VOLUME ["/app"]
VOLUME ["/app/files/files"]

ENTRYPOINT ["/prepare/run.sh"]
