@php
    $serviceCategories = App\Models\ServiceCategory::all();
    $chMessagesCount = \App\Models\ChMessage::userUnread()->count();
@endphp

<div class="mx-auto max-w-7xl p-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <a href="{{ route('frontpage.home') }}">
                    <img class="h-16" src="{{ asset('images/logo-gproduction.png') }}" alt="{{ config('app.name') }}">
                </a>
            </div>
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="{{ route('frontpage.home') }}"
                        class="rounded-md px-3 py-2  hover:bg-denim-100 hover:text-denim @if (request()->routeIs('frontpage.home*')) font-medium text-denim-600 @endif">Beranda</a>

                    @foreach ($serviceCategories as $serviceCategory)
                        <a href="{{ route('frontpage.service-category.list', ['code' => $serviceCategory->code]) }}"
                            class="rounded-md px-3 py-2  hover:bg-denim-100 hover:text-denim @if (request()->url() === route('frontpage.service-category.list', ['code' => $serviceCategory->code])) text-denim-600 @endif">
                            {{ $serviceCategory->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="hidden md:block">

            <!-- Profile dropdown -->
            <div class="relative ml-3">
                <div>
                    @if (auth()->user() && auth()->user()->role === 'customer')
                        <div class="flex items-center gap-x-6">
                            <div class="flex items-center gap-x-2">
                                <a href="{{ route('frontpage.checkout') }}"
                                    class="p-2 rounded-full border border-gray-300 hover:border-denim relative flex gap-x-2 max-w-xs items-center hover:text-denim"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <x-tabler-basket class="w-6 h-6"></x-tabler-basket>
                                </a>

                                <a href="{{ route('message') }}"
                                    class="p-2 rounded-full border border-gray-300 hover:border-denim relative flex gap-x-2 max-w-xs items-center hover:text-denim"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <x-tabler-message class="w-6 h-6"></x-tabler-message>
                                    <span class="sr-only">Notifications</span>
                                    <div
                                        class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2">
                                        {{ $chMessagesCount }}
                                    </div>
                                    </button>
                                </a>
                            </div>

                            <button type="button" class="relative flex gap-x-2 max-w-xs items-center hover:text-denim"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true"
                                x-on:click="open = !open" @click.outside="open = false">
                                {{ auth()->user()->name }}

                                <span class="absolute -inset-1.5"></span>
                                <x-tabler-chevron-down class="w-4 h-4"></x-tabler-chevron-down>
                                <span class="sr-only">Open user menu</span>
                            </button>
                        </div>
                    @else
                        <div class="flex items-center justify-between gap-3">
                            <x-filament::button tag="a" color="primary"
                                href="{{ route('frontpage.auth.login') }}">Masuk Akun</x-filament::button>
                            <span>atau</span>
                            <x-filament::button tag="a" color="gray"
                                href="{{ route('frontpage.auth.register') }}">Daftar Sekarang</x-filament::button>
                        </div>
                    @endif
                </div>

                @if (auth()->user() && auth()->user()->role === 'customer')
                    <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                        x-bind:class="!open ? 'hidden' : ''">
                        <a href="{{ route('frontpage.profile') }}"
                            class="block px-4 py-2 text-gray-700  hover:bg-denim-100 hover:text-denim" role="menuitem"
                            tabindex="-1">Profil</a>
                        <a href="{{ route('frontpage.transaction.list') }}"
                            class="block px-4 py-2 text-gray-700  hover:bg-denim-100 hover:text-denim" role="menuitem"
                            tabindex="-1">Transaksi</a>

                        <form action="{{ route('frontpage.auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="block px-4 py-2 w-full text-left text-gray-700 hover:bg-denim-100 hover:text-denim"
                                role="menuitem" tabindex="-1">Keluar</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <div class="flex md:hidden">
            <!-- Mobile menu button -->
            <button type="button" class="relative inline-flex items-center justify-center rounded-md"
                aria-controls="mobile-menu" aria-expanded="false" x-on:click="open = !open">
                <span class="absolute -inset-0.5"></span>
                <span class="sr-only">Open main menu</span>
                <!-- Menu open: "hidden", Menu closed: "block" -->
                <div :class="open ? 'hidden' : 'block'">
                    <x-tabler-menu-2 class="w-6 h-6"></x-tabler-menu-2>
                </div>
                <!-- Menu open: "block", Menu closed: "hidden" -->

                <div :class="open ? 'block' : 'hidden'">
                    <x-tabler-x class="w-6 h-6"></x-tabler-x>
                </div>
            </button>
        </div>
    </div>
</div>
