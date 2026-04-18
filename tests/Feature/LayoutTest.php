<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LayoutTest extends TestCase
{
    /**
     * Test that layout includes Livewire styles.
     *
     * @return void
     */
    public function testLayoutIncludesLivewireStyles()
    {
        $response = $this->get('/currency-rates');

        // Check for Livewire styles placeholder
        $response->assertSeeInOrder(['<head>', '@livewireStyles', '</head>'], false);
    }

    /**
     * Test that layout includes Livewire scripts.
     *
     * @return void
     */
    public function testLayoutIncludesLivewireScripts()
    {
        $response = $this->get('/currency-rates');

        // Check for Livewire scripts placeholder
        $response->assertSeeInOrder(['@livewireScripts', '</body>'], false);
    }

    /**
     * Test that navigation includes currency rates link.
     *
     * @return void
     */
    public function testNavigationIncludesCurrencyRatesLink()
    {
        $response = $this->get('/');

        $response->assertSee('Currency Rates');
        $response->assertSee(route('currency.rates'), false);
    }
}