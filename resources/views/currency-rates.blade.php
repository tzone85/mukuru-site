@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Currency Rates</div>
                <div class="panel-body">
                    <!-- Page Header -->
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-bold text-gray-800 mb-4">Live Currency Exchange Rates</h1>
                        <p class="text-lg text-gray-600">Real-time exchange rates powered by Livewire</p>
                        <nav class="mt-4">
                            <a href="{{ url('/') }}" class="text-blue-500 hover:text-blue-700 mr-4">← Back to Home</a>
                            @auth
                                <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-700">Dashboard</a>
                            @endauth
                        </nav>
                    </div>

                    <!-- Livewire Currency Rate Display Component -->
                    @livewire('currency-rate-display')

                    <!-- Features Section -->
                    <div class="mt-12 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Features</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                            <div class="bg-white p-6 rounded-lg shadow">
                                <div class="text-blue-500 mb-4">
                                    <svg class="h-8 w-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Real-time Updates</h3>
                                <p class="text-gray-600">Automatic refresh every 30 seconds with manual refresh option</p>
                            </div>
                            <div class="bg-white p-6 rounded-lg shadow">
                                <div class="text-green-500 mb-4">
                                    <svg class="h-8 w-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Reliable Data</h3>
                                <p class="text-gray-600">Fetches data from trusted exchange rate APIs with error handling</p>
                            </div>
                            <div class="bg-white p-6 rounded-lg shadow">
                                <div class="text-purple-500 mb-4">
                                    <svg class="h-8 w-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Responsive Design</h3>
                                <p class="text-gray-600">Beautiful Tailwind CSS styling that works on all devices</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection