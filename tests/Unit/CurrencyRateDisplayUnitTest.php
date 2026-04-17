<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Livewire\CurrencyRateDisplay;
use Illuminate\Support\Facades\Http;

class CurrencyRateDisplayUnitTest extends TestCase
{
    /**
     * Test component initialization
     *
     * @return void
     */
    public function testComponentInitialization()
    {
        $component = new CurrencyRateDisplay();

        $this->assertEmpty($component->rates);
        $this->assertEquals('USD', $component->baseCurrency);
        $this->assertContains('EUR', $component->targetCurrencies);
        $this->assertContains('GBP', $component->targetCurrencies);
        $this->assertContains('ZAR', $component->targetCurrencies);
        $this->assertContains('BWP', $component->targetCurrencies);
        $this->assertContains('KES', $component->targetCurrencies);
        $this->assertFalse($component->loading);
        $this->assertNull($component->error);
    }

    /**
     * Test successful rate fetching
     *
     * @return void
     */
    public function testSuccessfulRateFetching()
    {
        // Mock successful HTTP response
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
        $this->assertNull($component->error);
        $this->assertNotEmpty($component->rates);
        $this->assertArrayHasKey('EUR', $component->rates);
        $this->assertArrayHasKey('GBP', $component->rates);
        $this->assertArrayHasKey('ZAR', $component->rates);
        $this->assertEquals('0.8500', $component->rates['EUR']['formatted']);
        $this->assertEquals(0.85, $component->rates['EUR']['rate']);
        $this->assertNotNull($component->lastUpdated);
    }

    /**
     * Test failed rate fetching
     *
     * @return void
     */
    public function testFailedRateFetching()
    {
        // Mock failed HTTP response
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
     * Test HTTP timeout handling
     *
     * @return void
     */
    public function testHttpTimeoutHandling()
    {
        // Mock HTTP timeout
        Http::fake([
            'api.exchangerate-api.com/*' => function () {
                throw new \Exception('Connection timeout');
            }
        ]);

        $component = new CurrencyRateDisplay();
        $component->fetchRates();

        $this->assertFalse($component->loading);
        $this->assertNotNull($component->error);
        $this->assertStringContainsString('Unable to fetch current exchange rates', $component->error);
    }

    /**
     * Test partial rate data handling
     *
     * @return void
     */
    public function testPartialRateDataHandling()
    {
        // Mock response with only some currencies
        Http::fake([
            'api.exchangerate-api.com/*' => Http::response([
                'rates' => [
                    'EUR' => 0.85,
                    'GBP' => 0.75
                    // Missing ZAR, BWP, KES
                ]
            ], 200)
        ]);

        $component = new CurrencyRateDisplay();
        $component->fetchRates();

        $this->assertFalse($component->loading);
        $this->assertNull($component->error);
        $this->assertArrayHasKey('EUR', $component->rates);
        $this->assertArrayHasKey('GBP', $component->rates);
        $this->assertArrayNotHasKey('ZAR', $component->rates);
        $this->assertCount(2, $component->rates);
    }

    /**
     * Test refresh rates method
     *
     * @return void
     */
    public function testRefreshRatesMethod()
    {
        Http::fake([
            'api.exchangerate-api.com/*' => Http::response([
                'rates' => [
                    'EUR' => 0.85,
                    'GBP' => 0.75
                ]
            ], 200)
        ]);

        $component = new CurrencyRateDisplay();
        $this->assertEmpty($component->rates);

        $component->refreshRates();

        $this->assertNotEmpty($component->rates);
        $this->assertFalse($component->loading);
        $this->assertNull($component->error);
    }

    /**
     * Test rate formatting
     *
     * @return void
     */
    public function testRateFormatting()
    {
        Http::fake([
            'api.exchangerate-api.com/*' => Http::response([
                'rates' => [
                    'EUR' => 0.123456789,
                    'ZAR' => 15.987654321
                ]
            ], 200)
        ]);

        $component = new CurrencyRateDisplay();
        $component->fetchRates();

        // Test that rates are formatted to 4 decimal places
        $this->assertEquals('0.1235', $component->rates['EUR']['formatted']);
        $this->assertEquals('15.9877', $component->rates['ZAR']['formatted']);
    }

    /**
     * Test component state during loading
     *
     * @return void
     */
    public function testComponentStatesDuringLoading()
    {
        $component = new CurrencyRateDisplay();

        // Initially not loading
        $this->assertFalse($component->loading);

        // Mock delayed response to test loading state
        Http::fake([
            'api.exchangerate-api.com/*' => Http::response([
                'rates' => ['EUR' => 0.85]
            ], 200)
        ]);

        $component->fetchRates();

        // After fetch completes, should not be loading
        $this->assertFalse($component->loading);
    }

    /**
     * Test error state reset on successful fetch
     *
     * @return void
     */
    public function testErrorStateResetOnSuccessfulFetch()
    {
        $component = new CurrencyRateDisplay();
        $component->error = 'Previous error';

        Http::fake([
            'api.exchangerate-api.com/*' => Http::response([
                'rates' => ['EUR' => 0.85]
            ], 200)
        ]);

        $component->fetchRates();

        $this->assertNull($component->error);
    }
}