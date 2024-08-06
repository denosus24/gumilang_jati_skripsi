@php
    $serviceCategories = App\Models\ServiceCategory::all();
@endphp

<div class="md:hidden shadow" id="mobile-menu" :class="open ? '' : 'hidden'">
    <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
        <a href="{{ route('frontpage.home') }}"
            class="block rounded-md px-3 py-2  hover:bg-denim-100 hover:text-denim @if (request()->routeIs('frontpage.home*')) font-medium text-denim-600 @endif">Beranda</a>
        @foreach ($serviceCategories as $serviceCategory)
            <a href="{{ route('frontpage.service-category.list', ['code' => $serviceCategory->code]) }}"
                class="block rounded-md px-3 py-2  hover:bg-denim-100 hover:text-denim @if (request()->url() === route('frontpage.service-category.list', ['code' => $serviceCategory->code])) text-denim-600 @endif">
                {{ $serviceCategory->name }}
            </a>
        @endforeach
    </div>
    <div class="border-t border-denim-200 pb-3 pt-4">
        @if (auth()->user() && auth()->user()->role === 'customer')
            <div class="flex items-center px-5">
                <div class="space-y-3">
                    <div class="text-base font-medium leading-none">{{ auth()->user()->name }}</div>
                    <div class="font-medium leading-none text-gray-400">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1 px-2">
                <a href="{{ route('frontpage.profile') }}"
                    class="block px-4 py-2  text-gray-700  hover:bg-denim-100 hover:text-denim" role="menuitem"
                    tabindex="-1" id="user-menu-item-0">Profil</a>
                <a href="{{ route('frontpage.transaction.list') }}"
                    class="block px-4 py-2  text-gray-700  hover:bg-denim-100 hover:text-denim" role="menuitem"
                    tabindex="-1" id="user-menu-item-1">Transaksi</a>
                <form action="{{ route('frontpage.auth.logout') }}" method="POST">
                    @csrf
                    <button type="button"
                        class="block px-4 py-2 text-left text-gray-700 w-full  hover:bg-denim-100 hover:text-denim"
                        role="menuitem" tabindex="-1" id="user-menu-item-2">Keluar</button>
                </form>
            </div>
        @else
            <div class="flex items-center gap-3 px-5">
                <x-filament::button tag="a" color="primary" href="{{ route('frontpage.auth.login') }}">Masuk
                    Akun</x-filament::button>
                <span>atau</span>
                <x-filament::button tag="a" color="gray" href="{{ route('frontpage.auth.register') }}">Daftar
                    Sekarang</x-filament::button>
            </div>
        @endif
    </div>
</div>
