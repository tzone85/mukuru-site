<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Livewire\CurrencyRates;

class CurrencyRatesComponentTest extends TestCase
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
     * Test CurrencyRates component basic properties
     *
     * @return void
     */
    public function testCurrencyRatesComponentBasicProperties()
    {
        $reflection = new \ReflectionClass('App\Http\Livewire\CurrencyRates');

        // Test that the class exists and is instantiable
        $this->assertTrue($reflection->isInstantiable());

        // Test that it has expected properties
        $this->assertTrue($reflection->hasProperty('rates'));
        $this->assertTrue($reflection->hasProperty('baseCurrency'));
        $this->assertTrue($reflection->hasProperty('targetCurrencies'));
        $this->assertTrue($reflection->hasProperty('isLoading'));
        $this->assertTrue($reflection->hasProperty('lastUpdated'));
        $this->assertTrue($reflection->hasProperty('errorMessage'));
    }

    /**
     * Test CurrencyRates component has expected public properties
     *
     * @return void
     */
    public function testCurrencyRatesHasExpectedPublicProperties()
    {
        $component = new \App\Http\Livewire\CurrencyRates();

        // Test initial property values
        $this->assertIsArray($component->rates);
        $this->assertEquals('USD', $component->baseCurrency);
        $this->assertIsArray($component->targetCurrencies);
        $this->assertFalse($component->isLoading);
        $this->assertNull($component->lastUpdated);
        $this->assertNull($component->errorMessage);
    }

    /**
     * Test CurrencyRates component default target currencies
     *
     * @return void
     */
    public function testDefaultTargetCurrencies()
    {
        $component = new \App\Http\Livewire\CurrencyRates();

        $expectedCurrencies = ['EUR', 'GBP', 'JPY', 'AUD', 'CAD'];
        $this->assertEquals($expectedCurrencies, $component->targetCurrencies);
    }

    /**
     * Test CurrencyRates component has required methods
     *
     * @return void
     */
    public function testCurrencyRatesHasRequiredMethods()
    {
        $reflection = new \ReflectionClass('App\Http\Livewire\CurrencyRates');

        // Test that required methods exist
        $this->assertTrue($reflection->hasMethod('render'));
        $this->assertTrue($reflection->hasMethod('mount'));
        $this->assertTrue($reflection->hasMethod('fetchRates'));
        $this->assertTrue($reflection->hasMethod('updateRates'));
        $this->assertTrue($reflection->hasMethod('setBaseCurrency'));
        $this->assertTrue($reflection->hasMethod('formatRate'));
    }

    /**
     * Test render method returns view reference
     *
     * @return void
     */
    public function testRenderMethod()
    {
        $component = new \App\Http\Livewire\CurrencyRates();

        $reflection = new \ReflectionMethod($component, 'render');
        $this->assertTrue($reflection->isPublic());
        $this->assertEquals('render', $reflection->getName());
    }

    /**
     * Test mount method exists and is public
     *
     * @return void
     */
    public function testMountMethod()
    {
        $component = new \App\Http\Livewire\CurrencyRates();

        $reflection = new \ReflectionMethod($component, 'mount');
        $this->assertTrue($reflection->isPublic());
        $this->assertEquals('mount', $reflection->getName());
    }

    /**
     * Test fetchRates method exists and is public
     *
     * @return void
     */
    public function testFetchRatesMethod()
    {
        $component = new \App\Http\Livewire\CurrencyRates();

        $reflection = new \ReflectionMethod($component, 'fetchRates');
        $this->assertTrue($reflection->isPublic());
        $this->assertEquals('fetchRates', $reflection->getName());
    }

    /**
     * Test updateRates method exists and is public
     *
     * @return void
     */
    public function testUpdateRatesMethod()
    {
        $component = new \App\Http\Livewire\CurrencyRates();

        $reflection = new \ReflectionMethod($component, 'updateRates');
        $this->assertTrue($reflection->isPublic());
        $this->assertEquals('updateRates', $reflection->getName());
    }

    /**
     * Test setBaseCurrency method exists and is public
     *
     * @return void
     */
    public function testSetBaseCurrencyMethod()
    {
        $component = new \App\Http\Livewire\CurrencyRates();

        $reflection = new \ReflectionMethod($component, 'setBaseCurrency');
        $this->assertTrue($reflection->isPublic());
        $this->assertEquals('setBaseCurrency', $reflection->getName());
    }

    /**
     * Test formatRate method functionality
     *
     * @return void
     */
    public function testFormatRateMethodFunctionality()
    {
        $component = new \App\Http\Livewire\CurrencyRates();

        $result = $component->formatRate(1.2345, 'EUR');
        $this->assertIsString($result);
        $this->assertEquals('1.2345 EUR', $result);

        $result = $component->formatRate(110.5678, 'JPY');
        $this->assertEquals('110.5678 JPY', $result);
    }

    /**
     * Test setBaseCurrency method functionality
     *
     * @return void
     */
    public function testSetBaseCurrencyMethodFunctionality()
    {
        $component = new \App\Http\Livewire\CurrencyRates();

        // Initial state
        $this->assertEquals('USD', $component->baseCurrency);

        // Change base currency
        $component->setBaseCurrency('EUR');
        $this->assertEquals('EUR', $component->baseCurrency);

        // Change to another currency
        $component->setBaseCurrency('GBP');
        $this->assertEquals('GBP', $component->baseCurrency);
    }

    /**
     * Test getMockRates private method exists (indirectly through fetchRates)
     *
     * @return void
     */
    public function testMockRatesFunctionality()
    {
        $component = new \App\Http\Livewire\CurrencyRates();

        // Call fetchRates which should populate rates with mock data
        $component->fetchRates();

        // Verify rates were populated
        $this->assertNotEmpty($component->rates);
        $this->assertIsArray($component->rates);

        // Verify specific currencies exist in mock data
        $this->assertArrayHasKey('EUR', $component->rates);
        $this->assertArrayHasKey('GBP', $component->rates);
        $this->assertArrayHasKey('JPY', $component->rates);

        // Verify rates are numeric
        foreach ($component->rates as $rate) {
            $this->assertIsNumeric($rate);
        }
    }

    /**
     * Test component properties after fetchRates is called
     *
     * @return void
     */
    public function testComponentStateAfterFetchRates()
    {
        $component = new \App\Http\Livewire\CurrencyRates();

        // Initial state
        $this->assertFalse($component->isLoading);
        $this->assertNull($component->lastUpdated);
        $this->assertEmpty($component->rates);

        // Call fetchRates
        $component->fetchRates();

        // After fetchRates
        $this->assertFalse($component->isLoading);
        $this->assertNotNull($component->lastUpdated);
        $this->assertNotEmpty($component->rates);
        $this->assertNull($component->errorMessage);
    }
}