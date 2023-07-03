@props(['key' => null, 'label' => null, 'value' => '', 'class' => ''])

<div class="flex flex-row gap-2 p-2{{ $label ? ' pl-4' : '' }}{{ $class ? ' '.$class : ''}}">
    @if($label)
        <div class="flex flex-row items-center w-1/4">
            @if($key)
                <label class="w-full" for="ipt--{{ $key }}">{{ $label }}</label>
            @else
                <span class="w-full">{{ $label }}</span>
            @endif
        </div>
        <div class="flex flew-row items-center w-3/4">
            @if($key)
                <input id="ipt--{{ $key }}" class="bm-input w-full p-2" name="data[{{ $key }}]" value="{{ $value }}">
            @else
                {{ $slot }}
            @endif
        </div>
    @else
        {{ $slot }}
    @endif
</div>
