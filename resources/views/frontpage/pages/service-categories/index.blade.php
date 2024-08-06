<div class="mt-24">
    <section class="min-h-screen flex">
        <div class="container mx-auto p-8">

            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline md:inline-flex items-center">
                    <li class="flex items-center">
                        <a href="{{ route('frontpage.home') }}"
                            class="ms-2 me-2 inline-flex items-center text-sm font-medium text-denim hover:text-gray-600 hover:underline md:ms-0 text-ellipsis">
                            Beranda
                        </a>
                        <x-tabler-chevron-right class="w-4 h-4"></x-tabler-chevron-right>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-gray-600 md:ms-2 text-ellipsis">
                            Layanan {{ $serviceCategory->name }}
                        </span>
                    </li>
                </ol>
            </nav>

            <div>
                <h1 class="font-medium text-xl md:text-3xl mb-4">Layanan {{ $serviceCategory->name }}</h1>
                <p class="text-gray-700 mb-8">
                    Pilih Paket Layanan yang Kamu Butuhkan Ya!
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($serviceCategory->services as $service)
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
</div>
