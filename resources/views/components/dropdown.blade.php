@props(['placement' => 'bottom-right', 'width' => '48', 'header' => ''])


<div class="hs-dropdown relative inline-flex [--placement:{{ $placement }}]">
   {{ $trigger }}
<div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-[15rem] bg-white shadow-md rounded-lg p-2 dark:bg-gray-800 dark:border dark:border-gray-700"
aria-labelledby="hs-dropdown-with-header">
{{ $header }}
<div class="mt-2 py-2 first:pt-0 last:pb-0">
    {{ $slot }}
</div>
</div>
</div>