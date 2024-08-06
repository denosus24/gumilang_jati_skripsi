@php
    $orderBadgeColor = match ($order->status) {
        'pending' => 'bg-yellow-100 text-yellow-500',
        'done' => 'bg-green-100 text-green-800',
        'revision' => 'bg-denim-100 text-denom-800',
        'ongoing' => 'bg-blue-100 text-blue-800',
        default => 'bg-yellow-100 text-yellow-800',
    };

    $orderBadgeLabel = match ($order->status) {
        'pending' => 'Belum Dimulai',
        'done' => 'Sudah Selesai',
        'revision' => 'Revisi',
        'ongoing' => 'Dalam Pengerjaan',
        default => 'Belum Dimulai',
    };
@endphp

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
                    <li class="flex items-center">
                        <a href="{{ route('frontpage.transaction.list') }}"
                            class="ms-1 me-2 inline-flex items-center text-sm font-medium text-denim hover:text-gray-600 hover:underline md:ms-0 text-ellipsis">
                            Daftar Pekerjaan
                        </a>
                        <x-tabler-chevron-right class="w-4 h-4"></x-tabler-chevron-right>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <span class="ms-0 text-sm font-medium text-gray-600 md:ms-2 text-ellipsis">
                            Proyek {{ $order->order_number }}</span>
                    </li>
                </ol>
            </nav>

            <div x-data="{ currentTab: 1 }">
                <div id="tabs" class="border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                        <li x-on:click="currentTab = 1">
                            <a href="#invoice"
                                class="inline-flex items-center gap-x-3 justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300 group"
                                :class="{ 'border-denim text-denim hover:border-denim hover:text-denim': currentTab === 1 }">
                                <x-tabler-list-details></x-tabler-list-details>
                                Detail Proyek
                            </a>
                        </li>
                        <li x-on:click="currentTab = 2">
                            <a href="{{ route('message') }}"
                                class="inline-flex items-center gap-x-3 justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300 group"
                                :class="{ 'border-denim text-denim hover:border-denim hover:text-denim': currentTab === 2 }">
                                <x-tabler-message-2></x-tabler-message-2>
                                Ruang Konsultasi
                            </a>
                        </li>
                    </ul>
                </div>

                <div id="tabs-content">
                    <div class="py-8" x-show="currentTab === 1">
                        <div class="bg-white shadow rounded p-6">
                            <div class="flex justify-between">
                                <div
                                    class="inline-block {{ $orderBadgeColor }} text-sm font-medium px-4 py-3 rounded mb-8">
                                    {{ $orderBadgeLabel }}
                                </div>
                            </div>

                            <div class="flex justify-between mb-8">
                                <div id="invoice-heading">
                                    <h1 class="text-xl md:text-3xl font-medium mb-3">Proyek</h1>
                                    <p>Nomor Order: {{ $order->order_number }}</p>
                                </div>

                                <div>
                                    Tanggal Pesanan: {{ $order->created_at->format('d/m/Y G:i') }}
                                </div>
                            </div>

                            <div class="flex flex-col gap-y-8">
                                <div class="flex justify-between items-center w-full md:w-1/2 gap-y-2">
                                    <div>
                                        <h2 class="font-semibold">Nama Pelanggan</h2>
                                        <p>{{ $order->user_name }}</p>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center w-full md:w-1/2 gap-y-2">
                                    <div>
                                        <h2 class="font-semibold">Nama Paket yang Dipesan</h2>
                                        <p>{{ $order->package->service->name . ' / ' . $order->package->name }}</p>
                                    </div>
                                    <div>
                                        <h2 class="font-semibold">Total Pembelian</h2>
                                        <p>{{ number_format($order->package->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center w-full md:w-1/2 gap-y-2">
                                    <div>
                                        <h2 class="font-semibold">Briefing</h2>
                                        <p>{!! $order->briefs !!}</p>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center w-full md:w-1/2 gap-y-2">
                                    <div>
                                        <h2 class="font-semibold">Deskripsi Laporan</h2>
                                        <p>{!! $order->order_report->description ?? '-' !!}</p>
                                    </div>
                                    <div>
                                        <h2 class="font-semibold">Link Berkas</h2>
                                        <p><a
                                                href="{{ $order->order_report->attachment_link }}">{{ $order->order_report->attachment_link }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                {{ $this->table }}
                            </div>
                        </div>

                        <div class="p-8" x-show="currentTab === 2">
                            <div class="bg-white shadow rounded p-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
