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
                <x-overview-card title="Billings"  :items="[
                ['label' => 'Generated Bills', 'num' => $bill->count(), 'url'=>route('bills.index')] ,
                ['label' => 'Awaiting Payments', 'num' => $bill->count() - $bill->paidCount()] 
                ]" >
                <x-slot name="icon">
                    <x-svg.reporting class="flex-shrink-0 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                </x-slot>
            </x-overview-card>

            <x-overview-card title="Fees"  :items="[
                ['label' => 'Open', 'num' => $fee->where(['rstatus' => 'open'])->count(), 'url'=>route('fees.index')] ,
                ['label' => 'Close', 'num' => $fee->where(['rstatus' => 'close'])->count(), 'url'=>route('fees.index')] 
                ]" >
                <x-slot name="icon">
                    <x-svg.payment class="flex-shrink-0 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                </x-slot>
            </x-overview-card>

                <x-overview-card title="Users" :items="[
                    ['label'=>'Open',  'num' => $user->where(['rstate' => 'open'])->count(),'url'=>route('users.index'),'tooltip' =>'Users opened'],
                    ['label'=>'Closed',  'num' => $user->where(['rstate' => 'close'])->count(), 'url'=>route('users.index'),'tooltip' =>'Users closed'],
                 ]">
                    <x-slot name="icon">
                        <x-svg.user class="h-8 w-8"  />
                    </x-slot>
                </x-overview-card>
                <x-overview-card title="Students" :items="[
                    ['label' => 'Open', 'num' => $student->where(['rstate' => 'open'])->count(), 'url'=>route('students.index')],
                    ['label' => 'Close', 'num' => $student->where(['rstate' => 'close'])->count(), 'url'=>route('students.index')]
                    ]">
                    <x-slot name="icon">
                      <x-svg.student class="h-8 w-8"  />
                    </x-slot>
                </x-overview-card>

            <x-overview-card title="Guardians"  :items="[
                ['label' => 'Open', 'num' => $guardian->where(['rstate' => 'open'])->count(), 'url'=>route('guardians.index')] ,
                ['label' => 'Close', 'num' => $guardian->where(['rstate' => 'close'])->count(), 'url'=>route('guardians.index')] 
                ]" >
                <x-slot name="icon">
                    <x-svg.guardian class="flex-shrink-0 overflow-visible h-8 w-8 text-gray-400 dark:text-gray-600" />
                </x-slot>
            </x-overview-card>

            <x-overview-card title="Classes"  :items="[
                ['label' => 'Total', 'num' => $class->count(), 'url'=>route('classes.index')] ,
                ]" >
                <x-slot name="icon">
                    <x-svg.class class="h-8 w-8" />
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
