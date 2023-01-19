@php
    use Illuminate\Support\Carbon;
    use App\Models\User;
    use App\Models\ExpenseType;
@endphp
<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Expenses', 'url' => route('expenses.index')],
            ['title' => 'Expense Details', 'url' => route('expenses.show', ['expense' => $expenseReport->id])],
        ]" />
        <a href="{{ route('expenses.index') }}" class="flex items-center hover:text-sky-600">
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
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black {{ isset($expense) ? '' : 'active' }}"
                            id="basic-tabs-item-1" data-hs-tab="#basic-tabs-1" aria-controls="basic-tabs-1"
                            role="tab">
                            Expense Report
                        </button>
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black {{ isset($expense) ? 'active' : '' }}"
                            id="basic-tabs-item-2" data-hs-tab="#basic-tabs-2" aria-controls="basic-tabs-2"
                            role="tab">
                            Expense Line Items
                        </button>
                    </nav>
                </div>
                <div class="mt-3 p-5">
                    <div class="divide-y {{ isset($expense) ? 'hidden' : '' }} divide-slate-300" id="basic-tabs-1"
                        role="tabpanel" aria-labelledby="basic-tabs-item-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-5">
                            <div class="flex flex-row row-start-1 justify-between col-span-2">
                                <div class="flex flex-row">
                                    <span class="shadow-md p-1 flex items-center">
                                        <x-svg.payment
                                            class="flex-shrink-0 mx-3 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                                    </span>
                                    <div class="mx-3">
                                        <p class="text-sky-600 font-semibold">{{ $expenseReport->id }} </p>
                                        <p class="mt-2 font-semibold"> {{ $expenseReport->user->firstname }}
                                            {{ $expenseReport->user->surname }} </p>
                                        <p class="uppercase text-gray-600">From:
                                            {{ Carbon::parse($expenseReport->from_date)->format('d/m/y') }} To:
                                            {{ Carbon::parse($expenseReport->to_date)->format('d/m/y') }} </p>
                                    </div>
                                </div>
                                <div class="item-end">
                                    <span
                                        class="uppercase py-2 px-4 rounded text-white font-semibold shadow-md {{ ['draft' => 'bg-blue-600', 'submitted' => 'bg-yellow-600', 'approved' => 'bg-green-600', 'rejected' => 'bg-red-600'][$expenseReport->status] }}">{{ $expenseReport->status }}</span>
                                </div>
                            </div>
                            <div class="row-start-2  w-full divide-y divide-slate-300">
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Expense by user</span>
                                    <a href="{{ route('users.show', ['user' => $expenseReport->user_id]) }}"
                                        class="w-1/2 font-semibold hover:text-sky-600">
                                        {{ $expenseReport->user->firstname }} {{ $expenseReport->user->surname }}
                                    </a>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">From Date </span>
                                    <span class="w-1/2">
                                        {{ Carbon::parse($expenseReport->from_date)->format('d/m/y') }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">To Date </span>
                                    <span class="w-1/2">
                                        {{ Carbon::parse($expenseReport->to_date)->format('d/m/y') }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Total Expenses </span>
                                    <span class="w-1/2 font-semibold text-green-600"> {{ __('GHS') }}
                                        {{ number_format($expenseReport->totalExpense(), 2) }}
                                    </span>
                                </div>
                            </div>

                            <div class="row-start-3 md:row-start-2 w-full divide-y divide-slate-300">
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">User responsible for approval</span>
                                    <a href="{{ route('users.show', ['user' => $expenseReport->approval_user_id]) }}"
                                        class="w-1/2 font-semibold hover:text-sky-600">
                                        {{ $expenseReport->approvalUser->firstname }} {{ $expenseReport->approvalUser->surname }}
                                    </a>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Creation Date</span>
                                    <span class="w-1/2">
                                        {{ date('d/m/y h:i a', strtotime($expenseReport->created_at)) }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-1/2 text-gray-600">Last Updated</span>
                                    <span class="w-1/2">
                                        {{ date('d/m/y h:i a', strtotime($expenseReport->updated_at)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col w-full divide-y divide-slate-300 col-span-2">
                                <div class="flex flex-row justify-between py-3">
                                    <span class="w-full font-semibold">Line items</span>
                                </div>
                                @foreach ($expenseReport->expenses as $key => $row)
                                    <div class="flex flex-row justify-between py-3">
                                        <span class="px-2">#{{ $row->id }}</span>
                                        <span class="px-2">{{ Carbon::parse($row->edate)->format('d/m/y') }}</span>
                                        <span class="w-1/3 text-gray-600"> {{ $row->expenseType->title }} </span>
                                        <span class="w-1/3">
                                            {{ $row->amount }}
                                        </span>
                                        <span
                                            class="px-2 w-1/3">{{ Str::of($row->description)->limit(100, ' (...)') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="py-5 flex flex-row gap-3 shadow-md items-end">
                            <x-a-button-p class="ml-3 py-3.5" :href="route('expense-reports.edit', ['expense_report' => $expenseReport->id])">
                                {{ __('Modify') }}
                            </x-a-button-p>
                            <x-a-button class="ml-3 py-3.5 shadow-md" :href="route('expense-reports.index')">
                                {{ __('Close') }}
                            </x-a-button>
                        </div>
                    </div>
                    <div id="basic-tabs-2" class="{{ isset($expense) ? '' : 'hidden' }}" role="tabpanel"
                        aria-labelledby="basic-tabs-item-2">

                        <form class="expense-details-form w-full"
                            action="{{ isset($expense) ? route('expenses.update', ['expense' => $expense->id]) : route('expenses.store') }} ">
                            @csrf
                            @if (isset($expense))
                                @method('put')
                            @else
                                @method('post')
                            @endif
                            <x-input id="id" type="hidden" name="id" :value="old('id', isset($expense) ? $expense->id : '')" />
                            <x-input id="user_id" type="hidden" name="user_id" :value="$expenseReport->user_id" />
                            <x-input id="expense_report_id" type="hidden" name="expense_report_id" :value="$expenseReport->id" />

                            <div
                                class="px-6 py-4 grid grid-cols-1 md:grid-cols-3 gap-5 items-end content-center justify-start">
                                <!-- Expense Type amount -->
                                <div class="w-full field">
                                    <x-label for="edate" :value="__('Date')" />
                                    <x-input id="edate" class="mt-1 block w-full" type="date" name="edate"
                                        :value="old('edate', isset($expense) ? $expense->edate : '')" required autofocus placeholder="{{ __('Date') }}" />
                                </div>
                                <!-- Expense Type amount -->
                                <div class="w-full field">
                                    <x-label for="amount" :value="__('Amount')" />
                                    <x-input id="amount" class="mt-1 block w-full" type="number" name="amount"
                                        :value="old('amount', isset($expense) ? $expense->amount : '')" required autofocus placeholder="{{ __('Amount') }}" />
                                </div>

                                <!-- Expense type -->
                                <div class="w-full field">
                                    <x-label for="expensetype" :value="__('Expense type')" />
                                    <div class="flex flex-row gap-1">
                                        <x-select id="expensetype"
                                            class="mt-1 block w-full select2-expensetype shadow-md"
                                            name="expense_type_id" placeholder="Select expense type">
                                            <option value=""></option>
                                            @foreach (ExpenseType::where('status', 'open')->get() as $key => $row)
                                                <option value="{{ old('expense_type_id', $row->id) }}"
                                                    {{ old('expense_type_id', isset($expense) ? $expense->expenseType->id : '') === $row->id ? 'selected' : '' }}>
                                                    {{ $row->title }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <a href="{{ route('expense-types.create', ['backtourl' => route('expense-reports.show', ['expense_report' => $expenseReport->id])]) }}"
                                            class="bg-white rounded outline outline-offset-1 outline-blue-500 text-center flex items-center px-5">
                                            <i class="fa fa-plus text-gray-600"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- Expense Type amount -->
                                <div class="w-full field">
                                    <x-label for="amount" :value="__('Description')" />
                                    <textarea id="amount" class="mt-1 block w-full bordered shadow-md rounded p-1" name="description" required
                                        placeholder="{{ __('Enter a description') }}">{{ isset($expense) ? $expense->amount : '' }}</textarea>
                                </div>

                                <div class="flex">
                                    @if (isset($expense))
                                        <x-button-p class="ml-3 py-3.5 shadow-md ">
                                            {{ __('Save') }}
                                        </x-button-p>
                                        <x-a-button href="{{ route('expenses.index') }}"
                                            class="ml-3 py-3.5 shadow-md">
                                            {{ __('Cancel') }}
                                        </x-a-button>
                                    @else
                                        <x-button-p class="ml-3 py-3.5 shadow-md ">
                                            {{ __('Add Payment') }}
                                        </x-button-p>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <div class="p-5">
                            <table class="dt-expenses display w-full">
                                <thead class="uppercase">
                                    <tr class="border">
                                        <th class="w-5">#</th>
                                        <th class="border">Added Date</th>
                                        <th class="border text-center">Amount</th>
                                        <th class="border text-center">Expense Type</th>
                                        <th class="border">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($expenseReport->expenses as $key => $row)
                                        <tr>
                                            <td class="border text-center">{{ $row->id }}</td>
                                            <td class="border text-center">{{ $row->created_at }}</td>
                                            <td class="border text-center">{{ $row->amount }}</td>
                                            <td class="border text-center">{{ $row->expenseType->title }}</td>
                                            <td class="border text-center flex items-end gap-3">
                                                <form action="{{ route('expenses.update', ['expense' => $row->id]) }}"
                                                    method="POST" novalidate class="expense-details-form">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="id"
                                                        value="{{ $row->id }} ">
                                                </form>
                                                <a class="delete-expense"
                                                    href="{{ route('expenses.destroy', ['expense' => $row->id]) }} "><i
                                                        class="fa text-4xl text-gray-400 hover:text-sky-600 fa-trash"></i></a>
                                                <a
                                                    href="{{ route('expense-reports.show', ['expense_report' => $expenseReport->id, 'id' => $row->id]) }} "><i
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
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{ asset('plugins/validator/validator.js') }} " defer></script>
        <script src="{{ asset('plugins/validator/multifield.js') }} " defer></script>
        <script src="{{ asset('js/expense/expense.js') }} " defer></script>
        <script src="{{ asset('js/expense/item.js') }} " defer></script>
    @endsection

</x-app-layout>
