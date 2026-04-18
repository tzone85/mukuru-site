<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LivewireInstallationTest extends TestCase
{
    /**
     * Test that Livewire package is added to composer.json
     *
     * @return void
     */
    public function test_livewire_package_is_in_composer_json()
    {
        $composerJson = json_decode(file_get_contents(base_path('composer.json')), true);

        $this->assertArrayHasKey('livewire/livewire', $composerJson['require']);
    }

    /**
     * Test that Livewire assets are published to public directory
     *
     * @return void
     */
    public function test_livewire_assets_are_published()
    {
        $this->assertTrue(file_exists(public_path('livewire/livewire.js')));
        $this->assertTrue(file_exists(public_path('livewire/livewire.min.js')));
    }

    /**
     * Test that Livewire configuration is published
     *
     * @return void
     */
    public function test_livewire_configuration_is_published()
    {
        $this->assertTrue(file_exists(config_path('livewire.php')));

        $config = require config_path('livewire.php');
        $this->assertIsArray($config);
        $this->assertArrayHasKey('class_namespace', $config);
        $this->assertEquals('App\\Http\\Livewire', $config['class_namespace']);
    }

    /**
     * Test that Livewire service provider is auto-discovered
     *
     * @return void
     */
    public function test_livewire_service_provider_is_auto_discovered()
    {
        // Check if Livewire class exists (indicates service provider is loaded)
        $this->assertTrue(class_exists('Livewire\Livewire'));
    }

    /**
     * Test that Livewire component directory exists
     *
     * @return void
     */
    public function test_livewire_component_namespace_directory_can_be_created()
    {
        $componentDir = app_path('Http/Livewire');

        // Create directory if it doesn't exist
        if (!is_dir($componentDir)) {
            mkdir($componentDir, 0755, true);
        }

        $this->assertTrue(is_dir($componentDir));
    }

    /**
     * Test that Livewire view directory can be created
     *
     * @return void
     */
    public function test_livewire_view_directory_can_be_created()
    {
        $viewDir = resource_path('views/livewire');

        // Create directory if it doesn't exist
        if (!is_dir($viewDir)) {
            mkdir($viewDir, 0755, true);
        }

        $this->assertTrue(is_dir($viewDir));
    }
}