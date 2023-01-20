<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Classs', 'url' => route('classes.index')],
            ['title' => 'Class Details', 'url' => route('classes.show', ['class' => $class->id])],
        ]" />
        <a href="{{ route('classes.index') }}" class="flex items-center hover:text-sky-600">
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
                            Class
                        </button>
                        @if ($module->hasModule('Courses Management'))
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                            id="basic-tabs-item-2" data-hs-tab="#basic-tabs-2" aria-controls="basic-tabs-2"
                            role="tab">
                            Related Courses
                        </button>
                        @endif

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
                                <p class="text-sky-600 font-semibold">{{ $class->id; }} </p>
                                <p>{{ $class->name; }} </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-10">
                        <div class="flex flex-col w-full divide-y divide-slate-300">
                            @if ($module->hasModule('Courses Management'))
                            <div class="flex flex-row justify-between py-3">
                                <span class="w-1/2 text-gray-600">Total courses for this class</span>
                                <span class="w-1/2">
                                    {{ $class->courses()->count() }}
                                </span>
                            </div>
                            @endif
                            <div class="flex flex-row justify-between py-3">
                                <span class="w-1/2 text-gray-600">Total students for this class</span>
                                <span class="w-1/2">
                                    {{ $class->students()->count() }}
                                </span>
                            </div>
                            <div class="flex flex-row justify-between py-3">
                                <span class="w-1/2 text-gray-600">Class Level</span>
                                <span class="w-1/2">
                                    {{ $class->level }}
                                </span>
                            </div>
                        </div>

                        <div class="w-full divide-y divide-slate-300">
                            <div class="flex flex-row justify-between py-3">
                                <span class="w-1/2 text-gray-600">Creation Date</span>
                                <span class="w-1/2">
                                    {{ date('d/m/y h:i a', strtotime($class->created_at)) }}
                                </span>
                            </div>
                            <div class="flex flex-row justify-between py-3">
                                <span class="w-1/2 text-gray-600">Last Updated</span>
                                <span class="w-1/2">
                                    {{ date('d/m/y h:i a', strtotime($class->updated_at)) }}
                                </span>
                            </div>
                        </div>
                        </div>
                        <div class="py-5">
                            <x-a-button-p class="ml-3 py-3.5 item-end" href="{{route('classes.edit',['class'=>$class->id]) }} ">
                                {{ __('Modify') }}
                            </x-a-button-p>
                            <x-a-button href="{{route('classes.index') }} " class="ml-3 py-3.5 shadow-md">
                                {{ __('Cancel') }}
                            </x-a-button>
                            <x-a-button-r class="ml-3 py-3.5 shadow-md rdelete">
                                {{ __('Delete') }}
                            </x-a-button-r>
                        </div>
                    </div>
                    <div id="basic-tabs-2" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-2">
                        <p class="text-gray-500 dark:text-gray-400">
                            This is the <em class="font-semibold text-gray-800 dark:text-gray-200">second</em>
                            item's tab body.
                        </p>
                    </div>
                    <div id="basic-tabs-3" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-3">
                        <div class="pt-5">
                            <div class="hidden">
                            <x-svg.student class="svg-icon-student flex-shrink-0 mx-3 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                            </div>
                            <p class="alert-processing">Processing...</p>

                            <table class="dt-related-students display w-full" data-class-id="{{ $class->id }}"
                                data-title="{{ Str::of("List of students table")->headline() }}"
                                data-subtitle="{{ 'Generated on '.date('d/m/y')." for ".$class->name }}">
                                <thead class="uppercase">
                                    <tr>
                                        <th class="w-5"></th>
                                        <th class="w-5">Ref#</th>
                                        <th>Student Name</th>
                                        <th>Sex</th>
                                        <th>Transit</th>
                                        <th>Affiliation</th>
                                        <th>Guardian</th>
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

    <!-- End Content -->
    @section('script')
    <script src="{{ asset('js/class/related-students.js') }} " defer></script>
    @endsection

</x-app-layout>
