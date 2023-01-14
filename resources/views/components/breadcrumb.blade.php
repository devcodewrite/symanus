 @props(['items' => [] ])
 <!-- Breadcrumb -->
 <ol class="flex items-center whitespace-nowrap min-w-0" aria-label="Breadcrumb">
    @foreach($items as $i => $item)
        @if($i === sizeof($items) - 1)
            <li class="text-sm font-semibold text-gray-400 truncate dark:text-gray-200" aria-current="page">
                {{ $item['title'] }}
            </li>
        @else
            <li class="flex items-center text-sm text-gray-800 dark:text-gray-400">
                @if($item['url'] && sizeof($items) > 1)
                    <a href="{{ $item['url'] }} " class="text-sm text-gray-800 dark:text-gray-400 hover:text-blue-600" >{{ $item['title'] }} </a>
                @else
                    {{ $item['title'] }}
                @endif
                
            </li>
            <x-svg.arrow-right />
        @endif
    @endforeach
</ol>
<!-- End Breadcrumb -->