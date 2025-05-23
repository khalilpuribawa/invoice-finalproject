@csrf
<div class="space-y-6">
    <div>
        <x-input-label for="name" :value="__('Nama Metode Pembayaran')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
            :value="old('name')" required autofocus
            placeholder="Misal: Bank Transfer BCA, GoPay, OVO" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="mt-4"> {{-- class mt-4 di sini bisa dihilangkan karena sudah ada space-y-6 --}}
        <x-input-label for="details" :value="__('Detail Tambahan (Opsional)')" />
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Misalnya: No. Rekening 1234567890 a/n PT ABC, atau instruksi singkat.
        </p>
        <textarea id="details" name="details" rows="4"
            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            placeholder="Instruksi atau detail rekening..."
            >{{ old('details') }}</textarea>
        <x-input-error :messages="$errors->get('details')" class="mt-2" />
    </div>

    <div class="block mt-4"> {{-- class mt-4 di sini bisa dihilangkan --}}
        <label for="is_active" class="flex items-center p-3 rounded-md border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors cursor-pointer">
            <input id="is_active" type="checkbox"
                class="h-5 w-5 rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}> {{-- Default checked untuk create --}}
            <div class="ml-3">
                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Status Metode Pembayaran') }}</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">{{ __('Centang jika metode pembayaran ini aktif dan bisa dipilih pengguna.') }}</span>
            </div>
        </label>
         <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
    </div>
</div>

<div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
    <a href="{{ route('admin.payment-methods.index') }}"
        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 mr-4">
        Batal
    </a>
    <x-primary-button>
        <i class="fas fa-plus-circle mr-2"></i>
        {{ __('Simpan Metode') }}
    </x-primary-button>