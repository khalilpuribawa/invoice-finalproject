<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            @if (Route::has('admin.reports.download'))
                <a href="{{ route('admin.reports.download') }}"
                    class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:border-emerald-700 focus:ring ring-emerald-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fas fa-download mr-2"></i> Unduh Laporan
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-6">
                <!-- Total Revenue Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-semibold text-gray-600 dark:text-gray-400 uppercase">Total Pendapatan
                        </h3>
                        <i class="fas fa-dollar-sign text-3xl text-green-500"></i>
                    </div>
                    <p class="text-4xl font-bold text-green-600 dark:text-green-400">Rp
                        {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Dari invoice terbayar</p>
                </div>

                <!-- Total Users Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-semibold text-gray-600 dark:text-gray-400 uppercase">Total Pengguna
                        </h3>
                        <i class="fas fa-users text-3xl text-indigo-500"></i>
                    </div>
                    <p class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalUsers ?? 0 }}</p>
                    @if (Route::has('admin.users.index'))
                        <a href="{{ route('admin.users.index') }}"
                            class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline mt-2 block">Kelola
                            Pengguna</a>
                    @else
                        <span class="text-sm text-gray-500 dark:text-gray-400 mt-2 block">Kelola Pengguna</span>
                    @endif
                </div>

                <!-- Total Invoices Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-semibold text-gray-600 dark:text-gray-400 uppercase">Total Invoice
                        </h3>
                        <i class="fas fa-file-invoice text-3xl text-blue-500"></i>
                    </div>
                    <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $totalInvoices ?? 0 }}</p>
                    @if (Route::has('admin.invoices.index'))
                        <a href="{{ route('admin.invoices.index') }}"
                            class="text-sm text-blue-600 dark:text-blue-400 hover:underline mt-2 block">Lihat Semua
                            Invoice</a>
                    @else
                        <span class="text-sm text-gray-500 dark:text-gray-400 mt-2 block">Lihat Semua Invoice</span>
                    @endif
                </div>

                <!-- Unpaid Invoices Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-semibold text-gray-600 dark:text-gray-400 uppercase">Invoice Belum
                            Bayar</h3>
                        <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
                    </div>
                    <p class="text-4xl font-bold text-red-600 dark:text-red-400">{{ $unpaidInvoices ?? 0 }}</p>
                    @if (Route::has('admin.invoices.index'))
                        <a href="{{ route('admin.invoices.index', ['status' => 'unpaid']) }}"
                            class="text-sm text-red-600 dark:text-red-400 hover:underline mt-2 block">Lihat Invoice
                            Belum Bayar</a>
                    @else
                        <span class="text-sm text-gray-500 dark:text-gray-400 mt-2 block">Lihat Invoice Belum
                            Bayar</span>
                    @endif
                </div>
            </div>

            <!-- Dashboard Action Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-8">
                @if (Route::has('admin.invoices.index'))
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 flex flex-col hover:shadow-xl transition-shadow duration-200">
                        {{-- Header Kartu --}}
                        <div class="flex items-start mb-4"> {{-- Diubah ke items-start untuk alignment yang lebih baik jika teks judul panjang --}}
                            <div
                                class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                                {{-- Menambah margin kanan pada ikon wrapper --}}
                                <i class="fas fa-file-invoice-dollar text-2xl text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white leading-tight">Manajemen
                                Invoice</h3> {{-- Dihilangkan ml-4, leading-tight ditambahkan --}}
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-6 flex-grow">Lihat, filter, dan kelola
                            semua invoice. Update status pembayaran dan detail lainnya.</p>
                        <a href="{{ route('admin.invoices.index') }}"
                            class="mt-auto w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            <i class="fas fa-list-alt mr-2"></i> Lihat Daftar Invoice
                        </a>
                    </div>
                @endif

                @if (Route::has('admin.users.index'))
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 flex flex-col hover:shadow-xl transition-shadow duration-200">
                        {{-- Header Kartu --}}
                        <div class="flex items-start mb-4">
                            <div
                                class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mr-4">
                                <i class="fas fa-user-cog text-2xl text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white leading-tight">Manajemen
                                Pengguna</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 flex-grow">Tambah, edit, atau hapus
                            pengguna. Atur peran dan akses pengguna.</p>
                        @if (Route::has('admin.users.create'))
                            <a href="{{ route('admin.users.create') }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2 mb-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
                            </a>
                        @endif
                        <a href="{{ route('admin.users.index') }}"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-sm text-indigo-700 dark:text-indigo-300 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            Kelola Semua Pengguna
                        </a>
                    </div>
                @endif

                @if (Route::has('admin.payment-methods.index'))
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 flex flex-col hover:shadow-xl transition-shadow duration-200">
                        {{-- Header Kartu --}}
                        <div class="flex items-start mb-4">
                            <div
                                class="flex-shrink-0 h-12 w-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                                <i class="fas fa-credit-card text-2xl text-green-600 dark:text-green-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white leading-tight">Metode
                                Pembayaran</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 flex-grow">Konfigurasi metode pembayaran
                            yang tersedia untuk pelanggan.</p>
                        @if (Route::has('admin.payment-methods.create'))
                            <a href="{{ route('admin.payment-methods.create') }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2 mb-3 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                <i class="fas fa-plus-circle mr-2"></i> Tambah Metode
                            </a>
                        @endif
                        <a href="{{ route('admin.payment-methods.index') }}"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-sm text-green-700 dark:text-green-300 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                            Kelola Metode
                        </a>
                    </div>
                @endif
            </div>

            <!-- Recent Invoices -->
            <div class="mt-8">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Faktur Terbaru</h2>
                <div class="space-y-4">
                    @forelse ($recentInvoices ?? [] as $invoice)
                        @php $invoicePaymentStatus = $invoice->payment_status ?? 'unknown'; @endphp
                        <div
                            class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 sm:p-6 transition-shadow duration-200 ease-in-out
                            {{ $invoicePaymentStatus === 'paid' ? 'border-l-4 border-green-500 dark:border-green-400' : '' }}
                            {{ $invoicePaymentStatus === 'unpaid' ? 'border-l-4 border-red-500 dark:border-red-400' : '' }}
                            {{ $invoicePaymentStatus === 'pending' ? 'border-l-4 border-yellow-500 dark:border-yellow-400' : '' }}
                            {{ !in_array($invoicePaymentStatus, ['paid', 'unpaid', 'pending']) ? 'border-l-4 border-gray-300 dark:border-gray-600' : '' }}">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                <div class="mb-4 sm:mb-0">
                                    <div class="flex items-center mb-1">
                                        <i
                                            class="fas fa-file-alt text-xl mr-2 text-indigo-600 dark:text-indigo-400 flex-shrink-0"></i>
                                        <a href="{{ Route::has('admin.invoices.show') && isset($invoice->id) ? route('admin.invoices.show', $invoice->id) : (Route::has('admin.invoices.index') ? route('admin.invoices.index') : '#') }}"
                                            class="text-lg font-semibold text-gray-900 dark:text-gray-100 hover:text-indigo-700 dark:hover:text-indigo-300 truncate"
                                            title="Faktur #{{ $invoice->invoice_number ?? 'N/A' }}">
                                            Faktur #{{ $invoice->invoice_number ?? 'N/A' }}
                                        </a>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Untuk: <span
                                            class="font-medium text-gray-700 dark:text-gray-300">{{ $invoice->user->name ?? ($invoice->customer_name ?? 'Pelanggan Tidak Dikenal') }}</span>
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                        Tanggal:
                                        {{ isset($invoice->created_at) && $invoice->created_at ? $invoice->created_at->format('d M Y, H:i') : 'N/A' }}
                                    </p>
                                </div>
                                <div class="flex flex-col items-start sm:items-end w-full sm:w-auto">
                                    <p class="text-xl font-bold text-gray-800 dark:text-gray-200 whitespace-nowrap">
                                        Rp {{ number_format($invoice->total_amount ?? 0, 0, ',', '.') }}
                                    </p>
                                    <span
                                        class="mt-1 px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $invoicePaymentStatus === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100' : '' }}
                                        {{ $invoicePaymentStatus === 'unpaid' ? 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100' : '' }}
                                        {{ $invoicePaymentStatus === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100' : '' }}
                                        {{ !in_array($invoicePaymentStatus, ['paid', 'unpaid', 'pending']) ? 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $invoicePaymentStatus)) }}
                                    </span>
                                    @if (Route::has('admin.invoices.show') && isset($invoice->id))
                                        <a href="{{ route('admin.invoices.show', $invoice->id) }}"
                                            class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium whitespace-nowrap">
                                            Lihat Detail →
                                        </a>
                                    @elseif(Route::has('admin.invoices.index'))
                                        <a href="{{ route('admin.invoices.index') }}"
                                            class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium whitespace-nowrap">
                                            Lihat Daftar →
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-folder-open text-4xl text-gray-400 dark:text-gray-500 mb-3"></i>
                                <p class="text-gray-600 dark:text-gray-400 font-medium">Tidak ada faktur terbaru.</p>
                                <p class="text-sm text-gray-500 dark:text-gray-500">Belum ada data faktur untuk
                                    ditampilkan di sini.</p>
                            </div>
                        </div>
                    @endforelse
                    @if (isset($recentInvoices) && $recentInvoices->count() > 0 && Route::has('admin.invoices.index'))
                        <div class="mt-6 text-center">
                            <a href="{{ route('admin.invoices.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-emerald-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                                Lihat Semua Faktur
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Chart and Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8 mb-12">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Pendapatan Bulanan</h3>
                    <div class="h-72 sm:h-80 md:h-96">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Aktivitas Pengguna</h3>
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @forelse ($recentActivities ?? ($recentInvoices->take(5)) as $activity)
                            @php $activityStatus = $activity->status ?? 'unknown'; @endphp
                            <div class="flex items-start space-x-3">
                                <div
                                    class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center
                                    {{ $activityStatus === 'paid' ? 'bg-green-100 dark:bg-green-700' : '' }}
                                    {{ $activityStatus === 'unpaid' || $activityStatus === 'pending' ? 'bg-yellow-100 dark:bg-yellow-700' : '' }}
                                    {{ !in_array($activityStatus, ['paid', 'unpaid', 'pending']) ? 'bg-gray-100 dark:bg-gray-600' : '' }}">
                                    @if ($activityStatus === 'paid')
                                        <i class="fas fa-check-circle text-green-600 dark:text-green-300"></i>
                                    @elseif($activityStatus === 'unpaid' || $activityStatus === 'pending')
                                        <i class="fas fa-hourglass-half text-yellow-600 dark:text-yellow-300"></i>
                                    @else
                                        <i class="fas fa-info-circle text-gray-600 dark:text-gray-300"></i>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                        @if (isset($activity->invoice_number))
                                            Inv #{{ $activity->invoice_number }} -
                                        @endif
                                        {{ $activity->user->name ?? ($activity->customer_name ?? 'Pengguna Sistem') }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        @if (isset($activity->description))
                                            {{ $activity->description }}
                                        @elseif(isset($activity->invoice_number))
                                            Status: {{ ucfirst(str_replace('_', ' ', $activityStatus)) }}
                                        @else
                                            Aktivitas tercatat
                                        @endif
                                        <span class="whitespace-nowrap">-
                                            {{ isset($activity->created_at) && $activity->created_at ? $activity->created_at->diffForHumans() : '' }}</span>
                                    </p>
                                </div>
                                @if (isset($activity->total_amount))
                                    <div
                                        class="text-sm font-semibold
                                    {{ $activityStatus === 'paid' ? 'text-green-600 dark:text-green-400' : '' }}
                                    {{ $activityStatus === 'unpaid' || $activityStatus === 'pending' ? 'text-yellow-600 dark:text-yellow-400' : '' }}
                                    {{ !in_array($activityStatus, ['paid', 'unpaid', 'pending']) ? 'text-gray-700 dark:text-gray-300' : '' }}">
                                        Rp{{ number_format($activity->total_amount ?? 0, 0, ',', '.') }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada aktivitas terbaru.</p>
                        @endforelse
                    </div>
                    @if (
                        (isset($recentActivities) && $recentActivities->count() > 0) ||
                            (isset($recentInvoices) && $recentInvoices->count() > 0))
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Akses
                                Cepat</h4>
                            <div class="grid grid-cols-2 gap-2">
                                @if (Route::has('admin.users.index'))
                                    <a href="{{ route('admin.users.index') }}"
                                        class="text-xs py-1 px-2 rounded bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-800 dark:hover:bg-indigo-700 text-indigo-700 dark:text-indigo-300 text-center"><i
                                            class="fas fa-users mr-1"></i>Pengguna</a>
                                @endif
                                @if (Route::has('admin.invoices.index'))
                                    <a href="{{ route('admin.invoices.index') }}"
                                        class="text-xs py-1 px-2 rounded bg-blue-50 hover:bg-blue-100 dark:bg-blue-800 dark:hover:bg-blue-700 text-blue-700 dark:text-blue-300 text-center"><i
                                            class="fas fa-file-invoice mr-1"></i>Invoices</a>
                                @endif
                                @if (Route::has('admin.payment-methods.index'))
                                    <a href="{{ route('admin.payment-methods.index') }}"
                                        class="text-xs py-1 px-2 rounded bg-green-50 hover:bg-green-100 dark:bg-green-800 dark:hover:bg-green-700 text-green-700 dark:text-green-300 text-center"><i
                                            class="fas fa-credit-card mr-1"></i>Pembayaran</a>
                                @endif
                                @if (Route::has('admin.settings.index'))
                                    <a href="{{ route('admin.settings.index') }}"
                                        class="text-xs py-1 px-2 rounded bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-center"><i
                                            class="fas fa-cog mr-1"></i>Pengaturan</a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @php
                    // Default chart data (array of 12 'N/A' for labels and 12 zeros for data)
                    // Ini untuk memastikan JavaScript memiliki array dengan panjang yang benar
                    // bahkan jika $chartData dari controller tidak ada atau tidak lengkap.
                    $defaultLabels = array_fill(0, 12, 'N/A');
                    $defaultDataValues = array_fill(0, 12, 0);

                    $chartLabels = isset($chartData['labels']) && is_array($chartData['labels']) && count($chartData['labels']) === 12 ? $chartData['labels'] : $defaultLabels;
                    $chartDataValues = isset($chartData['data']) && is_array($chartData['data']) && count($chartData['data']) === 12 ? $chartData['data'] : $defaultDataValues;
                @endphp

                const chartLabelsFromPHP = @json($chartLabels);
                const chartDataFromPHP = @json($chartDataValues);

                // console.log("Chart Labels:", chartLabelsFromPHP); // Untuk debug
                // console.log("Chart Data:", chartDataFromPHP);   // Untuk debug

                const revenueChartCanvas = document.getElementById('revenueChart');
                if (revenueChartCanvas) {
                    const ctx = revenueChartCanvas.getContext('2d');
                    const revenueChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: chartLabelsFromPHP,
                            datasets: [{
                                label: 'Pendapatan',
                                data: chartDataFromPHP,
                                backgroundColor: document.documentElement.classList.contains('dark') ?
                                    'rgba(16, 185, 129, 0.5)' : 'rgba(16, 185, 129, 0.2)',
                                borderColor: 'rgb(16, 185, 129)',
                                pointBackgroundColor: 'rgb(16, 185, 129)',
                                pointBorderColor: document.documentElement.classList.contains('dark') ?
                                    '#1f2937' : '#fff',
                                pointHoverBackgroundColor: document.documentElement.classList.contains(
                                    'dark') ? '#1f2937' : '#fff',
                                pointHoverBorderColor: 'rgb(16, 185, 129)',
                                tension: 0.3,
                                fill: true,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + value.toLocaleString('id-ID');
                                        },
                                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                            '#6b7280',
                                    },
                                    grid: {
                                        color: document.documentElement.classList.contains('dark') ?
                                            'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)',
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' :
                                            '#6b7280',
                                    },
                                    grid: {
                                        display: false,
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: document.documentElement.classList.contains('dark') ?
                                        '#374151' : '#fff',
                                    titleColor: document.documentElement.classList.contains('dark') ?
                                        '#e5e7eb' : '#1f2937',
                                    bodyColor: document.documentElement.classList.contains('dark') ? '#d1d5db' :
                                        '#374151',
                                    borderColor: document.documentElement.classList.contains('dark') ?
                                        'rgba(255,255,255,0.2)' : 'rgba(0,0,0,0.2)',
                                    borderWidth: 1
                                }
                            }
                        }
                    });

                    // Observer untuk update warna chart saat dark mode berubah
                    const observer = new MutationObserver(mutations => {
                        mutations.forEach(mutation => {
                            if (mutation.attributeName === "class" && document.getElementById(
                                    'revenueChart')) {
                                const isDark = document.documentElement.classList.contains('dark');
                                revenueChart.options.scales.y.ticks.color = isDark ? '#9ca3af' :
                                    '#6b7280';
                                revenueChart.options.scales.y.grid.color = isDark ?
                                    'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)';
                                revenueChart.options.scales.x.ticks.color = isDark ? '#9ca3af' :
                                    '#6b7280';
                                revenueChart.options.plugins.tooltip.backgroundColor = isDark ?
                                    '#374151' : '#fff';
                                revenueChart.options.plugins.tooltip.titleColor = isDark ? '#e5e7eb' :
                                    '#1f2937';
                                revenueChart.options.plugins.tooltip.bodyColor = isDark ? '#d1d5db' :
                                    '#374151';
                                revenueChart.options.plugins.tooltip.borderColor = isDark ?
                                    'rgba(255,255,255,0.2)' : 'rgba(0,0,0,0.2)';
                                revenueChart.data.datasets[0].backgroundColor = isDark ?
                                    'rgba(16, 185, 129, 0.5)' : 'rgba(16, 185, 129, 0.2)';
                                revenueChart.data.datasets[0].pointBorderColor = isDark ? '#1f2937' :
                                    '#fff';
                                revenueChart.data.datasets[0].pointHoverBackgroundColor = isDark ?
                                    '#1f2937' : '#fff';
                                revenueChart.update();
                            }
                        });
                    });
                    observer.observe(document.documentElement, {
                        attributes: true
                    });
                }
            });
        </script>
    @endpush

</x-app-layout>
