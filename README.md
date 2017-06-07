keeweb-webdav
==============

# Installation with Docker compose :

``` 
version: '2'
services:
    webdav:
        build: .
        restart: always
        ports:
        - 80
        environment:
        - WEBDAV_USERNAME=admin
        - WEBDAV_PASSWORD=admin
        - WEBDAV_BASEURI=/webdav
        - BRUTEFORCE_PROTECTION_MAXRETRY=20
        volumes:
        - webdav_files:/var/www/files
        - webdav_www:/var/www
        networks:
            proxyweb:
                ipv4_address: 172.240.1.14
    web:
        image: viossat/keeweb
        ports:
        - 81:80
        volumes:
        - web_www:/var/www/html
        - web_log:/var/log/lighttpd
volumes:
    webdav_files:
        driver: local
    webdav_www:
        driver: local
    web_www:
        driver: local
    web_log:
        driver: local
```

# How to use !

Connect you to : http://localhost:81
And upload your kdbx files

Go to http://localhost:80 to use Keeweb browser client.
Join your Webdav file.

Warning, is recommanded to use a reverse proxy with TLS if you want protected a public access !

# Code license

You are free to use the code in this repository under the terms of the 0-clause BSD license. LICENSE contains a copy of this license.

# Forked

Original maintainer Stephen Ausman <sausman@stackd.com>
Forked from https://github.com/stackd/docker-sabre-dav
