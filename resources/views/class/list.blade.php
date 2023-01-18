<x-app-layout>
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Classes', 'url' => route('classes.index')],
            ['title' => 'Class List', 'url' => route('classes.index')],
        ]" />
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <div class="p-5 bg-white rounded-5 w-full divide-y divide-slate-300">
            <div class="flex flex-col md:flex-row items-center justify-between mb-3">
                <div class="flex py-5">
                    <x-svg.class
                        class="svg-icon-class flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600 uppercase">List of Classes</h5>
                </div>
                <!-- Actions -->
                    <div class="dt-action" data-dt="dt-classes">
                        <x-select class="dt-action-select w-40" name="action">
                            <option value="">--Select action--</option>
                            <option value="delete">
                                <i class="fa fa-trash"></i> Delete
                            </option>
                        </x-select>

                        <x-button class="dt-action-btn ml-1" data-target-url="{{ url('api/datatable-actions/classes') }}" disabled>{{__('Confirm')}} </x-button>
                    </div>
                <x-a-button-p class="ml-3 mt-3 md:mt-0" :href="route('classes.create')">
                    <x-svg.add />
                    {{ __('New Class') }}
                </x-a-button-p>
            </div>
            <div class="pt-5">
                <p class="alert-processing">Processing...</p>
                <div class="overflow-x-auto">
                <table class="dt-classes hidden display w-full">
                    <thead class="uppercase">
                        <tr>
                            <th class="w-5"></th>
                            <th class="w-5">#</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Assigned To</th>
                            <th>Updated Date</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
        </div>
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{ asset('js/class/list.js') }} " defer></script>
    @endsection
</x-app-layout>
