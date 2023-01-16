<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('plugins/validator/fv.css') }}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Fees', 'url' => route('fees.index')],
            ['title' => 'Fee List', 'url' => route('fees.index')],
            isset($fee)
                ? ['title' => 'Edit Fee', 'url' => route('fees.edit', ['fee' => $fee->id])]
                : ['title' => 'New Fee', 'url' => route('fees.create')],
        ]" />
        <a href="{{ route('fees.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next
                class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <form novalidate class="fee-details-form"
            action="{{ isset($fee) ? route('fees.update', ['fee' => $fee->id]) : route('fees.store') }}" data-redirect-url="{{route('fees.index')}} ">
            @csrf
            @if (isset($fee))
                @method('put')
            @else
                @method('post')
            @endif

            <x-input id="id" type="hidden" name="id" :value="old('id', isset($fee) ? $fee->id : '')" />
            <div class="p-5 bg-white rounded-5 w-full mb-5 divide-y divide-slate-300">
                <div class="flex py-5 mb-5">
                    <x-svg.payment class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ isset($fee) ? 'Edit Fee' : 'New Fee' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid md:grid-cols-2 gap-12 overflow-hidden">
                        <div class="w-full flex gap-3">
                              <!-- Fee status -->
                              <div class="w-1/3 field">
                                <x-label for="rstatus" :value="__('Fee Status')" />
                                <x-select id="rstatus" class="mt-1 w-full select2-level" name="rstatus" required>
                                    <option value="open"
                                        {{ old('rstatus', isset($fee) ? $fee->rstatus : '') === 'open' ? 'selected' : '' }}>
                                        Open
                                    </option>
                                    <option value="close"
                                        {{ old('rstatus', isset($fee) ? $fee->rstatus : '') === 'close' ? 'selected' : '' }}>
                                        Close
                                    </option>
                                </x-select>
                            </div>
                            <!-- Fee amount -->
                            <div class="w-2/3 field">
                                <x-label for="amount" :value="__('Fee Amount')" />
                                <x-input id="amount" class="mt-1 block w-full" type="number" name="amount"
                                    :value="old('amount', isset($fee) ? $fee->amount : '')" required autofocus
                                    placeholder="Enter the {{ __('Fee amount') }}" />
                            </div>
                        </div>
                        <!-- Fee type -->
                        <div class="w-full field">
                            <x-label for="feetype" :value="__('Fee type')" />
                            <div class="flex gap-1">
                                <x-select id="feetype" class="mt-1 w-full select2-feetype shadow-md" name="fee_type_id"
                                    required>
                                    <option value=""></option>
                                    @foreach ($feetypes as $key => $row)
                                        <option value="{{ old('fee_type_id',$row->id) }}"
                                            {{ old('fee_type_id', isset($fee) ? $fee->feeType->id : '') === $row->id ? 'selected' : '' }}>
                                            {{ $row->title }}
                                        </option>
                                    @endforeach
                                </x-select>
                                <a href="{{ route('fee-types.create', ['backtourl' => route('fees.create')]) }}"
                                    class="bg-white rounded outline outline-offset-1 outline-blue-500 text-center flex items-center px-5">
                                    <i class="fa fa-plus text-gray-600"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Fee class -->
                        <div class="w-full field">
                            <x-label for="classes" :value="__('For Class(es):')" />
                            <div class="flex gap-1">
                                <x-select id="classes"
                                    class="mt-1 block w-full select2-classes overfllow-y-auto shadow-md"
                                    :name="isset($fee)?'class_id':'classes[][class_id]'" placeholder="Select the class(es)" required
                                    :multiple="!isset($fee)">
                                    @if (isset($fee))
                                        <option value="{{ $fee->class_id }}" selected>
                                            {{ $fee->class->name }} </option>
                                    @endif
                                </x-select>
                                <a href="{{ route('classes.create', ['backtourl' => route('fees.create')]) }}"
                                    class="bg-white rounded outline outline-offset-1 outline-blue-500 text-center flex items-center px-5">
                                    <i class="fa fa-plus text-gray-600"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Fee Description -->
                        <div class="w-full field">
                            <x-label for="description" :value="__('Fee description')" />
                            <x-input id="description" class="mt-1 block w-full" type="text" name="description"
                                :value="old('description', isset($fee) ? $fee->description : '')" autofocus placeholder="Enter the {{ __('Fee Description') }}" />
                        </div>

                    </div>

                    <div aria-label="form-footer"
                        class="flex flex-col md:flex-row gap-5 items-center justify-between mt-4">
                        <div class="float-left">
                            <label for="stay">Stay on page: </label>
                            <input class="form-checkbox p-2.5" type="checkbox" name="stay" id="stay">
                        </div>
                        <div class="">
                            @if (isset($fee))
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                                <x-a-button-w href="{{ route('fees.show', ['fee' => $fee->id]) }}" class="ml-3 py-3.5 shadow-md">
                                    {{ __('View Details') }}
                                </x-a-button-w>

                                <x-a-button href="{{ route('fees.show', ['fee' => $fee->id]) }}" class="ml-3 py-3.5 shadow-md">
                                    {{ __('Cancel') }}
                                </x-a-button>
                            @else
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Create a Fee') }}
                                </x-button-p>
                                <x-a-button href="{{ route('fees.index') }}" class="ml-3 py-3.5 shadow-md">
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
        <script src="{{ asset('js/fee/edit.js') }} " defer></script>
    @endsection

</x-app-layout>
