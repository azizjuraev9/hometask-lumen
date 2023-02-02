#!/bin/sh


if [ "$1" = "notification" ]; then
    php artisan notification:consume
else
    php artisan migrate
    php artisan app:init
    php -S 0.0.0.0:8000 -t public/
fi
