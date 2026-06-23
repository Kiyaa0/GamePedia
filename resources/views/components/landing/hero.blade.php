@props(['games' => []])

<section class="pt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <style>
            .hero-scrollbar-hidden {
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
            .hero-scrollbar-hidden::-webkit-scrollbar {
                display: none;
            }
        </style>

        @if (count($games) === 0)
            <div class="relative rounded-xl overflow-hidden h-[500px] md:h-[600px] bg-[#1a1a1a] flex items-center justify-center">
                <p class="text-gray-500 text-sm">Gagal memuat hero slider. Silakan coba lagi nanti.</p>
            </div>
        @else
        <div id="heroSlider" class="relative rounded-xl overflow-hidden">

            <div class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth w-full hero-scrollbar-hidden">

                @foreach ($games as $index => $game)
                    <div class="min-w-full flex-shrink-0 snap-center relative h-[500px] md:h-[600px] overflow-hidden">

                        <div class="absolute inset-0 bg-cover bg-center"
                            style="background-image: url('{{ $game['background_image'] ?? 'https://via.placeholder.com/1400x600/1a1a1a/666?text=No+Image' }}');">
                        </div>

                        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>

                        {{-- Counter top-right --}}
                        <div class="absolute top-6 right-6 z-20">
                            <span class="text-2xl font-bold text-red-600">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-sm text-gray-600"> / {{ str_pad($loop->count, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        {{-- Content center-left --}}
                        <div class="absolute inset-0 z-10 flex items-center p-12 md:pl-20">
                            <div class="max-w-xl">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="w-6 h-1 bg-red-600"></span>
                                    <span class="text-xs font-bold text-red-600 uppercase tracking-widest">
                                        {{ collect($game['genres'] ?? [])->pluck('name')->take(2)->implode(' / ') }}
                                    </span>
                                </div>

                                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white uppercase leading-tight mt-2">
                                    {{ $game['name'] }}
                                </h2>

                                <p class="text-sm text-gray-400 mt-2">
                                    {{ collect($game['platforms'] ?? [])->pluck('platform.name')->take(3)->implode(' · ') }}
                                </p>

                                <p class="text-sm text-gray-400 mt-4 max-w-md">
                                    {{ $game['description_raw'] ?? Str::limit($game['name'].' is one of the most popular games right now.', 120) }}
                                </p>

                                <div class="flex items-center gap-5 mt-8">
                                    <a href="{{ route('games.show', $game['id']) }}"
                                        class="inline-flex items-center gap-2 bg-white text-black font-bold text-xs uppercase tracking-widest px-6 py-3.5 rounded-sm hover:bg-gray-200 transition">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        Play Now
                                    </a>
                                    <a href="{{ route('games.show', $game['id']) }}"
                                        class="text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-white transition border-b border-gray-600 pb-0.5">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>

            {{-- Indicators bottom-left --}}
            <div class="absolute bottom-6 left-8 flex gap-2 z-20">
                @foreach ($games as $index => $game)
                    <button data-slide="{{ $index }}"
                        class="slide-dot h-1 {{ $index === 0 ? 'bg-red-600 w-8' : 'bg-gray-700 w-4' }} rounded-full transition-all duration-300"></button>
                @endforeach
            </div>

        </div>

        <script>
            (function () {
                const container = document.querySelector('#heroSlider .overflow-x-auto');
                const dots = document.querySelectorAll('.slide-dot');

                if (!container || dots.length === 0) return;

                const updateDots = () => {
                    const scrollLeft = container.scrollLeft;
                    const slideWidth = container.clientWidth;
                    const activeIndex = Math.round(scrollLeft / slideWidth);

                    dots.forEach((dot, i) => {
                        if (i === activeIndex) {
                            dot.className = 'slide-dot h-1 bg-red-600 w-8 rounded-full transition-all duration-300';
                        } else {
                            dot.className = 'slide-dot h-1 bg-gray-700 w-4 rounded-full transition-all duration-300';
                        }
                    });
                };

                container.addEventListener('scroll', updateDots);

                dots.forEach((dot) => {
                    dot.addEventListener('click', () => {
                        const index = parseInt(dot.dataset.slide);
                        const slideWidth = container.clientWidth;
                        container.scrollTo({ left: index * slideWidth, behavior: 'smooth' });
                    });
                });
            })();
        </script>
        @endif

    </div>
</section>
