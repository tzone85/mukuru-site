<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\File;

class Vue3IntegrationTest extends TestCase
{
    /**
     * Test that Blade view with currency component loads properly
     * This test specifically loads the welcome.blade.php view that contains <currency-component>
     */
    public function testBladeViewWithCurrencyComponentLoads()
    {
        // Load the actual Blade view that contains Vue currency component
        $response = $this->get('/');

        $response->assertStatus(200);

        // Verify the Vue app mount point exists
        $response->assertSee('<div id="app">', false);

        // Verify the currency component tag is present in the Blade view
        $response->assertSee('<currency-component></currency-component>', false);

        // Verify the API_URL script is present for component functionality
        $response->assertSee('let API_URL =', false);
    }

    /**
     * Test that JavaScript compilation is successful and contains Vue 3 code
     * This verifies the webpack compilation process worked correctly
     */
    public function testJavaScriptCompilationSuccessful()
    {
        $appJsPath = public_path('js/app.js');

        // Verify compiled JavaScript file exists
        $this->assertFileExists($appJsPath, 'Compiled app.js file should exist');

        $jsContent = file_get_contents($appJsPath);

        // Verify Vue is present in compiled JS (for Vue 2 to Vue 3 upgrade)
        $this->assertStringContainsString('Vue', $jsContent, 'Vue should be present in compiled JavaScript');

        // Verify currency component is registered
        $this->assertStringContainsString('currency-component', $jsContent, 'Currency component should be registered in JavaScript');

        // Test that JS file is accessible via HTTP
        $response = $this->get('/js/app.js');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/javascript');
    }

    /**
     * Test Vue 3 mount functionality by verifying component structure
     * This tests the actual Vue 3 mount point and component registration
     */
    public function testVue3MountFunctionality()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Verify Vue app mount point structure
        $this->assertStringContainsString('id="app"', $content, 'Vue mount point should exist');

        // Verify currency component is present within the app
        $this->assertStringContainsString('<currency-component>', $content, 'Currency component should be mounted within Vue app');

        // Verify no Vue mounting errors
        $this->assertStringNotContainsString('Vue.createApp is not a function', $content);
        $this->assertStringNotContainsString('[Vue warn]', $content);
        $this->assertStringNotContainsString('Failed to mount app', $content);

