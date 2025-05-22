@csrf
<div>
    <x-input-label for="name" :value="__('Nama Metode Pembayaran')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
        :value="old('name', $paymentMethod->name ?? '')" required autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="details" :value="__('Detail (misal: No. Rekening, instruksi, dll)')" />
    <textarea id="details" name="details" rows="3"
        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('details', $paymentMethod->details ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('details')" class="mt-2" />
</div>

<div class="block mt-4">
    <label for="is_active" class="inline-flex items-center">
        <input id="is_active" type="checkbox"
            class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
            name="is_active" value="1" {{ old('is_active', $paymentMethod->is_active ?? true) ? 'checked' : '' }}>
        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Aktifkan Metode Pembayaran Ini') }}</span>
    </label>
</div>

<div class="flex items-center justify-end mt-6">
    <a href="{{ route('admin.payment-methods.index') }}"
        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 mr-4">
        Batal
    </a>
    <x-primary-button>
        {{ isset($paymentMethod) ? 'Update Metode' : 'Simpan Metode' }}
    </x-primary-button>
</div>