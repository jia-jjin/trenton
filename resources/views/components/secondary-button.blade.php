<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-[#E9C46A] hover:[filter:brightness(1.03)] hover:scale-105 border border-gray-300 rounded-md font-semibold text-xs text-black uppercase tracking-widest shadow-sm focus:outline-none focus:ring focus:ring-black focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
