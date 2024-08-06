<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan
        {{ $order->package->service->service_category->code === 'SMM' ? 'Manajemen Sosial Media' : 'Manajemen KOL' }} -
        {{ $order->order_number }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
    </style>
</head>

<body>
    <table style="width: 100%">
        <tbody>
            <tr>
                <td style="width: 75%;">
                    <h1 style="font-weight: 500; font-size: 24px; margin-bottom: 5px;">Laporan
                        {{ $order->package->service->service_category->code === 'SMM' ? 'Manajemen Sosial Media' : 'Manajemen KOL' }}
                    </h1>
                    <h1 style="font-weight: 500; font-size: 14px;">Layanan {{ $order->package->service->name }} - Paket
                        {{ $order->package->name }}</h1>
                </td>
                <td style="width: 25%">
                    <img src="{{ public_path('images/logo-gproduction.png') }}" alt="Logo Gumilang Jati"
                        style="width: 150px; object-fit: contain;">
                </td>
            </tr>
        </tbody>
    </table>

    <div style="border-top: 1px solid #efefef; padding: 20px; margin-top: 20px;"></div>

    <table style="width: 50%; text-align: left; font-size: 14px; border: border-collapse; border: 1px solid #efefef;">
        <tbody>
            <tr>
                <th style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: left;">
                    No. Pesanan
                </th>
                <td style="padding: 10px; border-bottom: 1px solid #efefef; text-align: left; font-weight: 600;">
                    {{ $order->order_number }}
                </td>
            </tr>
            <tr>
                <th style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: left;">
                    Nama Pelanggan
                </th>
                <td style="padding: 10px; border-bottom: 1px solid #efefef; text-align: left;">
                    {{ $order->user_name }}
                </td>
            </tr>
            <tr>
                <th style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: left;">
                    Tanggal Pesanan
                </th>
                <td style="padding: 10px; border-bottom: 1px solid #efefef; text-align: left;">
                    {{ $order->created_at->translatedFormat('l, j F Y') }}
                </td>
            </tr>
            <tr>
                <th style="padding: 10px; font-weight: normal; text-align: left;">
                    Tanggal Laporan Terakhir
                </th>
                <td style="padding: 10px; text-align: left;">
                    {{ $order->order_report->updated_at->translatedFormat('l, j F Y') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div style="border-top: 1px solid #efefef; padding: 20px; margin-top: 20px;"></div>

    @if ($order->package->service->service_category->code === 'SMM')
        <table style="width: 100%; font-size: 14px;">
            <thead>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">No.</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Aset</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Judul Postingan</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Caption</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Jumlah Revisi</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($order->order_report->content_plans->sortBy([['id', 'desc']]) as $contentPlan)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            {{ $i }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            {{ $contentPlan['asset'] ?? '' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ $contentPlan['title'] ?? '' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ $contentPlan['caption'] ?? '' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ $contentPlan->content_plan_revisions->count() ?? '0' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center; color: green;">
                            {{ match ($contentPlan['status']) {
                                'uploaded' => 'Terunggah. Menunggu Respon Client',
                                'revision_submitted' => 'Revisi Terunggah. Menunggu Respon Client',
                                'revision' => 'Menunggu Revisi',
                                'done' => 'Sudah Sesuai',
                            } }}
                        </td>
                    </tr>
                    @php $i++ @endphp
                @endforeach
            </tbody>
        </table>
    @else
        <h1 style="font-size: 16px; font-weight: 700;">Ringkasan KOL</h1>
        <table style="width: 100%; font-size: 14px;">
            <thead>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">No.</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Influencer</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Jumlah Follower</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Cost</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Link Postingan</th>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($order->order_report->kol_plans->sortBy([['id', 'desc']]) as $kolPlan)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            {{ $i }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            <a href="{{ $kolPlan['influencer_link'] }}">{{ $kolPlan['influencer_name'] ?? '' }}</a>
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['total_followers']) ? number_format($kolPlan['total_followers'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            Rp{{ isset($kolPlan['cost']) ? number_format($kolPlan['cost'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['post_url']) ? $kolPlan['post_url'] : '-' }}
                        </td>
                    </tr>
                    @php $i++ @endphp
                @endforeach
            </tbody>
        </table>

        <br><br>

        <h1 style="font-size: 16px; font-weight: 700;">Performa Berdasarkan Tayangan (Views)</h1>
        <table style="width: 100%; font-size: 14px;">
            <thead>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">No.</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">Influencer</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;"rowspan="2">Cost</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" colspan="6">Performa</th>
                </tr>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Tayangan (Views)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Disukai (Likes)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Komentar (Comments)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Dibagikan (Shares)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Pembelian (Direct Purchases)
                    </th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Cost per Mile (CPM)</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($order->order_report->kol_plans->sortBy([['views', 'desc']]) as $kolPlan)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            {{ $i }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            <a href="{{ $kolPlan['influencer_link'] }}">{{ $kolPlan['influencer_name'] ?? '' }}</a>
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            Rp{{ isset($kolPlan['cost']) ? number_format($kolPlan['cost'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['views']) ? number_format($kolPlan['views'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['likes']) ? number_format($kolPlan['likes'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['comments'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['shares'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['direct_purchases'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['cpm'], 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @php $i++ @endphp
                @endforeach
            </tbody>
        </table>

        <br><br>

        <h1 style="font-size: 16px; font-weight: 700;">Performa Berdasarkan Disukai (Likes)</h1>
        <table style="width: 100%; font-size: 14px;">
            <thead>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">No.</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">Influencer</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;"rowspan="2">Cost</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" colspan="6">Performa</th>
                </tr>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Tayangan (Views)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Disukai (Likes)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Komentar (Comments)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Dibagikan (Shares)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Pembelian (Direct Purchases)
                    </th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Cost per Mile (CPM)</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($order->order_report->kol_plans->sortBy([['likes', 'desc']]) as $kolPlan)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            {{ $i }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            <a href="{{ $kolPlan['influencer_link'] }}">{{ $kolPlan['influencer_name'] ?? '' }}</a>
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            Rp{{ isset($kolPlan['cost']) ? number_format($kolPlan['cost'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['views']) ? number_format($kolPlan['views'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['likes']) ? number_format($kolPlan['likes'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['comments'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['shares'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['direct_purchases'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['cpm'], 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @php $i++ @endphp
                @endforeach
            </tbody>
        </table>

        <br><br>

        <h1 style="font-size: 16px; font-weight: 700;">Performa Berdasarkan Komentar (Comments)</h1>
        <table style="width: 100%; font-size: 14px;">
            <thead>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">No.</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">Influencer
                    </th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;"rowspan="2">Cost</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" colspan="6">Performa</th>
                </tr>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Tayangan (Views)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Disukai (Likes)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Komentar (Comments)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Dibagikan (Shares)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Pembelian (Direct Purchases)
                    </th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Cost per Mile (CPM)</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($order->order_report->kol_plans->sortBy([['comments', 'desc']]) as $kolPlan)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            {{ $i }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            <a href="{{ $kolPlan['influencer_link'] }}">{{ $kolPlan['influencer_name'] ?? '' }}</a>
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            Rp{{ isset($kolPlan['cost']) ? number_format($kolPlan['cost'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['views']) ? number_format($kolPlan['views'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['likes']) ? number_format($kolPlan['likes'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['comments'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['shares'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['direct_purchases'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['cpm'], 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @php $i++ @endphp
                @endforeach
            </tbody>
        </table>

        <br><br>

        <h1 style="font-size: 16px; font-weight: 700;">Performa Berdasarkan Dibagikan (Shares)</h1>
        <table style="width: 100%; font-size: 14px;">
            <thead>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">No.</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">Influencer
                    </th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;"rowspan="2">Cost</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" colspan="6">Performa</th>
                </tr>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Tayangan (Views)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Disukai (Likes)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Komentar (Comments)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Dibagikan (Shares)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Pembelian (Direct Purchases)
                    </th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Cost per Mile (CPM)</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($order->order_report->kol_plans->sortBy([['shares', 'desc']]) as $kolPlan)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            {{ $i }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            <a href="{{ $kolPlan['influencer_link'] }}">{{ $kolPlan['influencer_name'] ?? '' }}</a>
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            Rp{{ isset($kolPlan['cost']) ? number_format($kolPlan['cost'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['views']) ? number_format($kolPlan['views'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['likes']) ? number_format($kolPlan['likes'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['comments'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['shares'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['direct_purchases'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['cpm'], 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @php $i++ @endphp
                @endforeach
            </tbody>
        </table>

        <br><br>

        <h1 style="font-size: 16px; font-weight: 700;">Performa Berdasarkan Pembelian (Direct Purchases)</h1>
        <table style="width: 100%; font-size: 14px;">
            <thead>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">No.</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">Influencer
                    </th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;"rowspan="2">Cost</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" colspan="6">Performa</th>
                </tr>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Tayangan (Views)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Disukai (Likes)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Komentar (Comments)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Dibagikan (Shares)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Pembelian (Direct Purchases)
                    </th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Cost per Mile (CPM)</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($order->order_report->kol_plans->sortBy([['direct_purchases', 'desc']]) as $kolPlan)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            {{ $i }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            <a href="{{ $kolPlan['influencer_link'] }}">{{ $kolPlan['influencer_name'] ?? '' }}</a>
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            Rp{{ isset($kolPlan['cost']) ? number_format($kolPlan['cost'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['views']) ? number_format($kolPlan['views'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['likes']) ? number_format($kolPlan['likes'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['comments'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['shares'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['direct_purchases'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['cpm'], 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @php $i++ @endphp
                @endforeach
            </tbody>
        </table>

        <br><br>

        <h1 style="font-size: 16px; font-weight: 700;">Performa Berdasarkan Cost per Mile (CPM)</h1>
        <table style="width: 100%; font-size: 14px;">
            <thead>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">No.</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" rowspan="2">Influencer
                    </th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;"rowspan="2">Cost</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;" colspan="6">Performa</th>
                </tr>
                <tr>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Tayangan (Views)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Disukai (Likes)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Komentar (Comments)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Dibagikan (Shares)</th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Pembelian (Direct Purchases)
                    </th>
                    <th style="padding: 10px; background: #efefef; font-weight: normal;">Cost per Mile (CPM)</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($order->order_report->kol_plans->sortBy([['cpm', 'desc']]) as $kolPlan)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            {{ $i }}
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal;">
                            <a href="{{ $kolPlan['influencer_link'] }}">{{ $kolPlan['influencer_name'] ?? '' }}</a>
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            Rp{{ isset($kolPlan['cost']) ? number_format($kolPlan['cost'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['views']) ? number_format($kolPlan['views'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['likes']) ? number_format($kolPlan['likes'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['comments'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['shares'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['direct_purchases'], 0, ',', '.') : '-' }}
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #efefef; font-weight: normal; text-align: center;">
                            {{ isset($kolPlan['comments']) ? number_format($kolPlan['cpm'], 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @php $i++ @endphp
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
