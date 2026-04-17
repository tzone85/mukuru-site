<?php

namespace Tests\Unit;

use Tests\TestCase;

class ComposerJsonTest extends TestCase
{
    /**
     * Test that composer.json meets Laravel 6.x upgrade requirements
     *
     * @return void
     */
    public function testComposerJsonMeetsLaravel6xRequirements()
    {
        $composerPath = base_path('composer.json');
        $this->assertFileExists($composerPath, 'composer.json file should exist');

        $composerContent = file_get_contents($composerPath);
        $composer = json_decode($composerContent, true);

        $this->assertNotNull($composer, 'composer.json should be valid JSON');

        // Test PHP requirement is >= 7.4.0
        $this->assertArrayHasKey('require', $composer);
        $this->assertArrayHasKey('php', $composer['require']);
        $this->assertEquals('>=7.4.0', $composer['require']['php']);

        // Test Laravel framework is ^6.0
        $this->assertArrayHasKey('laravel/framework', $composer['require']);
        $this->assertEquals('^6.0', $composer['require']['laravel/framework']);

        // Test dev dependencies are compatible versions
        $this->assertArrayHasKey('require-dev', $composer);
        $devDeps = $composer['require-dev'];

        $this->assertArrayHasKey('phpunit/phpunit', $devDeps);
        $this->assertEquals('^8.5', $devDeps['phpunit/phpunit']);

        $this->assertArrayHasKey('mockery/mockery', $devDeps);
        $this->assertEquals('^1.1', $devDeps['mockery/mockery']);

        $this->assertArrayHasKey('fzaninotto/faker', $devDeps);
        $this->assertEquals('^1.9', $devDeps['fzaninotto/faker']);
    }

    /**
     * Test that composer.json is valid JSON
     *
     * @return void
     */
    public function testComposerJsonIsValidJson()
    {
        $composerPath = base_path('composer.json');
        $composerContent = file_get_contents($composerPath);

        json_decode($composerContent, true);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error(), 'composer.json should be valid JSON');
    }
}