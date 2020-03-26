#!/usr/bin/env php
<?php
/**
* --host: host example.dev
* --path:  project-name/
* --company: company name if you want to use SSL
* --country: country name if you want to use SSL
**/
$args     = getopt(null, ["host:", "path:", "company:", "country:"]);
$file     = file_get_contents('./nginx/sites/app.conf.example');
$host     = $args['host'];
$filename = './nginx/sites/' . $host . '.conf';

$data = str_replace([
    'server_name app.test;',
    'root /var/www/app',
    'ssl_certificate /etc/nginx/ssl/default.crt;',
    'ssl_certificate_key /etc/nginx/ssl/default.key;',
    '# listen 443 ssl;',
    '# ssl_certificate',
    '# ssl_certificate_key',
    'error_log /var/log/nginx/app_error.log;',
    'access_log /var/log/nginx/app_access.log;',
], [
    'server_name ' . $args["host"] . ';',
    'root /var/www/' . $args["path"],
    'ssl_certificate /etc/nginx/ssl/' . $host . '.crt;',
    'ssl_certificate_key /etc/nginx/ssl/' . $host . '.key;',
    'listen 443 ssl;',
    'ssl_certificate',
    'ssl_certificate_key',
    'error_log /var/log/nginx/' . $host . '_error.log;',
    'access_log /var/log/nginx/' . $host . '_access.log;',
], $file);

exec('rm -f ' . $filename);
file_put_contents($filename, $data);

exec('rm -f ./customssl.cnf && rm -f ./nginx/ssl/' . $host . '.key && rm -f ./nginx/ssl/' . $host . '.csr && rm -f ./nginx/ssl/' . $host . '.crt');

$customssl_file = fopen("customssl.cnf", "w");
fwrite($customssl_file, '[v3_req]' . PHP_EOL);
fwrite($customssl_file, 'subjectAltName = @alt_names' . PHP_EOL);
fwrite($customssl_file, '[alt_names]' . PHP_EOL);
fwrite($customssl_file, 'DNS.1 = ' . $host . PHP_EOL);
fclose($customssl_file);

exec('openssl genrsa -out "./nginx/ssl/' . $host . '.key" 2048');
exec('openssl req -new -key "./nginx/ssl/' . $host . '.key" -out "./nginx/ssl/' . $host . '.csr" -subj "/C=ES/ST=Madrid/L=Madrid/O=' . $args['company'] . '/CN=' . $host . '"');
exec('openssl x509 -req -days 365 -in "./nginx/ssl/' . $host . '.csr" -signkey "./nginx/ssl/' . $host . '.key" -out "./nginx/ssl/' . $host . '.crt" -extfile ./customssl.cnf -extensions v3_req');

exec('rm -f customssl.cnf');

echo PHP_EOL . 'La configuración para nginx del sitio ' . $host . ' ha sido creada en el sistema'  . PHP_EOL . 'Salir y reinciar docker para aplicar los cambios' . PHP_EOL . PHP_EOL;
