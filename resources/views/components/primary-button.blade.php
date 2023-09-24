<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-secondary-120 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary-80 focus:bg-secondary-80 active:bg-secondary-140 focus:outline-none focus:ring-2 focus:ring-accent-50 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
