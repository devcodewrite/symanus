<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('plugins/validator/fv.css') }}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Expenses', 'url' => route('expenses.index')],
            ['title' => 'Expense List', 'url' => route('expenses.index')],
            isset($expense)
                ? ['title' => 'Edit Expense', 'url' => route('expenses.edit', ['expense' => $expense->id])]
                : ['title' => 'New Expense', 'url' => route('expenses.create')],
        ]" />
        <a href="{{ route('expenses.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next
                class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <form novalidate class="expense-details-form"
            action="{{ isset($expense) ? route('expenses.update', ['expense' => $expense->id]) : route('expenses.store') }}" data-redirect-url="{{route('expenses.index')}} ">
            @csrf
            @if (isset($expense))
                @method('put')
            @else
                @method('post')
            @endif

            <x-input id="id" type="hidden" name="id" :value="old('id', isset($expense) ? $expense->id : '')" />
            <div class="p-5 bg-white rounded-5 w-full mb-5 divide-y divide-slate-300">
                <div class="flex py-5 mb-5">
                    <x-svg.payment class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ isset($expense) ? 'Edit Expense' : 'New Expense' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid md:grid-cols-2 gap-12 overflow-hidden">
                        <div class="w-full flex gap-3">
                              <!-- Expense status -->
                              <div class="w-1/3 field">
                                <x-label for="rstatus" :value="__('Expense Status')" />
                                <x-select id="rstatus" class="mt-1 w-full select2-level" name="rstatus" required>
                                    <option value="open"
                                        {{ old('rstatus', isset($expense) ? $expense->rstatus : '') === 'open' ? 'selected' : '' }}>
                                        Open
                                    </option>
                                    <option value="close"
                                        {{ old('rstatus', isset($expense) ? $expense->rstatus : '') === 'close' ? 'selected' : '' }}>
                                        Close
                                    </option>
                                </x-select>
                            </div>
                            <!-- Expense amount -->
                            <div class="w-2/3 field">
                                <x-label for="amount" :value="__('Expense Amount')" />
                                <x-input id="amount" class="mt-1 block w-full" type="number" name="amount"
                                    :value="old('amount', isset($expense) ? $expense->amount : '')" required autofocus
                                    placeholder="Enter the {{ __('Expense amount') }}" />
                            </div>
                        </div>
                        <!-- Expense type -->
                        <div class="w-full field">
                            <x-label for="expensetype" :value="__('Expense type')" />
                            <div class="flex gap-1">
                                <x-select id="expensetype" class="mt-1 w-full select2-expensetype shadow-md" name="expense_type_id"
                                    required>
                                    <option value=""></option>
                                    @foreach ($expensetypes as $key => $row)
                                        <option value="{{ old('expense_type_id',$row->id) }}"
                                            {{ old('expense_type_id', isset($expense) ? $expense->expenseType->id : '') === $row->id ? 'selected' : '' }}>
                                            {{ $row->title }}
                                        </option>
                                    @endforeach
                                </x-select>
                                <a href="{{ route('expense-types.create', ['backtourl' => route('expenses.create')]) }}"
                                    class="bg-white rounded outline outline-offset-1 outline-blue-500 text-center flex items-center px-5">
                                    <i class="fa fa-plus text-gray-600"></i>
                                </a>
                            </div>
                        </div>
                        <!-- Expense Description -->
                        <div class="w-full field">
                            <x-label for="description" :value="__('Expense purpose')" />
                            <x-input id="description" class="mt-1 block w-full" type="text" name="description"
                                :value="old('description', isset($expense) ? $expense->description : '')" autofocus placeholder="What is the expense for?" />
                        </div>
                    </div>
                    <div aria-label="form-footer"
                        class="flex flex-col md:flex-row gap-5 items-center justify-between mt-4">
                        <div class="float-left">
                            <label for="stay">Stay on page: </label>
                            <input class="form-checkbox p-2.5" type="checkbox" name="stay" id="stay">
                        </div>
                        <div class="">
                            @if (isset($expense))
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                                <x-a-button-w href="{{ route('expenses.show', ['expense' => $expense->id]) }}" class="ml-3 py-3.5 shadow-md">
                                    {{ __('View Details') }}
                                </x-a-button-w>

                                <x-a-button href="{{ route('expenses.show', ['expense' => $expense->id]) }}" class="ml-3 py-3.5 shadow-md">
                                    {{ __('Cancel') }}
                                </x-a-button>
                            @else
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Create a Expense') }}
                                </x-button-p>
                                <x-a-button href="{{ route('expenses.index') }}" class="ml-3 py-3.5 shadow-md">
                                    {{ __('Cancel') }}
                                </x-a-button>
                            @endif
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
        <script src="{{ asset('js/expense/edit.js') }} " defer></script>
    @endsection

</x-app-layout>
