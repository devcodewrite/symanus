<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Payments', 'url' => route('payments.index')],
            ['title' => 'Payment Details', 'url' => route('payments.show', ['class' => $payment->id])],
        ]" />
        <a href="{{ route('payments.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
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
                    <nav class="flex space-x-4" aria-label="Tabs" role="tablist">
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black active"
                            id="basic-tabs-item-1" data-hs-tab="#basic-tabs-1" aria-controls="basic-tabs-1"
                            role="tab">
                            Payment
                        </button>
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                            id="basic-tabs-item-2" data-hs-tab="#basic-tabs-2" aria-controls="basic-tabs-2"
                            role="tab">
                            Related Bills
                        </button>
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                            id="basic-tabs-item-3" data-hs-tab="#basic-tabs-3" aria-controls="basic-tabs-3"
                            role="tab">
                           Related Students
                        </button>
                    </nav>
                </div>

                <div class="mt-3 p-5">
                    <div class="divide-y divide-slate-300" id="basic-tabs-1" role="tabpanel" aria-labelledby="basic-tabs-item-1">
                        <div class="flex flex-row mb-5">
                            <span class="shadow-md p-1">
                                <x-svg.class
                                    class="flex-shrink-0 mx-3 overflow-visible h-10 w-10 text-gray-400 dark:text-gray-600" />
                            </span>
                            <div class="mx-3">
                                <p class="text-sky-600 font-semibold">{{ $payment->id; }} </p>
                                <p>{{ $payment->name; }} </p>
                            </div>
                        </div>
                        <div class="flex flex-col w-full divide-y divide-slate-300 md:w-1/2">
                            <div class="flex flex-row justify-between py-3">
                                <span class="w-1/2 text-gray-600">Total bills for this payment</span>
                                <span class="w-1/2">
                                    {{ $payment->bills()->count() }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="py-5">
                            <x-button-p class="ml-3 py-3.5 item-end">
                                {{ __('Create a Payment') }}
                            </x-button-p>
                            <x-a-button class="ml-3 py-3.5 shadow-md">
                                {{ __('Cancel') }}
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
