<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Fees', 'url' => route('fees.index')],
            ['title' => 'Fee Details', 'url' => route('fees.show', ['fee' => $fee->id])],
        ]" />
        <a href="{{ route('fees.index') }}" class="flex items-center hover:text-sky-600">
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
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black active"
                            id="basic-tabs-item-1" data-hs-tab="#basic-tabs-1" aria-controls="basic-tabs-1"
                            role="tab">
                            Fee
                        </button>
                        @if(false)
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                            id="basic-tabs-item-2" data-hs-tab="#basic-tabs-2" aria-controls="basic-tabs-2"
                            role="tab">
                            Related Billings
                        </button>
                        @endif
                        @if(false)
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                            id="basic-tabs-item-3" data-hs-tab="#basic-tabs-3" aria-controls="basic-tabs-3"
                            role="tab">
                            Related Payments
                        </button>
                        @endif
                    </nav>
                </div>

                <div class="mt-3 p-5">
                    <div class="divide-y divide-slate-300" id="basic-tabs-1" role="tabpanel"
                        aria-labelledby="basic-tabs-item-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-10">
                            <div class="flex flex-row justify-between w-full md:col-span-2">
                                <div class="flex flex-row">
                                    <span class="shadow-md p-1 flex items-center">
                                        <x-svg.payment class="flex-shrink-0 mx-3 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                                    </span>
                                    <div class="mx-3">
                                        <p class="text-sky-600 font-semibold">{{ $fee->id }} </p>
                                        <p class="mt-2 font-semibold">{{ $fee->class->name }} {{ $fee->feeType->title }} </p>
                                        <p class="uppercase text-gray-600"> {{ __('GHS ') }}  {{ $fee->amount }} </p>
                                    </div>
                                </div>
                                <div class="item-end">
                                    <span
                                        class="uppercase py-2 px-4 rounded text-white font-semibold shadow-md {{ ['open' => 'bg-green-600', 'close' => 'bg-red-600'][$fee->rstatus] }}">{{ $fee->rstatus }}</span>
                                </div>
                            </div>

                            <div class="flex flex-col w-full divide-y divide-slate-300">

                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Amount</span>
                                    <span class="w-1/2 text-blue-600 font-semibold">
                                       {{ __('GHS ') }} {{ $fee->amount }}
                                    </span>
                                </div>
                               
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Fee Class</span>
                                    <span class="w-1/2">
                                        {{ $fee->class->name }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Fee Type</span>
                                    <a class="w-1/2 hover:text-sky-600" href="{{route('fee-types.create', ['id'=>$fee->feeType->id]) }}">
                                        {{ $fee->feeType->title }}
                                    </a>
                                </div>

                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Total releted billings</span>
                                    @if ($fee->billings)
                                        <span>
                                        </span>
                                    @else
                                        <span class="w-1/2 flex flex-col">
                                            <p>No billings</p>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Total releted payments</span>
                                    @if ($fee->payments)
                                        <span>
                                        </span>
                                    @else
                                        <span class="w-1/2 flex flex-col">
                                            <p>No payments</p>
                                        </span>
                                    @endif
                                </div>
                                
                            </div>

                            <div class="flex flex-col w-full divide-y divide-slate-300">
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Creation Date</span>
                                    <span class="w-1/2">
                                        {{ date('d/m/y h:i a',strtotime($fee->created_at)) }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Last Updated</span>
                                    <span class="w-1/2">
                                        {{ date('d/m/y h:i a',strtotime($fee->updated_at)) }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Short Description</span>
                                    <span class="w-1/2">
                                        {{$fee->description }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="py-5">
                            <x-a-button-p class="ml-3 py-3.5 item-end">
                                {{ __('Clone') }}
                            </x-a-button-p>
                            <x-a-button-w class="ml-3 py-3.5 item-end">
                                {{ __("Generate Student's Bills") }}
                            </x-a-button-w>
                            <x-a-button-p class="ml-3 py-3.5 item-end" :href="route('fees.edit', ['fee' => $fee->id])">
                                {{ __('Modify') }}
                            </x-a-button-p>
                            <x-a-button class="ml-3 py-3.5 shadow-md">
                                {{ __('Close') }}
                            </x-a-button>
                        </div>
                    </div>
                    <div id="basic-tabs-2" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-2">
                        <p class="text-gray-500 dark:text-gray-400">
                            This is the <em class="font-semibold text-gray-800 dark:text-gray-200">second</em>
                            item's tab body.
                        </p>
                    </div>
                    <div id="basic-tabs-3" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-3">
                        <p class="text-gray-500 dark:text-gray-400">
                            This is the <em class="font-semibold text-gray-800 dark:text-gray-200">third</em> item's
                            tab body.
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- End Content -->
    @section('script')
    @endsection

</x-app-layout>
