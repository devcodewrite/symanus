<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{asset('plugins/validator/fv.css')}}">
    @endsection
    @section('breadcrumb')
        <x-breadcrumb :items="[
            ['title' => 'Top-up SMS', 'url' => route('sms.create')],
        ]" />
        <a href="{{ route('sms.index') }}" class="flex items-center hover:text-sky-600">
            <x-svg.arrow-left-next class="flex-shrink-0 mx-2 overflow-visible h-2.5 w-2.5 hover:text-sky-600 text-gray-600 dark:text-gray-200" />
            {{ __('back to list') }}
        </a>
    @endsection
    <!-- Content -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:pl-72 py-5 divide-y divide-slate-300">
        <form novalidate class="sms-edit-form mb-5" action="{{ route('sms.store') }} " data-redirect-url="{{route('sms.index') }}">
            @csrf
            @method('post')
            <div class="p-5 bg-white rounded-5 w-full mb-5">
                <div class="flex py-5 mb-5">
                    <x-svg.class class="flex-shrink-0 mx-3 overflow-visible h-5 w-5 text-gray-400 dark:text-gray-600" />
                    <h5 class="text-cyan-600">{{ 'Amount SMS' }}</h5>
                </div>
                <div class="w-full">
                    <div aria-label="formbody" class="mt-6 px-6 py-4 grid md:grid-cols-3 gap-5 overflow-hidden">
                        <!-- SMS Amount -->
                        <div class="w-full field">
                            <x-label for="amount" :value="__('SMS Amount')" />
                            <x-input id="amount" class="mt-1 block w-full form-control" type="number" name="amount" autofocus placeholder="Enter the {{ __('SMS Amount') }}"
                            onkeyup="$('#units').val(Math.round(this.value/{{config('app.sms_charge')}}))" step=".10" min="10" required/>
                        </div>

                         <!-- SMS Amount -->
                         <div class="w-full field">
                            <x-label for="units" :value="__('SMS Units')" />
                            <x-input id="units" class="mt-1 block w-full form-control" type="number" name="units" placeholder="0.00" readonly
                            required/>
                        </div>

                          <!-- User Email -->
                          <div class="w-full field">
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" class="mt-1 block w-full" type="email" name="email"
                                :value="auth()->user()->email" placeholder="Enter the {{ __('Email') }}" />
                        </div>

                    </div>
                    <div aria-label="form-footer" class="flex flex-col md:flex-row gap-5 items-center justify-between mt-4">
                        <div class="flex lex-row gap-3">
                                <x-button-p class="ml-3 py-3.5">
                                    {{ __('Top-Up SMS') }}
                                </x-button-p>
                        </div>
                    </div>
                </div>
        </form>
        <div class="p-5">
            <table class="dt-credits display w-full">
                <thead class="uppercase">
                    <tr class="border">
                        <th class="w-5">Ref#</th>
                        <th class="border text-center">Units</th>
                        <th class="border ">Amount</th>
                        <th class="border ">Updated Date</th>
                        <th class="border">Created Date</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($smsCredits as $key => $row)
                        <tr>
                            <td class="border text-center">{{ $row->ref }}</td>
                            <td class="border text-center">{{ $row->units }}</td>
                            <td class="border text-center">{{ $row->amount }}</td>
                            <td class="border text-center">{{ $row->updated_at }}</td>
                            <td class="border text-center">{{ $row->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- End Content -->
    @section('script')
        <script src="{{asset('plugins/validator/validator.js')}}" defer></script>
        <script src="{{asset('plugins/validator/multifield.js')}}" defer></script>
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script src="{{asset('js/sms/edit.js')}}" defer></script>
    @endsection
</x-app-layout>
