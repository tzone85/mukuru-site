<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CurrencyRates extends Component
{
    /**
     * Currency rates data
     *
     * @var array
     */
    public $rates = [];

    /**
     * Base currency
     *
     * @var string
     */
    public $baseCurrency = 'USD';

    /**
     * Target currencies to display
     *
     * @var array
     */
    public $targetCurrencies = ['EUR', 'GBP', 'JPY', 'AUD', 'CAD'];

    /**
     * Loading state
     *
     * @var bool
     */
    public $isLoading = false;

    /**
     * Last updated timestamp
     *
     * @var string
     */
    public $lastUpdated;

    /**
     * Error message
     *
     * @var string|null
     */
    public $errorMessage;

    /**
     * Component initialization
     */
    public function mount()
    {
        $this->fetchRates();
    }

    /**
     * Fetch exchange rates from external API
     *
     * @return void
     */
    public function fetchRates()
    {
        $this->isLoading = true;
        $this->errorMessage = null;

        try {
            // Mock API call - replace with actual API integration
            $this->rates = $this->getMockRates();
            $this->lastUpdated = now()->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to fetch exchange rates: ' . $e->getMessage();
        } finally {
            $this->isLoading = false;
        }
    }

    /**
     * Update rates manually
     *
     * @return void
     */
    public function updateRates()
    {
        $this->fetchRates();
        $this->emit('ratesUpdated');
    }

    /**
     * Change base currency
     *
     * @param string $currency
     * @return void
     */
    public function setBaseCurrency($currency)
    {
        $this->baseCurrency = $currency;
        $this->fetchRates();
    }

    /**
     * Get mock exchange rates for development
     *
     * @return array
     */
    private function getMockRates()
    {
        // Mock data - replace with actual API call
        return [
            'EUR' => 0.85,
            'GBP' => 0.73,
            'JPY' => 110.23,
            'AUD' => 1.35,
            'CAD' => 1.25,
        ];
    }

    /**
     * Format rate display
     *
     * @param float $rate
     * @param string $currency
     * @return string
     */
    public function formatRate($rate, $currency)
    {
        return number_format($rate, 4) . ' ' . $currency;
    }

    /**
     * Render the component view
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.currency-rates');
    }
}