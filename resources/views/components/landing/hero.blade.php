<section class="pt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div x-data="{ active: 0 }" class="relative min-h-[500px] overflow-hidden rounded-lg">
            {{-- Slides --}}
            <div class="relative">

                {{-- Slide 1 --}}
                <div x-show="active === 0" x-cloak
                    class="relative min-h-[500px] bg-cover bg-center"
                    style="background-image: linear-gradient(to right, rgba(15,15,17,0.95) 0%, rgba(15,15,17,0.3) 60%, rgba(15,15,17,0.9) 100%), url('https://via.placeholder.com/1400x600/1a1a2e/ffffff?text=RPG');">

                    {{-- Thick red diagonal right --}}
                    <div class="absolute inset-0 z-[5] opacity-60"
                         style="clip-path: polygon(68% 0, 100% 0, 100% 100%, 55% 100%);
                                background: linear-gradient(to right, #E51920 2px, #E51920 2px, transparent 2px);
                                background-color: rgba(229,25,32,0.15);">
                    </div>

                    {{-- Content --}}
                    <div class="absolute inset-0 z-10 flex items-center px-8 md:px-16">
                        <div class="max-w-xl">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-block w-6 h-px bg-[#E51920]"></span>
                                <span class="text-xs font-bold text-[#E51920] uppercase tracking-[0.2em]">Action / RPG</span>
                            </div>
                            <h2 class="text-4xl md:text-5xl lg:text-7xl font-black text-white leading-[1.05] mb-3">SHADOW OF THE<br>LAST HUNT</h2>
                            <p class="text-xs text-gray-500 mb-1">open world · co-op · pc / ps5</p>
                            <p class="text-gray-400 text-sm md:text-base mb-8 max-w-md">Rise, Tarnished, and explore the Lands Between in this epic fantasy RPG.</p>
                            <div class="flex items-center gap-5">
                                {{-- Play Now skewed --}}
                                <a href="{{ route('games.index') }}" class="inline-flex items-center gap-3 bg-white text-black font-bold text-xs uppercase tracking-[0.15em] px-6 py-3.5 transition hover:bg-gray-200 -skew-x-12">
                                    <span class="inline-flex items-center gap-2 skew-x-12">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        Play Now
                                    </span>
                                </a>
                                {{-- View Details --}}
                                <a href="{{ route('games.index') }}" class="text-xs font-bold text-gray-400 uppercase tracking-[0.15em] hover:text-white transition border-b border-gray-600 pb-0.5">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Slide indicator --}}
                    <div class="absolute top-6 right-6 z-20 text-right">
                        <span class="text-2xl font-bold text-[#E51920]">04</span>
                        <span class="text-sm text-gray-600"> / 12</span>
                    </div>
                </div>

                {{-- Slide 2 --}}
                <div x-show="active === 1" x-cloak
                    class="relative min-h-[500px] bg-cover bg-center"
                    style="background-image: linear-gradient(to right, rgba(15,15,17,0.95) 0%, rgba(15,15,17,0.3) 60%, rgba(15,15,17,0.9) 100%), url('https://via.placeholder.com/1400x600/16213e/ffffff?text=Action');">

                    <div class="absolute inset-0 z-[5] opacity-60"
                         style="clip-path: polygon(68% 0, 100% 0, 100% 100%, 55% 100%);
                                background: linear-gradient(to right, #E51920 2px, #E51920 2px, transparent 2px);
                                background-color: rgba(229,25,32,0.15);">
                    </div>

                    <div class="absolute inset-0 z-10 flex items-center px-8 md:px-16">
                        <div class="max-w-xl">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-block w-6 h-px bg-[#E51920]"></span>
                                <span class="text-xs font-bold text-[#E51920] uppercase tracking-[0.2em]">Action / Adventure</span>
                            </div>
                            <h2 class="text-4xl md:text-5xl lg:text-7xl font-black text-white leading-[1.05] mb-3">GOD OF WAR<br>RAGNARÖK</h2>
                            <p class="text-xs text-gray-500 mb-1">ps5 · ps4 · pc · action adventure</p>
                            <p class="text-gray-400 text-sm md:text-base mb-8 max-w-md">Kratos and Atreus journey through the Nine Realms in search of answers.</p>
                            <div class="flex items-center gap-5">
                                <a href="{{ route('games.index') }}" class="inline-flex items-center gap-3 bg-white text-black font-bold text-xs uppercase tracking-[0.15em] px-6 py-3.5 transition hover:bg-gray-200 -skew-x-12">
                                    <span class="inline-flex items-center gap-2 skew-x-12">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        Play Now
                                    </span>
                                </a>
                                <a href="{{ route('games.index') }}" class="text-xs font-bold text-gray-400 uppercase tracking-[0.15em] hover:text-white transition border-b border-gray-600 pb-0.5">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="absolute top-6 right-6 z-20 text-right">
                        <span class="text-2xl font-bold text-[#E51920]">04</span>
                        <span class="text-sm text-gray-600"> / 12</span>
                    </div>
                </div>

                {{-- Slide 3 --}}
                <div x-show="active === 2" x-cloak
                    class="relative min-h-[500px] bg-cover bg-center"
                    style="background-image: linear-gradient(to right, rgba(15,15,17,0.95) 0%, rgba(15,15,17,0.3) 60%, rgba(15,15,17,0.9) 100%), url('https://via.placeholder.com/1400x600/0f3460/ffffff?text=Open+World');">

                    <div class="absolute inset-0 z-[5] opacity-60"
                         style="clip-path: polygon(68% 0, 100% 0, 100% 100%, 55% 100%);
                                background: linear-gradient(to right, #E51920 2px, #E51920 2px, transparent 2px);
                                background-color: rgba(229,25,32,0.15);">
                    </div>

                    <div class="absolute inset-0 z-10 flex items-center px-8 md:px-16">
                        <div class="max-w-xl">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-block w-6 h-px bg-[#E51920]"></span>
                                <span class="text-xs font-bold text-[#E51920] uppercase tracking-[0.2em]">Open World / Adventure</span>
                            </div>
                            <h2 class="text-4xl md:text-5xl lg:text-7xl font-black text-white leading-[1.05] mb-3">THE LEGEND OF<br>ZELDA: TOTK</h2>
                            <p class="text-xs text-gray-500 mb-1">switch · open world · adventure</p>
                            <p class="text-gray-400 text-sm md:text-base mb-8 max-w-md">Embark on an unforgettable journey across the skies and depths of Hyrule.</p>
                            <div class="flex items-center gap-5">
                                <a href="{{ route('games.index') }}" class="inline-flex items-center gap-3 bg-white text-black font-bold text-xs uppercase tracking-[0.15em] px-6 py-3.5 transition hover:bg-gray-200 -skew-x-12">
                                    <span class="inline-flex items-center gap-2 skew-x-12">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        Play Now
                                    </span>
                                </a>
                                <a href="{{ route('games.index') }}" class="text-xs font-bold text-gray-400 uppercase tracking-[0.15em] hover:text-white transition border-b border-gray-600 pb-0.5">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="absolute top-6 right-6 z-20 text-right">
                        <span class="text-2xl font-bold text-[#E51920]">03</span>
                        <span class="text-sm text-gray-600"> / 12</span>
                    </div>
                </div>
            </div>

            {{-- Dots --}}
            <div class="absolute bottom-6 left-8 flex gap-2 z-20">
                <template x-for="(slide, index) in [0,1,2]" :key="index">
                    <button @click="active = index"
                        :class="{'bg-[#E51920] w-6': active === index, 'bg-gray-600 w-2.5': active !== index}"
                        class="h-0.5 rounded-full transition-all duration-300"></button>
                </template>
            </div>
        </div>
    </div>
</section>
