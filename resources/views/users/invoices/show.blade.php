<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex space-x-8">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition-colors">Dashboard</a>
                <a href="{{ route('user.invoices.index') }}" class="text-gray-400 hover:text-white transition-colors">My Invoices</a>
                <span class="text-white font-medium">Detail Invoice</span>
            </div>
            <div class="flex items-center">
                <button id="theme-toggle" class="mr-4 text-gray-400 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
                <div class="relative">
                    <button class="flex items-center text-gray-300 hover:text-white">
                        <span>Regular User</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Status Banner -->
            @if($invoice->payment_status == 'paid')
            <div class="mb-6 p-4 bg-green-900/20 border-l-4 border-green-500 rounded-r-md flex items-center text-gray-800 dark:text-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-green-300">
                    Invoice ini telah dibayar pada {{ $invoice->paid_at->format('d M Y H:i') }} menggunakan {{ $invoice->paymentMethod->name ?? 'metode pembayaran yang dipilih' }}.
                </p>
            </div>
            @elseif($invoice->due_date->isPast())
            <div class="mb-6 p-4 bg-red-900/20 border-l-4 border-red-500 rounded-r-md flex items-center text-gray-800 dark:text-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-red-300">
                    Invoice ini telah melewati tanggal jatuh tempo ({{ $invoice->due_date->format('d M Y') }}) dan belum dibayar.
                </p>
            </div>
            @else
            <div class="mb-6 p-4 bg-yellow-900/20 border-l-4 border-yellow-500 rounded-r-md flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-yellow-300">
                    Invoice ini belum dibayar. Tanggal jatuh tempo: {{ $invoice->due_date->format('d M Y') }} ({{ $invoice->due_date->diffForHumans() }}).
                </p>
            </div>
            @endif

            <!-- Invoice Header Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider mb-2">INVOICE</h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-4">#{{ $invoice->invoice_number }}</p>
                    
                    <div class="inline-block">
                        @if($invoice->payment_status == 'paid')
                        <span class="px-4 py-1 bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 rounded-full text-sm font-semibold">
                            Paid
                        </span>
                        @else
                        <span class="px-4 py-1 bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 rounded-full text-sm font-semibold">
                            Unpaid
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Client Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">INFORMASI KLIEN</h2>
                        
                        <div class="space-y-4">
                            <p class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $invoice->client_name }}</p>
                            
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-600 dark:text-gray-300">{{ $invoice->client_email }}</span>
                            </div>
                            
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-gray-600 dark:text-gray-300">{{ $invoice->client_address ?: 'Tidak ada alamat' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">INFORMASI INVOICE</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Tanggal Terbit:</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $invoice->issue_date->format('d M Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Jatuh Tempo:</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $invoice->due_date->format('d M Y') }}</span>
                            </div>
                            
                            @if($invoice->payment_status == 'paid' && $invoice->paid_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Tanggal Pembayaran:</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $invoice->paid_at->format('d M Y') }}</span>
                            </div>
                            
                            @if($invoice->paymentMethod)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Metode Pembayaran:</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $invoice->paymentMethod->name }}</span>
                            </div>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">DESKRIPSI</h2>
                    
                    <div class="text-gray-600 dark:text-gray-300 whitespace-pre-line">
                        {{ $invoice->description ?: 'Tidak ada deskripsi' }}
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">Rp {{ number_format($invoice->total_amount, 2, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Pajak:</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">Rp 0,00</span>
                        </div>
                        
                        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between">
                            <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total:</span>
                            <span class="text-xl font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($invoice->total_amount, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex flex-col sm:flex-row sm:justify-between items-center space-y-4 sm:space-y-0">
                <div>
                    <a href="#" onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-gray-200 text-sm font-medium hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-blue-500 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak Invoice
                    </a>
                </div>
                
                <div class="flex space-x-3">
                    @if($invoice->payment_status == 'unpaid')
                    <a href="{{ route('user.invoices.edit', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-gray-200 text-sm font-medium hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-blue-500 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Invoice
                    </a>
                    @endif
                    
                    <a href="{{ route('user.invoices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-gray-200 text-sm font-medium hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-blue-500 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Function to set the theme
        function setTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            }
        }

        // Initialize theme based on localStorage or system preference
        document.addEventListener('DOMContentLoaded', function() {
            // Default to dark theme for this design
            setTheme('dark');

            // Add event listener for theme toggle button
            const themeToggleBtn = document.getElementById('theme-toggle');
            themeToggleBtn.addEventListener('click', function() {
                // Toggle theme
                if (localStorage.theme === 'dark') {
                    setTheme('light');
                } else {
                    setTheme('dark');
                }
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        /* Dark theme base styles */
        body {
            background-color: #111827;
            color: #f3f4f6;
        }

        /* Print styles */
        @media print {
            body {
                background-color: white !important;
                color: black !important;
            }

            .dark\:bg-gray-800 {
                background-color: white !important;
            }

            .dark\:text-gray-100,
            .dark\:text-gray-300,
            .dark\:text-gray-400 {
                color: black !important;
            }

            .dark\:border-gray-700 {
                border-color: #e5e7eb !important;
            }

            header, 
            .no-print, 
            button, 
            [role="button"],
            [type="button"] {
                display: none !important;
            }
        }
    </style>
    @endpush
</x-app-layout>