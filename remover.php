#!/usr/bin/env php
<?php
/**
* --host: host example.dev
**/
$args     = getopt(null, ["host:"]);
$host     = $args['host'];
$filename = './nginx/sites/' . $host . '.conf';

exec('rm -f ' . $filename);
exec('rm -f ./nginx/ssl/' . $host . '.key && rm -f ./nginx/ssl/' . $host . '.csr && rm -f ./nginx/ssl/' . $host . '.crt');

echo PHP_EOL . 'La configuración para nginx del sitio ' . $host . ' ha sido borrada del sistema'  . PHP_EOL . 'Salir y reinciar docker para aplicar los cambios' . PHP_EOL . PHP_EOL;
