<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('plugins/validator/fv.css') }}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Payments', 'url' => route('payments.index')],
            ['title' => 'Payment List', 'url' => route('payments.index')],
            isset($payment)
                ? ['title' => 'Edit Payment', 'url' => route('payments.edit', ['class' => $payment->id])]
                : ['title' => 'New Payment', 'url' => route('payments.create')],
        ]" />
        <a href="{{ route('payments.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next
                class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <form novalidate class="class-details-form"
            action="{{ isset($payment) ? route('payments.update', ['class' => $payment->id]) : route('payments.store') }}" data-redirect-url="{{route('payments.index')}} ">
            @csrf
            @if (isset($payment))
                @method('put')
            @else
                @method('post')
            @endif

            <x-input id="id" type="hidden" name="id" :value="old('id', isset($payment) ? $payment->id : '')" />
            <div class="p-5 bg-white rounded-5 w-full mb-5 divide-y divide-slate-300">
                <div class="flex py-5 mb-5">
                    <x-svg.class class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ isset($payment) ? 'Edit Payment' : 'New Payment' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid md:grid-cols-2 gap-12 overflow-hidden">
                        <!-- Payment amount -->
                        <div class="w-full field">
                            <x-label for="amount" :value="__('Payment Amount')" />
                            <x-input id="amount" class="mt-1 block w-full" type="number" name="amount"
                                :value="old('amount', isset($payment) ? $payment->amount : '')" required autofocus placeholder="Enter the {{ __('Payment amount') }}" />
                        </div>
                        <!-- Payment type -->
                        <div class="w-full field">
                            <x-label for="fee_type" :value="__('Payment type')" />
                            <div class="flex gap-1">
                                <x-select id="fee_type" class="mt-1 w-full select2-fee_type shadow-md" name="fee_type_id"
                                    required>
                                    <option value=""></option>
                                    @foreach ($fee_types as $key => $row)
                                        <option value="{{ old('fee_type_id', isset($payment) ? $payment->id : $row->id) }}"
                                            {{ old('fee_type_id', isset($payment) ? $payment->id : '') === $row->id ? 'selected' : '' }}>
                                            {{ $row->title }}
                                        </option>
                                    @endforeach
                                </x-select>
                                <a href="{{ route('payment-types.create', ['backtourl'=>route('payments.create')]) }}"
                                    class="bg-white rounded outline outline-offset-1 outline-blue-500 text-center flex items-center px-5">
                                    <i class="fa fa-plus text-gray-600"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div aria-label="form-footer"
                        class="flex flex-col md:flex-row gap-5 items-center justify-between mt-4">
                        <div class="float-left">
                            <label for="stay">Stay on page: </label>
                            <input class="form-checkbox p-2.5" type="checkbox" name="stay" id="stay">
                        </div>
                        <div class="">
                            @if (isset($payment))
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                            @else
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Create a Payment') }}
                                </x-button-p>
                            @endif

                            <x-a-button class="ml-3 py-3.5 shadow-md">
                                {{ __('Cancel') }}
                            </x-a-button>
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
        <script src="{{ asset('js/payment/edit.js') }} " defer></script>
    @endsection

</x-app-layout>
