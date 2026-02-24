<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf

                        {{-- Account --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Account
                            </label>
                            <select name="account_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Select an account</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}"
                                        {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $account->account_number }} -
                                        {{ $account->customer->name }}
                                        (₱{{ number_format($account->balance, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('account_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Transaction Number --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Transaction Number
                            </label>
                            <input type="text" name="transaction_number"
                                value="{{ old('transaction_number', 'TXN-' . str_pad(rand(1, 9999999999), 10, '0', STR_PAD_LEFT)) }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('transaction_number')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Transaction Type
                            </label>
                            <select name="type" id="type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Select type</option>
                                <option value="disbursement" {{ old('type') == 'disbursement' ? 'selected' : '' }}>
                                    Disbursement
                                </option>
                                <option value="payment" {{ old('type') == 'payment' ? 'selected' : '' }}>
                                    Payment
                                </option>
                            </select>
                            @error('type')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Amount --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Amount
                            </label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('amount')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Date --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Transaction Date
                            </label>
                            <input type="date" name="transaction_date"
                                value="{{ old('transaction_date', date('Y-m-d')) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('transaction_date')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Payment Fields --}}
                        <div id="payment-fields" style="display:none;">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Payment Method
                                </label>
                                <select name="payment_method"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Select method</option>
                                    <option value="cash">Cash</option>
                                    <option value="check">Check</option>
                                    <option value="bank transfer">Bank Transfer</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Reference Number
                                </label>
                                <input type="text" name="reference_number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Notes
                            </label>
                            <textarea name="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('notes') }}</textarea>
                        </div>

                        {{-- Send Email Checkbox --}}
                        <div class="mb-4 flex items-center">
                            <input type="checkbox" name="send_email" value="1"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                Send transaction email after saving
                            </span>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex justify-end mt-6">
                            <a href="{{ route('transactions.index') }}"
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>

                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Save Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const typeSelect = document.getElementById('type');
        const paymentFields = document.getElementById('payment-fields');

        function togglePaymentFields() {
            paymentFields.style.display = typeSelect.value === 'payment' ? 'block' : 'none';
        }

        typeSelect.addEventListener('change', togglePaymentFields);
        togglePaymentFields();
    </script>
</x-app-layout>
