<?php

// Bootstrap file for PHPUnit tests
// Suppress PHP 8.x deprecation warnings that cause issues with Laravel 6.x

// Set error reporting to exclude deprecation warnings during testing
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// Set custom error handler to skip deprecation warnings BEFORE autoloading
set_error_handler(function ($severity, $message, $file, $line) {
    // Skip deprecation warnings
    if ($severity === E_DEPRECATED || $severity === E_USER_DEPRECATED) {
        return true; // Don't execute PHP's internal error handler
    }
    // Let PHP handle other errors normally
    return false;
}, E_ALL);

// Suppress deprecation warnings globally during testing
ini_set('error_reporting', E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// Load the normal Composer autoloader
require __DIR__ . '/../vendor/autoload.php';