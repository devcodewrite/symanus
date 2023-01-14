  @props(['title', 'items' => [], 'icon' => ''])
  <!-- Card -->
  <div class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md transition dark:bg-slate-900 dark:border-gray-800">
    <div class="p-4 md:p-5">
        <div class="flex items-center">
            {{ $icon }}
            <div class="ml-5">
                <h3 class="font-semibold text-gray-800 dark:group-hover:text-gray-400 dark:text-gray-200 uppercase">
                    {{ $title }}
                </h3>
                @foreach($items as $item)
                <div class="flex flex-row items-center">
                    <a href="{{ isset($item['url'])? $item['url']:'javascript:;' }}" class="mr-2 text-blue-600">{{$item['label'] }}</a>
                    @if(isset($item['tooltip']))
                        <div class="hs-tooltip inline-block [--trigger:hover] [--placement:right]">
                            <a class="hs-tooltip-toggle inline text-center" href="javascript:;">
                            <span class="text-sm px-1 rounded-md bg-gray-100 border border-white/[.3] shadow-md shadow-gray-800/[.05] hover:bg-white hover:border-white hover:text-blue-600 hover:shadow-gray-800/[.1] transition">
                                {{ $item['num'] }}
                            </span>
                            <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-3 px-4 bg-white border text-sm text-gray-600 rounded-md shadow-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400" role="tooltip">
                               {{ $item['tooltip'] }}
                            </div>
                            </a>
                        </div>
                    @else
                    <span class="text-sm px-1 rounded-md bg-gray-100 border border-white/[.3] shadow-md shadow-gray-800/[.05]">
                        {{ $item['num'] }}
                    </span>
                    @endif
                </div>
                @endforeach
                
            </div>
        </div>
    </div>
</div>
<!-- End Card -->
