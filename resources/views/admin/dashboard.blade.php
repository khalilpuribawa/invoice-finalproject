<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Revenue Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Total Pendapatan</h3>
                        <p class="mt-1 text-3xl font-semibold text-green-600">
                            Rp {{ number_format($totalRevenue, 2, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Dari invoice terbayar</p>
                    </div>
                </div>

                <!-- Total Users Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Total Pengguna</h3>
                        <p class="mt-1 text-3xl font-semibold text-indigo-600">
                            {{ $totalUsers }}
                        </p>
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-500 hover:underline">Kelola
                            Pengguna</a>
                    </div>
                </div>

                <!-- Total Invoices Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Total Invoice</h3>
                        <p class="mt-1 text-3xl font-semibold text-blue-600">
                            {{ $totalInvoices }}
                        </p>
                        <a href="{{ route('admin.invoices.index') }}"
                            class="text-sm text-blue-500 hover:underline">Lihat Semua Invoice</a>
                    </div>
                </div>

                <!-- Unpaid Invoices Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Invoice Belum Bayar</h3>
                        <p class="mt-1 text-3xl font-semibold text-red-600">
                            {{ $unpaidInvoices }}
                        </p>
                        <a href="{{ route('admin.invoices.index', ['status' => 'unpaid']) }}"
                            class="text-sm text-blue-500 hover:underline">Lihat Invoice Belum Bayar</a>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Akses Cepat:</h3>
                    <div class="space-y-2">
                        <p><a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800">Kelola
                                Pengguna</a></p>
                        <p><a href="{{ route('admin.invoices.index') }}" class="text-blue-600 hover:text-blue-800">Lihat
                                Semua Invoice</a></p>
                        <p><a href="{{ route('admin.payment-methods.index') }}"
                                class="text-blue-600 hover:text-blue-800">Kelola Metode Pembayaran</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>