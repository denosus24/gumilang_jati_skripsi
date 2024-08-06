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
                            Checkout Pesanan</span>
                    </li>
                </ol>
            </nav>

            <div class="md:flex gap-x-8">
                <div class="flex flex-col w-full md:w-2/3 gap-y-3">
                    @if (count($carts) > 0)
                        @foreach ($carts as $cart)
                            <div class="md:flex bg-white border border-gray-100 p-8 rounded shadow">
                                <div class="w-full md:w-3/5 flex flex-col gap-y-3" id="detail-package">
                                    <h1 class="font-regular text-sm">{{ $cart->package->service->name }}</h1>
                                    <h2 class="font-medium text-xl">{{ $cart->package->name }}</h2>
                                    <h2 class="font-medium text-denim text-xl">
                                        @if ($cart->package->service->service_category->code === 'KOL')
                                            <div class="text-sm text-gray-500">Mulai dari</div>
                                        @endif
                                        Rp{{ number_format($cart->package->price - $cart->package->fixed_discount, 0, ',', '.') }}

                                        @if ($cart->package->fixed_discount > 0)
                                            <s class="text-gray-500 text-sm">
                                                Rp{{ number_format($cart->package->fixed_discount, 0, ',', '.') }}
                                            </s>
                                        @endif
                                    </h2>
                                    <p class="text-gray-500 text-sm">{{ $cart->package->service->summary }}</p>

                                    <div class="grid grid-cols-2 gap-3">
                                        @foreach ($cart->package->includes as $include)
                                            <div class="flex items-center gap-x-3">
                                                <div>
                                                    <x-tabler-circle-check
                                                        class="w-5 h-5 text-denim"></x-tabler-circle-check>
                                                </div>
                                                <div class="text-xs">{{ $include }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="w-full md:w-2/5 flex md:justify-end md:items-end items-end gap-x-3" id="quantity" wire:ignore>
                                    <div>
                                        @livewire(\App\Livewire\Components\CartComponent::class, ['cart' => $cart])
                                    </div>
                                    <div>
                                        {{ $this->removeCartAction }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex justify-center items-center">
                            <dotlottie-player src="{{ asset('lottie/empty-state.lottie') }}" background="transparent"
                                speed="1" style="width: 300px; height: 300px;" loop autoplay></dotlottie-player>
                        </div>
                        <div class="flex flex-col justify-center items-center gap-y-3">
                            <h1 class="text-xl md:text-2xl">Belum ada layanan yang ditambahkan</h1>
                            <p class="text-gray-500">Yuk, pilih layanan kamu sekarang <a
                                    href="{{ route('frontpage.home') }}" class="text-denim hover:underline">di sini</a>
                            </p>
                        </div>
                    @endif

                </div>

                @if (count($carts) > 0)
                    <div class="w-full md:w-1/3">
                        <div class="flex flex-col gap-y-6 bg-white rounded shadow sticky top-28 p-8">
                            <div class="flex flex-col gap-y-1 border-b pb-6 border-gray-300">
                                <h1 class="font-medium">Total Pembayaran</h1>
                                <p class="text-2xl font-medium text-gray-900">
                                    Rp{{ number_format($orderAmount, 0, ',', '.') }}</p>
                            </div>

                            <div class="flex flex-col gap-y-1">
                                <h1 class="text-lg font-medium">Selesaikan Pembayaran</h1>
                                <p class="text-sm text-gray-500">Harap mengisi form detail kebutuhan agar kami dapat
                                    memberikan rekomendasi dari kebutuhan kamu</p>
                            </div>

                            <form wire:submit="checkout" class="flex flex-col gap-y-3">
                                {{ $this->form }}

                                <x-filament::button type="submit" class="mt-3 block w-full">
                                    Lanjut Pembayaran
                                </x-filament::button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
@endpush
