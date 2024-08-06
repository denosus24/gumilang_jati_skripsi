<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pelanggan Daftar Hari Ini', User::where('role', 'customer')->where(DB::raw('DATE(created_at)'), now()->format('Y-m-d'))->count()),
            Stat::make('Total Transaksi Hari Ini', Transaction::where(DB::raw('DATE(created_at)'), now()->format('Y-m-d'))->count()),
            Stat::make('Total Pesanan Hari Ini', Order::where(DB::raw('DATE(created_at)'), now()->format('Y-m-d'))->count()),
            Stat::make('Total Pendapatan Hari Ini', function () {
                $income = Transaction::where(DB::raw('DATE(created_at)'),  now()->format('Y-m-d'))->get()->sum('amount');

                return 'Rp' . number_format($income, 0, ',', '.');
            }),
        ];
    }
}
