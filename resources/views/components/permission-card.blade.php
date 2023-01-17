@props(['key', 'options', 'disabled' => false, 'permission'])

<h1>{{__(Str::headline($key)) }} </h1>
@if($key === 'is_admin')
<div class="flex gap-2 items-end py-3">
<x-label for="yes" value="Yes" />
<x-input id="yes" type="radio" name="{{$key}}" value="1" :checked="$options==1" :disabled="$permission->id===1||$permission->id===2" />
<x-label for="no" value="No" />
<x-input id="no" type="radio" name="{{$key}}" value="0"  :checked="$options==0" :disabled="$permission->id===1||$permission->id===2" />
</div>
@else
<div class="flex gap-2 flex-row col-span-2 items-end py-3">
    @foreach (['view', 'create', 'update', 'delete', 'report'] as $value)
        <x-label :value="Str::headline($value)" />
        <x-input type="checkbox" name="{{$key}}[]" :value="$value" :checked="in_array($value,explode(',', $options))" :disabled="$disabled||$permission->id===1||$permission->id===2" />
 @endforeach
</div>

@endif
