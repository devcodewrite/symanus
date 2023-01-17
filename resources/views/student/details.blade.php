<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Students', 'url' => route('students.index')],
            ['title' => 'Student Details', 'url' => route('students.show', ['student' => $student->id])],
        ]" />
        <a href="{{ route('students.index') }}" class="flex items-center hover:text-sky-600">
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
                        <x-svg.student
                            class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    </div>
                    <nav class="flex space-x-4 overflow-x-auto" aria-label="Tabs" role="tablist">
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black active"
                            id="basic-tabs-item-1" data-hs-tab="#basic-tabs-1" aria-controls="basic-tabs-1"
                            role="tab">
                            Student
                        </button>
                        @if ($module->hasModule('Courses Management'))
                            <button type="button"
                                class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                                id="basic-tabs-item-2" data-hs-tab="#basic-tabs-2" aria-controls="basic-tabs-2"
                                role="tab">
                                Related Courses
                            </button>
                        @endif
                        @if ($module->hasModule('Report Card Management'))
                            <button type="button"
                                class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                                id="basic-tabs-item-3" data-hs-tab="#basic-tabs-3" aria-controls="basic-tabs-3"
                                role="tab">
                                Related Assessments
                            </button>
                        @endif

                        @if ($module->hasModule('Fees Collection Management'))
                            <button type="button"
                                class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                                id="basic-tabs-item-2" data-hs-tab="#basic-tabs-2" aria-controls="basic-tabs-2"
                                role="tab">
                                Related Bills
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
                                    <span class="shadow-md p-1">
                                        <img class="h-24" src="{{ $student->getAvatar() }}" alt="Student Photo">
                                    </span>
                                    <div class="mx-3">
                                        <p class="text-sky-600 font-semibold">{{ $student->studentid }} </p>
                                        <p class="mt-5 font-semibold">{{ $student->firstname }} {{ $student->surname }}
                                        </p>
                                        <p class="uppercase text-gray-600">{{ $student->sex }} </p>
                                    </div>
                                </div>
                                <div class="item-end">
                                    <span
                                        class="uppercase py-2 px-4 rounded text-white font-semibold shadow-md {{ ['open' => 'bg-green-600', 'close' => 'bg-red-600'][$student->rstate] }}">{{ $student->rstate }}</span>
                                </div>
                            </div>

                            <div class="flex flex-col w-full divide-y divide-slate-300">

                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Admission Date</span>
                                    <span class="w-1/2">
                                        {{ date('d/m/y', strtotime($student->admitted_at)) }}
                                    </span>
                                </div>
                                
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Student Class</span>
                                    <span class="w-1/2">
                                        {{ $student->class->name }}
                                    </span>
                                </div>

                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Guardian</span>
                                    @if ($student->guardian)
                                        <span class="w-1/2 flex flex-col">
                                            <span>{{ $student->guardian->firstname }}
                                                {{ $student->guardian->surname }}</span>
                                            <span>{{ $student->guardian->phone }}
                                                {{ '/' . $student->guardian->mobile }}</span>
                                        </span>
                                    @else
                                        <span class="w-1/2 flex flex-col">
                                            <p>No guardian assigned!</p>
                                        </span>
                                    @endif

                                </div>
                                @if ($module->hasModule('Courses Management'))
                                    <div class="flex flex-row justify-between py-3">
                                        <span class="w-1/2 text-gray-600">Total courses for this student</span>
                                        <span class="w-1/2">
                                            {{ $student->class->courses->count() }}
                                        </span>
                                    </div>
                                @endif

                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Born On</span>
                                    <span class="w-1/2">
                                        {{ $student->dateofbirth?date('d/m/y', strtotime($student->dateofbirth)):'Not set' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col w-full divide-y divide-slate-300">

                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Student Affiliation</span>
                                    <span class="w-1/2 uppercase">
                                        {{ $student->affiliation }}
                                    </span>
                                </div>

                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Student Transit</span>
                                    <span class="w-1/2 uppercase">
                                        {{ $student->transit }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Student Address</span>
                                    <span class="w-1/2">
                                        {{ $student->address }}
                                    </span>
                                </div>

                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Student Debt</span>
                                    <span class="w-1/2">
                                        {{ __('GHS') }} {{ number_format($student->getBalance(), 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="py-5">
                          
                            <x-a-button-p class="ml-3 py-3.5 item-end" :href="route('students.edit', ['student' => $student->id])">
                                {{ __('Modify') }}
                            </x-a-button-p>
                            @if($student->rstate === 'open')
                            <x-a-button class="ml-3 py-3.5 shadow-md close">
                                {{ __('Close') }}
                            </x-a-button>
                            @else
                            <x-a-button class="ml-3 py-3.5 shadow-md open">
                                {{ __('Open') }}
                            </x-a-button>
                            @endif
                           
                        </div>
                    </div>
                    <div class="hidden" id="basic-tabs-2" role="tabpanel" aria-labelledby="basic-tabs-item-2">
                        <p class="alert-processing">Processing...</p>
                        <div class="hidden">
                            <x-svg.payment
                                class="svg-icon-payment flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                        </div>
                        <div>
                        <table class="dt-related-bills hidden display w-full" data-student-id="{{ $student->id }}">
                            <thead class="uppercase">
                                <tr>
                                    <th class="w-5"></th>
                                    <th class="w-5">#</th>
                                    <th class="w-5">Date</th>
                                    <th>Bill Amount</th>
                                    <th>Creator</th>
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
        <script src="{{ asset('js/student/related-bills.js') }} " defer></script>
        <script src="{{ asset('js/student/details.js') }} " defer></script>
    @endsection

</x-app-layout>
