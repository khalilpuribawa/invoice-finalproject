<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex space-x-8">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition-colors">Dashboard</a>
                <a href="{{ route('user.invoices.index') }}" class="text-gray-400 hover:text-white transition-colors">My Invoices</a>
                <span class="text-white font-medium">Buat Invoice</span>
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
            <!-- Breadcrumb -->
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-blue-400">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('user.invoices.index') }}" class="ml-1 text-sm font-medium text-gray-400 hover:text-blue-400 md:ml-2">Invoices</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-300 md:ml-2">Buat Invoice Baru</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Buat Invoice Baru
                </h1>
                <a href="{{ route('user.invoices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 text-sm font-medium hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-blue-500 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg border border-gray-700">
                <div class="p-6">
                    <form method="POST" action="{{ route('user.invoices.store') }}" class="space-y-6">
                        @include('users.invoices._form', ['paymentMethods' => $paymentMethods])
                    </form>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="mt-8 bg-blue-900/30 rounded-lg p-4 border border-blue-800/50">
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tips untuk Membuat Invoice
                </h3>
                <ul class="list-disc list-inside text-sm text-gray-300 space-y-1">
                    <li>Pastikan semua informasi klien sudah benar dan lengkap</li>
                    <li>Tetapkan tanggal jatuh tempo yang jelas untuk memudahkan pembayaran</li>
                    <li>Berikan deskripsi yang detail tentang produk atau layanan yang ditagih</li>
                    <li>Simpan salinan invoice untuk catatan keuangan Anda</li>
                </ul>
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

        /* Form styling enhancements */
        input, select, textarea {
            background-color: #1f2937;
            border-color: #374151;
            color: #f3f4f6;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25);
        }

        label {
            color: #d1d5db;
        }

        /* Button hover effects */
        button:hover {
            transform: translateY(-1px);
            transition: all 0.2s;
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        form {
            animation: fadeIn 0.3s ease-in-out forwards;
        }
    </style>
    @endpush
</x-app-layout>