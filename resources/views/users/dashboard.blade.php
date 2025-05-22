<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mb-4">Welcome, {{ $user->name }}!</p>
                    <a href="{{ route('user.invoices.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Buat Invoice Baru
                    </a>

                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-6 mb-2">
                        Invoice Terbaru Anda:
                    </h3>
                    @if($recentInvoices->count() > 0)
                    <ul class="list-disc pl-5">
                        @foreach($recentInvoices as $invoice)
                        <li>
                            <a href="{{ route('user.invoices.show', $invoice) }}"
                                class="text-blue-600 hover:text-blue-800">
                                {{ $invoice->invoice_number }} - {{ $invoice->client_name }}
                                ({{ $invoice->payment_status }})
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p>Anda belum memiliki invoice.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>