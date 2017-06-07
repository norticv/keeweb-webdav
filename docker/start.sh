#!/bin/bash

echo "Change parameters"

sed -i "s/%%WEBDAV_USERNAME%%/${WEBDAV_USERNAME}/" /params.php
sed -i "s/%%WEBDAV_PASSWORD%%/${WEBDAV_PASSWORD}/" /params.php
sed -i "s#%%WEBDAV_BASEURI%%#${WEBDAV_BASEURI}#" /params.php
sed -i "s/%%BRUTEFORCE_PROTECTION_MAXRETRY%%/${BRUTEFORCE_PROTECTION_MAXRETRY}/" /params.php

echo "Welcome to KeeWeb docker container"
/sbin/my_init
