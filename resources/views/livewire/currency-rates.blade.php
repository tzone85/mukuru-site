<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Currency Exchange Rates</h4>
                        <small class="text-muted">Real-time currency exchange rates</small>
                    </div>

                    <div class="panel-body">
                        @if($errorMessage)
                            <div class="alert alert-danger" role="alert">
                                {{ $errorMessage }}
                            </div>
                        @endif

                        <!-- Search and Filter Controls -->
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search">Search Currency</label>
                                    <input type="text"
                                           class="form-control"
                                           id="search"
                                           placeholder="Search by currency code or name..."
                                           wire:model.live="search">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="baseCurrency">Base Currency</label>
                                    <select class="form-control" 
                                            id="baseCurrency" 
                                            wire:model.live="baseCurrency"
                                            wire:change="setBaseCurrency($event.target.value)">
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="GBP">GBP</option>
                                        <option value="JPY">JPY</option>
                                        <option value="AUD">AUD</option>
                                        <option value="CAD">CAD</option>
                                        <option value="ZAR">ZAR</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button"
                                            class="btn btn-primary btn-block"
                                            wire:click="updateRates"
                                            wire:loading.attr="disabled"
                                            @if($isLoading) disabled @endif>
                                        @if($isLoading)
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Updating...
                                        @else
                                            <span wire:loading.remove>Refresh Rates</span>
                                            <span wire:loading>
                                                <i class="glyphicon glyphicon-refresh spinning"></i> Loading...
                                            </span>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if($lastUpdated)
                            <div class="row" style="margin-bottom: 15px;">
                                <div class="col-md-12">
                                    <small class="text-muted">Last updated: {{ $lastUpdated }}</small>
                                </div>
                            </div>
                        @endif

                        @if($isLoading && empty($rates))
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading rates...</span>
                                </div>
                                <p class="mt-2 text-muted">Loading exchange rates...</p>
                            </div>
                        @elseif(!empty($rates))
                            <!-- Exchange Rates Table -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr class="active">
                                            <th>
                                                <a href="#" wire:click.prevent="sortBy('currency_code')">
                                                    Currency
                                                    @if($sortField === 'currency_code')
                                                        <i class="glyphicon glyphicon-triangle-{{ $sortDirection === 'asc' ? 'top' : 'bottom' }}"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>Currency Name</th>
                                            <th>
                                                <a href="#" wire:click.prevent="sortBy('rate')">
                                                    Exchange Rate
                                                    @if($sortField === 'rate')
                                                        <i class="glyphicon glyphicon-triangle-{{ $sortDirection === 'asc' ? 'top' : 'bottom' }}"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>1 {{ $baseCurrency }} =</th>
                                            <th>Change (24h)</th>
                                            <th>
                                                <a href="#" wire:click.prevent="sortBy('updated_at')">
                                                    Last Updated
                                                    @if($sortField === 'updated_at')
                                                        <i class="glyphicon glyphicon-triangle-{{ $sortDirection === 'asc' ? 'top' : 'bottom' }}"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($rates as $currency => $rate)
                                            <tr wire:key="rate-{{ $rate['id'] ?? $currency }}">
                                                <td>
                                                    <strong>{{ is_array($rate) ? ($rate['currency_code'] ?? $currency) : $currency }}</strong>
                                                    <span class="label label-info">{{ $baseCurrency }}</span>
                                                </td>
                                                <td>{{ is_array($rate) ? ($rate['currency_name'] ?? 'N/A') : 'N/A' }}</td>
                                                <td>
                                                    <span class="text-primary">
                                                        {{ number_format(is_array($rate) ? $rate['rate'] : $rate, 4) }}
                                                    </span>
                                                </td>
                                                <td>{{ formatRate(is_array($rate) ? $rate['rate'] : $rate, is_array($rate) ? ($rate['currency_code'] ?? $currency) : $currency) }}</td>
                                                <td>
                                                    @if(is_array($rate) && isset($rate['change_24h']))
                                                        <span class="label {{ $rate['change_24h'] >= 0 ? 'label-success' : 'label-danger' }}">
                                                            {{ $rate['change_24h'] >= 0 ? '+' : '' }}{{ number_format($rate['change_24h'], 2) }}%
                                                        </span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ is_array($rate) && isset($rate['updated_at']) ? \Carbon\Carbon::parse($rate['updated_at'])->diffForHumans() : 'N/A' }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-xs" role="group">
                                                        <button type="button"
                                                                class="btn btn-info"
                                                                wire:click="viewDetails('{{ is_array($rate) ? ($rate['currency_code'] ?? $currency) : $currency }}')"
                                                                title="View Details">
                                                            <i class="glyphicon glyphicon-eye-open"></i>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-success"
                                                                wire:click="addToWatchlist('{{ is_array($rate) ? ($rate['currency_code'] ?? $currency) : $currency }}')"
                                                                title="Add to Watchlist">
                                                            <i class="glyphicon glyphicon-star{{ in_array(is_array($rate) ? ($rate['currency_code'] ?? $currency) : $currency, $watchlist ?? []) ? '' : '-empty' }}"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">
                                                    @if($search)
                                                        <p>No currencies found matching "{{ $search }}"</p>
                                                        <button type="button" class="btn btn-sm btn-default" wire:click="clearSearch">Clear Search</button>
                                                    @else
                                                        <p>No exchange rates available</p>
                                                        <button type="button" class="btn btn-sm btn-primary" wire:click="fetchRates">Load Rates</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if(method_exists($rates, 'links'))
                                <div class="text-center">
                                    {{ $rates->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center text-muted">
                                <p>No exchange rates available.</p>
                                <button wire:click="fetchRates" class="btn btn-primary">
                                    Load Rates
                                </button>
                            </div>
                        @endif

                        <!-- Loading Indicator -->
                        <div wire:loading.block class="text-center" style="margin-top: 20px;">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <i class="glyphicon glyphicon-refresh spinning"></i>
                                    <strong>Updating exchange rates...</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Footer with Statistics -->
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">
                                    <strong>Total Currencies:</strong> {{ count($rates ?? []) }}
                                </small>
                            </div>
                            <div class="col-md-4 text-center">
                                <small class="text-muted">
                                    <strong>Base Currency:</strong> {{ $baseCurrency }}
                                </small>
                            </div>
                            <div class="col-md-4 text-right">
                                <small class="text-muted">
                                    <strong>Last Refresh:</strong>
                                    <span wire:poll.10s="updateLastRefreshTime">{{ $lastRefreshTime ?? 'Never' }}</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles for Spinning Animation -->
    <style>
        .spinning {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .table > thead > tr > th > a {
            color: inherit;
            text-decoration: none;
        }

        .table > thead > tr > th > a:hover {
            color: #337ab7;
            text-decoration: none;
        }

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

        /* Responsive table improvements */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 12px;
            }

            .btn-group-xs .btn {
                padding: 1px 5px;
                font-size: 11px;
            }

            .hidden-xs {
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            .panel-heading .panel-title {
                font-size: 16px;
            }

            .form-group {
                margin-bottom: 10px;
            }
        }
    </style>
</div>