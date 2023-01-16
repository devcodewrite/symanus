<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('plugins/validator/fv.css') }}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Guardian', 'url' => route('guardians.index')],
            ['title' => 'Guardian List', 'url' => route('guardians.index')],
            isset($guardian)
                ? ['title' => 'Edit Guardian', 'url' => route('guardians.edit', ['guardian' => $guardian->id])]
                : ['title' => 'New Guardian', 'url' => route('guardians.create')],
        ]" />
        <a href="{{ route('guardians.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next
                class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <form class="guardian-details-form"
            action="{{ isset($guardian) ? route('guardians.update', ['guardian' => $guardian->id]) : route('guardians.store') }} "
            novalidate data-redirect-url="{{ route('guardians.index') }}">
            @csrf
            @if (isset($guardian))
                @method('put')
            @else
                @method('post')
            @endif


            <x-input id="id" type="hidden" name="id" :value="old('id', isset($guardian) ? $guardian->id : '')" />

            <div class="p-5 bg-white rounded-5 w-full mb-5 divide-y divide-slate-300">
                <div class="flex py-5 mb-5">
                    <x-svg.guardian
                        class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ isset($guardian) ? 'Edit Guardian' : 'New Guardian' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid md:grid-cols-2 gap-6 overflow-hidden">
                        <!-- Guardian first Name -->
                        <div class="w-full field">
                            <x-label for="firstname" :value="__('Guardian First Name')" />
                            <x-input id="firstname" class="mt-1 block w-full" type="text" name="firstname"
                                :value="old('firstname', isset($guardian) ? $guardian->firstname : '')" required autofocus placeholder="Enter the {{ __('First Name') }}" />
                        </div>

                        <div class="w-full field">
                            <x-label for="surname" :value="__('Guardian Surname')" />
                            <x-input id="surname" class="mt-1 block w-full" type="text" name="surname"
                                :value="old('surname', isset($guardian) ? $guardian->surname : '')" required placeholder="Enter the {{ __('Surname') }}" />
                        </div>
                        <div class="w-full flex flex-col md:flex-row gap-6">
                            <div class="w-full field">
                                <x-label for="sex" :value="__('Select the Sex:')" />
                                <x-select id="sex" class="block w-full select2-sex" name="sex" required
                                    placeholder="Select the sex">
                                    <option value="">Select a sex</option>
                                    <option value="male" {{ isset($guardian)? ($guardian->sex === 'male' ? 'selected' : ''):'' }}>Male
                                    </option>
                                    <option value="female" {{ isset($guardian)? ($guardian->sex === 'female' ? 'selected' : ''):'' }}>
                                        Female</option>
                                    <option value="other" {{ isset($guardian)? ($guardian->sex === 'other' ? 'selected' : ''):'' }}>Other
                                    </option>
                                </x-select>
                            </div>
                        </div>

                        <!-- Guardian Address -->
                        <div class="w-full field">
                            <x-label for="address" :value="__('Guardian Address')" />
                            <x-input id="address" class="mt-1 block w-full" type="text" name="address"
                                :value="old('address', isset($guardian) ? $guardian->address : '')" placeholder="Enter the {{ __('Address') }}" />
                        </div>

                         <!-- Guardian Occupation -->
                         <div class="w-full field">
                            <x-label for="occupation" :value="__('Guardian Occupation')" />
                            <x-input id="occupation" class="mt-1 block w-full" type="text" name="occupation"
                                :value="old('occupation', isset($guardian) ? $guardian->occupation : '')" placeholder="Enter the {{ __('Occupation') }}" />
                        </div>
                      
                        <!-- Guardian Photo -->
                        <div class="w-full flex flex-col md:flex-row gap-3">
                            <div class="w-24">
                                <img src="{{ isset($guardian)?$guardian->getAvatar():asset('img/no-image.png') }} "
                                    class="shadow-md bg-white-100 p-1 w-24 avatar-placeholder" alt="Guardian Photo" />
                            </div>
                            <div class="w-full">
                                <x-label for="avatar" :value="__('Guardian Photo')" />
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
                            @if (isset($guardian))
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                                <x-a-button-w :href="route('guardians.show',['guardian' => $guardian->id])" class="ml-3 py-3.5 shadow-md">
                                    {{ __('View Details') }}
                                </x-a-button-w>
                            @else
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Create a Guardian') }}
                                </x-button-p>
                            @endif

                            <x-a-button :href="route('guardians.index')" class="ml-3 py-3.5 shadow-md">
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
        <script src="{{ asset('js/guardian/edit.js') }} " defer></script>
    @endsection

</x-app-layout>
