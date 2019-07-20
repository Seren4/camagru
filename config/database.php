<?php

$DB_TYPE = 'mysql';
$DB_HOST = '127.0.0.1';
$DB_NAME = 'camagru';
$DB_USER =  'root';
$DB_PASS = '';

/**
 * Configuration for error reporting, on a dev server
 * error_reporting(E_ALL);
 * ini_set("display_errors", 1);
 * */

define('URL_PROTOCOL', 'http://');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_INDEX_FILE', 'index.php' . '/');
define('URL', URL_PROTOCOL . URL_DOMAIN . '/');
define('URL_WITH_INDEX_FILE', URL_PROTOCOL . URL_DOMAIN . '/' . URL_INDEX_FILE);