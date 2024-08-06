@php
    $transactionBadgeColor = match ($transaction->status) {
        'pending' => 'bg-yellow-100 text-yellow-500',
        'paid' => 'bg-green-100 text-green-800',
        'expired' => 'bg-gray-100 text-gray-800',
        'declined' => 'bg-red-100 text-red-800',
        default => 'bg-yellow-100 text-yellow-800',
    };

    $transactionBadgeLabel = match ($transaction->status) {
        'pending' => 'Menunggu Pembayaran',
        'paid' => 'Sudah Dibayar',
        'expired' => 'Kadaluarsa',
        'declined' => 'Ditolak',
        default => 'Menunggu Pembayaran',
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
                            Daftar Transaksi
                        </a>
                        <x-tabler-chevron-right class="w-4 h-4"></x-tabler-chevron-right>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <span class="ms-0 text-sm font-medium text-gray-600 md:ms-2 text-ellipsis">
                            Invoice {{ $transaction->invoice_number }}</span>
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
                                <x-tabler-receipt></x-tabler-receipt>
                                Detail Transaksi
                            </a>
                        </li>
                        <li x-on:click="currentTab = 2">
                            <a href="#history-order"
                                class="inline-flex items-center gap-x-3 justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300 group"
                                :class="{ 'border-denim text-denim hover:border-denim hover:text-denim': currentTab === 2 }">
                                <x-tabler-list-details></x-tabler-list-details>
                                Daftar Pekerjaan
                            </a>
                        </li>
                    </ul>
                </div>

                <div id="tabs-content">
                    <div class="py-8" x-show="currentTab === 1">
                        <div class="bg-white shadow rounded p-6">
                            <div class="flex justify-between">
                                @if ($transaction->status === 'pending')
                                    <div>
                                        <x-filament::button color="primary" tag="a"
                                            href="{{ $transaction->payment_url }}" size="lg"
                                            icon="tabler-arrow-right" icon-position="after">
                                            Bayar Sekarang
                                        </x-filament::button>
                                    </div>
                                @endif

                                <div
                                    class="inline-block {{ $transactionBadgeColor }} text-sm font-medium px-4 py-3 rounded mb-8">
                                    {{ $transactionBadgeLabel }}
                                </div>
                            </div>

                            <div class="flex justify-between mb-8">
                                <div id="invoice-heading">
                                    <h1 class="text-xl md:text-3xl font-medium mb-3">INVOICE</h1>
                                    <p>{{ $transaction->invoice_number }}</p>
                                    <br><br>

                                    <p class="font-medium mb-3">Kepada</p>
                                    <p class="text-gray-700 mb-7">{{ $transaction->user_name }}</p>

                                    <p class="font-medium mb-3">Nomor Handphone / Whatsapp</p>
                                    <p class="text-gray-700 text-sm">{{ $transaction->phone_number }}</p>
                                </div>
                                <div id="date-heading">
                                    <p class="font-medium text-right mb-3">Tanggal Invoice</p>
                                    <p class="">{{ $transaction->created_at->format('Y/m/d H:i') }}</p>
                                </div>
                            </div>

                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Deskripsi
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Harga
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaction->orders as $order)
                                            <tr class="bg-white border-b">
                                                <td scope="row"
                                                    class="leading-6 px-6 py-4 text-gray-700 whitespace-nowrap">
                                                    <h1 class="font-bold">{{ $order->order_number }} -
                                                        {{ $order->package->service->name }}</h1>
                                                    <h2 class="font-medium"> {{ $order->package->name }}</h2>
                                                    <p>{{ implode(', ', $order->package->includes) }}</p>
                                                    <p>x {{ $order->quantity }} bulan</p>
                                                    <p><b>Briefing:</b> {{ $order->briefs }}</p>
                                                    <p><b>Catatan:</b> {{ $order->note ?? '-' }}</p>
                                                </td>
                                                <td class="px-6 py-4 text-gray-700">
                                                    {{ $order->quantity }} x
                                                    Rp{{ number_format($order->base_amount, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-white border-b">
                                            <td class="text-right text-gray-700 font-medium px-6 py-4">Sub Total</td>
                                            <td class="text-gray-700 px-6 py-4">
                                                Rp{{ number_format($transaction->base_amount, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <td class="text-right text-gray-700 font-medium px-6 py-4">Diskon</td>
                                            <td class="text-gray-700 px-6 py-4">
                                                Rp{{ number_format($transaction->discount_amount, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                            <td class="text-right text-gray-700 font-medium px-6 py-4">Total</td>
                                            <td class="text-gray-700 px-6 py-4">
                                                Rp{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="p-8" x-show="currentTab === 2">
                        <div class="bg-white shadow rounded p-6">
                            {{ $this->table }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
