@props(['name' => '', 'label' => '', 'value' => null, 'error' => null, 'required' => false])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="uppercase-label mb-2 block">
            {{ $label }}
            @if($required)
                <span class="text-bauhaus-red">*</span>
            @endif
        </label>
    @endif
    
    <input 
        id="{{ $name }}"
        name="{{ $name }}"
        type="text"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-3 border-2 border-bauhaus-black rounded-none 
                       focus:outline-none focus:ring-2 focus:ring-bauhaus-red focus:ring-offset-0
                       font-medium text-foreground bg-white
                       transition-all duration-200'
        ]) }}
        @if($required) required @endif
    />
    
    @if($error)
        <p class="text-bauhaus-red text-sm mt-1 font-medium">{{ $error }}</p>
    @endif
</div>
