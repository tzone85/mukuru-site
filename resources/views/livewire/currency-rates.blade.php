<div class="currency-rates-widget">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Currency Exchange Rates</h5>
            <button
                wire:click="updateRates"
                class="btn btn-sm btn-outline-primary"
                @if($isLoading) disabled @endif
            >
                @if($isLoading)
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Updating...
                @else
                    Refresh
                @endif
            </button>
        </div>
        <div class="card-body">
            @if($errorMessage)
                <div class="alert alert-danger" role="alert">
                    {{ $errorMessage }}
                </div>
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="baseCurrency" class="form-label">Base Currency:</label>
                    <select
                        wire:model="baseCurrency"
                        wire:change="setBaseCurrency($event.target.value)"
                        class="form-select"
                        id="baseCurrency"
                    >
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                        <option value="JPY">JPY</option>
                        <option value="AUD">AUD</option>
                        <option value="CAD">CAD</option>
                    </select>
                </div>
                @if($lastUpdated)
                    <div class="col-md-6 d-flex align-items-end">
                        <small class="text-muted">Last updated: {{ $lastUpdated }}</small>
                    </div>
                @endif
            </div>

            @if($isLoading && empty($rates))
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading rates...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading exchange rates...</p>
                </div>
            @elseif(!empty($rates))
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Currency</th>
                                <th scope="col">Exchange Rate</th>
                                <th scope="col">1 {{ $baseCurrency }} =</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rates as $currency => $rate)
                                <tr>
                                    <td>
                                        <strong>{{ $currency }}</strong>
                                    </td>
                                    <td>{{ number_format($rate, 4) }}</td>
                                    <td>{{ formatRate($rate, $currency) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted">
                    <p>No exchange rates available.</p>
                    <button wire:click="fetchRates" class="btn btn-primary">
                        Load Rates
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.currency-rates-widget .card {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

.currency-rates-widget .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1rem;
}

.currency-rates-widget .table-responsive {
    max-height: 400px;
    overflow-y: auto;
}

.currency-rates-widget .spinner-border-sm {
    width: 0.875rem;
    height: 0.875rem;
}
</style>