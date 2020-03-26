jrepl "^PHP_VERSION=.*$" "PHP_VERSION=7.3" /f .env /o - && docker-compose build php-fpm && docker-compose build workspace
