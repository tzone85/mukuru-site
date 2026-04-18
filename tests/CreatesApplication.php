<?php

namespace Tests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        // Suppress deprecation warnings globally before Laravel bootstrap
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
        ini_set('error_reporting', E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

        // Set a custom error handler that skips deprecation warnings
        set_error_handler(function ($severity, $message, $file, $line) {
            // Skip all deprecation warnings completely
            if (
                $severity === E_DEPRECATED ||
                $severity === E_USER_DEPRECATED ||
                strpos($message, 'deprecated') !== false ||
                strpos($message, 'Implicitly marking parameter') !== false
            ) {
                return true;
            }
            // Let other errors proceed normally
            return false;
        }, E_ALL);

        $app = require __DIR__.'/../bootstrap/app.php';

        // Suppress Laravel 5.5 deprecation warnings during bootstrap for PHP 8.x compatibility
        $originalErrorHandler = set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            // Suppress Laravel framework deprecation warnings specifically
            if (($errno === E_DEPRECATED || $errno === E_USER_DEPRECATED) &&
                (strpos($errfile, 'laravel/framework') !== false ||
                 strpos($errfile, 'illuminate/') !== false ||
                 strpos($errstr, 'Implicitly marking parameter') !== false ||
                 strpos($errstr, 'nullable is deprecated') !== false)) {
                return true; // Suppress the error
            }

            // Suppress strict standards warnings from Laravel
            if ($errno === E_STRICT && strpos($errfile, 'vendor/') !== false) {
                return true;
            }

            // Let other errors pass through
            return false;
        }, E_ALL);

        try {
            $app->make(Kernel::class)->bootstrap();
        } finally {
            // Restore original error handler
            if ($originalErrorHandler !== null) {
                set_error_handler($originalErrorHandler);
            } else {
                restore_error_handler();
            }
        }

        Hash::setRounds(4);

        return $app;
    }
}