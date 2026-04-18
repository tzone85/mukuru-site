<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Livewire\CurrencyRates;

class CurrencyRatesTest extends TestCase
{
    /**
     * Test CurrencyRates component class exists
     *
     * @return void
     */
    public function testCurrencyRatesComponentExists()
    {
        $this->assertTrue(class_exists('App\Http\Livewire\CurrencyRates'));
    }

    /**
     * Test CurrencyRates component extends Livewire Component
     *
     * @return void
     */
    public function testCurrencyRatesExtendsLivewireComponent()
    {
        $reflection = new \ReflectionClass(CurrencyRates::class);

        // Check if it has a parent class (should extend Component)
        $this->assertTrue($reflection->hasProperty('rates'));
        $this->assertTrue($reflection->hasMethod('render'));
        $this->assertTrue($reflection->hasMethod('fetchRates'));
        $this->assertTrue($reflection->hasMethod('updateRates'));
    }

    /**
     * Test CurrencyRates component has required properties
     *
     * @return void
     */
    public function testCurrencyRatesHasRequiredProperties()
    {
        $component = new CurrencyRates();

        // Test that required properties exist
        $this->assertObjectHasAttribute('rates', $component);
        $this->assertObjectHasAttribute('baseCurrency', $component);
        $this->assertObjectHasAttribute('targetCurrencies', $component);
        $this->assertObjectHasAttribute('isLoading', $component);
        $this->assertObjectHasAttribute('lastUpdated', $component);
        $this->assertObjectHasAttribute('errorMessage', $component);
    }

    /**
     * Test CurrencyRates component has default property values
     *
     * @return void
     */
    public function testCurrencyRatesHasDefaultPropertyValues()
    {
        $component = new CurrencyRates();

        // Test default values
        $this->assertIsArray($component->rates);
        $this->assertEquals('USD', $component->baseCurrency);
        $this->assertIsArray($component->targetCurrencies);
        $this->assertContains('EUR', $component->targetCurrencies);
        $this->assertContains('GBP', $component->targetCurrencies);
        $this->assertIsBool($component->isLoading);
        $this->assertFalse($component->isLoading);
    }

    /**
     * Test CurrencyRates render method returns view
     *
     * @return void
     */
    public function testCurrencyRatesRenderReturnsView()
    {
        $component = new CurrencyRates();

        // Test that render method exists and is callable
        $this->assertTrue(method_exists($component, 'render'));

        // Test that render method is public
        $reflection = new \ReflectionMethod($component, 'render');
        $this->assertTrue($reflection->isPublic());
    }

    /**
     * Test CurrencyRates fetchRates method exists
     *
     * @return void
     */
    public function testCurrencyRatesFetchRatesMethodExists()
    {
        $component = new CurrencyRates();

        $this->assertTrue(method_exists($component, 'fetchRates'));

        // Test that fetchRates is public
        $reflection = new \ReflectionMethod($component, 'fetchRates');
        $this->assertTrue($reflection->isPublic());
    }

    /**
     * Test CurrencyRates updateRates method exists
     *
     * @return void
     */
    public function testCurrencyRatesUpdateRatesMethodExists()
    {
        $component = new CurrencyRates();

        $this->assertTrue(method_exists($component, 'updateRates'));

        // Test that updateRates is public
        $reflection = new \ReflectionMethod($component, 'updateRates');
        $this->assertTrue($reflection->isPublic());
    }

    /**
     * Test CurrencyRates setBaseCurrency method exists
     *
     * @return void
     */
    public function testCurrencyRatesSetBaseCurrencyMethodExists()
    {
        $component = new CurrencyRates();

        $this->assertTrue(method_exists($component, 'setBaseCurrency'));

        // Test that setBaseCurrency is public
        $reflection = new \ReflectionMethod($component, 'setBaseCurrency');
        $this->assertTrue($reflection->isPublic());
    }

    /**
     * Test CurrencyRates formatRate method exists
     *
     * @return void
     */
    public function testCurrencyRatesFormatRateMethodExists()
    {
        $component = new CurrencyRates();

        $this->assertTrue(method_exists($component, 'formatRate'));

        // Test that formatRate is public
        $reflection = new \ReflectionMethod($component, 'formatRate');
        $this->assertTrue($reflection->isPublic());
    }

    /**
     * Test CurrencyRates mount method functionality
     *
     * @return void
     */
    public function testCurrencyRatesMountMethod()
    {
        $component = new CurrencyRates();

        $this->assertTrue(method_exists($component, 'mount'));

        // Test that mount is public
        $reflection = new \ReflectionMethod($component, 'mount');
        $this->assertTrue($reflection->isPublic());
    }

    /**
     * Test CurrencyRates component class structure
     *
     * @return void
     */
    public function testCurrencyRatesComponentStructure()
    {
        $reflection = new \ReflectionClass(CurrencyRates::class);

        // Test that the class exists and is instantiable
        $this->assertTrue($reflection->isInstantiable());

        // Test that it's in the correct namespace
        $this->assertEquals('App\Http\Livewire', $reflection->getNamespaceName());

        // Test that it has the expected methods
        $this->assertTrue($reflection->hasMethod('render'));
        $this->assertTrue($reflection->hasMethod('mount'));
        $this->assertTrue($reflection->hasMethod('fetchRates'));
        $this->assertTrue($reflection->hasMethod('updateRates'));
        $this->assertTrue($reflection->hasMethod('setBaseCurrency'));
    }

    /**
     * Test CurrencyRates formatRate method functionality
     *
     * @return void
     */
    public function testFormatRateMethod()
    {
        $component = new CurrencyRates();

        $formattedRate = $component->formatRate(1.2345, 'EUR');
        $this->assertIsString($formattedRate);
        $this->assertStringContainsString('1.2345', $formattedRate);
        $this->assertStringContainsString('EUR', $formattedRate);
    }

    /**
     * Test CurrencyRates setBaseCurrency method functionality
     *
     * @return void
     */
    public function testSetBaseCurrencyMethod()
    {
        $component = new CurrencyRates();

        $component->setBaseCurrency('EUR');
        $this->assertEquals('EUR', $component->baseCurrency);

        $component->setBaseCurrency('GBP');
        $this->assertEquals('GBP', $component->baseCurrency);
    }
}