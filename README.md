keeweb-webdav
==============

This program is a manager password can be use in local and online.

Technicaly, it's a combinaison of keeweb program to manage your passwords and Webdav (sabre/dav) to storage the password file.
Learn the keeweb documentation for more explication.

## Features :

### Security / Brute force protection

Enabled by default, This protection block global web access an user try to connect at you 

## Quick start :

### Requirements :

1. [Docker](https://www.docker.com/community-edition#/download) version **1.12.0+**
2. [Docker Compose](https://docs.docker.com/compose/install/) version **1.9.0+**

### Install last release 

Get the last stable release

```bash
$ wget https://github.com/norticv/keeweb-webdav/archive/v1.0.0-alpha.zip keeweb-webdav.zip && unzip keeweb-webdav.zip 
```

Install and run the program

```bash
$ ./install
```
Now you can open your web browser and go to http://localhost:8080 
Use the login "admin" and password "admin" to connect you. 

Is highly recommended to change the password.

Warning, is recommended to use a reverse proxy with TLS if you want protected a public access !

## Configuration :

WEBDAV_USERNAME : default admin, is webdav username using to authentication

WEBDAV_PASSWORD : default admin, is webdav password using to authentication

BRUTEFORCE_PROTECTION_MAXRETRY : default 10, block the access at the password page after 10 authentication try. 

## FAQ

### How to use !

Connect you to : http://localhost:8080

### Where is the password storage file ?

You can find the keepass file in files/general.kdbx

### I want use my keepass file 

You can replace your file in files/general.kdbx and it's ok

### Where can I change the default keeweb configuration ?

You can modify the file files/keeweb.config.json
