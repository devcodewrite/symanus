@php
    use Illuminate\Support\Carbon;
    use App\Models\User;
@endphp
<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('plugins/validator/fv.css') }}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Expense Reports', 'url' => route('expense-reports.index')],
            ['title' => 'Expense Report List', 'url' => route('expense-reports.index')],
            isset($expenseReport)
                ? ['title' => 'Edit Expense Report', 'url' => route('expense-reports.edit', ['expense_report' => $expenseReport->id])]
                : ['title' => 'New Expense Report', 'url' => route('expense-reports.create')],
        ]" />
        <a href="{{ route('expense-reports.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next
                class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <form novalidate class="expense-details-form"
            action="{{ isset($expenseReport) ? route('expense-reports.update', ['expense_report' => $expenseReport->id]) : route('expense-reports.store') }}"
            data-redirect-url="{{ route('expense-reports.index') }}">
            @csrf
            @if (isset($expenseReport))
                @method('put')
            @else
                @method('post')
            @endif

            <x-input id="id" type="hidden" name="id" :value="old('id', isset($expenseReport) ? $expenseReport->id : '')" />
            <div class="p-5 bg-white rounded-5 w-full mb-5 divide-y divide-slate-300">
                <div class="flex py-5 mb-5">
                    <x-svg.payment
                        class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ isset($expenseReport) ? 'Edit Expense Report' : 'New Expense Report' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid md:w-1/2 gap-10 overflow-hidden">
                        <div class="flex flex-col md:flex-row md:gap-6 gap-12">
                            <!-- Expense Report date-->
                            <div class="md:w-1/2 w-full field">
                                <x-label for="from_date" :value="__('Date From')" />
                                <x-input id="from_date" class="mt-1 block w-full" type="date" name="from_date"
                                    :value="isset($expenseReport)
                                        ?  carbon::parse($expenseReport->from_date)->format('Y-m-d')
                                        : Carbon::now()
                                            ->startOfMonth()
                                            ->format('Y-m-d')" required />
                            </div>
                            <!-- Expense Report date-->
                            <div class="md:w-1/2 w-full field">
                                <x-label for="to_date" :value="__('Date To')" />
                                <x-input id="to_date" class="mt-1 block w-full" type="date" name="to_date"
                                    :value="isset($expenseReport)
                                        ? carbon::parse($expenseReport->to_date)->format('Y-m-d')
                                        : Carbon::now()
                                            ->endOfMonth()
                                            ->format('Y-m-d')" required/>
                            </div>
                        </div>

                        <!-- Expense Report user -->
                        <div class="w-full field">
                            <x-label for="user" :value="__('Expense Report by user:')" />
                            <div class="flex gap-1">
                                <x-select id="user"
                                    class="mt-1 block w-full select2-users overfllow-y-auto shadow-md" name="user_id"
                                    placeholder="Select the user" required>
                                    @if (isset($expenseReport))
                                        <option value="{{ $expenseReport->user_id }}" selected>
                                            {{ $expenseReport->user->firstname }} {{ $expenseReport->user->surname }}</option>
                                    @endif
                                </x-select>
                                <a href="{{ route('users.create', ['backtourl' => route('expense-reports.create')]) }}"
                                    class="bg-white rounded outline outline-offset-1 outline-blue-500 text-center flex items-center px-5">
                                    <i class="fa fa-plus text-gray-600"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Expense Report user -->
                        <div class="w-full field">
                            <x-label for="approval_user_id" :value="__('User responsible for approval:')" />
                            <div class="flex gap-1">
                                <x-select id="approval_user_id"
                                    class="mt-1 block w-full select2-approval-users overfllow-y-auto shadow-md"
                                    name="approval_user_id" placeholder="Select the user" required>
                                    @if (isset($expenseReport))
                                        <option value="{{ $expenseReport->approval_user_id }}" selected>
                                            {{ $expenseReport->approvalUser->firstname }}
                                            {{ $expenseReport->approvalUser->surname }}
                                        </option>
                                    @endif
                                </x-select>
                                <a href="{{ route('users.create', ['backtourl' => route('expense-reports.create')]) }}"
                                    class="bg-white rounded outline outline-offset-1 outline-blue-500 text-center flex items-center px-5">
                                    <i class="fa fa-plus text-gray-600"></i>
                                </a>
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
                            @if (isset($expenseReport))
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                                <x-a-button-w href="{{ route('expense-reports.show', ['expense_report' => $expenseReport->id]) }}"
                                    class="ml-3 py-3.5 shadow-md">
                                    {{ __('View Details') }}
                                </x-a-button-w>

                                <x-a-button href="{{ route('expense-reports.show', ['expense_report' => $expenseReport->id]) }}"
                                    class="ml-3 py-3.5 shadow-md">
                                    {{ __('Cancel') }}
                                </x-a-button>
                            @else
                                <x-button-p class="ml-3 py-3.5 item-end">
                                    {{ __('Create a Report') }}
                                </x-button-p>
                                <x-a-button href="{{ route('expense-reports.index') }}" class="ml-3 py-3.5 shadow-md">
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
