<?php

// Configure error handling for PHPUnit + Laravel 5.5 + PHP 8.x compatibility
// This addresses specific compatibility issues while maintaining test functionality
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_STRICT);
ini_set('error_reporting', E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_STRICT);

// Set error handler before autoloader to catch early deprecation warnings
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Suppress specific Laravel 5.5 + PHP 8.x compatibility issues
    if ($errno === E_DEPRECATED || $errno === E_USER_DEPRECATED) {
        return true; // Suppress deprecation warnings
    }
    if ($errno === E_STRICT) {
        return true; // Suppress strict standards warnings
    }
    return false; // Let other errors proceed
}, E_ALL);

// Load the normal Composer autoloader
require __DIR__ . '/../vendor/autoload.php';