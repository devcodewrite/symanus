<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('plugins/validator/fv.css') }}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'User', 'url' => route('users.index')],
            ['title' => 'User List', 'url' => route('users.index')],
            isset($user)
                ? ['title' => 'Edit User', 'url' => route('users.edit', ['user' => $user->id])]
                : ['title' => 'New User', 'url' => route('users.create')],
        ]" />
        <a href="{{ route('users.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next
                class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <form class="user-details-form"
            action="{{ isset($user) ? route('users.update', ['user' => $user->id]) : route('users.store') }} " novalidate
            data-redirect-url="{{ route('users.index') }}">
            @csrf
            @if (isset($user))
                @method('put')
            @else
                @method('post')
            @endif
            <x-input id="id" type="hidden" name="id" :value="old('id', isset($user) ? $user->id : '')" />
            <div class="p-5 bg-white rounded-5 w-full mb-5 divide-y divide-slate-300">
                <div class="flex py-5 mb-5">
                    <x-svg.user class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ isset($user) ? 'Edit User' : 'New User' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User first Name -->
                        <div class="w-full field">
                            <x-label for="firstname" :value="__('User First Name')" />
                            <x-input id="firstname" class="mt-1 block w-full" type="text" name="firstname"
                                :value="old('firstname', isset($user) ? $user->firstname : '')" required autofocus placeholder="Enter the {{ __('First Name') }}" />
                        </div>

                        <div class="w-full field">
                            <x-label for="surname" :value="__('User Surname')" />
                            <x-input id="surname" class="mt-1 block w-full" type="text" name="surname"
                                :value="old('surname', isset($user) ? $user->surname : '')" required placeholder="Enter the {{ __('Surname') }}" />
                        </div>
                        <div class="w-full flex flex-col md:flex-row gap-6">
                            <div class="w-full field">
                                <x-label for="sex" :value="__('Select the Sex:')" />
                                <x-select id="sex" class="block w-full select2-sex" name="sex" required
                                    placeholder="Select the sex">
                                    <option value="">Select a sex</option>
                                    <option value="male"
                                        {{ isset($user) ? ($user->sex === 'male' ? 'selected' : '') : '' }}>Male
                                    </option>
                                    <option value="female"
                                        {{ isset($user) ? ($user->sex === 'female' ? 'selected' : '') : '' }}>
                                        Female</option>
                                    <option value="other"
                                        {{ isset($user) ? ($user->sex === 'other' ? 'selected' : '') : '' }}>Other
                                    </option>
                                </x-select>
                            </div>
                        </div>

                        <!-- User Email -->
                        <div class="w-full field">
                            <x-label for="email" :value="__('User Email')" />
                            <x-input id="email" class="mt-1 block w-full" type="email" name="email"
                                :value="old('email', isset($user) ? $user->email : '')" placeholder="Enter the {{ __('Email') }}" />
                        </div>
                        <!-- User Phone -->
                        <div class="w-full field">
                            <x-label for="phone" :value="__('User Phone')" />
                            <x-input id="phone" class="mt-1 block w-full" type="tel" name="phone"
                                :value="old('phone', isset($user) ? $user->phone : '')" placeholder="Enter the {{ __('Phone') }}" />
                        </div>

                        <!-- User Class -->
                        <div class="w-full field">
                            <x-label for="user-role-id" :value="__('Assigned Role:')" />
                            <x-select id="user-role-id" class="mt-1 block w-full select2-user-role" name="user_role_id"
                                required placeholder="Select the role">
                              @foreach($roles as $key => $row)
                                <option value=""></option>
                                <option value="{{ $row->id }}" {{ isset($user)?($row->id===$user->user_role_id?'selected':''):''}}>
                                    {{ $row->title }} </option>
                              @endforeach
                            </x-select>
                        </div>
                         <!-- User ID -->
                         <div class="w-full field md:row-start-4">
                            <x-label for="username" :value="__('Username/ID')" />
                            <x-input id="username" class="block w-full" type="email" name="username" required
                                :value="old('username', isset($user) ? $user->username : '')" placeholder="Enter the {{ __('User ID') }}" />
                        </div>
                        @if (!isset($user))
                            <div class="w-full field md:row-start-4">
                                <x-label for="password" :value="__('Login Password')" />
                                <x-input id="password" class="block w-full" type="password" name="password" required
                                    placeholder="Enter the {{ __('User Password') }}" />
                            </div>
                        @endif

                        <!-- User Avatar -->
                        <div class="w-full flex flex-col md:flex-row gap-3 md:row-start-5">
                            <div class="w-24">
                                <img src="{{ isset($user) ? $user->getAvatar() : asset('img/no-image.png') }} "
                                    class="shadow-md bg-white-100 p-1 w-24 avatar-placeholder" alt="User Photo" />
                            </div>
                            <div class="w-full">
                                <x-label for="avatar" :value="__('User Photo')" />
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
                            @if (isset($user))
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                                <x-a-button-w :href="route('users.show', ['user' => $user->id])" class="ml-3 py-3.5 shadow-md">
                                    {{ __('View Details') }}
                                </x-a-button-w>
                            @else
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Create a User') }}
                                </x-button-p>
                            @endif

                            <x-a-button :href="route('users.index')" class="ml-3 py-3.5 shadow-md">
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
        <script src="{{ asset('js/user/edit.js') }} " defer></script>
    @endsection

</x-app-layout>
