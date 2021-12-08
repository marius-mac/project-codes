<?php
// ERROR REPORTING
error_reporting(E_ALL & ~E_NOTICE);

// !!! DATABASE SETTINGS - CHANGE THESE TO YOUR OWN !!!
define('DB_HOST', 'localhost');
define('DB_NAME', 'phplogin');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// FILE PATHS
define('PATH_LIB', __DIR__ . DIRECTORY_SEPARATOR);

// START SESSION
session_start();
?>