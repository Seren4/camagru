<?php
/**
 * set a constant = project's folder path (DIRECTORY_SEPARATOR adds a '/' to the end of the path).
 * Then, set a constant that holds the project's "application" folder, like "/var/www/application".
 */

define('ROOT', __DIR__ . '/');
define('APP', ROOT . 'application' . '/');
define('ASSETS', ROOT . 'assets/');

/** load application config (error reporting etc.) */
require 'config/database.php';

/** load application class */
require APP . '/classes/application.php';
require APP . '/classes/controller.php';

/** start the application */
$app = new Application($DB_NAME, $DB_TYPE, $DB_HOST, $DB_USER, $DB_PASS);
