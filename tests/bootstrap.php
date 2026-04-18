<?php

/*
 * PHPUnit bootstrap for Laravel 5.5 + PHP 8.5 compatibility
 *
 * Problem: Laravel 5.5 framework has implicit nullable parameters that trigger
 * deprecation warnings in PHP 8+. These warnings get converted to exceptions
 * during application bootstrap, causing all Laravel-based tests to fail.
 *
 * Solution: Targeted error suppression for framework compatibility while
 * preserving proper error detection for actual test code.
 */

// Set up error suppression before autoloader runs
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Suppress Laravel 5.5 framework compatibility warnings
    if ($errno === E_DEPRECATED || $errno === E_USER_DEPRECATED) {
        // Specifically target Laravel framework deprecation warnings
        if (strpos($errfile, 'laravel/framework') !== false ||
            strpos($errfile, 'illuminate/') !== false ||
            strpos($errstr, 'Implicitly marking parameter') !== false ||
            strpos($errstr, 'nullable is deprecated') !== false) {
            return true; // Suppress Laravel framework deprecations
        }
    }

    // Suppress strict standards warnings from Laravel 5.5
    if ($errno === E_STRICT && strpos($errfile, 'vendor/') !== false) {
        return true;
    }

    // Let all other errors through for proper test failure detection
    return false;
}, E_ALL);

// Configure error reporting for compatibility
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

// Load Composer autoloader
require __DIR__ . '/../vendor/autoload.php';