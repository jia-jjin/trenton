<button {{ $attributes->merge(['type' => 'submit', 'class' => 'border border-black inline-flex items-center px-4 py-2 bg-[#E9C46A] border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:[filter:brightness(1.03)] transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
