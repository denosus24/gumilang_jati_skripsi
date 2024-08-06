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
                        <span class="ms-0 text-sm font-medium text-gray-600 md:ms-2 text-ellipsis">
                            Pesanan Selesai</span>
                    </li>
                </ol>
            </nav>

            <div class="mt-18 flex flex-col justify-center items-center my-2 gap-y-8">
                <div>
                    <dotlottie-player src="{{ asset('lottie/thumbs-up.lottie') }}" background="transparent"
                        speed="1" style="width: 250px; height: 250px;" loop autoplay></dotlottie-player>
                </div>

                <div class="flex flex-col justify-center items-center gap-y-3">
                    <h1 class="text-xl md:text-2xl">Terima kasih telah memesan jasa kami!</h1>
                    <p class="text-gray-500">Admin akan segera menghubungi kamu dalam waktu 1 x 24 jam melalui Whatsapp</p>
                </div>

                <div>
                    <x-filament::button tag="a" href="{{ route('frontpage.transaction.list') }}" size="xl">Lihat Daftar Transaksi</x-filament::button>
                </div>
            </div>
        </div>
    </section>
</div>


@push('scripts')
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
@endpush
