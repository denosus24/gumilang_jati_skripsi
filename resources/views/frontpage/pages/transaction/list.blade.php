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
                            Daftar Transaksi</span>
                    </li>
                </ol>
            </nav>

            <div>
                {{ $this->table }}
            </div>
        </div>
    </section>
</div>
