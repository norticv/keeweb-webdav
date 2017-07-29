#!/bin/bash
set -e

if [[ ! -f /initialized ]]; then 
    /prepare/init.sh
fi

# Run
echo "- Start services"
service php7.0-fpm start
exec service nginx start
