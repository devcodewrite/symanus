<x-app-layout>
    @section('style')
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Settings', 'url' => route('classes.index')],
            ['title' => 'Setting Details', 'url' => route('classes.show', ['class' => $class->id])],
        ]" />
        <a href="{{ route('classes.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
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
                    <nav class="flex space-x-4" aria-label="Tabs" role="tablist">
                        <button type="button"
                            class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-black active"
                            id="basic-tabs-item-1" data-hs-tab="#basic-tabs-1" aria-controls="basic-tabs-1"
                            role="tab">
                            General Settings
                        </button>
                    </nav>
                </div>
                <div class="mt-3 p-5">
                    <div class="divide-y divide-slate-300" id="basic-tabs-1" role="tabpanel" aria-labelledby="basic-tabs-item-1">
                        <table class="p-5">
                            <tbody>
                                <tr>
                                    <th style="width: 100px;">School Name:</th>
                                    <td><a href="#" id="schoolname" data-type="text" data-name="school_name" data-pk="1"></a></td>
                                </tr>
                                <tr>
                                    <th>School Logo Url:</th>
                                    <td><a href="#" id="schoollogo" data-type="url" data-name="school_logo_url" data-pk="1"></a></td>
                                </tr>
                                <tr>
                                    <th>School Location:</th>
                                    <td><a href="#" id="schoollocation" data-type="text" data-name="school_location" data-pk="1"></a></td>
                                </tr>
                                <tr>
                                    <th>School Email:</th>
                                    <td><a href="#" id="schoolemail" data-type="email" data-name="school_email" data-pk="1"></a></td>
                                </tr>
                                <tr>
                                    <th>School Tel:</th>
                                    <td><a href="#" id="schooltel" data-type="tel" data-name="school_tel" data-pk="1"></a></td>
                                </tr>
                                <tr>
                                    <th>School Mobile :</th>
                                    <td><a href="#" id="schoolmobile" data-type="tel" data-name="school_phone" data-pk="1"><?= $this->setting->getValue('school_phone'); ?></a></td>
                                </tr>

                                <tr>
                                    <th>Max Levels :</th>
                                    <td><a href="#" id="maxlevels" data-type="number" data-name="levels" data-pk="1"><?= $this->setting->getValue('levels'); ?></a></td>
                                </tr>

                                <tr>
                                    <th>leave letter to :</th>
                                    <td><a href="#" id="leaveletterto" data-type="text" data-name="leave_letter_to" data-pk="1"><?= $this->setting->getValue('leave_letter_to'); ?></a></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="py-5">
                            <x-a-button-p class="ml-3 py-3.5 item-end">
                                {{ __('Save Changes') }}
                            </x-a-button-p>
                        </div>
                    </div>
                    <div id="basic-tabs-2" class="hidden" role="tabpanel" aria-labelledby="basic-tabs-item-2">
                        <p class="text-gray-500 dark:text-gray-400">
                            This is the <em class="font-semibold text-gray-800 dark:text-gray-200">second</em>
                            item's tab body.
                        </p>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

    <!-- End Content -->
    @section('script')
    <script src="{{ asset('js/class/related-students.js') }} " defer></script>
    @endsection

</x-app-layout>
