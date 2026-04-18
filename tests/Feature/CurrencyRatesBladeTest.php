<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyRatesBladeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function currency_rates_blade_template_exists()
    {
        $viewPath = resource_path('views/livewire/currency-rates.blade.php');

        $this->assertFileExists($viewPath, 'Currency rates Blade template should exist');
    }

    /** @test */
    public function currency_rates_blade_template_contains_livewire_directives()
    {
        $viewPath = resource_path('views/livewire/currency-rates.blade.php');
        $content = file_get_contents($viewPath);

        // Test for required Livewire directives
        $this->assertStringContainsString('wire:model', $content, 'Template should contain wire:model directive');
        $this->assertStringContainsString('wire:click', $content, 'Template should contain wire:click directive');
    }

    /** @test */
    public function currency_rates_blade_template_contains_table_structure()
    {
        $viewPath = resource_path('views/livewire/currency-rates.blade.php');
        $content = file_get_contents($viewPath);

        // Test for table structure
        $this->assertStringContainsString('<table', $content, 'Template should contain a table element');
        $this->assertStringContainsString('<thead>', $content, 'Template should contain table header');
        $this->assertStringContainsString('<tbody>', $content, 'Template should contain table body');
        $this->assertStringContainsString('Currency', $content, 'Template should contain Currency column');
        $this->assertStringContainsString('Exchange Rate', $content, 'Template should contain Exchange Rate column');
    }

    /** @test */
    public function currency_rates_blade_template_has_responsive_design()
    {
        $viewPath = resource_path('views/livewire/currency-rates.blade.php');
        $content = file_get_contents($viewPath);

        // Test for responsive classes
        $this->assertStringContainsString('table-responsive', $content, 'Template should have responsive table class');
        $this->assertStringContainsString('col-md-', $content, 'Template should use responsive grid classes');
        $this->assertStringContainsString('@media', $content, 'Template should contain responsive media queries');
    }

    /** @test */
    public function currency_rates_blade_template_contains_bootstrap_styling()
    {
        $viewPath = resource_path('views/livewire/currency-rates.blade.php');
        $content = file_get_contents($viewPath);

        // Test for Bootstrap classes (matching existing app styling)
        $this->assertStringContainsString('panel-default', $content, 'Template should use panel-default class');
        $this->assertStringContainsString('panel-heading', $content, 'Template should use panel-heading class');
        $this->assertStringContainsString('panel-body', $content, 'Template should use panel-body class');
        $this->assertStringContainsString('container', $content, 'Template should use container class');
        $this->assertStringContainsString('form-control', $content, 'Template should use form-control class');
        $this->assertStringContainsString('btn btn-', $content, 'Template should use button classes');
    }

    /** @test */
    public function currency_rates_blade_template_has_search_functionality()
    {
        $viewPath = resource_path('views/livewire/currency-rates.blade.php');
        $content = file_get_contents($viewPath);

        // Test for search functionality
        $this->assertStringContainsString('wire:model.live="search"', $content, 'Template should have live search functionality');
        $this->assertStringContainsString('Search Currency', $content, 'Template should have search label');
        $this->assertStringContainsString('placeholder="Search by currency', $content, 'Template should have search placeholder');
    }

    /** @test */
    public function currency_rates_blade_template_has_loading_states()
    {
        $viewPath = resource_path('views/livewire/currency-rates.blade.php');
        $content = file_get_contents($viewPath);

        // Test for loading states
        $this->assertStringContainsString('wire:loading', $content, 'Template should have loading directives');
        $this->assertStringContainsString('Loading...', $content, 'Template should show loading text');
        $this->assertStringContainsString('wire:loading.attr="disabled"', $content, 'Template should disable buttons during loading');
    }

    /** @test */
    public function currency_rates_blade_template_has_sorting_functionality()
    {
        $viewPath = resource_path('views/livewire/currency-rates.blade.php');
        $content = file_get_contents($viewPath);

        // Test for sorting functionality
        $this->assertStringContainsString('sortBy(', $content, 'Template should have sorting functionality');
        $this->assertStringContainsString('$sortField', $content, 'Template should check sort field');
        $this->assertStringContainsString('$sortDirection', $content, 'Template should check sort direction');
        $this->assertStringContainsString('glyphicon-triangle-', $content, 'Template should show sort indicators');
    }

    /** @test */
    public function currency_rates_blade_template_handles_empty_state()
    {
        $viewPath = resource_path('views/livewire/currency-rates.blade.php');
        $content = file_get_contents($viewPath);

        // Test for empty state handling
        $this->assertStringContainsString('@forelse', $content, 'Template should use forelse directive');
        $this->assertStringContainsString('@empty', $content, 'Template should handle empty state');
        $this->assertStringContainsString('No exchange rates available', $content, 'Template should show empty message');
        $this->assertStringContainsString('No currencies found', $content, 'Template should show no search results message');
    }

    /** @test */
    public function currency_rates_blade_template_has_interactive_features()
    {
        $viewPath = resource_path('views/livewire/currency-rates.blade.php');
        $content = file_get_contents($viewPath);

        // Test for interactive features
        $this->assertStringContainsString('refreshRates', $content, 'Template should have refresh functionality');
        $this->assertStringContainsString('addToWatchlist', $content, 'Template should have watchlist functionality');
        $this->assertStringContainsString('viewDetails', $content, 'Template should have view details functionality');
        $this->assertStringContainsString('wire:click=', $content, 'Template should have clickable elements');
    }

    /** @test */
    public function currency_rates_blade_template_has_proper_structure()
    {
        $viewPath = resource_path('views/livewire/currency-rates.blade.php');
        $content = file_get_contents($viewPath);

        // Test that template is wrapped in a div (Livewire requirement)
        $this->assertStringStartsWith('<div>', $content, 'Template should start with a div element');
        $this->assertStringContainsString('</div>', $content, 'Template should contain closing div elements');

        // Test for proper HTML structure
        $this->assertStringContainsString('Currency Exchange Rates', $content, 'Template should have proper title');
        $this->assertStringContainsString('Real-time currency exchange rates', $content, 'Template should have subtitle');
    }
}