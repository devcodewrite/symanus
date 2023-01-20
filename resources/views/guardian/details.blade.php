<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Guardians', 'url' => route('guardians.index')],
            ['title' => 'Guardian Details', 'url' => route('guardians.show', ['guardian' => $guardian->id])],
        ]" />
        <a href="{{ route('guardians.index') }}" class="flex items-center hover:text-sky-600">
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
                            Guardian
                        </button>
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                            id="basic-tabs-item-2" data-hs-tab="#basic-tabs-2" aria-controls="basic-tabs-2"
                            role="tab">
                            Related Students
                        </button>
                    </nav>
                </div>

                <div class="mt-3 p-5">
                    <div class="divide-y divide-slate-300" id="basic-tabs-1" role="tabpanel"
                        aria-labelledby="basic-tabs-item-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-10">
                            <div class="flex flex-row justify-between w-full md:col-span-2">
                                <div class="flex flex-row">
                                    <span class="shadow-md p-1">
                                        <img class="h-24" src="{{ $guardian->getAvatar() }}" alt="Guardian Photo">
                                    </span>
                                    <div class="mx-3">
                                        <p class="text-sky-600 font-semibold">{{ $guardian->id }} </p>
                                        <p class="mt-5 font-semibold">{{ $guardian->firstname }} {{ $guardian->surname }} </p>
                                        <p class="uppercase text-gray-600">{{ $guardian->sex }} </p>
                                    </div>
                                </div>
                                <div class="item-end">
                                    <span
                                        class="uppercase py-2 px-4 rounded text-white font-semibold shadow-md {{ ['open' => 'bg-green-600', 'close' => 'bg-red-600'][$guardian->rstate] }}">{{ $guardian->rstate }}</span>
                                </div>
                            </div>

                            <div class="flex flex-col w-full divide-y divide-slate-300">

                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Contact(s)</span>
                                    <span class="w-1/2">
                                        {{ $guardian->phone }}  {{ $guardian->mobile?'/'.$guardian->mobile:'' }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Guardian Email</span>
                                    <span class="w-1/2">
                                        {{ $guardian->email }}
                                    </span>
                                </div>
                              
                            </div>

                            <div class="flex flex-col w-full divide-y divide-slate-300">
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Guardian Occupation</span>
                                    <span class="w-1/2">
                                        {{ $guardian->occupation }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Guardian Address</span>
                                    <span class="w-1/2">
                                        {{ $guardian->address }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="py-5">
                            
                            <x-a-button-p class="ml-3 py-3.5 item-end" :href="route('guardians.edit', ['guardian' => $guardian->id])">
                                {{ __('Modify') }}
                            </x-a-button-p>
                            @if($guardian->rstate === 'open')
                            <x-a-button class="ml-3 py-3.5 shadow-md close">
                                {{ __('Close') }}
                            </x-a-button>
                            @else
                            <x-a-button class="ml-3 py-3.5 shadow-md open">
                                {{ __('Open') }}
                            </x-a-button>
                            @endif
                           

                            <x-a-button-r class="ml-3 py-3.5 shadow-md rdelete">
                                {{ __('Delete') }}
                            </x-a-button-r>
                        </div>
                    </div>
                    <div id="basic-tabs-2" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-2">
                        
                        <div class="pt-5">
                            <div class="flex flex-col items-end w-full">
                                <x-a-button-p class="ml-3 mb-5 self-end md:mt-0" :href="route('students.create')">
                                    <x-svg.add />
                                    {{ __('New Student') }}
                                </x-a-button-p>
                            </div>
                            <div class="hidden">
                            <x-svg.student class="svg-icon-student flex-shrink-0 mx-3 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                            </div>
                            <p class="alert-processing">Processing...</p>
                            <div class="w-full overflow-x-auto flex">
                            <table class="dt-related-students display w-full" data-guardian-id="{{ $guardian->id }}"
                                data-title="{{ Str::of("List of attendances table")->headline() }}"
                                data-subtitle="{{ 'Generated on '.date('d/m/y')." for $guardian->firstname $guardian->surname" }}">
                                <thead class="uppercase">
                                    <tr>
                                        <th class="w-5"></th>
                                        <th class="w-5">Ref#</th>
                                        <th>Student Name</th>
                                        <th>Sex</th>
                                        <th>Class</th>
                                        <th>Transit</th>
                                        <th>Affiliation</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- End Content -->
    @section('script')
    <script src="{{ asset('js/guardian/related-students.js') }} " defer></script>
    <script src="{{ asset('js/guardian/details.js') }} " defer></script>
    @endsection

</x-app-layout>
