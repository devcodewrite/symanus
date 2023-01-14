<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Reporting', 'url' => route('reporting.student-balances')],
            ['title' => 'Student Balances', 'url' => route('reporting.student-balances')],
        ]" />
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
                    <nav class="flex space-x-4" aria-label="Tabs" role="tablist">
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black active"
                            id="basic-tabs-item-1" data-hs-tab="#basic-tabs-1" aria-controls="basic-tabs-1"
                            role="tab">
                            Reporting Student Balances
                        </button>
                    </nav>
                </div>

                <div class="mt-3 p-5">
                    <div class="divide-y divide-slate-300 flex flex-col gap-8" id="basic-tabs-1" role="tabpanel"
                        aria-labelledby="basic-tabs-item-1">
                        <form class="grid grid-cols-1 md:grid-cols-2 gap-5 w-full" action="{{ route('reporting.student-balances') }}"
                            method="GET">
                            <div class="grid grid-cols-2 md:grid-cols-3 items-center w-full">
                                <span class="text-gray-400 md:col-span-1 w-full">Reporting name </span>
                                <span class="md:col-span-2 w-full">Student Balances Report</span>
                            </div>

                            <div class="grid grid-cols-1 row-start-2 md:grid-cols-3 items-center">
                                <span class="text-gray-400 col-span-1">Reporting for class </span>
                                <div class="col-span-2">
                                    <x-select id="class" class="mt-1 block w-full select2-class" name="class_id"
                                        required>
                                        @if ($class)
                                            <option value="{{ $class->id }}" selected>
                                                {{ $class->name }} </option>
                                        @endif
                                    </x-select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 row-start-3 md:grid-cols-3 justify-start items-center">
                                <span class="text-gray-400 col-span-1">Reporting period </span>
                                <div class="flex gap-3 w-full md:flex-row flex-col col-span-2">
                                    <div class="md:w-1/2">
                                        <x-label for="report-from">From:</x-label>
                                        <x-input id="report-from" type="date" name="report_from"
                                            value="{{ isset($reportFrom)?$reportFrom: now()->toDateString() }}" />
                                    </div>
                                    <div class="md:w-1/2">
                                        <x-label for="report-to">To: </x-label>
                                        <x-input id="report-to" type="date" name="report_to"
                                            value="{{ isset($reportTo)?$reportTo: now()->toDateString() }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row-start-4  md:row-start-3 self-end">
                                <x-button-p class="ml-3 py-3.5">
                                    {{ __('Generate') }}
                                </x-button-p>
                            </div>
                        </form>
                        <main class="p-5">
                            <table class="dt-report-student-balances display w-full">
                                <thead class="uppercase">
                                    <tr>
                                        <th>Student</th>
                                        @php
                                            $totalCols = [];
                                            $grandTotal = 0;
                                        @endphp

                                        @foreach ($feeTypes as $key => $row)
                                            @php
                                                $totalCols[$key] = 0;
                                            @endphp
                                            <th>{{ $row->title }} </th>
                                        @endforeach
                                        <th class="text-center">Row Total</th>
                                    </tr>
                                </thead>
                            <tbody>
                                @foreach ($students as $key => $rRow)
                                    <tr>
                                        <th>
                                            {{ $rRow->firstname }}
                                            {{ $rRow->surname }}
                                        </th>
                                        @php
                                            $totalRow = 0;
                                        @endphp
                                        @foreach ($feeTypes as $key => $row)
                                            @php
                                                $colVal = $rRow->getBalance($row, $reportFrom, $reportTo);
                                                $totalCols[$key] += $colVal;
                                                $totalRow += $colVal;
                                                $grandTotal += $colVal;
                                            @endphp
                                            <td>{{ number_format($colVal,2) }} </td>
                                        @endforeach
                                        <td>
                                            {{ __('GHS') }} {{ number_format($totalRow,2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="uppercase text-center">
                                    <th> Total</th>
                                @foreach ($totalCols as $key => $val)
                                    <th>{{ number_format($val,2) }} </th>
                                @endforeach
                                <th>{{ __('GHS') }} {{  number_format($grandTotal,2) }} </th>
                                </tr>
                            </tfoot>
                        </table>
                        </main>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{ asset('js/reporting/student-balances.js') }} " defer></script>
    @endsection

</x-app-layout>
