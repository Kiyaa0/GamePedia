<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-[#222] border border-white/5 rounded-md font-semibold text-xs text-gray-300 uppercase tracking-widest shadow-sm hover:bg-[#333] focus:outline-none focus:ring-2 focus:ring-[#E51920] focus:ring-offset-2 focus:ring-offset-[#0f0f11] disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
