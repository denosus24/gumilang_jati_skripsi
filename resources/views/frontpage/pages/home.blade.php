<div>
    <section class="bg-gray-100 h-screen flex items-center">
        <div class="container mx-auto flex flex-col md:flex-row items-center">
            <!-- Left Side -->
            <div class="w-full md:w-1/2 flex flex-col justify-center items-start p-8">
                <span class="animate-ping inline-flex w-6 h-6 rounded-full bg-denim opacity-75"></span>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Kelola Media Sosial & Influencer Kamu dengan Mudah</h1>
                <p class="text-xl mb-8">Optimalkan sosial media kamu dan tingkatkan kolaborasi dengan KOL melalui
                    Gumilang Jati.</p>
                
                @if (!auth()->user())
                <x-filament::button tag="a" size="xl" class="" href="{{ route('frontpage.auth.register') }}">Daftar Sekarang!</x-filament::button>
                @else
                <x-filament::button tag="a" size="xl" class="" href="{{ route('frontpage.service-category.list', ['code' => 'SMM']) }}">Jelajahi Semua Layanan</x-filament::button>
                @endif
            </div>
            <!-- Right Side -->
            <div class="hidden md:flex w-full md:w-1/2 justify-center items-center p-8">
                <img src="{{ asset('images/poster-gproduction.webp') }}" alt="Gumilang Jati Production">
            </div>
        </div>`
    </section>

    <section class="min-h-screen flex flex-col p-8">
        <div class="container mx-auto">
            <div>
                <h1 class="font-medium text-xl md:text-3xl mb-4">Layanan Khusus untuk Kamu</h1>
                <p class="text-gray-700 mb-8">
                    Pilih Paket Layanan yang Kamu Butuhkan Ya!
                </p>
            </div>
    
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($services as $service)
                    <div class="bg-white rounded shadow px-6 py-8">
                        <x-frontpage::carousel :items="$service->image_with_urls" data-carousel="static"
                            class="mb-8 h-48"></x-frontpage::carousel>
    
                        <div class="space-y-3">
                            <h2 class="font-medium text-xl">{{ $service->name }}</h2>
    
                            <p class="line-clamp-3">{{ strip_tags($service->description) }}</p>
    
                            <x-filament::button tag="a"
                                href="{{ route('frontpage.service.view', ['code' => $service->code]) }}">Lihat Paket
                                Layanan</x-filament::button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="min-h-screen flex items-center">
        <div class="container mx-auto flex flex-col md:flex-row items-center">
            <!-- Left Side -->
            <div class="w-full md:w-2/3 flex flex-col justify-center items-start p-8">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Mengapa Harus Memilih Kami?
                    <span class="animate-ping inline-flex w-6 h-6 rounded-full bg-denim opacity-75"></span>
                </h1>

                <div class="space-y-8 mt-8">
                    <div class="flex gap-3">
                        <div>
                            <div class="text-2xl p-5 rounded-tl-lg rounded-br-lg bg-denim-700 text-white">
                                1
                            </div>
                        </div>
                        <div class="space-y-2">
                            <h1 class="text-xl font-medium">Efisiensi dan Waktu yang Lebih Singkat</h1>
                            <p>Dengan platform kami, kamu dapat mengelola semua akun media sosial dan kolaborasi dengan
                                KOL dalam satu tempat. Ini mengurangi kebutuhan untuk beralih antara berbagai alat dan
                                platform, sehingga kamu dapat lebih fokus pada strategi dan konten kreatif.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div>
                            <div class="text-2xl p-5 rounded-tl-lg rounded-br-lg bg-denim-700 text-white">
                                2
                            </div>
                        </div>
                        <div class="space-y-2">
                            <h1 class="text-xl font-medium">Analitik yang Mendalam dan Laporan Terperinci</h1>
                            <p>Dapatkan wawasan yang mendalam tentang kinerja kampanye melalui analitik yang
                                komprehensif. Platform kami menyediakan laporan terperinci yang membantu kamu memahami
                                tren, mengukur ROI, dan mengoptimalkan strategi pemasaran kamu berdasarkan data yang
                                akurat.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div>
                            <div class="text-2xl p-5 rounded-tl-lg rounded-br-lg bg-denim-700 text-white">
                                3
                            </div>
                        </div>
                        <div class="space-y-2">
                            <h1 class="text-xl font-medium">Kolaborasi yang Lebih Baik dengan KOL</h1>
                            <p>Platform kami memudahkan kamu untuk menemukan, mengelola, dan berkolaborasi dengan KOL
                                yang relevan dengan merek kamu. Dengan fitur komunikasi terintegrasi, kamu dapat
                                berinteraksi secara langsung dan efisien, memastikan kampanye berjalan lancar dan
                                mencapai audiens yang tepat.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden md:flex w-full md:w-1/2 justify-center items-center p-8">
                <img src="{{ asset('images/report-analytics.webp') }}" alt="Laporan Analisis">
            </div>
        </div>
    </section>
</div>
