<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kelola Metode Pembayaran') }}
            </h2>
            @if(Route::has('admin.payment-methods.create'))
            <a href="{{ route('admin.payment-methods.create') }}"
                class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-plus mr-2"></i> Tambah Metode Baru
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Session Messages --}}
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-0 sm:p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nama Metode
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Detail
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($paymentMethods as $method)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $method->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ Str::limit($method->details, 70) }} {{-- Batasi panjang detail agar tabel tidak terlalu lebar --}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $method->is_active ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100' }}">
                                            {{ $method->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            @if(Route::has('admin.payment-methods.edit'))
                                            <a href="{{ route('admin.payment-methods.edit', $method->id) }}"
                                                class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300" title="Edit Metode">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            @endif
                                            @if(Route::has('admin.payment-methods.destroy'))
                                                {{-- Menggunakan konfirmasi JS dari contoh HTML Statis Anda untuk tombol Hapus --}}
                                                {{-- Anda juga bisa menggunakan <x-modal> seperti di Kelola Pengguna jika sudah ada --}}
                                                <form action="{{ route('admin.payment-methods.destroy', $method->id) }}" method="POST" class="inline"
                                                      onsubmit="event.preventDefault(); confirmDelete('{{ addslashes($method->name) }}', this);">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300" title="Hapus Metode">
                                                        <i class="fas fa-trash mr-1"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-300">
                                        Tidak ada metode pembayaran.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($paymentMethods->hasPages())
                    <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                        {{ $paymentMethods->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal (Diambil dari UI Statis Anda) -->
    <div id="deleteMethodModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 dark:bg-opacity-80 overflow-y-auto h-full w-full z-[100]"> {{-- z-index dinaikkan --}}
        <div class="relative top-1/4 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600 dark:text-red-400"></i>
                </div>
                <h3 class="mt-2 text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Konfirmasi Hapus</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Apakah Anda yakin ingin menghapus metode pembayaran <strong id="methodNameToDelete" class="font-semibold dark:text-white"></strong>?
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="items-center px-4 py-3 bg-gray-50 dark:bg-gray-700 rounded-b-md">
                    <div class="flex justify-end space-x-3">
                        <button id="cancelDeleteMethodBtn"
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:border-gray-400 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Batal
                        </button>
                        <button id="confirmDeleteMethodBtn"
                            class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete confirmation modal for payment methods
        const deleteMethodModalElement = document.getElementById("deleteMethodModal");
        const methodNameElement = document.getElementById("methodNameToDelete");
        const cancelDeleteMethodBtnElement = document.getElementById("cancelDeleteMethodBtn");
        const confirmDeleteMethodBtnElement = document.getElementById("confirmDeleteMethodBtn");
        let formToSubmitForDelete = null;

        window.confirmDelete = function(name, formElement) {
            if (methodNameElement && deleteMethodModalElement) {
                methodToDelete = name; // Jika Anda masih menggunakan variabel global ini
                methodNameElement.textContent = name;
                deleteMethodModalElement.classList.remove("hidden");
                formToSubmitForDelete = formElement; // Simpan elemen form yang akan disubmit
            } else {
                console.error("Modal elements not found for payment method deletion.");
            }
        }

        if (cancelDeleteMethodBtnElement && deleteMethodModalElement) {
            cancelDeleteMethodBtnElement.onclick = function() {
                deleteMethodModalElement.classList.add("hidden");
                formToSubmitForDelete = null;
            }
        }

        if (confirmDeleteMethodBtnElement && deleteMethodModalElement) {
            confirmDeleteMethodBtnElement.onclick = function() {
                if (formToSubmitForDelete) {
                    formToSubmitForDelete.submit(); // Submit form yang sudah disimpan
                }
                deleteMethodModalElement.classList.add("hidden");
                formToSubmitForDelete = null;
            }
        }

        if (deleteMethodModalElement) {
            // Tutup modal jika klik di luar konten modal
            deleteMethodModalElement.addEventListener('click', function(event) {
                if (event.target === deleteMethodModalElement) {
                    deleteMethodModalElement.classList.add("hidden");
                    formToSubmitForDelete = null;
                }
            });
             // Tutup modal dengan tombol Escape
            window.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !deleteMethodModalElement.classList.contains('hidden')) {
                    deleteMethodModalElement.classList.add('hidden');
                    formToSubmitForDelete = null;
                }
            });
        }

        // Auto-hide success/error messages
        const autoHideAlerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
        autoHideAlerts.forEach(function(alert) {
            setTimeout(function() {
                if (alert) { // Cek lagi jika elemen masih ada
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500); // Hapus elemen setelah transisi
                }
            }, 5000);
        });
    });
    </script>
    @endpush
</x-app-layout>