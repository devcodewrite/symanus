<x-app-layout>
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Modules', 'url' => route('modules.index')],
            ['title' => 'Class List', 'url' => route('modules.index')],
        ]" />
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <div class="p-5 bg-white rounded-5 w-full divide-y divide-slate-300">
            <div class="flex flex-col md:flex-row items-center justify-between mb-3">
                <div class="flex py-5">
                    <x-svg.class
                        class="svg-icon-class flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600 uppercase">List of Modules</h5>
                </div>
            </div>
            <div class=" gap-5 grid grid-cols-1 md:grid-cols-3 py-5">
                @foreach($modules as $key => $module)
                    <x-module :module="$module" ></x-module>
                @endforeach
            </div>
        </div>
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{ asset('js/module/edit.js') }} " defer></script>
    @endsection
</x-app-layout>
