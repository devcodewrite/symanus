@php
    use App\Models\Classes;
    use App\Models\Attendance;
    use App\Models\User;
@endphp
<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{asset('plugins/validator/fv.css')}}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Attendances', 'url' => route('attendances.index')],
            ['title' => 'Attendance List', 'url' => route('attendances.index')],
            isset($attendance)?['title' => 'Edit Attendance', 'url' => route('attendances.edit',['attendance' => $attendance->id])]:['title' => 'New Attendance', 'url' => route('attendances.create')],
        ]" />
        <a href="{{ route('attendances.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <form novalidate class="attendance-details-form" action="{{ isset($attendance)?route('attendances.update',['attendance' => $attendance->id]):route('attendances.store') }} " data-redirect-url="{{ url('attendances') }}">
            @csrf
            @if(isset($attendance))
                @method('put')
            @else
                @method('post')
            @endif
            <x-input id="id" type="hidden" name="id" :value="old('id', isset($attendance)?$attendance->id:'')" />

            <div class="p-5 bg-white rounded-5 w-full mb-5 divide-y divide-slate-300">
                <div class="flex py-5 mb-5">
                    <x-svg.attendance class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ isset($attendance)?'Edit Attendance':'New Attendance' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid md:grid-cols-2 gap-12 overflow-hidden">
                        <!-- Date -->
                        <div class="w-full field">
                            <x-label for="adate" :value="__('Date')" />
                            <x-input id="adate" class="block w-full" type="date" name="adate" required
                            :value="old('adate', isset($attendance)?$attendance->adate:date('Y-m-d'))" placeholder="Enter the {{ __('Date of Creation') }}" />
                        </div>
                         <!-- Class -->
                         @if(Gate::inspect('createForAnyClass', new Attendance())->allowed())
                         <div class="w-full field">
                            <x-label for="class" :value="__('Assigned Class:')" />
                            <x-select id="class" class="mt-1 block w-full select2-class" name="class_id" required
                        placeholder="Select the class"  :disabled="isset($attendance)">
                                @if(isset($attendance))
                                    <option value="{{ $attendance->class_id }} "  selected>
                                        {{ $attendance->class->name }} </option>
                                @endif
                            </x-select>
                        </div>
                        @else
                        <div class="w-full field">
                            <x-label for="class" :value="__('Assigned Class:')" />
                            <x-select id="class" class="mt-1 block w-full select2" name="class_id" required
                                        placeholder="Select the class"  :disabled="isset($attendance)">
                                @if(isset($attendance))
                                    <option value="{{ $attendance->class_id }} "  selected>
                                        {{ $attendance->class->name }} </option>
                                @else
                                        @foreach(auth()->user()->classes as $key => $row)
                                        <option value="{{ $row->id }}">
                                            {{ $row->name }} </option>
                                        @endforeach
                                @endif

                            </x-select>
                        </div>
                        @endif

                        <!-- User -->
                        @if(Gate::inspect('viewAny', new User())->allowed())
                        <div class="w-full field">
                            <x-label for="user" :value="__('Assign To:')" />
                            <x-select id="user" class="mt-1 block w-full select2-users" required name="user_id"
                                placeholder="Select the User" >
                                @if(isset($attendance->user))
                                    <option value="{{ $attendance->user_id }}"  selected>
                                        {{ $attendance->user->firstname }} 
                                        {{ $attendance->user->surname }} 
                                    </option>
                                @endif
                            </x-select>
                        </div>
                        @else
                        <div class="w-full field">
                            <x-label for="user" :value="__('Assign To:')" />
                            <x-select id="user" class="mt-1 block w-full select2" required name="user_id" readonly
                                placeholder="Select the User" >
                                <option value="{{auth()->user()->id}}">{{ auth()->user()->firstname }} {{ auth()->user()->surname }}</option>
                            </x-select>
                        </div>
                        @endif
                         <!-- Attendance approval user -->
                         <div class="w-full field">
                            <x-label for="approval_user_id" :value="__('User responsible for approval:')" />
                            <div class="flex gap-1">
                                <x-select id="approval_user_id"
                                    class="mt-1 block w-full select2-approval-users overfllow-y-auto shadow-md"
                                    name="approval_user_id" placeholder="Select the user" required>
                                    @if (isset($attendance))
                                        <option value="{{ $attendance->approval_user_id }}" selected>
                                            {{ $attendance->approvalUser->firstname }}
                                            {{ $attendance->approvalUser->surname }}
                                        </option>
                                    @endif
                                </x-select>
                                <a href="{{ route('users.create', ['backtourl' => route('attendances.create')]) }}"
                                    class="bg-white rounded outline outline-offset-1 outline-blue-500 text-center flex items-center px-5">
                                    <i class="fa fa-plus text-gray-600"></i>
                                </a>
                            </div>
                        </div>

                        <div class="field w-full flex items-end gap-2">
                            <x-label for="generate-bill" :value="__('Auto Bill Students')" />
                            <x-input id="generate-bill" class="mt-1" type="checkbox" checked name="bill_students"
                                value="yes" />
                        </div>
                    </div>
                  
                    <div aria-label="form-footer" class="flex flex-col md:flex-row gap-5 items-center justify-between mt-4">
                        <div class="float-left">
                            <label for="stay">Stay on page: </label>
                            <input class="form-checkbox p-2.5" type="checkbox" name="stay" id="stay">
                        </div>
                        <div class="flex flex-row gap-3">
                            @if(isset($attendance))
                                <x-button-p class="ml-3 py-3.5">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                                <x-a-button-w :href="route('attendances.show',['attendance' => $attendance->id])" class="ml-3 py-3.5 shadow-md">
                                    {{ __('View Details') }}
                                </x-a-button-w>
                            @else
                                <x-button-p class="ml-3 py-3.5">
                                    {{ __('Create a Attendance') }}
                                </x-button-p>
                            @endif
                            <x-a-button :href="route('attendances.index')" class="ml-3 py-3.5 shadow-md">
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
        <script src="{{asset('plugins/validator/validator.js')}} " defer></script>
        <script src="{{asset('plugins/validator/multifield.js')}} " defer></script>
        <script src="{{asset('js/attendance/edit.js')}} " defer></script>
    @endsection

</x-app-layout>
