<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Rekap Semua Invoice') }}
            </h2>
            {{-- Contoh tombol Tambah Invoice Baru, jika diperlukan dari halaman ini --}}
            {{-- @if(Route::has('admin.invoices.create'))
            <a href="{{ route('admin.invoices.create') }}"
                class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:border-emerald-700 focus:ring ring-emerald-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-plus mr-2"></i> Buat Invoice Baru
            </a>
            @endif --}}
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Pesan Sukses/Error dari Session --}}
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                 class="mb-6 p-4 bg-green-100 dark:bg-green-700 border border-green-300 dark:border-green-600 text-green-700 dark:text-green-100 rounded-md shadow-sm flex justify-between items-center"
                 role="alert">
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="text-green-700 dark:text-green-100 hover:text-green-900 dark:hover:text-green-50" aria-label="Close">
                    <span class="sr-only">Tutup</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif
            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                 class="mb-6 p-4 bg-red-100 dark:bg-red-700 border border-red-300 dark:border-red-600 text-red-700 dark:text-red-100 rounded-md shadow-sm flex justify-between items-center"
                 role="alert">
                <span>{{ session('error') }}</span>
                <button @click="show = false" class="text-red-700 dark:text-red-100 hover:text-red-900 dark:hover:text-red-50" aria-label="Close">
                    <span class="sr-only">Tutup</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Filter Form -->
            <div class="mb-6 p-4 sm:p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                <form method="GET" action="{{ route('admin.invoices.index') }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label for="status_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Pembayaran</label>
                            <select name="status" id="status_filter"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 sm:text-sm rounded-md">
                                <option value="">Semua Status</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Terbayar</option>
                                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div>
                            <label for="user_id_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pengguna (Pembuat)</label>
                            <select name="user_id" id="user_id_filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 sm:text-sm rounded-md">
                                <option value="">Semua Pengguna</option>
                                @isset($usersForFilter)
                                    @foreach($usersForFilter as $userFilter)
                                        <option value="{{ $userFilter->id }}" {{ request('user_id') == $userFilter->id ? 'selected' : '' }}>{{ $userFilter->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="flex space-x-2 items-center pt-1 sm:pt-0 md:pt-5"> {{-- Penyesuaian alignment tombol filter --}}
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                            <a href="{{ route('admin.invoices.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <i class="fas fa-undo-alt mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-0 sm:p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No. Invoice</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pembuat</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Klien</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tgl Terbit</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($invoices as $invoice)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $invoice->invoice_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $invoice->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $invoice->client_name ?? $invoice->customer_name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $invoice->issue_date ? \Carbon\Carbon::parse($invoice->issue_date)->format('d M Y') : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900 dark:text-gray-100">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($invoice->payment_status == 'paid') bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100
                                            @elseif($invoice->payment_status == 'unpaid') bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100
                                            @elseif($invoice->payment_status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100
                                            @elseif($invoice->payment_status == 'cancelled') bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $invoice->payment_status ?? 'unknown')) }}
                                        </span>
                                        @if($invoice->payment_status == 'paid' && $invoice->paymentMethod)
                                            <span class="block text-xs text-gray-500 dark:text-gray-400 mt-0.5">({{ $invoice->paymentMethod->name }})</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button type="button"
                                            onclick="openStatusModal('{{ $invoice->id }}', '{{ addslashes($invoice->invoice_number) }}', '{{ $invoice->payment_status }}', {{ $invoice->payment_method_id ?? 'null' }})"
                                            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                            title="Update Status">
                                            <i class="fas fa-pencil-alt mr-1"></i> Update
                                        </button>
                                        {{-- Contoh link ke halaman show (detail) invoice jika Anda membuatnya --}}
                                        {{-- @if(Route::has('admin.invoices.show'))
                                            <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="ml-2 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300" title="Lihat Invoice">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif --}}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
                                        Tidak ada invoice ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($invoices->hasPages())
                    <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                        {{ $invoices->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Status Pembayaran -->
    <div id="statusModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75 dark:bg-opacity-80 transition-opacity" aria-hidden="true" onclick="closeStatusModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="updateStatusForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start w-full">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-edit text-xl text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                    Update Status Invoice #<span id="modalInvoiceNumber" class="font-bold"></span>
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="payment_status_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Pembayaran</label>
                                        <select id="payment_status_modal" name="payment_status"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 sm:text-sm rounded-md">
                                            <option value="unpaid">Belum Dibayar</option>
                                            <option value="pending">Pending</option>
                                            <option value="paid">Sudah Dibayar</option>
                                        </select>
                                    </div>
                                    <div id="payment_method_div_modal" style="display: none;"> {{-- Defaultnya disembunyikan, JS akan menampilkan jika status 'paid' --}}
                                        <label for="payment_method_id_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Metode Pembayaran</label>
                                        <select id="payment_method_id_modal" name="payment_method_id"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 sm:text-sm rounded-md">
                                            <option value="">Pilih Metode...</option>
                                            @isset($paymentMethods)
                                                @foreach($paymentMethods as $method)
                                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                                                @endforeach
                                            @else
                                                 <option value="" disabled>Metode tidak tersedia</option>
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan Perubahan
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
    document.addEventListener('DOMContentLoaded', function () {
        const statusModalElement = document.getElementById('statusModal');
        const updateStatusFormElement = document.getElementById('updateStatusForm');
        const modalInvoiceNumberSpanElement = document.getElementById('modalInvoiceNumber');
        const paymentStatusModalSelectElement = document.getElementById('payment_status_modal');
        const paymentMethodModalSelectElement = document.getElementById('payment_method_id_modal');
        const paymentMethodDivModalElement = document.getElementById('payment_method_div_modal');

        if (!statusModalElement || !updateStatusFormElement || !modalInvoiceNumberSpanElement || !paymentStatusModalSelectElement || !paymentMethodModalSelectElement || !paymentMethodDivModalElement) {
            console.warn('Satu atau lebih elemen UI modal tidak ditemukan. Fungsi modal mungkin tidak bekerja dengan benar.');
            // Anda bisa memilih untuk tidak menghentikan eksekusi di sini,
            // agar fungsionalitas lain di halaman (jika ada) tetap berjalan.
        }

        window.openStatusModal = function(invoiceId, invoiceNumber, currentStatus, currentMethodId) {
            if (!updateStatusFormElement || !modalInvoiceNumberSpanElement || !paymentStatusModalSelectElement || !paymentMethodModalSelectElement || !paymentMethodDivModalElement || !statusModalElement) return; // Guard clause

            // Membuat URL untuk action form, memastikan query string dari halaman sebelumnya dipertahankan
            let formActionUrl = `{{ url('admin/invoices') }}/${invoiceId}/update-status`;
            const previousQueryString = window.location.search; // Ambil query string dari URL saat ini (halaman daftar)
            if (previousQueryString) {
                formActionUrl += previousQueryString;
            }
            updateStatusFormElement.action = formActionUrl;

            modalInvoiceNumberSpanElement.textContent = invoiceNumber || 'N/A';
            paymentStatusModalSelectElement.value = currentStatus;

            // Setel nilai metode pembayaran
            paymentMethodModalSelectElement.value = currentMethodId || ''; // Jika null atau undefined, set ke string kosong

            if (currentStatus === 'paid') {
                paymentMethodDivModalElement.style.display = 'block';
            } else {
                paymentMethodDivModalElement.style.display = 'none';
                paymentMethodModalSelectElement.value = ''; // Reset jika bukan paid
            }
            statusModalElement.classList.remove('hidden');
        }

        window.closeStatusModal = function() {
            if (!statusModalElement) return; // Guard clause
            statusModalElement.classList.add('hidden');
        }

        if (paymentStatusModalSelectElement) { // Pastikan elemen ada
            paymentStatusModalSelectElement.addEventListener('change', function() {
                if (this.value === 'paid') {
                    paymentMethodDivModalElement.style.display = 'block';
                } else {
                    paymentMethodDivModalElement.style.display = 'none';
                    paymentMethodModalSelectElement.value = '';
                }
            });
        }

        if(statusModalElement) {
            statusModalElement.addEventListener('click', function(event) {
                if (event.target === statusModalElement) {
                    closeStatusModal();
                }
            });
        }
    });
    </script>
    @endpush
</x-app-layout>