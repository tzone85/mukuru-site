<div class="bg-white shadow-lg rounded-lg p-6 max-w-2xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Exchange Rates</h2>
        <div class="flex items-center space-x-3">
            <button
                wire:click="refreshRates"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200 ease-in-out flex items-center space-x-2"
                @if($loading) disabled @endif
            >
                @if($loading)
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Updating...</span>
                @else
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Refresh</span>
                @endif
            </button>
        </div>
    </div>

    <!-- Base Currency Info -->
    <div class="mb-4">
        <p class="text-sm text-gray-600">
            Base Currency: <span class="font-semibold text-gray-800">{{ $baseCurrency }}</span>
        </p>
        @if($lastUpdated)
            <p class="text-xs text-gray-500">
                Last updated: {{ $lastUpdated }}
            </p>
        @endif
    </div>

    <!-- Error Message -->
    @if($error)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <p class="font-medium">{{ $error }}</p>
        </div>
    @endif

    <!-- Loading State -->
    @if($loading)
        <div class="flex justify-center items-center py-8">
            <div class="animate-pulse">
                <p class="text-gray-600">Loading exchange rates...</p>
            </div>
        </div>
    @endif

    <!-- Currency Rates Grid -->
    @if(!$loading && !empty($rates))
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($rates as $currency => $data)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ $currency }}</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $currency }}</h3>
                                <p class="text-xs text-gray-500">{{ $baseCurrency }}/{{ $currency }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-gray-900">{{ $data['formatted'] }}</p>
                            <p class="text-xs text-gray-500">Rate</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Empty State -->
    @if(!$loading && empty($rates) && !$error)
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No rates available</h3>
            <p class="mt-1 text-sm text-gray-500">Click refresh to load exchange rates</p>
        </div>
    @endif

    <!-- Auto-refresh indicator -->
    <div class="mt-6 pt-4 border-t border-gray-200">
        <p class="text-xs text-gray-500 text-center">
            Rates update automatically. Click refresh for latest data.
        </p>
    </div>
</div>

<!-- Auto-refresh script for real-time updates -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-refresh every 30 seconds
        setInterval(function() {
            @this.call('refreshRates');
        }, 30000);
    });
</script>