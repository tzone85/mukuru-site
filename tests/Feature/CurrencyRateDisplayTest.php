<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Livewire\CurrencyRateDisplay;
use Livewire\Testing\TestableLivewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class CurrencyRateDisplayTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that CurrencyRateDisplay component class exists
     *
     * @return void
     */
    public function testCurrencyRateDisplayClassExists()
    {
        $this->assertTrue(class_exists('App\Http\Livewire\CurrencyRateDisplay'));
    }

    /**
     * Test component basic structure
     *
     * @return void
     */
    public function testComponentBasicStructure()
    {
        $reflection = new \ReflectionClass('App\Http\Livewire\CurrencyRateDisplay');

        // Test that the class exists and is instantiable
        $this->assertTrue($reflection->isInstantiable());

        // Test that it has the expected methods
        $this->assertTrue($reflection->hasMethod('mount'));
        $this->assertTrue($reflection->hasMethod('fetchRates'));
        $this->assertTrue($reflection->hasMethod('refreshRates'));
        $this->assertTrue($reflection->hasMethod('render'));
    }

    /**
     * Test component extends Livewire Component
     *
     * @return void
     */
    public function testComponentExtendsLivewireComponent()
    {
        $reflection = new \ReflectionClass('App\Http\Livewire\CurrencyRateDisplay');

        // Test that it extends the Livewire Component class
        $this->assertEquals('Livewire\Component', $reflection->getParentClass()->getName());
    }

    /**
     * Test component has required properties
     *
     * @return void
     */
    public function testComponentHasRequiredProperties()
    {
        $component = new CurrencyRateDisplay();

        $this->assertIsArray($component->rates);
        $this->assertIsString($component->baseCurrency);
        $this->assertIsArray($component->targetCurrencies);
        $this->assertIsBool($component->loading);
        $this->assertNull($component->error);
    }

    /**
     * Test component default property values
     *
     * @return void
     */
    public function testComponentDefaultPropertyValues()
    {
        $component = new CurrencyRateDisplay();

        $this->assertEquals('USD', $component->baseCurrency);
        $this->assertEquals(['EUR', 'GBP', 'ZAR', 'BWP', 'KES'], $component->targetCurrencies);
        $this->assertFalse($component->loading);
        $this->assertEmpty($component->rates);
    }

    /**
     * Test component fetchRates method sets loading state
     *
     * @return void
     */
    public function testFetchRatesSetsLoadingState()
    {
        // Mock HTTP response
        Http::fake([
            'api.exchangerate-api.com/*' => Http::response([
                'rates' => [
                    'EUR' => 0.85,
                    'GBP' => 0.75,
                    'ZAR' => 15.50,
                    'BWP' => 12.30,
                    'KES' => 110.50
                ]
            ], 200)
        ]);

        $component = new CurrencyRateDisplay();
        $component->fetchRates();

        $this->assertFalse($component->loading);
        $this->assertNotEmpty($component->rates);
        $this->assertNull($component->error);
    }

    /**
     * Test component handles API failure gracefully
     *
     * @return void
     */
    public function testComponentHandlesApiFailure()
    {
        // Mock HTTP failure
        Http::fake([
            'api.exchangerate-api.com/*' => Http::response([], 500)
        ]);

        $component = new CurrencyRateDisplay();
        $component->fetchRates();

        $this->assertFalse($component->loading);
        $this->assertNotNull($component->error);
        $this->assertStringContainsString('Failed to fetch exchange rates', $component->error);
    }

    /**
     * Test component view file exists
     *
     * @return void
     */
    public function testComponentViewExists()
    {
        $viewPath = resource_path('views/livewire/currency-rate-display.blade.php');
        $this->assertFileExists($viewPath);
    }

    /**
     * Test component view contains required Tailwind CSS classes
     *
     * @return void
     */
    public function testComponentViewContainsTailwindClasses()
    {
        $viewPath = resource_path('views/livewire/currency-rate-display.blade.php');
        $viewContent = file_get_contents($viewPath);

        // Test for common Tailwind CSS classes
        $this->assertStringContainsString('bg-white', $viewContent);
        $this->assertStringContainsString('shadow-lg', $viewContent);
        $this->assertStringContainsString('rounded-lg', $viewContent);
        $this->assertStringContainsString('text-2xl', $viewContent);
        $this->assertStringContainsString('font-bold', $viewContent);
        $this->assertStringContainsString('grid', $viewContent);
        $this->assertStringContainsString('flex', $viewContent);
    }

    /**
     * Test component view contains real-time update features
     *
     * @return void
     */
    public function testComponentViewContainsRealTimeFeatures()
    {
        $viewPath = resource_path('views/livewire/currency-rate-display.blade.php');
        $viewContent = file_get_contents($viewPath);

        // Test for Livewire directives
        $this->assertStringContainsString('wire:click', $viewContent);
        $this->assertStringContainsString('refreshRates', $viewContent);

        // Test for auto-refresh script
        $this->assertStringContainsString('setInterval', $viewContent);
        $this->assertStringContainsString('@this.call', $viewContent);
    }

    /**
     * Test component renders exchange rate data correctly
     *
     * @return void
     */
    public function testComponentRendersExchangeRateData()
    {
        $component = new CurrencyRateDisplay();
        $component->rates = [
            'EUR' => ['rate' => 0.85, 'formatted' => '0.8500'],
            'GBP' => ['rate' => 0.75, 'formatted' => '0.7500']
        ];
        $component->baseCurrency = 'USD';

        $view = $component->render();
        $this->assertNotNull($view);
    }

    /**
     * Test component refreshRates method calls fetchRates
     *
     * @return void
     */
    public function testRefreshRatesCallsFetchRates()
    {
        // Mock HTTP response
        Http::fake([
            'api.exchangerate-api.com/*' => Http::response([
                'rates' => ['EUR' => 0.85]
            ], 200)
        ]);

        $component = new CurrencyRateDisplay();
        $initialRatesCount = count($component->rates);

        $component->refreshRates();

        // After refresh, rates should be populated
        $this->assertGreaterThan($initialRatesCount, count($component->rates));
    }

    /**
     * Test component listeners property is properly defined
     *
     * @return void
     */
    public function testComponentListenersProperty()
    {
        $component = new CurrencyRateDisplay();
        $reflection = new \ReflectionClass($component);
        $listenersProperty = $reflection->getProperty('listeners');
        $listenersProperty->setAccessible(true);

        $listeners = $listenersProperty->getValue($component);

        $this->assertIsArray($listeners);
        $this->assertArrayHasKey('refreshRates', $listeners);
        $this->assertEquals('fetchRates', $listeners['refreshRates']);
    }
}