<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('plugins/validator/fv.css') }}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Student', 'url' => route('students.index')],
            ['title' => 'Student List', 'url' => route('students.index')],
            isset($student)
                ? ['title' => 'Edit Student', 'url' => route('students.edit', ['student' => $student->id])]
                : ['title' => 'New Student', 'url' => route('students.create')],
        ]" />
        <a href="{{ route('students.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next
                class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <form class="student-details-form"
            action="{{ isset($student) ? route('students.update', ['student' => $student->id]) : route('students.store') }} "
            novalidate data-redirect-url="{{ route('students.index') }}">
            @csrf
            @if (isset($student))
                @method('put')
            @else
                @method('post')
            @endif


            <x-input id="id" type="hidden" name="id" :value="old('id', isset($student) ? $student->id : '')" />

            <div class="p-5 bg-white rounded-5 w-full mb-5 divide-y divide-slate-300">
                <div class="flex py-5 mb-5">
                    <x-svg.student
                        class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ isset($student) ? 'Edit Student' : 'New Student' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid md:grid-cols-2 gap-6 overflow-hidden">
                        <!-- Student ID -->
                        <div class="w-full field">
                            <x-label for="studentid" :value="__('Student ID')" />
                            <x-input id="studentid" class="block w-full" type="text" name="studentid" required
                                :value="old('studentid', isset($student) ? $student->studentid : $new_studentid)" placeholder="Enter the {{ __('Student ID') }}" />
                        </div>
                        <!-- Admitted at -->
                        <div class="w-full field">
                            <x-label for="admitted_at" :value="__('Admission Date')" />
                            <x-input id="admitted_at" class="block w-full" type="date" name="admitted_at" required
                                :value="old('admitted_at', isset($student) ? $student->admitted_at : date('Y-m-d'))" placeholder="Enter the {{ __('Date of Admission') }}" />
                        </div>

                        <!-- Student first Name -->
                        <div class="w-full field">
                            <x-label for="firstname" :value="__('Student First Name')" />
                            <x-input id="firstname" class="mt-1 block w-full" type="text" name="firstname"
                                :value="old('firstname', isset($student) ? $student->firstname : '')" required autofocus placeholder="Enter the {{ __('First Name') }}" />
                        </div>

                        <div class="w-full field">
                            <x-label for="surname" :value="__('Student Surname')" />
                            <x-input id="surname" class="mt-1 block w-full" type="text" name="surname"
                                :value="old('surname', isset($student) ? $student->surname : '')" required placeholder="Enter the {{ __('Surname') }}" />
                        </div>
                        <div class="w-full flex flex-col md:flex-row gap-6">
                            <div class="w-full field">
                                <x-label for="sex" :value="__('Select the Sex:')" />
                                <x-select id="sex" class="block w-full select2-sex" name="sex" required
                                    placeholder="Select the sex">
                                    <option value="">Select a sex</option>
                                    <option value="male" {{ isset($student)? ($student->sex === 'male' ? 'selected' : ''):'' }}>Male
                                    </option>
                                    <option value="female" {{ isset($student)? ($student->sex === 'female' ? 'selected' : ''):'' }}>
                                        Female</option>
                                    <option value="other" {{ isset($student)? ($student->sex === 'other' ? 'selected' : ''):'' }}>Other
                                    </option>
                                </x-select>
                            </div>
                            <div class="w-full field">
                                <x-label for="dateofbirth" :value="__('Student Date of Birth')" />
                                <x-input id="dateofbirth" class="block w-full" type="date" name="dateofbirth"
                                    :value="old('dateofbirth', isset($student) ? $student->dateofbirth : '')" placeholder="Enter the {{ __('Date of birth') }}" />
                            </div>
                        </div>

                        <!-- Student Address -->
                        <div class="w-full field">
                            <x-label for="address" :value="__('Student Address')" />
                            <x-input id="address" class="mt-1 block w-full" type="text" name="address"
                                :value="old('address', isset($student) ? $student->address : '')" placeholder="Enter the {{ __('Address') }}" />
                        </div>

                        <!-- Student Class -->
                        <div class="w-full field">
                            <x-label for="class" :value="__('Assigned Class:')" />
                            <x-select id="class" class="mt-1 block w-full select2-class" name="class_id" required
                                placeholder="Select the class">
                                @if (isset($student))
                                    <option value="{{ $student->class_id }} " selected>
                                        {{ $student->class->name }} </option>
                                @endif
                            </x-select>
                        </div>

                        <!-- Student Guardian -->
                        <div class="w-full field">
                            <x-label for="guardian" :value="__('Assigned Guardain:')" />
                            <x-select id="guardian" class="mt-1 block w-full select2-guardian" name="guardian_id"
                                placeholder="Select the guardian">
                                @if (isset($student->gaurdian))
                                    <option value="{{ $student->guardian_id }} " selected>
                                        {{ $student->guardian->firstname . ' ' . $student->guardian->surname }}@{{ $student - > guardian - > phone }}
                                    </option>
                                @endif
                            </x-select>
                        </div>
                        <!-- Transit -->
                        <div class="w-full field">
                            <x-label for="transit" :value="__('Select the Transit:')" />
                            <x-select id="transit" class="block w-full select2-transit" name="transit" required
                                placeholder="Select a transit">
                                <option value="">Select a transit</option>
                                <option value="walk" {{ isset($student)? ($student->transit === 'walk' ? 'selected' : ''):'' }}>Walk to
                                    school</option>
                                <option value="bus" {{ isset($student)? ($student->transit === 'bus' ? 'selected' : ''):'' }}>Take
                                    school bus</option>
                            </x-select>
                        </div>

                        <!-- Affiliation -->
                        <div class="w-full field">
                            <x-label for="affiliation" :value="__('Select the affiliation:')" />
                            <x-select id="affiliation" class="block w-full select2-affiliation" name="affiliation" required
                                placeholder="Select an affiliation">
                                <option value="">Select an affiliation</option>
                                <option value="staffed"
                                    {{ isset($student)? ($student->affiliation === 'staffed' ? 'selected' : ''):'' }}>Staffed</option>
                                <option value="non-staffed"
                                    {{ isset($student)? ($student->affiliation === 'non-staffed' ? 'selected' : ''):'' }}>Non Staffed
                                </option>
                            </x-select>
                        </div>

                        <!-- Student Address -->
                        <div class="w-full flex flex-col md:flex-row gap-3">
                            <div class="w-24">
                                <img src="{{ isset($student)?$student->getAvatar():asset('img/no-image.png') }} "
                                    class="shadow-md bg-white-100 p-1 w-24 avatar-placeholder" alt="Student Photo" />
                            </div>
                            <div class="w-full">
                                <x-label for="avatar" :value="__('Student Photo')" />
                                <x-input id="avatar" class="mt-1 block w-full" type="file" name="avatar"
                                    onchange="readURL(this)" placeholder="Set a photo" />
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
                            @if (isset($student))
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                                <x-a-button-w :href="route('students.show',['student' => $student->id])" class="ml-3 py-3.5 shadow-md">
                                    {{ __('View Details') }}
                                </x-a-button-w>
                            @else
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Create a Student') }}
                                </x-button-p>
                            @endif

                            <x-a-button :href="route('students.index')" class="ml-3 py-3.5 shadow-md">
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
        <script src="{{ asset('js/student/edit.js') }} " defer></script>
    @endsection

</x-app-layout>
