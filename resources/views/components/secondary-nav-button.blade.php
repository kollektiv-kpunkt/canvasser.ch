@php
    if (!isset($attributes["href"])) {
        throw new \ErrorException('The secondary-nav-button component requires an href attribute.');
    }
@endphp
<a {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-white border border-accent-70 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-accent-90 focus:outline-none focus:ring-2 focus:ring-secondary-50 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
