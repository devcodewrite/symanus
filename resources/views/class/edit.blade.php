@php
use App\Models\Setting;
@endphp
<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{asset('plugins/validator/fv.css')}}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Calsses', 'url' => route('classes.index')],
            ['title' => 'Calss List', 'url' => route('classes.index')],
            isset($class)?['title' => 'Edit Calss', 'url' => route('classes.edit',['class' => $class->id])]:['title' => 'New Calss', 'url' => route('classes.create')],
        ]" />
        <a href="{{ route('classes.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5">
        <form novalidate class="class-details-form" action="{{ isset($class)?route('classes.update',['class' => $class->id]):route('classes.store') }} " data-redirect-url="{{route('classes.index') }}">
            @csrf
            @if(isset($class))
                @method('put')
            @else
                @method('post')
            @endif

            <x-input id="id" type="hidden" name="id" :value="old('id', isset($class)?$class->id:'')" />

            <div class="p-5 bg-white rounded-5 w-full mb-5 divide-y divide-slate-300">
                <div class="flex py-5 mb-5">
                    <x-svg.class class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ isset($class)?'Edit Calss':'New Calss' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid md:grid-cols-2 gap-12 overflow-hidden">
                        <!-- Calss Description -->
                        <div class="w-full field">
                            <x-label for="name" :value="__('Calss Name')" />
                            <x-input id="name" class="mt-1 block w-full" type="text" name="name"
                                :value="old('name', isset($class)?$class->name:'')" required autofocus placeholder="Enter the {{ __('Calss Name') }}" />
                        </div>
                        <!-- Calss level -->
                        <div class="w-full field">
                            <x-label for="level" :value="__('Calss level')" />
                            <x-select id="level" class="mt-1 w-full select2-level" name="level" required>
                                <option value=""></option>
                                @for ($i = 0; $i < (new Setting())->getValue('max_level',10); $i++)
                                    <option value="{{$i}}" {{ isset($class)?($class->level===$i?'selected':''):''}}>
                                    level {{ $i }} </option>
                                @endfor
                            </x-select>
                        </div>

                        <!-- Calss type -->
                        <div class="w-full">
                            <x-label for="user" :value="__('Assign To:')" />
                            <x-select id="user" class="mt-1 block w-full select2-users" name="user_id"
                                placeholder="Select the User">
                                @if(isset($class))
                                    <option value="{{ $class->user_id }} "  selected>
                                        {{ $class->user->firstname }} {{ $class->user->surname }} </option>
                                @endif
                            </x-select>
                        </div>
                    </div>
                  
                    <div aria-label="form-footer" class="flex flex-col md:flex-row gap-5 items-center justify-between mt-4">
                        <div class="float-left">
                            <label for="stay">Stay on page: </label>
                            <input class="form-checkbox p-2.5" type="checkbox" name="stay" id="stay">
                        </div>
                        <div class="flex lex-row gap-3">
                            @if(isset($class))
                                <x-button-p class="ml-3 py-3.5">
                                    {{ __('Save Changes') }}
                                </x-button-p>
                                <x-a-button-w :href="route('classes.show',['class' => $class->id])" class="ml-3 py-3.5 shadow-md">
                                    {{ __('View Details') }}
                                </x-a-button-w>
                            @else
                                <x-button-p class="ml-3 py-3.5">
                                    {{ __('Create a Calss') }}
                                </x-button-p>
                            @endif
                           
                            <x-a-button :href="route('classes.index')" class="ml-3 py-3.5 shadow-md">
                                {{ __('Cancel') }}
                            </x-a-button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{asset('plugins/validator/validator.js')}} " defer></script>
        <script src="{{asset('plugins/validator/multifield.js')}} " defer></script>
        <script src="{{asset('js/class/edit.js')}} " defer></script>
    @endsection

</x-app-layout>
