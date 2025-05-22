<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rekap Semua Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            <!-- Filter Form (Opsional) -->
            <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <form method="GET" action="{{ route('admin.invoices.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status
                            Pembayaran:</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Semua Status</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Terbayar</option>
                            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Terbayar
                            </option>
                        </select>
                    </div>
                    <!-- Tambahkan filter lain jika perlu, misal by user -->
                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Filter
                        </button>
                        <a href="{{ route('admin.invoices.index') }}"
                            class="ml-2 text-sm text-gray-600 dark:text-gray-400 hover:underline">Reset Filter</a>
                    </div>
                </form>
            </div>


            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    No. Invoice</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Pengguna</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Klien</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Total</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($invoices as $invoice)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $invoice->invoice_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $invoice->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $invoice->client_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Rp
                                    {{ number_format($invoice->total_amount, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $invoice->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($invoice->payment_status) }}
                                    </span>
                                    @if($invoice->payment_status == 'paid' && $invoice->paymentMethod)
                                    <br> <small>({{ $invoice->paymentMethod->name }})</small>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <!-- Tombol Update Status Modal (Contoh) -->
                                    <button type="button"
                                        onclick="openStatusModal({{ $invoice->id }}, '{{ $invoice->payment_status }}', {{ $invoice->payment_method_id ?? 'null' }})"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600">
                                        Update Status
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6"
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
                                    Tidak ada invoice.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $invoices->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Status Pembayaran -->
    <div id="statusModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="updateStatusForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100"
                                    id="modal-title">
                                    Update Status Pembayaran Invoice #<span id="modalInvoiceNumber"></span>
                                </h3>
                                <div class="mt-4">
                                    <label for="payment_status"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <select id="payment_status" name="payment_status"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="unpaid">Belum Dibayar</option>
                                        <option value="paid">Sudah Dibayar</option>
                                    </select>
                                </div>
                                <div class="mt-4" id="payment_method_div">
                                    <label for="payment_method_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Metode
                                        Pembayaran (jika sudah dibayar)</label>
                                    <select id="payment_method_id" name="payment_method_id"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="">Pilih Metode</option>
                                        @foreach($paymentMethods as $method)
                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button type="button" onclick="closeStatusModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    const modal = document.getElementById('statusModal');
    const form = document.getElementById('updateStatusForm');
    const modalInvoiceNumber = document.getElementById('modalInvoiceNumber');
    const paymentStatusSelect = document.getElementById('payment_status');
    const paymentMethodSelect = document.getElementById('payment_method_id');
    const paymentMethodDiv = document.getElementById('payment_method_div');

    function openStatusModal(invoiceId, currentStatus, currentMethodId) {
        // Cari invoice number dari tabel atau kirim sebagai parameter
        const invoiceRow = document.querySelector(`button[onclick*="openStatusModal(${invoiceId},"]`).closest('tr');
        const invoiceNumberText = invoiceRow.cells[0].textContent;

        form.action = `{{ url('admin/invoices') }}/${invoiceId}/update-status`;
        modalInvoiceNumber.textContent = invoiceNumberText;
        paymentStatusSelect.value = currentStatus;
        paymentMethodSelect.value = currentMethodId || '';

        if (currentStatus === 'paid') {
            paymentMethodDiv.style.display = 'block';
        } else {
            paymentMethodDiv.style.display = 'none';
        }
        modal.classList.remove('hidden');
    }

    function closeStatusModal() {
        modal.classList.add('hidden');
    }

    paymentStatusSelect.addEventListener('change', function() {
        if (this.value === 'paid') {
            paymentMethodDiv.style.display = 'block';
        } else {
            paymentMethodDiv.style.display = 'none';
            paymentMethodSelect.value = ''; // Reset jika unpaid
        }
    });

    // Tutup modal jika klik di luar
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeStatusModal();
        }
    });
    </script>
    @endpush
</x-app-layout>