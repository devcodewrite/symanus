<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Setup', 'url' => route('fee-types.index')],
            ['title' => 'Attributes', 'url' => route('fee-types.index')],
            ['title' => 'Fee Types', 'url' => route('fee-types.create')],
        ]" />
        <a href="{{ route('fee-types.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next
                class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to Modules') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <div class="class-details flex flex-col bg-white py-5">
            <div class="w-full" aria-label="body">
                <div class="flex flex-row items-center border-b border-gray-200 px-4 dark:border-gray-700">
                    <div class="flex">
                        <x-svg.database
                            class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    </div>
                    <nav class="flex space-x-4" aria-label="Tabs" role="tablist">
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black active"
                            id="basic-tabs-item-1" data-hs-tab="#basic-tabs-1" aria-controls="basic-tabs-1"
                            role="tab">
                            Fee Types
                        </button>
                    </nav>
                </div>
                    <div class="divide-y divide-slate-300" id="basic-tabs-1" role="tabpanel"
                        aria-labelledby="basic-tabs-item-1">
                        <form class="fee-type-details-form w-full"
                            action="{{ isset($feetype) ? route('fee-types.update', ['fee_type' => $feetype->id]) : route('fee-types.store') }} ">
                            @csrf
                            @if (isset($feetype))
                                @method('put')
                            @else
                                @method('post')
                            @endif
                            <x-input id="id" type="hidden" name="id" :value="old('id', isset($feetype) ? $feetype->id : '')" />

                            <div class="px-6 py-4 grid grid-cols-2 md:grid-cols-3 gap-6 items-end content-center justify-start">
                                <!-- Fee Type amount -->
                                <div class="w-full">
                                    <x-label for="title" :value="__('Label')" />
                                    <x-input id="title" class="mt-1 block w-full" type="text" name="title"
                                        :value="old('title', isset($feetype) ? $feetype->title : '')" required autofocus placeholder="{{ __('Label') }}" />
                                </div>

                                 <!-- Transit -->
                        <div class="w-full field">
                            <x-label for="bill_ex_st_transit" :value="__('Exclude bills for transit:')" />
                            <x-select id="bill_ex_st_transit" class="block w-full select2" name="bill_ex_st_transit"
                                placeholder="Select a transit">
                                <option value=""></option>
                                <option value="walk" {{ isset($feetype)? ($feetype->bill_ex_st_transit === 'walk' ? 'selected' : ''):'' }}>Students that Walk to
                                    school</option>
                                <option value="bus" {{ isset($feetype)? ($feetype->bill_ex_st_transit === 'bus' ? 'selected' : ''):'' }}>Students that Take
                                    school bus</option>
                            </x-select>
                        </div>

                        <!-- Affiliation -->
                        <div class="w-full field">
                            <x-label for="bill_ex_st_affiliation" :value="__('Exclude bills for affiliation:')" />
                            <x-select id="bill_ex_st_affiliation" class="block w-full select2" name="bill_ex_st_affiliation" 
                                placeholder="Select an affiliation">
                                <option value=""></option>
                                <option value="staffed"
                                    {{ isset($feetype)? ($feetype->bill_ex_st_affiliation === 'staffed' ? 'selected' : ''):'' }}>Staffed Students</option>
                                <option value="non-staffed"
                                    {{ isset($feetype)? ($feetype->bill_ex_st_affiliation === 'non-staffed' ? 'selected' : ''):'' }}>Non Staffed Students
                                </option>
                            </x-select>
                        </div>
                         <!-- Attendance -->
                         <div class="w-full field">
                            <x-label for="attendance" :value="__('Exclude bills for attendance:')" />
                            <x-select id="attendance" class="block w-full select2" name="bill_ex_st_attendance"
                                placeholder="Select a attendance status">
                                <option value="">Select a attendance status</option>
                                <option value="present"
                                    {{ isset($feetype)? ($feetype->bill_ex_st_attendance === 'present' ? 'selected' : ''):'' }}>Students Present</option>
                                <option value="absent"
                                    {{ isset($feetype)? ($feetype->bill_ex_st_attendance === 'absent' ? 'selected' : ''):'' }}>Students Absent
                                </option>
                            </x-select>
                        </div>
                          <!-- Use in Attendance -->
                          <div class="w-full field">
                            <x-label for="for_attendance_bills" :value="__('For attendance bills:')" />
                            <x-input id="for_attendance_bills" class="mt-1" type="checkbox" :checked="isset($feetype)?$feetype->for_attendance_bills == true:true" name="for_attendance_bills"
                            value="1" />
                        </div>
                            <div class="flex">
                                @if (isset($feetype))
                                <x-button-p class="ml-3 py-3.5 shadow-md ">
                                    {{ __('Save') }}
                                </x-button-p>
                                    <x-a-button href="{{ route('fee-types.create') }}" class="ml-3 py-3.5 shadow-md">
                                        {{ __('Cancel') }}
                                    </x-a-button>
                                @else
                                    <x-button-p class="ml-3 py-3.5 shadow-md ">
                                        {{ __('Add') }}
                                    </x-button-p>
                                @endif
                            </div>
                            </div>
                        </form>
                        <div class="p-5">
                            <table class="dt-fee-types display w-full">
                                <thead class="uppercase">
                                    <tr class="border">
                                        <th class="w-5">#</th>
                                        <th class="border text-center">Label</th>
                                        <th class="border text-center">Exclude bills for transit</th>
                                        <th class="border text-center">Exclude bills for affiliation</th>
                                        <th class="border text-center">Exclude bills for attendance</th>
                                        <th class="border text-center">For attendance bills</th>
                                        <th class="border ">Updated Date</th>
                                        <th class="border">Created Date</th>
                                        <th class="border">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($feetypes as $key => $row)
                                        <tr>
                                            <td class="border text-center">{{ $row->id }}</td>
                                            <td class="border text-center">{{ $row->title }}</td>
                                            <td class="border text-center">{{ $row->bill_ex_st_transit }}</td>
                                            <td class="border text-center">{{ $row->bill_ex_st_affiliation }}</td>
                                            <td class="border text-center">{{ $row->bill_ex_st_attendance }}</td>
                                            <td class="border text-center"><span class="p-3 rounded text-white {{ ['bg-red-600','bg-green-600'][$row->for_attendance_bills] }}">{{ ['NO','YES'][$row->for_attendance_bills] }}</span></td>
                                            <td class="border text-center">{{ $row->updated_at }}</td>
                                            <td class="border text-center">{{ $row->created_at }}</td>
                                            <td class="border text-center flex items-end gap-3">
                                                <form action="{{ route('fee-types.update', ['fee_type' => $row->id])}}" method="POST" novalidate class="fee-type-details-form">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="id" value="{{ $row->id }} ">
                                                <label class="switch">
                                                    <input type="hidden" name="action" value="change-status">
                                                    @if($row->status === 'open')
                                                        <input type="hidden" name="status" value="close">
                                                    @endif
                                                    <input onchange="$(this).closest('form').submit()" type="checkbox" name="status" value="open"
                                                        {{ $row->status === 'open' ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                                </form>
                                                <a href="{{ route('fee-types.create', ['id' => $row->id]) }} "><i class="fa text-4xl text-gray-400 hover:text-sky-600 fa-edit"></i></a>
                                               
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

    <!-- End Content -->
    @section('script')
    <script src="{{ asset('js/fee-type/list.js') }} " defer></script>
    <script src="{{ asset('js/fee-type/edit.js') }} " defer></script>
    @endsection

</x-app-layout>
