@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-accent-50 focus:ring-accent-50 rounded-md shadow-sm']) !!}>{{ $slot }}</textarea>
