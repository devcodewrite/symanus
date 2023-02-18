<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Reporting', 'url' => route('reporting.student-list')],
            ['title' => 'Student List', 'url' => route('reporting.student-list')],
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
                            Reporting Student List
                        </button>
                    </nav>
                </div>

                <div class="mt-3 p-5">
                    <div class="divide-y divide-slate-300 flex flex-col gap-8" id="basic-tabs-1" role="tabpanel"
                        aria-labelledby="basic-tabs-item-1">
                        <form class="grid grid-cols-1 md:grid-cols-2 gap-5 w-full"
                            action="{{ route('reporting.student-list') }}" method="GET">
                            <div class="grid grid-cols-2 md:grid-cols-3 items-center w-full">
                                <span class="text-gray-400 md:col-span-1 w-full">Reporting name </span>
                                <span class="md:col-span-2 w-full">Student List Report</span>
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
                            <div class="grid grid-cols-1 row-start-2 md:grid-cols-3 items-center">
                                <span class="text-gray-400 col-span-1">Reporting for sex </span>
                                <div class="col-span-2">
                                    <x-select id="sex" class="block w-full select2-sex" name="sex"
                                        placeholder="Select the sex">
                                        <option value="">Select a sex</option>
                                        <option value="male"
                                            {{ isset($sex) ? ($sex === 'male' ? 'selected' : '') : '' }}>
                                            Male
                                        </option>
                                        <option value="female"
                                            {{ isset($sex) ? ($sex === 'female' ? 'selected' : '') : '' }}>
                                            Female</option>
                                        <option value="other"
                                            {{ isset($sex) ? ($sex === 'other' ? 'selected' : '') : '' }}>
                                            Other
                                        </option>
                                    </x-select>
                                </div>
                            </div>
                            <!-- Transit -->

                            <div class="grid grid-cols-1 row-start-3 md:grid-cols-3 items-center">
                                <span class="text-gray-400 col-span-1">Reporting for transit </span>
                                <div class="col-span-2">
                                    <x-select id="transit" class="block w-full select2-transit" name="transit"
                                        placeholder="Select a transit">
                                        <option value="">Select a transit</option>
                                        <option value="walk"
                                            {{ isset($transit) ? ($transit === 'walk' ? 'selected' : '') : '' }}>
                                            Walk to
                                            school</option>
                                        <option value="bus"
                                            {{ isset($transit) ? ($transit === 'bus' ? 'selected' : '') : '' }}>
                                            Take
                                            school bus</option>
                                    </x-select>
                                </div>
                            </div>

                            <!-- Affiliation -->
                            <div class="grid grid-cols-1 row-start-3 md:grid-cols-3 items-center">
                                <span class="text-gray-400 col-span-1">Reporting for affiliation </span>
                                <div class="col-span-2">
                                    <x-select id="affiliation" class="block w-full select2-affiliation"
                                        name="affiliation" placeholder="Select an affiliation">
                                        <option value="">Select an affiliation</option>
                                        <option value="staffed"
                                            {{ isset($affiliation) ? ($affiliation === 'staffed' ? 'selected' : '') : '' }}>
                                            Staffed</option>
                                        <option value="non-staffed"
                                            {{ isset($affiliation) ? ($affiliation === 'non-staffed' ? 'selected' : '') : '' }}>
                                            Non Staffed
                                        </option>
                                    </x-select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 row-start-4 md:grid-cols-3 justify-start items-center">
                                <span class="text-gray-400 col-span-1">Reporting admission date </span>
                                <div class="flex gap-3 w-full md:flex-row flex-col col-span-2">
                                    <div class="md:w-1/2">
                                        <x-label for="report-from">From:</x-label>
                                        <x-input id="report-from" type="date" name="report_from"
                                            value="{{ isset($reportFrom) ? $reportFrom : '' }}" />
                                    </div>
                                    <div class="md:w-1/2">
                                        <x-label for="report-to">To: </x-label>
                                        <x-input id="report-to" type="date" name="report_to"
                                            value="{{ isset($reportTo) ? $reportTo : '' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row-start-5  md:row-start-4 self-end">
                                <x-button-p class="ml-3 py-3.5">
                                    {{ __('Generate') }}
                                </x-button-p>
                                <x-a-button-w href="{{ route('reporting.student-list') }}" class="ml-3 py-3.5">
                                    {{ __('Reset') }}
                                    </x-button-w>
                            </div>
                        </form>
                        <main class="p-5">
                            <div class="row">
                                <div class="col-12 mb-5">
                                    <x-button-p class="ml-3 py-3.5 print">
                                        {{ __('Print') }}
                                    </x-button-p>
                                </div>
                            </div>
                            <div class="student-list pb-5">
                                <table class="w-full my-8">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <h2 class="uppercase text-center font-bold text-xl">Student List Report
                                                </h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="flex flex-col items-start">
                                                    <div class="px-6">
                                                        <x-app-logo imgSize="ls" appName="" />
                                                    </div>
                                                </span>
                                                <p class="uppercase font-semibold text-lg pl-6">
                                                    {{ $setting->getValue('school_name', 'SYMANUS') }}
                                                </p>
                                                <p class="text-sm pl-6">
                                                    Address:<span>{{ $setting->getValue('school_address', 'Atonsu S-Line') }}</span>
                                                    | Contact:
                                                    <span>{{ $setting->getValue('school_phone', '0246092155') }}</span>
                                                </p>
                                            </td>
                                            <td class="text-right">
                                                <p>
                                                    <span class="font-semibold">Date:</span>
                                                    <span>
                                                        {{ date('d/m/y') }}
                                                    </span>
                                                </p>
                                               <p>
                                                <span class="font-semibold">Reporting for :</span>
                                                    <span>
                                                        {{ isset($class)?$class->name:'' }}
                                                    </span>
                                               </p>
                                               <p>
                                                <span class="font-semibold">Peroid :</span>
                                                    <span>
                                                        {{ isset($reportFrom) ?  date('d/m/y',strtotime($reportFrom)) : '' }}
                                                    </span>
                                                    -
                                                    <span>
                                                        {{ isset($reportTo) ? date('d/m/y',strtotime($reportTo)) : '' }}
                                                    </span>
                                               </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table display w-full"
                                    data-title="{{ isset($students) ? Str::of('Reporting for Student Balances')->headline() : '' }}"
                                    data-subtitle=`{{ isset($students) ? "$reportFrom to $reportTo" : '' }}`>
                                    <thead class="uppercase">
                                        <tr class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <th>#</th>
                                            <th class="text-center">Photo</th>
                                            <th class="text-left">First Name</th>
                                            <th class="text-left">Surname</th>
                                            <th class="text-left">Sex</th>
                                            <th class="text-left">Affiliation</th>
                                            <th class="text-left">Transit</th>
                                            <th class="text-left">Guardian Name</th>
                                            <th class="text-left">Guardian Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($students))
                                            @foreach ($students as $key => $rRow)
                                                <tr class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                    <td><?= $key + 1 ?></td>
                                                    <td>
                                                        <span class="flex flex-col items-center">
                                                            <img class="h-10" src="{{ $rRow->getAvatar() }}"
                                                                alt="Student Photo">
                                                        </span>
                                                        <p class="text-gray-600 whitespace-no-wrap text-center">
                                                            {{ $rRow->studentid }}</p>
                                                    </td>

                                                    <td class="text-left uppercase">
                                                        {{ $rRow->firstname }}
                                                    </td>
                                                    <td class="text-left uppercase">
                                                        {{ $rRow->surname }}
                                                    </td>
                                                    <td class="uppercase">
                                                        {{ $rRow->sex }}
                                                    </td>
                                                    <td class="uppercase">
                                                        {{ $rRow->affiliation }}
                                                    </td>
                                                    <td class="uppercase">
                                                        {{ $rRow->transit }}
                                                    </td>
                                                    <td>
                                                        {{ $rRow->guardian ? $rRow->guardian->firstname : '' }}
                                                        {{ $rRow->guardian ? $rRow->guardian->surname : '' }}
                                                    </td>
                                                    <td>
                                                        {{ $rRow->guardian ? $rRow->guardian->phone : '' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row  mt-5">
                                <div class="col-12">
                                    <x-button-p class="ml-3 py-3.5 print float-right">
                                        {{ __('Print') }}
                                    </x-button-p>
                                </div>
                            </div>
                        </main>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{ asset('js/reporting/student-list.js') }} " defer></script>
    @endsection

</x-app-layout>
