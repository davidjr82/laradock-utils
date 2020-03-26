jrepl "^PHP_VERSION=.*$" "PHP_VERSION=7.2" /f .env /o - && docker-compose build php-fpm && docker-compose build workspace
