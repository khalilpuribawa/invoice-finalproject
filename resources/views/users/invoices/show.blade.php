<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Invoice: ') . $invoice->invoice_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold">Kepada:</h3>
                            <p>{{ $invoice->client_name }}</p>
                            <p>{{ $invoice->client_email }}</p>
                            <p>{{ $invoice->client_address }}</p>
                        </div>
                        <div class="text-right">
                            <h3 class="text-lg font-semibold">Invoice #{{ $invoice->invoice_number }}</h3>
                            <p>Tanggal Terbit: {{ $invoice->issue_date->format('d M Y') }}</p>
                            <p>Jatuh Tempo: {{ $invoice->due_date->format('d M Y') }}</p>
                            <p>Status:
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $invoice->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($invoice->payment_status) }}
                                </span>
                            </p>
                            @if($invoice->payment_status == 'paid' && $invoice->paymentMethod)
                            <p>Metode Pembayaran: {{ $invoice->paymentMethod->name }}</p>
                            <p>Dibayar pada: {{ $invoice->paid_at->format('d M Y H:i') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Deskripsi:</h3>
                        <p class="whitespace-pre-line">{{ $invoice->description ?: '-' }}</p>
                    </div>


                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex justify-end">
                            <div class="text-right">
                                <p class="text-lg">Total Tagihan:</p>
                                <p class="text-2xl font-bold">Rp
                                    {{ number_format($invoice->total_amount, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        @if($invoice->payment_status == 'unpaid')
                        <a href="{{ route('user.invoices.edit', $invoice) }}"
                            class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 active:bg-yellow-600 focus:outline-none focus:border-yellow-600 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Edit
                        </a>
                        @endif
                        <a href="{{ route('user.invoices.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-gray-500 active:bg-gray-400 dark:active:bg-gray-700 focus:outline-none focus:border-gray-400 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>