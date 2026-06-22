@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-[#1a1a1a] border-white/5 text-white placeholder-gray-500 focus:border-[#E51920] focus:ring-[#E51920] rounded-md shadow-sm']) }}>
