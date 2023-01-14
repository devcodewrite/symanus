@props(['module'])

<div class="h-36 flex shadow-md rounded-lg border">
    <span class="w-24 h-full bg-gray-100 flex rounded-l-lg border items-center justify-center"> 
        @if($module->icon)
            {{ $module->icon }}
        @else
        <i class="fa fa-info text-xl text-gray-600"></i>
        @endif
    </span>

    <div class="flex flex-col justify-between w-full">
        <div class="flex justify-between"> 
            <span class="font-bold text-sm p-1 uppercase"> {{ $module->name }} </span>
            <span> <i class="fa fa-info-circle text-gray-500 p-1"></i> </span>
        </div>
        <div class="text-gray-600 p-1">
            {{ Str::limit($module->description, 60, '...') }}
            
        </div>
        <div class="flex items-end justify-end p-1">
            <a href="javascript:;"><x-svg.setting class="h-8 mr-5" /></a>
            <form action="{{ route('modules.update', ['module' => $module->id])}}" method="POST" novalidate class="module-form">
                @csrf
                @method('put')
                <input type="hidden" name="id" value="{{ $module->id }} ">
            <label class="switch">
                @if($module->status === 'enabled')
                    <input type="hidden" name="status" value="disabled">
                @endif
                <input class="h-2" onchange="$(this).closest('form').submit()" type="checkbox" name="status" value="enabled"
                    {{ $module->status === 'enabled' ? 'checked' : '' }} {{ $module->locked?'disabled':'' }}>
                <span class="slider round" ></span>
            </label>
            </form>
        </div>
    </div>
</div>