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

        $app->make(Kernel::class)->bootstrap();

        Hash::setRounds(4);

        return $app;
    }
}