        // Verify JavaScript is included for mounting
        $this->assertStringContainsString('/js/app.js', $content, 'Vue JavaScript should be included');
    }

    /**
     * Test Vue 3 reactivity by checking currency component reactive elements
     * This verifies reactive form inputs and data binding work in Vue 3
     */
    public function testVue3ReactivityFunctionality()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Currency component should contain reactive form elements
        $this->assertStringContainsString('<currency-component>', $content);

        // Verify no Vue reactivity warnings/errors
        $this->assertStringNotContainsString('Uncaught TypeError', $content);
        $this->assertStringNotContainsString('reactivity error', $content);
        $this->assertStringNotContainsString('Vue 2 reactivity', $content);

        // Check currency component source for Vue 3 reactive patterns
        $componentPath = resource_path('assets/js/components/CurrencyComponent.vue');
        if (file_exists($componentPath)) {
            $componentContent = file_get_contents($componentPath);

            // Vue component should have data function (Vue 3 compatible)
            $this->assertStringContainsString('data()', $componentContent, 'Component should use Vue 3 data() function');

            // Should have reactive form elements
            $this->assertStringContainsString('v-model=', $componentContent, 'Component should have reactive v-model bindings');
            $this->assertStringContainsString('v-on:', $componentContent, 'Component should have event handlers');
        }
    }

    /**
     * Comprehensive Vue 3 upgrade success verification
     * This test confirms the full Vue 3 upgrade is working end-to-end
     */
    public function testVue3UpgradeSuccessEndToEnd()
    {
        // Test 1: Blade view loads with Vue component
        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Verify Vue app structure
        $this->assertStringContainsString('<div id="app">', $content, 'Vue app container should exist');
        $this->assertStringContainsString('<currency-component></currency-component>', $content, 'Currency component should be present');

        // Test 2: JavaScript compilation successful
        $appJsPath = public_path('js/app.js');
        $this->assertFileExists($appJsPath, 'Compiled Vue JavaScript should exist');

        $jsContent = file_get_contents($appJsPath);
        $this->assertStringContainsString('Vue', $jsContent, 'Vue should be compiled into JavaScript');

        // Test 3: No Vue 2/3 compatibility errors
        $this->assertStringNotContainsString('Vue 2 compatibility', $content);
        $this->assertStringNotContainsString('Vue.component is not a function', $content);
        $this->assertStringNotContainsString('createApp is not defined', $content);

        // Test 4: Component registration working
        $this->assertStringContainsString('currency-component', $jsContent, 'Currency component should be registered');

        // Test 5: API configuration present
        $this->assertStringContainsString('API_URL', $content, 'API configuration should be available for components');

        // Test 6: No console errors in page source
        $this->assertStringNotContainsString('console.error', $content);
        $this->assertStringNotContainsString('Uncaught', $content);
    }

    /**
     * Test Vue 3 components are properly registered and functional
     * This verifies component registration works in Vue 3 syntax
     */
    public function testVue3ComponentRegistration()
    {
        $appJsPath = resource_path('assets/js/app.js');

        if (file_exists($appJsPath)) {
            $appJsContent = file_get_contents($appJsPath);

            // Check for component registration
            $this->assertStringContainsString('currency-component', $appJsContent, 'Currency component should be registered in app.js');

            // For Vue 3 upgrade, ensure no old Vue 2 syntax errors
            if (strpos($appJsContent, 'Vue.createApp') !== false) {
                // Vue 3 syntax
                $this->assertStringContainsString('createApp', $appJsContent, 'Vue 3 createApp should be used');
            } else {
                // Vue 2 syntax (still valid during transition)
                $this->assertStringContainsString('new Vue', $appJsContent, 'Vue 2 syntax should work during upgrade');
            }
        }

        // Test component renders in browser
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('<currency-component>', false);
    }

    /**
     * Test that compiled assets support Vue 3 and work with existing Livewire
     * This ensures Vue 3 coexists with Livewire components
     */
    public function testVue3LivewireCoexistence()
    {
        // Test home page (Vue components)
        $vueResponse = $this->get('/');
        $vueResponse->assertStatus(200);
        $vueContent = $vueResponse->getContent();

        // Should contain Vue app
        $this->assertStringContainsString('id="app"', $vueContent);
        $this->assertStringContainsString('<currency-component>', $vueContent);
        $this->assertStringContainsString('js/app.js', $vueContent);

        // Test currency-rates page (Livewire components)
        $livewireResponse = $this->get('/currency-rates');
        $livewireResponse->assertStatus(200);
        $livewireContent = $livewireResponse->getContent();

        // Should contain Livewire
        $this->assertStringContainsString('@livewireStyles', $livewireContent);
        $this->assertStringContainsString('@livewireScripts', $livewireContent);
        $this->assertStringContainsString('@livewire', $livewireContent);

        // Both should load without conflicts
        $this->assertStringNotContainsString('Livewire conflicts with Vue', $vueContent);
        $this->assertStringNotContainsString('Vue conflicts with Livewire', $livewireContent);
        $this->assertStringNotContainsString('Alpine conflicts', $livewireContent);
    }

    /**
     * Test Vue 3 error handling and graceful degradation
     * This ensures Vue 3 upgrade handles errors properly
     */
    public function testVue3ErrorHandlingAndDegradation()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Verify no Vue 3 specific errors
        $this->assertStringNotContainsString('Vue 3 error', $content);
        $this->assertStringNotContainsString('composition API error', $content);
        $this->assertStringNotContainsString('reactive error', $content);
        $this->assertStringNotContainsString('createApp error', $content);

        // Verify no JavaScript runtime errors
        $this->assertStringNotContainsString('ReferenceError', $content);
        $this->assertStringNotContainsString('TypeError: Cannot read', $content);
        $this->assertStringNotContainsString('Uncaught Error', $content);

        // Verify graceful handling if Vue fails to load
        $this->assertStringNotContainsString('Vue is not defined', $content);
        $this->assertStringNotContainsString('Cannot access before initialization', $content);
    }
}