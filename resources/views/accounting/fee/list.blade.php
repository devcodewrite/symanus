<x-app-layout>
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Fees', 'url' => route('fees.index')],
            ['title' => 'Fee List', 'url' => route('fees.index')],
        ]" />
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <div class="p-5 bg-white rounded-5 w-full divide-y divide-slate-300">
            <div class="flex flex-col md:flex-row items-center justify-between mb-3">
                <div class="flex py-5">
                    <x-svg.class
                        class="svg-icon-class flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600 uppercase">List of Fees</h5>
                </div>
                <!-- Actions -->
                    <div class="dt-action" data-dt="dt-fees">
                        <x-select class="dt-action-select w-40" name="action">
                            <option value="">--Select action--</option>
                            <option value="delete">
                                <i class="fa fa-trash"></i> Delete
                            </option>
                        </x-select>

                        <x-button class="dt-action-btn ml-1" data-target-url="{{ url('api/datatable-actions/fees') }}" disabled>{{__('Confirm')}} </x-button>
                    </div>
                <x-a-button-p class="ml-3 mt-3 md:mt-0" :href="route('fees.create')">
                    <x-svg.add />
                    {{ __('New Fee') }}
                </x-a-button-p>
            </div>
            <div class="pt-5">
                <p class="alert-processing">Processing...</p>
                <table class="dt-fees hidden display w-full">
                    <thead class="uppercase">
                        <tr>
                            <th class="w-5"></th>
                            <th class="w-5">#</th>
                            <th>Amount</th>
                            <th>Class</th>
                            <th>Fee Type</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Updated Date</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{ asset('js/fee/list.js') }} " defer></script>
    @endsection
</x-app-layout>
