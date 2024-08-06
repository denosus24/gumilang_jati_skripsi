@php
    $serviceCategories = App\Models\ServiceCategory::all();
@endphp

<div>
    <!-- Footer Section -->
    <footer class="bg-denim-800 text-white py-8">
        <div class="container mx-auto flex flex-col md:flex-row gap-12 p-8">
            <div class="w-full md:w-1/4">
                <img src="{{ asset('images/logo-gproduction-invert.png') }}" alt="Logo Gumilang Jati" class="mb-5 w-64">
                <div class="text-xl font-medium mb-5">{{ config('app.name') }}</div>

                <div class="text-sm">
                    <p>Jl. Cempaka Putih Tengah I No.1, RT.11/RW.5, Cempaka Putih Tim., Kec. Cempaka Putih, Kota Jakarta
                        Pusat, Daerah Khusus Ibukota Jakarta 10510</p>
                </div>
            </div>
            <div class="w-full md:w-1/4">
                <h1 class="text-xl font-medium mb-5">Layanan</h1>
                <nav class="space-y-4">
                    @foreach ($serviceCategories as $serviceCategory)
                        <a href="{{ route('frontpage.service-category.list', ['code' => $serviceCategory->code]) }}"
                            class="block hover:text-yellow-400 mb-2">{{ $serviceCategory->name }}</a>
                    @endforeach
                    <a href="#" class="block hover:text-yellow-400">Hubungi Kami</a>
                </nav>
            </div>
            <div class="w-full md:w-1/4">
                <h1 class="text-xl font-medium mb-5">Ketentuan</h1>
                <nav class="space-y-4">
                    <a href="#" class="block hover:text-yellow-400 mb-2">Cara Kerja</a>
                    <a href="#" class="block hover:text-yellow-400 mb-2">Metode Pembayaran</a>
                </nav>
            </div>
        </div>
    </footer>
</div>
