<?php

echo "Verifying composer.json Laravel 6.x upgrade requirements...\n\n";

$composerPath = __DIR__ . '/composer.json';

if (!file_exists($composerPath)) {
    echo "❌ FAIL: composer.json does not exist\n";
    exit(1);
}

$composerContent = file_get_contents($composerPath);
$composer = json_decode($composerContent, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo "❌ FAIL: composer.json is not valid JSON: " . json_last_error_msg() . "\n";
    exit(1);
}

echo "✅ PASS: composer.json is valid JSON\n";

// Check PHP requirement
$checks = [
    [
        'name' => 'PHP requirement is >=7.4.0',
        'test' => isset($composer['require']['php']) && $composer['require']['php'] === '>=7.4.0'
    ],
    [
        'name' => 'Laravel framework is ^6.0',
        'test' => isset($composer['require']['laravel/framework']) && $composer['require']['laravel/framework'] === '^6.0'
    ],
    [
        'name' => 'PHPUnit version is compatible (^8.5)',
        'test' => isset($composer['require-dev']['phpunit/phpunit']) && $composer['require-dev']['phpunit/phpunit'] === '^8.5'
    ],
    [
        'name' => 'Mockery version is compatible (^1.1)',
        'test' => isset($composer['require-dev']['mockery/mockery']) && $composer['require-dev']['mockery/mockery'] === '^1.1'
    ],
    [
        'name' => 'Faker version is compatible (^1.9)',
        'test' => isset($composer['require-dev']['fzaninotto/faker']) && $composer['require-dev']['fzaninotto/faker'] === '^1.9'
    ],
    [
        'name' => 'fideloper/proxy updated (^4.4)',
        'test' => isset($composer['require']['fideloper/proxy']) && $composer['require']['fideloper/proxy'] === '^4.4'
    ],
    [
        'name' => 'laravel/tinker updated (^2.0)',
        'test' => isset($composer['require']['laravel/tinker']) && $composer['require']['laravel/tinker'] === '^2.0'
    ]
];

$allPassed = true;

foreach ($checks as $check) {
    if ($check['test']) {
        echo "✅ PASS: {$check['name']}\n";
    } else {
        echo "❌ FAIL: {$check['name']}\n";
        $allPassed = false;
    }
}

echo "\n";

if ($allPassed) {
    echo "🎉 All acceptance criteria met! composer.json is ready for Laravel 6.x\n";
    exit(0);
} else {
    echo "💥 Some requirements not met. Please review the changes.\n";
    exit(1);
}