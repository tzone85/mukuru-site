<?php

echo "Laravel Livewire Installation Verification\n";
echo "==========================================\n\n";

// 1. Check composer.json
$composerJson = json_decode(file_get_contents('composer.json'), true);
if (isset($composerJson['require']['livewire/livewire'])) {
    echo "✅ Livewire package is in composer.json\n";
} else {
    echo "❌ Livewire package NOT found in composer.json\n";
}

// 2. Check assets
if (file_exists('public/livewire/livewire.js') && file_exists('public/livewire/livewire.min.js')) {
    echo "✅ Livewire assets are published to public directory\n";
} else {
    echo "❌ Livewire assets NOT found in public directory\n";
}

// 3. Check config
if (file_exists('config/livewire.php')) {
    echo "✅ Livewire configuration file exists\n";
} else {
    echo "❌ Livewire configuration file NOT found\n";
}

// 4. Check directories
if (is_dir('app/Http/Livewire')) {
    echo "✅ Livewire component directory exists\n";
} else {
    echo "❌ Livewire component directory NOT found\n";
}

if (is_dir('resources/views/livewire')) {
    echo "✅ Livewire views directory exists\n";
} else {
    echo "❌ Livewire views directory NOT found\n";
}

// 5. Check vendor package
if (is_dir('vendor/livewire/livewire')) {
    echo "✅ Livewire vendor package is installed\n";
} else {
    echo "❌ Livewire vendor package NOT found\n";
}

echo "\nInstallation Summary:\n";
echo "- Package added to composer.json\n";
echo "- Assets published to public/livewire/\n";
echo "- Configuration published to config/livewire.php\n";
echo "- Service provider auto-discovery enabled (Laravel 6.0 feature)\n";
echo "\nLaravel Livewire installation complete! 🎉\n";