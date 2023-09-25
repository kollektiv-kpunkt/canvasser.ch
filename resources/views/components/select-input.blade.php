@props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-accent-50 focus:ring-accent-50 rounded-md shadow-sm']) !!} {{($multiple) ? "multiple" : ""}}>
    @foreach ($options as $option)
        @if (isset($option["id"]))
            <option value="{{ $option["id"] }}" @if (in_array($option["id"], $selected))selected @endif>{{ $option["name"] }}</option>
        @else
            <option value="{{ $option }}" @if (in_array($option, $selected))selected @endif>{{ $option }}</option>
        @endif
    @endforeach
</select>
