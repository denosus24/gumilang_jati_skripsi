<div class="mt-24"> 
    <section class="min-h-screen flex">
        <div class="container mx-auto p-8">

            <nav class="md:flex mb-8" aria-label="Breadcrumb">
                <ol class="inline md:inline-flex items-center">
                    <li class="flex items-center">
                        <a href="{{ route('frontpage.home') }}"
                            class="ms-1 me-2 inline-flex items-center text-sm font-medium text-denim hover:text-gray-600 hover:underline md:ms-0 text-ellipsis">
                            Beranda
                        </a>
                        <x-tabler-chevron-right class="w-4 h-4"></x-tabler-chevron-right>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <a href="{{ route('frontpage.service-category.list', ['code' => $service->service_category->code]) }}"
                            class="ms-0 me-2 inline-flex items-center text-sm font-medium text-denim hover:text-gray-600 hover:underline md:ms-2 text-ellipsis">
                            Layanan
                            {{ $service->service_category->name }}
                        </a>
                        <x-tabler-chevron-right class="w-4 h-4"></x-tabler-chevron-right>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <span class="ms-0 me-2 text-sm font-medium text-gray-600 md:ms-2 text-ellipsis">
                            {{ $service->name }}</span>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row gap-x-12">
                <div class="w-full md:w-2/3 gap-y-8">
                    <div>
                        <h1 class="font-medium text-2xl md:text-3xl mb-3">{{ $service->name }}</h1>
                        <p class="text-gray-700 mb-8">
                            {!! $service->summary !!}
                        </p>
                    </div>

                    <x-frontpage::carousel :items="$service->image_with_urls" data-carousel="static" wire:ignore
                        class="mb-8 h-48 md:h-96"></x-frontpage::carousel>

                    <div class="grid grid-cols-1 gap-y-8 divide-y">
                        <div>
                            <h2 class="font-medium text-xl mb-3">Deskripsi Layanan</h2>
                            <p class="text-justify">
                                {!! $service->description !!}
                            </p>
                        </div>

                        <div class="pt-6">
                            <h2 class="font-medium text-xl mb-3">Siapa yang Membutuhkan?</h2>
                            <p class="text-justify">
                            <div class="flex flex-col gap-y-2">
                                Paket ini cocok bagi yang ingin
                                @foreach ($service->people_in_needs as $peopleNeed)
                                    <div class="flex items-center gap-x-3">
                                        <div>
                                            <x-tabler-circle-check class="w-5 h-5 text-denim"></x-tabler-circle-check>
                                        </div>
                                        <span>{{ $peopleNeed }}</span>
                                    </div>
                                @endforeach
                            </div>
                            </p>
                        </div>

                        <div class="pt-6">
                            <h2 class="font-medium text-xl mb-3">Pertanyaan Sering Ditanyakan (FAQ)</h2>
                            <p class="text-justify">
                            <div class="flex flex-col gap-y-2">

                                <div id="accordion-open" data-accordion="open">
                                    @php $i = 1; @endphp
                                    @foreach ($service->faqs as $faq)
                                        <h2 id="accordion-open-heading-{{ $i }}">
                                            <button type="button"
                                                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right border-b border-gray-200 text-gray-500 hover:text-gray-700"
                                                data-accordion-target="#accordion-open-body-{{ $i }}"
                                                aria-expanded="false"
                                                aria-controls="accordion-open-body-{{ $i }}">
                                                <div class="text-left">
                                                    {{ $faq['question'] }}
                                                </div>
                                                <div>
                                                    <x-tabler-chevron-down></x-tabler-chevron-down>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="accordion-open-body-{{ $i }}" class="hidden"
                                            aria-labelledby="accordion-open-heading-{{ $i }}">
                                            <div class="p-5 ">
                                                {{ $faq['answer'] }}
                                            </div>
                                        </div>
                                        @php $i++ @endphp
                                    @endforeach
                                </div>
                            </div>
                            </p>
                        </div>
                    </div>
                </div>

                @if (isset($selectedPackage))
                    <div class="bg-white hidden md:block w-full md:w-1/3 gap-y-8">
                        <div class="px-8 py-6 rounded shadow sticky top-28">
                            <div class="flex flex-col gap-y-5">
                                <h2 class="font-regular text-lg">Pilihan Paket untuk Kamu</h2>

                                <div>
                                    <h3 class="flex flex-col items-baseline gap-3">
                                        <span>Mulai Dari</span>
                                        <span
                                            class="font-medium text-3xl">Rp{{ number_format($selectedPackage->price - $selectedPackage->fixed_discount, 0, ',', '.') }}
                                            / bulan</span>

                                        @if ($selectedPackage->fixed_discount > 0)
                                            <span
                                                class="line-through text-gray-500">Rp{{ number_format($selectedPackage->fixed_discount, 0, ',', '.') }}
                                                / bulan</span>
                                        @endif
                                    </h3>
                                </div>

                                <div>
                                    <h3 class="font-medium flex items-center gap-x-3 mb-3">
                                        <x-tabler-list-check class="w-5 h-5"></x-tabler-list-check>
                                        <span>Paket Sudah Dengan</span>
                                    </h3>

                                    <div class="flex flex-col gap-y-2">
                                        @foreach ($selectedPackage->includes as $include)
                                            <div class="flex items-center gap-x-3">
                                                <x-tabler-circle-check
                                                    class="w-5 h-5 text-denim"></x-tabler-circle-check>
                                                <span>{{ $include }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <h3 class="font-regular text-lg mb-3">Pilih Paket</h3>
                                    {{ $this->form }}
                                </div>

                                <div>
                                    <h3 class="font-regular text-lg mb-3">Mau Ambil Berapa Bulan</h3>
                                    <!-- jumlah bulan -->
                                </div>

                                <form wire:submit="create" class="mb-3">
                                    <x-filament::button type="submit" class="mt-3 block w-full">
                                        Order Sekarang
                                    </x-filament::button>

                                    <div class="text-center mt-3 text-sm">Atau</div>

                                    <x-filament::button type="button" tag="a" class="mt-3 block w-full" color="info" href="{{ route('message') }}">
                                        Konsultasi Dahulu
                                    </x-filament::button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white hidden md:block mb-8">
                        <div class="px-8 py-6 rounded">
                            <div class="flex flex-col gap-y-5">
                                <h2 class="font-regular text-lg">Pilihan Paket untuk Kamu</h2>
                                <p class="text-gray-600 text-sm">Mohon maaf, belum ada paket yang tersedia saat ini.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
