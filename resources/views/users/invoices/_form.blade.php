<!-- resources/views/user/invoices/_form.blade.php -->
@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-input-label for="client_name" :value="__('Nama Klien')" />
        <x-text-input id="client_name" class="block mt-1 w-full" type="text" name="client_name"
            :value="old('client_name', $invoice->client_name ?? '')" required autofocus />
        <x-input-error :messages="$errors->get('client_name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="client_email" :value="__('Email Klien')" />
        <x-text-input id="client_email" class="block mt-1 w-full" type="email" name="client_email"
            :value="old('client_email', $invoice->client_email ?? '')" required />
        <x-input-error :messages="$errors->get('client_email')" class="mt-2" />
    </div>
</div>

<div class="mt-4">
    <x-input-label for="client_address" :value="__('Alamat Klien')" />
    <textarea id="client_address" name="client_address" rows="3"
        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('client_address', $invoice->client_address ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('client_address')" class="mt-2" />
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
    <div>
        <x-input-label for="issue_date" :value="__('Tanggal Terbit')" />
        <x-text-input id="issue_date" class="block mt-1 w-full" type="date" name="issue_date"
            :value="old('issue_date', isset($invoice) ? $invoice->issue_date->format('Y-m-d') : date('Y-m-d'))"
            required />
        <x-input-error :messages="$errors->get('issue_date')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="due_date" :value="__('Tanggal Jatuh Tempo')" />
        <x-text-input id="due_date" class="block mt-1 w-full" type="date" name="due_date"
            :value="old('due_date', isset($invoice) ? $invoice->due_date->format('Y-m-d') : '')" required />
        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
    </div>
</div>

<div class="mt-4">
    <x-input-label for="total_amount" :value="__('Total Tagihan (Rp)')" />
    <x-text-input id="total_amount" class="block mt-1 w-full" type="number" step="0.01" name="total_amount"
        :value="old('total_amount', $invoice->total_amount ?? '')" required />
    <x-input-error :messages="$errors->get('total_amount')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="description" :value="__('Deskripsi Invoice (Opsional)')" />
    <textarea id="description" name="description" rows="4"
        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $invoice->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<!-- Jika user bisa pilih payment method saat buat/edit (saat ini tidak diimplementasikan di controller create/store)
<div class="mt-4">
    <x-input-label for="payment_method_id" :value="__('Metode Pembayaran (Opsional)')" />
    <select name="payment_method_id" id="payment_method_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
        <option value="">Pilih Metode Pembayaran</option>
        @foreach($paymentMethods as $method)
            <option value="{{ $method->id }}" {{ old('payment_method_id', $invoice->payment_method_id ?? '') == $method->id ? 'selected' : '' }}>
                {{ $method->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('payment_method_id')" class="mt-2" />
</div>
-->

<div class="flex items-center justify-end mt-6">
    <a href="{{ route('user.invoices.index') }}"
        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 mr-4">
        Batal
    </a>
    <x-primary-button>
        {{ isset($invoice) ? 'Update Invoice' : 'Simpan Invoice' }}
    </x-primary-button>
</div>