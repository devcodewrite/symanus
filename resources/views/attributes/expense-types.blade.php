<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Setup', 'url' => route('expense-types.index')],
            ['title' => 'Attributes', 'url' => route('expense-types.index')],
            ['title' => 'Expense Types', 'url' => route('expense-types.create')],
        ]" />
        <a href="{{ route('expense-types.index') }}" class="flex items-center hover:text-sky-600">
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
                            Expense Types
                        </button>
                    </nav>
                </div>
                <div class="divide-y divide-slate-300" id="basic-tabs-1" role="tabpanel"
                    aria-labelledby="basic-tabs-item-1">
                    <form class="expense-type-details-form w-full"
                        action="{{ isset($expensetype) ? route('expense-types.update', ['expense_type' => $expensetype->id]) : route('expense-types.store') }} ">
                        @csrf
                        @if (isset($expensetype))
                            @method('put')
                        @else
                            @method('post')
                        @endif
                        <x-input id="id" type="hidden" name="id" :value="old('id', isset($expensetype) ? $expensetype->id : '')" />

                        <div
                            class="px-6 py-4 grid grid-cols-2 md:grid-cols-3 gap-6 items-end content-center justify-start">
                            <!-- Expense Type amount -->
                            <div class="w-full">
                                <x-label for="title" :value="__('Label')" />
                                <x-input id="title" class="mt-1 block w-full" type="text" name="title"
                                    :value="old('title', isset($expensetype) ? $expensetype->title : '')" required autofocus placeholder="{{ __('Label') }}" />
                            </div>

                            <div class="flex">
                                @if (isset($expensetype))
                                    <x-button-p class="ml-3 py-3.5 shadow-md ">
                                        {{ __('Save') }}
                                    </x-button-p>
                                    <x-a-button href="{{ route('expense-types.create') }}"
                                        class="ml-3 py-3.5 shadow-md">
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
                        <table class="dt-expense-types display w-full">
                            <thead class="uppercase">
                                <tr class="border">
                                    <th class="w-5">#</th>
                                    <th class="border text-center">Label</th>
                                    <th class="border ">Updated Date</th>
                                    <th class="border">Created Date</th>
                                    <th class="border">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($expensetypes as $key => $row)
                                    <tr>
                                        <td class="border text-center">{{ $row->id }}</td>
                                        <td class="border text-center">{{ $row->title }}</td>
                                        <td class="border text-center">{{ $row->updated_at }}</td>
                                        <td class="border text-center">{{ $row->created_at }}</td>
                                        <td class="border text-center flex items-end gap-3">
                                            <form
                                                action="{{ route('expense-types.update', ['expense_type' => $row->id]) }}"
                                                method="POST" novalidate class="expense-type-details-form">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="id" value="{{ $row->id }} ">
                                                <label class="switch">
                                                    <input type="hidden" name="action" value="change-status">
                                                    @if ($row->status === 'open')
                                                        <input type="hidden" name="status" value="close">
                                                    @endif
                                                    <input onchange="$(this).closest('form').submit()" type="checkbox"
                                                        name="status" value="open"
                                                        {{ $row->status === 'open' ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </form>
                                            <a href="{{ route('expense-types.create', ['id' => $row->id]) }} "><i
                                                    class="fa text-4xl text-gray-400 hover:text-sky-600 fa-edit"></i></a>

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
        <script src="{{ asset('js/expense-type/list.js') }} " defer></script>
        <script src="{{ asset('js/expense-type/edit.js') }} " defer></script>
    @endsection

</x-app-layout>
