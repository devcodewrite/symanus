<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('plugins/validator/fv.css') }}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Staff', 'url' => route('staffs.index')],
            ['title' => 'Staff List', 'url' => route('staffs.index')],
            isset($staff)
                ? ['title' => 'Edit Staff', 'url' => route('staffs.edit', ['staff' => $staff->id])]
                : ['title' => 'New Staff', 'url' => route('staffs.create')],
        ]" />
        <a href="{{ route('staffs.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next
                class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <form class="staff-details-form"
            action="{{ isset($staff) ? route('staffs.update', ['staff' => $staff->id]) : route('staffs.store') }} "
            novalidate data-redirect-url="{{ route('staffs.index') }}">
            @csrf
            @if (isset($staff))
                @method('put')
            @else
                @method('post')
            @endif


            <x-input id="id" type="hidden" name="id" :value="old('id', isset($staff) ? $staff->id : '')" />

            <div class="p-5 bg-white rounded-5 w-full mb-5 divide-y divide-slate-300">
                <div class="flex py-5 mb-5">
                    <x-svg.teacher
                        class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ isset($staff) ? 'Edit Staff' : 'New Staff' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid md:grid-cols-2 gap-6 overflow-hidden">
                        <!-- Staff ID -->
                        <div class="w-full field">
                            <x-label for="staffid" :value="__('Staff ID')" />
                            <x-input id="staffid" class="block w-full" type="text" name="staffid" required
                                :value="old('staffid', isset($staff) ? $staff->staffid : $new_staffid)" placeholder="Enter the {{ __('Staff ID') }}" />
                        </div>
                        <!-- Admitted at -->
                        <div class="w-full field">
                            <x-label for="employed_at" :value="__('Admission Date')" />
                            <x-input id="employed_at" class="block w-full" type="date" name="employed_at" required
                                :value="old('employed_at', isset($staff) ? $staff->employed_at : date('Y-m-d'))" placeholder="Enter the {{ __('Date of Admission') }}" />
                        </div>

                        <!-- Staff first Name -->
                        <div class="w-full field">
                            <x-label for="firstname" :value="__('Staff First Name')" />
                            <x-input id="firstname" class="mt-1 block w-full" type="text" name="firstname"
                                :value="old('firstname', isset($staff) ? $staff->firstname : '')" required autofocus placeholder="Enter the {{ __('First Name') }}" />
                        </div>

                        <div class="w-full field">
                            <x-label for="surname" :value="__('Staff Surname')" />
                            <x-input id="surname" class="mt-1 block w-full" type="text" name="surname"
                                :value="old('surname', isset($staff) ? $staff->surname : '')" required placeholder="Enter the {{ __('Surname') }}" />
                        </div>
                        <div class="w-full flex flex-col md:flex-row gap-6">
                            <div class="w-full field">
                                <x-label for="sex" :value="__('Select the Sex:')" />
                                <x-select id="sex" class="block w-full select2-sex" name="sex" required
                                    placeholder="Select the sex">
                                    <option value="">Select a sex</option>
                                    <option value="male" {{ isset($staff)? ($staff->sex === 'male' ? 'selected' : ''):'' }}>Male
                                    </option>
                                    <option value="female" {{ isset($staff)? ($staff->sex === 'female' ? 'selected' : ''):'' }}>
                                        Female</option>
                                    <option value="other" {{ isset($staff)? ($staff->sex === 'other' ? 'selected' : ''):'' }}>Other
                                    </option>
                                </x-select>
                            </div>
                            <div class="w-full field">
                                <x-label for="dateofbirth" :value="__('Staff Date of Birth')" />
                                <x-input id="dateofbirth" class="block w-full" type="date" name="dateofbirth"
                                    :value="old('dateofbirth', isset($staff) ? $staff->dateofbirth : '')" placeholder="Enter the {{ __('Date of birth') }}" />
                            </div>
                        </div>

                        <!-- Staff Address -->
                        <div class="w-full field">
                            <x-label for="address" :value="__('Staff Address')" />
                            <x-input id="address" class="mt-1 block w-full" type="text" name="address"
                                :value="old('address', isset($staff) ? $staff->address : '')" placeholder="Enter the {{ __('Address') }}" />
                        </div>

                        <!-- Staff Class -->
                        <div class="w-full field">
                            <x-label for="class" :value="__('Assigned Class:')" />
                            <x-select id="class" class="mt-1 block w-full select2-class" name="class_id" required
                                placeholder="Select the class">
                                @if (isset($staff))
                                    <option value="{{ $staff->class_id }} " selected>
                                        {{ $staff->class->name }} </option>
                                @endif
                            </x-select>
                        </div>

                        <!-- Staff Address -->
                        <div class="w-full flex flex-col md:flex-row gap-3">
                            <div class="w-24">
                                <img src="{{ isset($staff)?$staff->getAvatar():asset('img/no-image.png') }} "
                                    class="shadow-md bg-white-100 p-1 w-24 avatar-placeholder" alt="Staff Photo" />
                            </div>
                            <div class="w-full">
                                <x-label for="avatar" :value="__('Staff Photo')" />
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
                            @if (isset($staff))
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                                <x-a-button-w :href="route('staffs.show',['staff' => $staff->id])" class="ml-3 py-3.5 shadow-md">
                                    {{ __('View Details') }}
                                </x-a-button-w>
                            @else
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Create a Staff') }}
                                </x-button-p>
                            @endif

                            <x-a-button :href="route('staffs.index')" class="ml-3 py-3.5 shadow-md">
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
        <script src="{{ asset('js/staff/edit.js') }} " defer></script>
    @endsection

</x-app-layout>
