<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('plugins/validator/fv.css') }}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Classes', 'url' => route('attendances.index')],
            ['title' => 'Class Details', 'url' => route('attendances.show', ['attendance' => $attendance->id])],
        ]" />
        <a href="{{ route('attendances.index') }}" class="flex items-center hover:text-sky-600">
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
                        <x-svg.attendance
                            class="svg-icon-attendance flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    </div>
                    <nav class="flex space-x-4 overflow-x-auto" aria-label="Tabs" role="tablist">
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black active"
                            id="basic-tabs-item-1" data-hs-tab="#basic-tabs-1" aria-controls="basic-tabs-1"
                            role="tab">
                            Attendance
                        </button>
                        @if ($attendance->status === 'draft')
                            <button type="button"
                                class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                                id="basic-tabs-item-2" data-hs-tab="#basic-tabs-2" aria-controls="basic-tabs-2"
                                role="tab">
                                Marking
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
                    <div class="divide-y divide-slate-300" id="basic-tabs-1" role="tabpanel"
                        aria-labelledby="basic-tabs-item-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-10">
                            <div class="flex flex-row justify-between w-full md:col-span-2">
                                <div class="flex flex-row">
                                    <span class="shadow-md p-1">
                                        <x-svg.attendance
                                            class="flex-shrink-0 mx-3 overflow-visible h-10 w-10 text-gray-400 dark:text-gray-600" />
                                    </span>
                                    <div class="mx-3">
                                        <p class="text-sky-600 font-semibold">{{ $attendance->id }} </p>
                                        <p>{{ date('d/m/y', strtotime($attendance->adate)) }} </p>
                                    </div>
                                </div>
                                <div class="item-end">
                                    <span
                                        class="uppercase py-2 px-4 rounded text-white font-semibold shadow-md
                                         {{ ['draft' => 'bg-yellow-600', 'approved' => 'bg-green-600', 'submitted' => 'bg-sky-600', 'rejected' => 'bg-red-600'][$attendance->status] }}">{{ $attendance->status }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col w-full divide-y divide-slate-300">
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">For Class</span>
                                    <span class="w-1/2">
                                        {{ $attendance->class->name }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">User</span>
                                    <span class="w-1/2">
                                        {{ $attendance->user->firstname }} {{ $attendance->user->surname }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Approval by</span>
                                    <span class="w-1/2">
                                        {{ $attendance->approvalUser->firstname }} {{ $attendance->approvalUser->surname }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Total students</span>
                                    <span class="w-1/2">
                                        {{ $attendance->students->count() }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Total absentees</span>
                                    <span class="w-1/2">
                                        {{ $attendance->studentAbsent() }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Total present</span>
                                    <span class="w-1/2">
                                        {{ $attendance->studentPresent() }}
                                    </span>
                                </div>
                            </div>
                            @if ($attendance->bills->count() > 0)
                                <div class="flex flex-col w-full divide-y divide-slate-300">
                                    <div class="flex flex-row justify-between py-3">
                                        <span class="w-full uppercase font-semibold text-black-600">Related Bills Summary</span>
                                    </div>
                                    <div class="flex flex-row justify-between py-3">
                                        <span class="w-1/2 text-gray-600">Estimated Amount</span>
                                        <span class="w-1/2 text-green-600 font-semibold">
                                            GHS {{ number_format($attendance->totalBill(), 2) }}
                                        </span>
                                    </div>
                                    <div class="flex flex-row justify-between py-3">
                                        <span class="w-1/2 text-gray-600">Advance Amount</span>
                                        <span class="w-1/2 text-sky-600 font-semibold">
                                            GHS {{ number_format($attendance->totalAdvance(), 2) }}
                                        </span>
                                    </div>
                                    <div class="flex flex-row justify-between py-3">
                                        <span class="w-1/2 text-gray-600">Expected Amount</span>
                                        <span class="w-1/2">
                                            GHS {{ number_format($attendance->expectedPayments(), 2) }}
                                        </span>
                                    </div>
                                    @if($attendance->status !== 'approved')
                                        <div class="flex flex-row justify-between py-3">
                                            <span class="w-1/2 text-black-600 font-semibold">Over Turn Amount</span>
                                            <span class="w-1/2 text-green-600 font-semibold">
                                                GHS
                                                {{ number_format($attendance->totalAdvance() + $attendance->expectedPayments(), 2) }}
                                            </span>
                                        </div>
                                        @else
                                        <div class="flex flex-row justify-between py-3">
                                            <span class="w-1/2 text-black-600 font-semibold">Over Turn Amount</span>
                                            <span class="w-1/2 text-green-600 font-semibold">
                                               Turned In
                                            </span>
                                        </div>

                                    @endif

                                   
                                </div>
                            @else
                                <div class="flex flex-col w-full divide-y divide-slate-300">
                                    <div class="flex flex-row justify-between py-3">
                                        <span class="w-full text-gray-600">No related bills.</span>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="md:flex md:flex-row grid grid-cols-3 items-end gap-3 pt-5">
                            @if ($attendance->status === 'rejected' || $attendance->status === 'submitted')
                                <x-a-button-w class="py-3.5 max-w-fit approve">
                                    {{ __('Approve') }}
                                </x-a-button-w>
                                <x-a-button-p class="py-3.5 max-w-fit draft">
                                    {{ __('Move to Draft') }}
                                </x-a-button-p>
                            @endif

                            @if ($attendance->status === 'draft')
                                <x-a-button-p class="py-3.5 max-w-fit submit">
                                    {{ __('Submit for Approval') }}
                                </x-a-button-p>
                                <x-a-button-w class="py-3.5 max-w-fit" :href="route('attendances.show', ['attendance' => $attendance->id])">
                                    {{ __('Refresh') }}
                                </x-a-button-w>
                            @endif

                            @if ($attendance->status === 'approved' || $attendance->status === 'submitted')
                                <x-a-button-r class="ml-3 py-3.5 max-w-fit reject">
                                    {{ __('Reject') }}
                                </x-a-button-r>
                            @endif
                            <x-a-button-p class="py-3.5 max-w-fit" :href="route('attendances.edit', ['attendance' => $attendance->id])">
                                {{ __('Modify') }}
                            </x-a-button-p>
                            <x-a-button class="py-3.5 max-w-fit rdelete">
                                {{ __('Delete') }}
                            </x-a-button>
                        </div>
                    </div>
                    <div id="basic-tabs-2" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-2">
                        @if ($attendance->status === 'draft')
                            <div>
                                <div id="vue-attendance-marking" data-attendance-id="{{ $attendance->id }}">
                                    <attendance-app />
                                </div>
                            </div>
                        @endif
                    </div>
                    @if ($attendance->status !== 'draft' || $attendance->bills->count() > 0)
                        <div id="basic-tabs-4" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-4">
                            <div id="summary-report" class="bg-white w-full divide-y divide-slate-300">
                                <div class="flex flex-col md:flex-row items-center justify-between mb-3">
                                    <div class="flex">
                                        <x-svg.attendance
                                            class="svg-icon-student flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                                        <h2 class="text-cyan-600 uppercase">Summary of Attendance and Bills</h2>
                                        <h3 class="text-cyan-600 uppercase"> {{ $attendance->class->name }} </h3>
                                        <h6 class="text-cyan-600 uppercase">{{ '' }} </h6>
                                    </div>
                                </div>
                                <div class="pt-5 md:w-3/4 divede-y divide-slate-300">

                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="basic-tabs-3" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-3">
                        <div class="bg-white w-full divide-y divide-slate-300">
                            <div class="flex flex-col md:flex-row items-center justify-between mb-3">
                                <div class="flex">
                                    <x-svg.student
                                        class="svg-icon-student flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                                    <h5 class="text-cyan-600 uppercase">List of Students</h5>
                                </div>
                                <!-- Actions -->
                                <div class="dt-action" data-dt="dt-students">
                                    <x-select class="dt-action-select w-40" name="action">
                                        <option value="">--Select action--</option>
                                        <option value="delete">
                                            <i class="fa fa-trash"></i> Delete
                                        </option>
                                        <option value="present-status">
                                            <i class="fa fa-checked"></i>Mark Present
                                        </option>
                                        <option value="absent-status">
                                            <i class="fa fa-unchecked"></i>Mark Absent
                                        </option>
                                    </x-select>

                                    <x-button class="dt-action-btn ml-1"
                                        data-target-url="{{ url('api/datatable-actions/attendance-related-students') }}"
                                        disabled>{{ __('Confirm') }} </x-button>
                                </div>

                            </div>
                            <div class="pt-5">
                                <p class="alert-processing">Processing...</p>
                               
                                    <table class="dt-related-students overflow-x-auto display w-full"
                                        data-attendance-id="{{ $attendance->id }}"
                                        data-title="{{ Str::of("List of students table")->headline() }}"
                                data-subtitle="{{ 'Generated on '.date('d/m/y')." for attendance." }}">
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
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{ asset('js/attendance/related-students.js') }} " defer></script>
        <script src="{{ asset('js/attendance/details.js') }} " defer></script>
    @endsection

</x-app-layout>
