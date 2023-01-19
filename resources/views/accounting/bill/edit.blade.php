<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('plugins/validator/fv.css') }}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Bills', 'url' => route('bills.index')],
            ['title' => 'Bill List', 'url' => route('bills.index')],
            isset($bill)
                ? ['title' => 'Edit Bill', 'url' => route('bills.edit', ['bill' => $bill->id])]
                : ['title' => 'Generate New Bills', 'url' => route('bills.create')],
        ]" />
        <a href="{{ route('bills.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next
                class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <form novalidate class="bill-details-form"
            action="{{ isset($bill) ? route('bills.update', ['bill' => $bill->id]) : route('bills.store') }}" data-redirect-url="{{route('bills.index')}} ">
            @csrf
            @if (isset($bill))
                @method('put')
            @else
                @method('post')
            @endif

            <x-input id="id" type="hidden" name="id" :value="old('id', isset($bill) ? $bill->id : '')" />
            <div class="p-5 bg-white rounded-5 w-full mb-5 divide-y divide-slate-300">
                <div class="flex py-5 mb-5">
                    <x-svg.reporting
                        class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ isset($bill) ? 'Edit Bill' : 'Generate Bills' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12 overflow-hidden">
                        @if(!isset($bill))
                        <div class="w-full">
                            <x-label for="date-type" :value="__('Billing function 1')" />
                            <x-select
                                onchange="$(this).val()==='single'?$('#single-date, #range-date').toggleClass('hidden'):$('#range-date, #single-date').toggleClass('hidden')"
                                id="date-type" class="mt-1 block w-full shadow-md" name="function1" required>
                                <option value="single">Bill by single date</option>
                                <option value="range">Bill by date range</option>
                            </x-select>
                        </div>
                        @endif
                        <div class="w-full" id="single-date">
                            <div class="w-1/2 field">
                                <x-label for="edate" :value="__('For Date')" />
                                <x-input id="edate" class="mt-1 block w-full" type="date" name="edate"
                                    :value="old('edate', date('Y-m-d'))" required />
                            </div>
                        </div>
                        @if(isset($bill))
                        <div class="w-full">
                            <div class="w-full field">
                                <x-label for="student" :value="__('For Student')" />
                                <x-input id="student" class="mt-1 block w-full" type="text"
                                    value="{{ $bill->student->firstname }} {{ $bill->student->surname }}"  disabled />
                            </div>
                        </div>
                        @endif
                        @if(!isset($bill))
                        <div class="w-full flex gap-3 hidden" id="range-date">
                            <!-- Bill date -->
                            <div class="w-1/2 field">
                                <x-label for="bill_from" :value="__('From Date')" />
                                <x-input id="bill_from" class="mt-1 block w-full" type="date" name="bill_from"
                                    :value="old('bill_from', date('Y-m-d'))" required />
                            </div>
                            <div class="w-1/2 field">
                                <x-label for="bill_to" :value="__('To Date')" />
                                <x-input id="bill_to" class="mt-1 block w-full" type="date" name="bill_to"
                                    :value="old('bill_to', date('Y-m-d'))" required />
                            </div>
                        </div>
                        @endif

                        @if(!isset($bill))
                        <div class="w-full md:row-start-2">
                            <x-label for="date-type" :value="__('Billing function 2')" />
                            <x-select
                                onchange="$(this).val()==='single'?$('#bill-fees, #bill-fee-types').toggleClass('hidden'):$('#bill-fees, #bill-fee-types').toggleClass('hidden')"
                                id="date-type" class="mt-1 block w-full shadow-md" name="function2" required>
                                <option value="fees">Bill by fees</option>
                                <option value="feetypes">Bill by fee types</option>
                            </x-select>
                        </div>
                        @endif
                        <!-- Bill fee -->
                        <div class="w-full md:row-start-2 field" id="bill-fees">
                            <x-label for="fees" :value="__('For Fee(s):')" />
                            <div class="flex gap-1">
                                <x-select id="fees"
                                    class="mt-1 block w-full select2-fees overfllow-y-auto shadow-md"
                                    name="fees[]" placeholder="Select the fee(s)" required multiple>
                                    @if (isset($bill))
                                        @foreach ($bill->fees as $key => $row)
                                            <option value="{{ $row->id }}" selected>
                                                {{ $row->class->name }} {{ $row->feeType->title }}
                                                {{ __('@') }}{{ $row->amount }} </option>
                                        @endforeach
                                    @endif
                                </x-select>
                                <a href="{{ route('fees.create', ['backtourl' => route('bills.create')]) }}"
                                    class="bg-white rounded outline outline-offset-1 outline-blue-500 text-center flex items-center px-5">
                                    <i class="fa fa-plus text-gray-600"></i>
                                </a>
                            </div>
                        </div>

                        @if(!isset($bill))
                        <!-- Fee type -->
                        <div class="w-full md:row-start-2 field hidden" id="bill-fee-types">
                            <x-label for="feetype" :value="__('Fee type(s)')" />
                            <div class="flex gap-1">
                                <x-select id="feetype" class="mt-1  overfllow-y-auto block select2-feetype shadow-md"
                                    name="feeTypes[]" required multiple>
                                    <option value=""></option>
                                    @foreach ($feetypes as $key => $row)
                                        <option value="{{ old('fee_type_id', $row->id) }}"
                                            {{ old('fee_type_id', isset($fee) ? $fee->feeType->id : '') === $row->id ? 'selected' : '' }}>
                                            {{ $row->title }}
                                        </option>
                                    @endforeach
                                </x-select>
                                <a href="{{ route('fee-types.create', ['backtourl' => route('bills.create')]) }}"
                                    class="bg-white rounded outline outline-offset-1 outline-blue-500 text-center flex items-center px-5">
                                    <i class="fa fa-plus text-gray-600"></i>
                                </a>
                            </div>
                        </div>
                       
                        @endif
                    </div>

                    <div aria-label="form-footer"
                        class="flex flex-col md:flex-row gap-5 items-center justify-between mt-4">
                        <div class="float-left">
                            <label for="stay">Stay on page: </label>
                            <input class="form-checkbox p-2.5" type="checkbox" name="stay" id="stay">
                        </div>
                        <div class="flex flex-row gap-3">
                            @if (isset($bill))
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                                <x-a-button-w href="{{ route('bills.show', ['bill' => $bill->id]) }}"
                                    class="ml-3 py-3.5 shadow-md">
                                    {{ __('View Details') }}
                                </x-a-button-w>

                                <x-a-button href="{{ route('bills.show', ['bill' => $bill->id]) }}"
                                    class="ml-3 py-3.5 shadow-md">
                                    {{ __('Cancel') }}
                                </x-a-button>
                            @else
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Generate Bills') }}
                                </x-button-p>
                                <x-a-button-w href="{{ route('bills.create') }}" class="ml-3 py-3.5 shadow-md">
                                    {{ __('Reset') }}
                                </x-a-button-w>
                                <x-a-button href="{{ route('bills.index') }}" class="ml-3 py-3.5 shadow-md">
                                    {{ __('Cancel') }}
                                </x-a-button>
                            @endif
                        </div>
                    </div>
                </div>
        </form>
    </div>
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{ asset('plugins/validator/validator.js') }} " defer></script>
        <script src="{{ asset('plugins/validator/multifield.js') }} " defer></script>
        <script src="{{ asset('js/bill/edit.js') }} " defer></script>
    @endsection
</x-app-layout>
