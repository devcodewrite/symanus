@php
    use Illuminate\Support\Carbon;
@endphp
<x-app-layout>
    @section('breadcrumb')
        <x-breadcrumb :items="[['title' => 'Accounting Overview', 'url' => route('overview')]]" />
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72">
        <!-- Announcement Banner -->
        <div class="bg-gradient-to-r from-red-500 via-purple-400 to-blue-500 my-5">
            <div class="max-w-[85rem] px-4 py-4 sm:px-6 lg:px-8 mx-auto">
                <!-- Grid -->
                <div class="grid justify-center md:grid-cols-2 md:justify-between md:items-center gap-2">
                    <div class="text-center md:text-left">
                        <p class=" text-white font-bold uppercase tracking-wider">
                            Welcome back! {{ Auth::user()->firstname }} {{ Auth::user()->surname }}
                        </p>
                        <p class="mt-1 text-xs text-white font-medium">
                            Is {{ $setting->getValue('app_name') }} useful to your organisation? Share to friends in
                            other school Now
                        </p>
                    </div>
                    <!-- End Col -->

                    <div class="mt-3 text-center md:text-left md:flex md:justify-end md:items-center">
                        <a class="py-3 px-6 inline-flex justify-center items-center gap-2 rounded-full font-medium bg-red-100 text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm"
                            href="#">
                            Share Now
                        </a>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Grid -->
            </div>
        </div>
        <!-- End Announcement Banner -->
        <!-- Card Section -->
        <div class="max-w-5xl px-4 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6">
                @php
                    $totalBillPayments = 0;
                    $totalBillExpected = 0;
                    foreach ($bill->where('bdate', date('Y-m-d'))->get() as $bill) {
                        $totalBillPayments += $bill->totalPayment();
                        $totalBillExpected += $bill->totalBill();
                    }
                    
                @endphp
                @if (Gate::inspect('viewAny', $bill)->allowed())
                    <x-overview-card title="Today's Income" :items="[
                        [
                            'label' => 'Total Expected',
                            'num' => number_format($totalBillExpected,2),
                        ],
                        [
                            'label' => 'Total Payments',
                            'num' => number_format($totalBillPayments,2),
                        ],
                        [
                            'label' => 'Overall Amount',
                            'num' => number_format($payment->where('paid_at', date('Y-m-d'))->sum('amount'),2),
                        ],
                    ]">
                        <x-slot name="icon">
                            <x-svg.reporting
                                class="flex-shrink-0 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                        </x-slot>
                    </x-overview-card>
                @endif

                @if (Gate::inspect('viewAny', $bill)->allowed())
                    <x-overview-card title="Today's Advances" :items="[
                        [
                            'label' => 'Total Amount',
                            'num' => number_format($advancePayment->where('paid_at', date('Y-m-d'))->sum('amount'),2),
                        ],
                    ]">
                        <x-slot name="icon">
                            <x-svg.reporting
                                class="flex-shrink-0 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                        </x-slot>
                    </x-overview-card>
                @endif

                @if (Gate::inspect('viewAny', $bill)->allowed())
                <x-overview-card title="Today's Expenses" :items="[
                    [
                        'label' => 'Total Amount',
                        'num' => '0.00',
                        'url' => route('expense-reports.index'),
                    ],
                ]">
                    <x-slot name="icon">
                        <x-svg.reporting
                            class="flex-shrink-0 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                    </x-slot>
                </x-overview-card>
            @endif

                @if (Gate::inspect('viewAny', $bill)->allowed())
                    <x-overview-card title="Today's Billings" :items="[
                        [
                            'label' => 'Generated Bills',
                            'num' => $bill->where('bdate', date('Y-m-d'))->count(),
                            'url' => route('bills.index'),
                        ],
                        [
                            'label' => 'Awaiting Payments',
                            'num' =>
                                $bill->where('bdate', date('Y-m-d'))->count() - $bill->paidCountByDate(date('Y-m-d')),
                        ],
                    ]">
                        <x-slot name="icon">
                            <x-svg.reporting
                                class="flex-shrink-0 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                        </x-slot>
                    </x-overview-card>
                @endif

                @if (Gate::inspect('viewAny', $attendance)->allowed())
                    <x-overview-card title="Today's Attendances" :items="[
                        [
                            'label' => 'Draft',
                            'num' => $attendance->where(['status' => 'draft', 'adate' => date('Y-m-d')])->count(),
                            'url' => route('attendances.index'),
                        ],
                        [
                            'label' => 'Awaiting Approval',
                            'num' => $attendance->where(['status' => 'submitted', 'adate' => date('Y-m-d')])->count(),
                            'url' => route('attendances.index'),
                        ],
                        [
                            'label' => 'Approved',
                            'num' => $attendance->where(['status' => 'approved', 'adate' => date('Y-m-d')])->count(),
                            'url' => route('attendances.index'),
                        ],
                        [
                            'label' => 'Rejected',
                            'num' => $attendance->where(['status' => 'rejected', 'adate' => date('Y-m-d')])->count(),
                            'url' => route('attendances.index'),
                        ],
                    ]">
                        <x-slot name="icon">
                            <x-svg.attendance
                                class="flex-shrink-0 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                        </x-slot>
                    </x-overview-card>
                @endif
                @if (Gate::inspect('viewAny', $sms)->allowed())
                    <x-overview-card title="Today's SMS" :items="[['label' => 'Sent', 'num' => 0]]">
                        <x-slot name="icon">
                            <x-svg.sms class="h-8 w-8" />
                        </x-slot>
                    </x-overview-card>
                @endif
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Card Section -->
        <!-- End Page Heading -->
    </div>
    <!-- End Content -->
</x-app-layout>
