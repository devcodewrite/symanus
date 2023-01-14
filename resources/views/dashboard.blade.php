<x-app-layout>
    @section('breadcrumb')
        <x-breadcrumb :items="[['title' => 'Dashboard', 'url' => route('dashboard')]]" />
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
                <x-overview-card title="Users" :items="[['label'=>'Open', 'num' => $user->where(['rstate' => 'open'])->count(), 'url'=>url('users'), 'tooltip' =>'Users opened']]">
                    <x-slot name="icon">
                        <svg class="mt-1 shrink-0 w-8 h-8 text-gray-800 dark:text-gray-200"
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
                        </svg>
                    </x-slot>
                </x-overview-card>
                <x-overview-card title="Students" :items="[['label' => 'Open', 'num' => $student->where(['rstate' => 'open'])->count(), 'url'=>url('students')]]">
                    <x-slot name="icon">
                        <svg class="mt-1 shrink-0 w-5 h-5 text-gray-800 dark:text-gray-200"
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M5.5 2A3.5 3.5 0 0 0 2 5.5v5A3.5 3.5 0 0 0 5.5 14h5a3.5 3.5 0 0 0 3.5-3.5V8a.5.5 0 0 1 1 0v2.5a4.5 4.5 0 0 1-4.5 4.5h-5A4.5 4.5 0 0 1 1 10.5v-5A4.5 4.5 0 0 1 5.5 1H8a.5.5 0 0 1 0 1H5.5z" />
                            <path d="M16 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        </svg>
                    </x-slot>
                </x-overview-card>

            <x-overview-card title="Staffs"  :items="[['label' => 'Open', 'num' => $staff->where(['rstate' => 'open'])->count(), 'url'=>url('staffs')] ]" >
                <x-slot name="icon">
                    <svg class="mt-1 shrink-0 w-5 h-5 text-gray-800 dark:text-gray-200"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M8.47 1.318a1 1 0 0 0-.94 0l-6 3.2A1 1 0 0 0 1 5.4v.817l5.75 3.45L8 8.917l1.25.75L15 6.217V5.4a1 1 0 0 0-.53-.882l-6-3.2ZM15 7.383l-4.778 2.867L15 13.117V7.383Zm-.035 6.88L8 10.082l-6.965 4.18A1 1 0 0 0 2 15h12a1 1 0 0 0 .965-.738ZM1 13.116l4.778-2.867L1 7.383v5.734ZM7.059.435a2 2 0 0 1 1.882 0l6 3.2A2 2 0 0 1 16 5.4V14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5.4a2 2 0 0 1 1.059-1.765l6-3.2Z" />
                    </svg>
                </x-slot>
            </x-overview-card>

            </div>
            <!-- End Grid -->
        </div>
        <!-- End Card Section -->
        <!-- End Page Heading -->
    </div>
    <!-- End Content -->
</x-app-layout>
