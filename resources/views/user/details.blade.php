<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Users', 'url' => route('users.index')],
            ['title' => 'User Details', 'url' => route('users.show', ['user' => $user->id])],
        ]" />
        <a href="{{ route('users.index') }}" class="flex items-center hover:text-sky-600">
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
                            User
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

                        @if (false)
                            <button type="button"
                                class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                                id="basic-tabs-item-4" data-hs-tab="#basic-tabs-4" aria-controls="basic-tabs-4"
                                role="tab">
                                Related Fees/Bills
                            </button>
                        @endif
                        @if (Gate::inspect('update', auth()->user()))
                            <button type="button"
                                class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                                id="basic-tabs-item-5" data-hs-tab="#basic-tabs-5" aria-controls="basic-tabs-5"
                                role="tab">
                                Permissions
                            </button>
                        @endif
                    </nav>
                </div>

                <div class="mt-3 p-5">
                    <div class="divide-y divide-slate-300" id="basic-tabs-1" role="tabpanel"
                        aria-labelledby="basic-tabs-item-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-10">
                            <div class="flex flex-col gap-5 md:flex-row justify-between w-full md:col-span-2">
                                <div class="flex flex-row">
                                    <span class="shadow-md p-1 w-24 flex items-center">
                                        <img class="h-auto w-24" src="{{ $user->getAvatar() }}" alt="User Photo">
                                    </span>
                                    <div class="mx-3">
                                        <p class="text-sky-600 font-semibold">{{ $user->username }} </p>
                                        <p class="mt-5 font-semibold">{{ $user->firstname }} {{ $user->surname }} </p>
                                        <p class="uppercase text-gray-600">{{ $user->sex }} </p>
                                    </div>
                                </div>
                                <div class="item-end">
                                    <span
                                        class="uppercase py-2 px-4 rounded text-white font-semibold shadow-md {{ ['open' => 'bg-green-600', 'close' => 'bg-red-600'][$user->rstate] }}">{{ $user->rstate }}</span>
                                </div>
                            </div>

                            <div class="flex flex-col w-full divide-y divide-slate-300">

                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Email</span>
                                    <span class="w-1/2 break-all">
                                        {{ $user->email }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Phone</span>
                                    <span class="w-1/2">
                                        {{ $user->phone }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Role</span>
                                    @if ($user->userRole)
                                        <span class="w-1/2">
                                            <span>{{ $user->userRole->title }}</span>
                                        </span>
                                    @else
                                        <span class="w-1/2 flex flex-col">
                                            <p>No role assigned!</p>
                                        </span>
                                    @endif

                                </div>

                            </div>

                            <div class="flex flex-col w-full divide-y divide-slate-300">

                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">User Class(s)</span>
                                    <span class="w-1/2">
                                        @foreach ($user->classes as $key => $row)
                                            <span class="shadow-md p-2 rounded mx-1"> {{ $row->name }} </span>
                                        @endforeach
                                    </span>
                                </div>
                                @if ($module->hasModule('Courses Management'))
                                    <div class="flex flex-row justify-between py-3">
                                        <span class="w-1/2 text-gray-600">Total courses for this user</span>
                                        <span class="w-1/2">
                                            {{ $user->class->courses->count() }}
                                        </span>
                                    </div>
                                @endif
                                
                            </div>
                        </div>

                        <div class="py-5">
                          
                            <x-a-button-p class="ml-3 py-3.5 item-end" :href="route('users.edit', ['user' => $user->id])">
                                {{ __('Modify') }}
                            </x-a-button-p>
                            <x-a-button class="ml-3 py-3.5 shadow-md .close">
                                {{ __('Close') }}
                            </x-a-button>
                        </div>
                    </div>
                    <div id="basic-tabs-2" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-2">
                        <p class="text-gray-500 dark:text-gray-400">
                            This is the <em class="font-semibold text-gray-800 dark:text-gray-200">second</em>
                            item's tab body.
                        </p>
                    </div>
                    <div id="basic-tabs-3" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-3">
                        <p class="text-gray-500 dark:text-gray-400">
                            This is the <em class="font-semibold text-gray-800 dark:text-gray-200">third</em> item's
                            tab body.
                        </p>
                    </div>
                    <div id="basic-tabs-4" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-4">
                        <p class="text-gray-500 dark:text-gray-400">
                            This is the <em class="font-semibold text-gray-800 dark:text-gray-200">third</em> item's
                            tab body.
                        </p>
                    </div>
                    <div id="basic-tabs-5" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-5">
                        <form class="user-permission-form"
                            action="{{ isset($user->permission_id) ? route('permissions.update', ['permission' => $user->permission_id]) : route('permissions.store') }}"

                            novalidate>
                            @csrf
                            @if($user->permission_id)
                                @method('put')
                            @else
                                @method('post')
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                            @endif
                           
                          
                            <div class="grid grid-cols-3 overflow-x-auto gap-5 divide-y divide-slate-300">
                                @foreach ($user->permission->toArray() as $key => $value)
                                    @continue($key === 'id')
                                    <x-permission-card :key="$key" :options="$value" :permission="$user->permission" />
                                @endforeach
                            </div>
                            <div class="p-5">
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Content -->
    @section('script')
    <script src="{{ asset('js/user/permission.js') }} " defer></script>
    @endsection

</x-app-layout>
