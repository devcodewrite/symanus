@php
    use App\Models\Fee;
@endphp
<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Bills', 'url' => route('bills.index')],
            ['title' => 'Bill Details', 'url' => route('bills.show', ['bill' => $bill->id])],
        ]" />
        <a href="{{ route('bills.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next
                class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <div class="class-details flex flex-col bg-white py-5">
            <div class="w-full" aria-label="body">
                <div class="flex flex-row items-center border-b border-gray-200 px-4 dark:border-gray-700">
                    <div class="flex">
                        <x-svg.class
                            class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    </div>
                    <nav class="flex space-x-4 overflow-x-auto" aria-label="Tabs" role="tablist">
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black {{ isset($payment) ? '' : 'active' }}"
                            id="basic-tabs-item-1" data-hs-tab="#basic-tabs-1" aria-controls="basic-tabs-1"
                            role="tab">
                            Bill
                        </button>
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black {{ isset($payment) ? 'active' : '' }}"
                            id="basic-tabs-item-2" data-hs-tab="#basic-tabs-2" aria-controls="basic-tabs-2"
                            role="tab">
                            Payments
                        </button>
                    </nav>
                </div>
                <div class="mt-3 p-5">
                    <div class="divide-y {{ isset($payment) ? 'hidden' : '' }} divide-slate-300" id="basic-tabs-1"
                        role="tabpanel" aria-labelledby="basic-tabs-item-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-5">
                            <div class="flex flex-row row-start-1 justify-between col-span-2">
                                <div class="flex flex-row">
                                    <span class="shadow-md p-1 flex items-center">
                                        <x-svg.payment
                                            class="flex-shrink-0 mx-3 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                                    </span>
                                    <div class="mx-3">
                                        <p class="text-sky-600 font-semibold">{{ $bill->id }} </p>
                                        <p class="mt-2 font-semibold"> {{ __('GHS ') }}
                                            {{ $bill->totalBill() }} </p>
                                        <p class="uppercase text-gray-600">{{ $bill->bdate }} </p>
                                    </div>
                                </div>
                                <div class="item-end">
                                    <span
                                        class="uppercase py-2 px-4 rounded text-white font-semibold shadow-md {{ ['Paid' => 'bg-green-600', 'Unpaid' => 'bg-red-600'][$bill->status] }}">{{ $bill->status }}</span>
                                </div>
                            </div>
                            <div class="row-start-2  w-full divide-y divide-slate-300">
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Student</span>
                                    <a href="{{ route('students.show', ['student' => $bill->student_id]) }}"
                                        class="w-1/2 font-semibold hover:text-sky-600">
                                        {{ $bill->student->firstname }} {{ $bill->student->surname }}
                                    </a>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Bill Date </span>
                                    <span class="w-1/2">
                                        {{ $bill->bdate }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Total Paid</span>
                                    @if ($bill->payments())
                                        <span class="w-1/2 text-green-400 font-semibold">
                                            {{ __('GHS ') }}
                                            {{ number_format($bill->payments()->sum('amount'), 2) }}
                                        </span>
                                    @else
                                        <span class="w-1/2 text-green-400">
                                            {{ __('GHS ') }} {{ '0.00' }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Remaining unpaid</span>
                                    <span class="w-1/2 text-blue-600 font-semibold">
                                        @php
                                            $balance = $bill->totalBill() - $bill->payments()->sum('amount');
                                        @endphp
                                        {{ __('GHS ') }} {{ $balance < 0 ? 0.0 : number_format($balance, 2) }}
                                    </span>
                                </div>
                            </div>

                            <div class="row-start-3 md:row-start-2 w-full divide-y divide-slate-300">
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Creation Date</span>
                                    <span class="w-1/2">
                                        {{ date('d/m/y h:i a', strtotime($bill->created_at)) }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Last Updated</span>
                                    <span class="w-1/2">
                                        {{ date('d/m/y h:i a', strtotime($bill->updated_at)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col w-full divide-y divide-slate-300 col-span-2">
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-full font-semibold">Line items</span>
                                </div>
                                @foreach ($bill->billFees as $key => $row)
                                    <div class="flex flex-row justify-between py-3">
                                        <span class="px-2">#{{ $key + 1 }}</span>
                                        <span class="w-1/3 text-gray-600"> {{ $row->fee?$row->fee->feeType->title:Fee::withTrashed()->find($row->fee_id)->feeType->title; }} </span>
                                        @if ($row->alt_amount)
                                            <span class="w-2/3">
                                                <s>{{ $row->amount }}</s>
                                                {{ $row->alt_amount }}
                                            </span>
                                        @else
                                            <span class="w-2/3">
                                                {{ $row->amount }}
                                            </span>
                                        @endif

                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="py-5 flex flex-row gap-3 shadow-md items-end">
                            <x-a-button-p class="ml-3 py-3.5" :href="route('bills.edit', ['bill' => $bill->id])">
                                {{ __('Modify') }}
                            </x-a-button-p>
                            <x-a-button class="ml-3 py-3.5 shadow-md" :href="route('bills.index')">
                                {{ __('Close') }}
                            </x-a-button>

                            @if ($balance > 0)
                                <x-a-button-p class="py-3.5 max-w-fit" :href="route('bills.edit', ['bill' => $bill->id])">
                                    {{ __('Modify') }}
                                </x-a-button-p>
                                <x-a-button-r class="py-3.5 max-w-fit rdelete" :data-target-url="route('bills.destroy', ['bill' => $bill->id])"
                                    data-redirect-url="{{ route('bills.index') }}">
                                    {{ __('Delete') }}
                                </x-a-button-r>
                            @endif
                        </div>

                    </div>
                    <div id="basic-tabs-2" class="{{ isset($payment) ? '' : 'hidden' }}" role="tabpanel"
                        aria-labelledby="basic-tabs-item-2">
                        @if ($bill->totalBill() - $bill->payments()->sum('amount') > 0)


                            <form class="payment-details-form w-full"
                                action="{{ isset($payment) ? route('payments.update', ['fee_type' => $payment->id]) : route('payments.store') }} ">
                                @csrf
                                @if (isset($payment))
                                    @method('put')
                                @else
                                    @method('post')
                                @endif
                                <x-input id="id" type="hidden" name="id" :value="old('id', isset($payment) ? $payment->id : '')" />
                                <x-input id="student_id" type="hidden" name="student_id" :value="$bill->student_id" />
                                <x-input id="bill_id" type="hidden" name="bill_id" :value="$bill->id" />

                                <div
                                    class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6 items-end content-center justify-start">
                                    <!-- Bill type -->
                                    <div class="w-full field" id="bill-fee-types">
                                        <x-label for="feetype" :value="__('Bill type')" />
                                        <x-select id="feetype" class="mt-1 min-w-max select2-feetype shadow-md"
                                            name="fee_type_id">
                                            <option value=""></option>
                                            @foreach ($bill->fees()->withTrashed()->get() as $key => $fee)
                                                <option value="{{ old('fee_type_id', $fee->feeType->id) }}"
                                                    {{ old('fee_type_id', isset($payment) ? $payment->feeType->id : '') === $fee->feeType->id ? 'selected' : '' }}>
                                                    @php
                                                        $bf = $bill->billFees->where('fee_id', $fee->id)->first();
                                                    @endphp
                                                    {{ $fee->feeType->title }}{{ '@' }}{{ $bf->alt_amount ? "$bf->alt_amount" : $bf->amount }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>

                                    <!-- Bill Type amount -->
                                    <div class="w-full">
                                        <x-label for="amount" :value="__('Amount')" />
                                        <x-input id="amount" class="mt-1 block w-full" type="number"
                                            name="amount" :value="old('amount', isset($payment) ? $payment->amount : '')" required autofocus
                                            placeholder="{{ __('Amount') }}" />
                                    </div>

                                    <div class="w-full">
                                        <x-label for="paid_at" :value="__('Paid Date')" />
                                        <x-input id="paid_at" class="mt-1 block w-full" type="date"
                                            name="paid_at" :value="old(
                                                'paid_at',
                                                isset($payment) ? $payment->paid_at : date('Y-m-d'),
                                            )" required
                                            placeholder="{{ __('Paid Date') }}" />
                                    </div>

                                    <div class="w-full">
                                        <x-label for="paid_by" :value="__('Paid by')" />
                                        <x-input id="paid_by" class="mt-1 block w-full" type="text"
                                            name="paid_by" :value="old('paid_by', isset($payment) ? $payment->paid_by : '')" required
                                            placeholder="{{ __('Paid by') }}" />
                                    </div>

                                    <div class="flex">
                                        @if (isset($payment))
                                            <x-button-p class="ml-3 py-3.5 shadow-md ">
                                                {{ __('Save') }}
                                            </x-button-p>
                                            <x-a-button href="{{ route('payments.index') }}"
                                                class="ml-3 py-3.5 shadow-md">
                                                {{ __('Cancel') }}
                                            </x-a-button>
                                        @else
                                            <x-button-p class="ml-3 py-3.5 shadow-md ">
                                                {{ __('Add Payment') }}
                                            </x-button-p>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="p-5">
                                <div
                                    class="p-5 w-full h-24 text-lg font-bold text-center flex items-center justify-center rounded-lg text-white bg-green-500">
                                    Payment completed!</div>
                            </div>
                        @endif

                        <div class="p-5">
                            <table class="dt-bill-payments display w-full"
                                data-title="{{ Str::of('List of payments table')->headline() }}"
                                data-subtitle="{{ 'Generated on ' . date('d/m/y') }}">
                                <thead class="uppercase">
                                    <tr class="border">
                                        <th class="w-5">#</th>
                                        <th class="border text-center">Amount</th>
                                        <th class="border text-center">Paid By</th>
                                        <th class="border">Added Date</th>
                                        <th class="border">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($bill->payments as $key => $row)
                                        <tr>
                                            <td class="border text-center">{{ $row->id }}</td>
                                            <td class="border text-center">{{ $row->amount }}</td>
                                            <td class="border text-center">{{ $row->paid_by }}</td>
                                            <td class="border text-center">{{ $row->created_at }}</td>
                                            <td class="border text-center flex items-end gap-3">
                                                <form action="{{ route('payments.update', ['payment' => $row->id]) }}"
                                                    method="POST" novalidate class="payment-details-form">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="id"
                                                        value="{{ $row->id }} ">
                                                </form>
                                                <a class="delete-payment"
                                                    href="{{ route('payments.destroy', ['payment' => $row->id]) }} "><i
                                                        class="fa text-4xl text-gray-400 hover:text-sky-600 fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{ asset('plugins/validator/validator.js') }} " defer></script>
        <script src="{{ asset('plugins/validator/multifield.js') }} " defer></script>
        <script src="{{ asset('js/bill/payment.js') }} " defer></script>
    @endsection

</x-app-layout>
