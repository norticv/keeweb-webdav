keeweb-webdav
==============

This program is a complete solution to storage and to manage your passwords in local only or online if you have an easy access.

### We uses :
* [Keeweb](https://keeweb.info/) Free cross-platform password manager compatible with KeePass.
* [Keepass file format kdbx](http://keepass.info/) Passwords file storage solution.
* [Sabre/dav](http://sabre.io/) (Webdav) To storage the Keepass file.
* [Docker](https://www.docker.com/) To create, configure and run easly the server.

### Security :
* We added a autentication protection to counter **Brute Force Attacks**. Available option :
  * Lock all accesses to file and program after *n* autentication failed. To unlocking, you will must restart the server. (**enabled by default**) 

## Quick start :

### Requirements :

1. [Docker](https://www.docker.com/community-edition#/download) version **1.12.0+**
2. [Docker Compose](https://docs.docker.com/compose/install/) version **1.9.0+**

### Install last release :

Get the last stable release

```bash
$ wget https://github.com/norticv/keeweb-webdav/archive/v1.0.1-beta.zip keeweb-webdav.zip && unzip keeweb-webdav.zip 
```

Install and run the program

```bash
$ ./install
```
Now you can open your web browser and go to http://localhost:8080 
Use the login "admin" and password "admin" to connect you.

By default, the Keepass file is available in folder *files/general.kdbx*.

*Is highly recommended to read the recommanded security before to start*.

## Recommanded security :

**By default, the keepass file have not password. It highly recommended to add it.**
The keepass file is encrypted, so you can disable the webdav autentication but it's not recommanded if you use a public access.

By default, the Keepass file is encrypted and without password. But we shoul

If you want use this program with a public access. It highly recommanded to follow this instructions :
* It is important to use a reverse proxy ;
* You can remove the webdav autentication but it's not recommand

Is highly recommended to change the password .
If you want use online, it is important to use a reverse proxy with TLS if you want protected a public access !

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
