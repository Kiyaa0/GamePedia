<section class="pt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div x-data="{ active: 0 }" class="relative overflow-hidden rounded-lg">
            {{-- Slides --}}
            <div class="relative">
                {{-- Slide 1 --}}
                <div x-show="active === 0" x-cloak
                    class="relative h-[400px] md:h-[500px] lg:h-[550px] bg-cover bg-center rounded-lg"
                    style="background-image: linear-gradient(to right, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.85) 100%), url('https://via.placeholder.com/1200x550/1a1a2e/ffffff?text=RPG');">

                    {{-- Dark field right side with diagonal clip --}}
                    <div class="absolute inset-0 z-[5]"
                         style="clip-path: polygon(65% 0, 100% 0, 100% 100%, 45% 100%);
                                background: linear-gradient(to right, #e21c1c 1px, #161616 1px);">
                    </div>

                    {{-- Content --}}
                    <div class="absolute inset-0 z-10 flex items-center px-8 md:px-16">
                        <div class="max-w-lg">
                            <span class="inline-block bg-white text-[#e21c1c] text-xs font-bold px-3 py-1.5 uppercase tracking-wider mb-4">RPG</span>
                            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-2">Elden Ring</h2>
                            <p class="text-xs text-[#666] mb-1">PS5 · Xbox X/S · PC · Action RPG</p>
                            <p class="text-gray-300 text-sm md:text-base mb-6">Rise, Tarnished, and explore the Lands Between in this epic fantasy RPG.</p>
                            <div class="flex items-center gap-4">
                                {{-- Play Now with diagonal clip + play icon --}}
                                <a href="{{ route('games.index') }}" class="inline-flex items-center gap-2 bg-[#e21c1c] hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest px-5 py-3 transition"
                                   style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 100%, 8px 100%);">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                    Play Now
                                </a>
                                {{-- View Details secondary link --}}
                                <a href="{{ route('games.index') }}" class="text-sm text-gray-400 hover:text-white transition border-b border-[#2a2a2a] hover:border-white pb-0.5">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Slide indicator --}}
                    <span class="absolute top-4 right-4 z-20 text-xs text-gray-500 font-mono tracking-wider">
                        01 / 12
                    </span>
                </div>

                {{-- Slide 2 --}}
                <div x-show="active === 1" x-cloak
                    class="relative h-[400px] md:h-[500px] lg:h-[550px] bg-cover bg-center rounded-lg"
                    style="background-image: linear-gradient(to right, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.85) 100%), url('https://via.placeholder.com/1200x550/16213e/ffffff?text=Action');">

                    <div class="absolute inset-0 z-[5]"
                         style="clip-path: polygon(65% 0, 100% 0, 100% 100%, 45% 100%);
                                background: linear-gradient(to right, #e21c1c 1px, #161616 1px);">
                    </div>

                    <div class="absolute inset-0 z-10 flex items-center px-8 md:px-16">
                        <div class="max-w-lg">
                            <span class="inline-block bg-white text-[#e21c1c] text-xs font-bold px-3 py-1.5 uppercase tracking-wider mb-4">Action</span>
                            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-2">God of War Ragnarök</h2>
                            <p class="text-xs text-[#666] mb-1">PS5 · PS4 · PC · Action Adventure</p>
                            <p class="text-gray-300 text-sm md:text-base mb-6">Kratos and Atreus journey through the Nine Realms in search of answers.</p>
                            <div class="flex items-center gap-4">
                                <a href="{{ route('games.index') }}" class="inline-flex items-center gap-2 bg-[#e21c1c] hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest px-5 py-3 transition"
                                   style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 100%, 8px 100%);">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                    Play Now
                                </a>
                                <a href="{{ route('games.index') }}" class="text-sm text-gray-400 hover:text-white transition border-b border-[#2a2a2a] hover:border-white pb-0.5">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

                    <span class="absolute top-4 right-4 z-20 text-xs text-gray-500 font-mono tracking-wider">
                        02 / 12
                    </span>
                </div>

                {{-- Slide 3 --}}
                <div x-show="active === 2" x-cloak
                    class="relative h-[400px] md:h-[500px] lg:h-[550px] bg-cover bg-center rounded-lg"
                    style="background-image: linear-gradient(to right, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.85) 100%), url('https://via.placeholder.com/1200x550/0f3460/ffffff?text=Open+World');">

                    <div class="absolute inset-0 z-[5]"
                         style="clip-path: polygon(65% 0, 100% 0, 100% 100%, 45% 100%);
                                background: linear-gradient(to right, #e21c1c 1px, #161616 1px);">
                    </div>

                    <div class="absolute inset-0 z-10 flex items-center px-8 md:px-16">
                        <div class="max-w-lg">
                            <span class="inline-block bg-white text-[#e21c1c] text-xs font-bold px-3 py-1.5 uppercase tracking-wider mb-4">Open World</span>
                            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-2">The Legend of Zelda: Tears of the Kingdom</h2>
                            <p class="text-xs text-[#666] mb-1">Switch · Open World · Adventure</p>
                            <p class="text-gray-300 text-sm md:text-base mb-6">Embark on an unforgettable journey across the skies and depths of Hyrule.</p>
                            <div class="flex items-center gap-4">
                                <a href="{{ route('games.index') }}" class="inline-flex items-center gap-2 bg-[#e21c1c] hover:bg-red-600 text-white text-xs font-bold uppercase tracking-widest px-5 py-3 transition"
                                   style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 100%, 8px 100%);">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                    Play Now
                                </a>
                                <a href="{{ route('games.index') }}" class="text-sm text-gray-400 hover:text-white transition border-b border-[#2a2a2a] hover:border-white pb-0.5">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

                    <span class="absolute top-4 right-4 z-20 text-xs text-gray-500 font-mono tracking-wider">
                        03 / 12
                    </span>
                </div>
            </div>

            {{-- Dots --}}
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                <template x-for="(slide, index) in [0,1,2]" :key="index">
                    <button @click="active = index"
                        :class="{'bg-white': active === index, 'bg-gray-600': active !== index}"
                        class="w-2.5 h-2.5 rounded-full transition"></button>
                </template>
            </div>
        </div>
    </div>
</section>
