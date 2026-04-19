<?php

namespace Tests\Feature;

use Tests\TestCase;

class VueCompilationTest extends TestCase
{
    /**
     * Test that Vue 3 components compile successfully.
     *
     * @return void
     */
    public function testVue3ComponentsCompileSuccessfully()
    {
        // Check that the compiled app.js exists
        $appJsPath = public_path('js/app.js');
        $this->assertTrue(file_exists($appJsPath), 'Compiled app.js file should exist');

        // Read the compiled JavaScript
        $compiledJs = file_get_contents($appJsPath);
        $this->assertNotEmpty($compiledJs, 'Compiled JavaScript should not be empty');

        // Verify Vue 3 specific patterns are present
        $this->assertStringContainsString('@vue/reactivity', $compiledJs, 'Should contain Vue 3 reactivity imports');
        $this->assertStringContainsString('createApp', $compiledJs, 'Should contain Vue 3 createApp function');
        $this->assertStringContainsString('__VUE_OPTIONS_API__', $compiledJs, 'Should contain Vue 3 feature flags');

        // Verify the file size is reasonable (should contain Vue 3 bundle)
        $fileSize = strlen($compiledJs);
        $this->assertGreaterThan(100000, $fileSize, 'Compiled JavaScript should be substantial in size');
        $this->assertLessThan(5000000, $fileSize, 'Compiled JavaScript should not be excessively large');
    }

    /**
     * Test that webpack configuration file exists and is valid.
     *
     * @return void
     */
    public function testWebpackConfigExists()
    {
        $webpackPath = base_path('webpack.mix.js');
        $this->assertTrue(file_exists($webpackPath), 'webpack.mix.js should exist');

        $configContent = file_get_contents($webpackPath);
        $this->assertStringContainsString('vue', $configContent, 'webpack.mix.js should contain Vue configuration');
        $this->assertStringContainsString('version: 3', $configContent, 'webpack.mix.js should specify Vue 3');
        $this->assertStringContainsString('VueLoaderPlugin', $configContent, 'webpack.mix.js should include VueLoaderPlugin');
    }

    /**
     * Test that Vue components exist and are valid.
     *
     * @return void
     */
    public function testVueComponentsExistAndAreValid()
    {
        // Check that Vue components exist
        $currencyComponentPath = resource_path('assets/js/components/CurrencyComponent.vue');
        $this->assertTrue(file_exists($currencyComponentPath), 'CurrencyComponent.vue should exist');

        // Read the component and verify it has Vue 3 compatible syntax
        $componentContent = file_get_contents($currencyComponentPath);
        $this->assertStringContainsString('<template>', $componentContent, 'Component should have a template section');
        $this->assertStringContainsString('<script>', $componentContent, 'Component should have a script section');
        $this->assertStringContainsString('export default', $componentContent, 'Component should export a default object');
    }

    /**
     * Test that package.json has correct Vue 3 dependencies.
     *
     * @return void
     */
    public function testPackageJsonHasVue3Dependencies()
    {
        $packageJsonPath = base_path('package.json');
        $this->assertTrue(file_exists($packageJsonPath), 'package.json should exist');

        $packageJson = json_decode(file_get_contents($packageJsonPath), true);
        $this->assertNotNull($packageJson, 'package.json should be valid JSON');

        // Check Vue 3 dependencies
        $devDependencies = $packageJson['devDependencies'] ?? [];
        $this->assertArrayHasKey('vue', $devDependencies, 'Vue should be in devDependencies');
        $this->assertArrayHasKey('@vue/compiler-sfc', $devDependencies, '@vue/compiler-sfc should be in devDependencies');
        $this->assertArrayHasKey('vue-loader', $devDependencies, 'vue-loader should be in devDependencies');

        // Verify versions are Vue 3 compatible
        $this->assertStringStartsWith('^3.', $devDependencies['vue'], 'Vue version should be 3.x');
        $this->assertStringStartsWith('^3.', $devDependencies['@vue/compiler-sfc'], '@vue/compiler-sfc version should be 3.x');
        $this->assertStringStartsWith('^17.', $devDependencies['vue-loader'], 'vue-loader version should be 17.x (Vue 3 compatible)');
    }
}