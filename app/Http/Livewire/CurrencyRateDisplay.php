<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyRateDisplay extends Component
{
    public $rates = [];
    public $baseCurrency = 'USD';
    public $targetCurrencies = ['EUR', 'GBP', 'ZAR', 'BWP', 'KES'];
    public $lastUpdated;
    public $loading = false;
    public $error = null;

    protected $listeners = ['refreshRates' => 'fetchRates'];

    public function mount()
    {
        $this->fetchRates();
    }

    public function fetchRates()
    {
        $this->loading = true;
        $this->error = null;

        try {
            // Using a free exchange rate API (exchangerate-api.com)
            $response = Http::timeout(10)->get("https://api.exchangerate-api.com/v4/latest/{$this->baseCurrency}");

            if ($response->successful()) {
                $data = $response->json();
                $this->rates = [];

                foreach ($this->targetCurrencies as $currency) {
                    if (isset($data['rates'][$currency])) {
                        $this->rates[$currency] = [
                            'rate' => $data['rates'][$currency],
                            'formatted' => number_format($data['rates'][$currency], 4)
                        ];
                    }
                }

                $this->lastUpdated = now()->format('Y-m-d H:i:s');

            } else {
                $this->error = 'Failed to fetch exchange rates. Please try again later.';
            }

        } catch (\Exception $e) {
            Log::error('Currency rate fetch failed: ' . $e->getMessage());
            $this->error = 'Unable to fetch current exchange rates.';
        }

        $this->loading = false;
    }

    public function refreshRates()
    {
        $this->fetchRates();
    }

    public function render()
    {
        return view('livewire.currency-rate-display');
    }
}