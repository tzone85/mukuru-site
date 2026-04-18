<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class Vue3ComponentTest extends TestCase
{
    /**
     * Test welcome blade view contains currency-component HTML
     *
     * @return void
     */
    public function testWelcomeBladeContainsCurrencyComponent()
    {
        $welcomeContent = file_get_contents(__DIR__ . '/../../resources/views/welcome.blade.php');

        $this->assertNotFalse($welcomeContent, 'Welcome blade view should exist');
        $this->assertStringContainsString('<currency-component></currency-component>', $welcomeContent, 'Welcome view should contain currency-component');
    }

    /**
     * Test layouts.app blade contains #app div
     *
     * @return void
     */
    public function testLayoutsAppContainsAppDiv()
    {
        $layoutContent = file_get_contents(__DIR__ . '/../../resources/views/layouts/app.blade.php');

        $this->assertNotFalse($layoutContent, 'App layout should exist');
        $this->assertStringContainsString('<div id="app">', $layoutContent, 'App layout should contain #app div for Vue mounting');
    }

    /**
     * Test welcome blade view extends layouts.app
     *
     * @return void
     */
    public function testWelcomeBladeExtendsLayoutsApp()
    {
        $welcomeContent = file_get_contents(__DIR__ . '/../../resources/views/welcome.blade.php');

        $this->assertNotFalse($welcomeContent, 'Welcome blade view should exist');
        $this->assertStringContainsString("@extends('layouts.app')", $welcomeContent, 'Welcome view should extend layouts.app');
    }

    /**
     * Test app layout includes Vue.js scripts
     *
     * @return void
     */
    public function testAppLayoutIncludesVueScripts()
    {
        $layoutContent = file_get_contents(__DIR__ . '/../../resources/views/layouts/app.blade.php');

        $this->assertNotFalse($layoutContent, 'App layout should exist');
        $this->assertStringContainsString('js/app.js', $layoutContent, 'App layout should include Vue.js app script');
    }

    /**
     * Test app layout includes CSRF token meta tag
     *
     * @return void
     */
    public function testAppLayoutIncludesCsrfToken()
    {
        $layoutContent = file_get_contents(__DIR__ . '/../../resources/views/layouts/app.blade.php');

        $this->assertNotFalse($layoutContent, 'App layout should exist');
        $this->assertStringContainsString('csrf-token', $layoutContent, 'App layout should include CSRF token meta tag');
    }

    /**
     * Test Vue component is registered in app.js
     *
     * @return void
     */
    public function testCurrencyComponentRegisteredInAppJs()
    {
        $appJsContent = file_get_contents(__DIR__ . '/../../public/js/app.js');

        $this->assertNotFalse($appJsContent, 'Compiled app.js should exist');
        $this->assertStringContainsString('currency-component', $appJsContent, 'Currency component should be registered in app.js');
    }

    /**
     * Test Vue app mounts to #app element
     *
     * @return void
     */
    public function testVueAppMountsToAppElement()
    {
        $appJsContent = file_get_contents(__DIR__ . '/../../public/js/app.js');

        $this->assertNotFalse($appJsContent, 'Compiled app.js should exist');
        $this->assertStringContainsString('#app', $appJsContent, 'Vue app should mount to #app element');
    }

    /**
     * Test currency-rates view exists and contains Livewire component
     *
     * @return void
     */
    public function testCurrencyRatesViewExistsAndContainsLivewire()
    {
        $currencyRatesContent = file_get_contents(__DIR__ . '/../../resources/views/currency-rates.blade.php');

        $this->assertNotFalse($currencyRatesContent, 'Currency rates blade view should exist');
        $this->assertStringContainsString("@extends('layouts.app')", $currencyRatesContent, 'Currency rates view should extend layouts.app');
        $this->assertStringContainsString('@livewire', $currencyRatesContent, 'Currency rates view should contain Livewire component');
    }

    /**
     * Test web routes define proper routes for Vue component pages
     *
     * @return void
     */
    public function testWebRoutesDefineVueComponentRoutes()
    {
        $routesContent = file_get_contents(__DIR__ . '/../../routes/web.php');

        $this->assertNotFalse($routesContent, 'Web routes file should exist');
        $this->assertStringContainsString("return view('welcome')", $routesContent, 'Routes should define welcome view');
        $this->assertStringContainsString("return view('currency-rates')", $routesContent, 'Routes should define currency-rates view');
    }

    /**
     * Test Vue components and Livewire can coexist by checking both templates
     *
     * @return void
     */
    public function testVueAndLivewireCoexistence()
    {
        // Check Vue component in welcome view
        $welcomeContent = file_get_contents(__DIR__ . '/../../resources/views/welcome.blade.php');
        $this->assertStringContainsString('<currency-component></currency-component>', $welcomeContent, 'Welcome should contain Vue component');

        // Check Livewire component in currency-rates view
        $currencyContent = file_get_contents(__DIR__ . '/../../resources/views/currency-rates.blade.php');
        $this->assertStringContainsString('@livewire', $currencyContent, 'Currency rates should contain Livewire component');

        // Both should extend the same layout that has #app div
        $this->assertStringContainsString("@extends('layouts.app')", $welcomeContent, 'Welcome should extend layouts.app');
        $this->assertStringContainsString("@extends('layouts.app')", $currencyContent, 'Currency rates should extend layouts.app');

        // Layout should support both frameworks
        $layoutContent = file_get_contents(__DIR__ . '/../../resources/views/layouts/app.blade.php');
        $this->assertStringContainsString('<div id="app">', $layoutContent, 'Layout should have Vue mount point');
        $this->assertStringContainsString('@livewireStyles', $layoutContent, 'Layout should include Livewire styles');
        $this->assertStringContainsString('@livewireScripts', $layoutContent, 'Layout should include Livewire scripts');
    }
}