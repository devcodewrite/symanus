<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Setup', 'url' => route('user-roles.index')],
            ['title' => 'Attributes', 'url' => route('user-roles.index')],
            ['title' => 'Fee Types', 'url' => route('user-roles.create')],
        ]" />
        <a href="{{ route('user-roles.index') }}" class="flex items-center hover:text-sky-600">
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
                            User Roles
                        </button>
                        @if (isset($userRole))
                            <button type="button"
                                class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black"
                                id="basic-tabs-item-2" data-hs-tab="#basic-tabs-2" aria-controls="basic-tabs-2"
                                role="tab">
                                Permissions
                            </button>
                        @endif
                    </nav>
                </div>
                <div>
                    <div class="divide-y divide-slate-300" id="basic-tabs-1" role="tabpanel"
                        aria-labelledby="basic-tabs-item-1">
                        <form class="user-role-details-form w-full"
                            action="{{ isset($userRole) ? route('user-roles.update', ['user_role' => $userRole->id]) : route('user-roles.store') }}">
                            @csrf
                            @if (isset($userRole))
                                @method('put')
                            @else
                                @method('post')
                            @endif
                            <x-input id="id" type="hidden" name="id" :value="old('id', isset($userRole) ? $userRole->id : '')" />
                            <div
                                class="px-6 py-4 grid grid-cols-2 md:grid-cols-3 gap-6 items-end content-center justify-start">
                                <!-- Fee Type amount -->
                                <div class="w-full">
                                    <x-label for="title" :value="__('Label')" />
                                    <x-input id="title" class="mt-1 block w-full" type="text" name="title"
                                        :value="old('title', isset($userRole) ? $userRole->title : '')" required autofocus placeholder="{{ __('Label') }}" />
                                </div>
                                <div class="flex">
                                    @if (isset($userRole))
                                        <x-button-p class="ml-3 py-3.5 shadow-md ">
                                            {{ __('Save') }}
                                        </x-button-p>
                                        <x-a-button href="{{ route('user-roles.create') }}"
                                            class="ml-3 py-3.5 shadow-md">
                                            {{ __('Cancel') }}
                                        </x-a-button>
                                    @else
                                        <x-button-p class="ml-3 py-3.5 shadow-md ">
                                            {{ __('Add Role') }}
                                        </x-button-p>

                                        <x-a-button-w class="ml-3 py-3.5 shadow-md" :href="route('user-roles.create')">
                                            {{ __('Reset Form') }}
                                        </x-a-button-w>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <div class="p-5">
                            <table class="dt-user-roles display w-full">
                                <thead class="uppercase">
                                    <tr class="border">
                                        <th class="w-5">#</th>
                                        <th class="border text-center">Label</th>
                                        <th class="border ">SUPER PRIVILLAGE</th>
                                        <th class="border ">Updated Date</th>
                                        <th class="border">Created Date</th>
                                        <th class="border">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($userRoles as $key => $row)
                                        <tr>
                                            <td class="border text-center">{{ $row->id }}</td>
                                            <td class="border text-center">{{ $row->title }}</td>
                                            <td class="border text-center"><span
                                                    class=" {{ ['bg-slate-400', 'bg-blue-600'][$row->permission ? $row->permission->is_admin : 0] }} shadow-md text-white rounded p-2">{{ $row->permission ? ($row->permission->is_admin ? 'IS ADMINISTRATOR' : 'NOT AN ADMINISTRATOR') : 'NONE' }}</span>
                                            </td>
                                            <td class="border text-center">{{ $row->updated_at }}</td>
                                            <td class="border text-center">{{ $row->created_at }}</td>
                                            <td class="border text-center flex items-end gap-3">
                                                <form
                                                    action="{{ route('user-roles.update', ['user_role' => $row->id]) }}"
                                                    method="POST" novalidate class="user-role-details-form">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="id" value="{{ $row->id }} ">
                                                    <label class="switch">
                                                        <input type="hidden" name="action" value="change-status">
                                                        @if ($row->status === 'open')
                                                            <input type="hidden" name="status" value="close">
                                                        @endif
                                                        <input onchange="$(this).closest('form').submit()"
                                                            type="checkbox" name="status" value="open"
                                                            {{ $row->status === 'open' ? 'checked' : '' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </form>
                                                <a href="{{ route('user-roles.create', ['id' => $row->id]) }} "><i
                                                        class="fa text-4xl text-gray-400 hover:text-sky-600 fa-edit"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if (isset($userRole))
                        <div class="hidden" id="basic-tabs-2" role="tabpanel" aria-labelledby="basic-tabs-item-2">
                            <div class="md:p-10 p-5 uppercase">
                                <h1> {{$userRole->title }} Permissions</h1>
                            </div>
                            <form class="user-role-permission-form divide divider-slate-400 md:p-10 p-5 border my-5"
                                action="{{ route('permissions.update', ['permission' => $userRole->permission->id]) }}"
                                novalidate>
                                @csrf
                                @method('put')

                                <div class="grid grid-cols-3 overflow-x-auto gap-5 divide-y divide-slate-300">
                                    @foreach ($userRole->permission->toArray() as $key => $value)
                                        @continue($key === 'id')
                                        <x-permission-card :permission="$userRole->permission" :key="$key" :options="$value" :disabled="$userRole->permission->is_admin||$userRole->permission->is_super_admin" />
                                    @endforeach
                                </div>
                                <div class="p-5">
                                    <x-button-p class="ml-3 py-3.5 item-end">
                                        {{ __('Save Changes') }}
                                    </x-button-p>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{ asset('js/user-role/list.js') }}" defer></script>
        <script src="{{ asset('js/user-role/edit.js') }}" defer></script>
        <script src="{{ asset('js/user-role/permission.js') }}" defer></script>
    @endsection

</x-app-layout>
