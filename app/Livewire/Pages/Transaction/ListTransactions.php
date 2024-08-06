<?php

namespace App\Livewire\Pages\Transaction;

use App\Models\Transaction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListTransactions extends Component implements HasForms, HasTable
{
    use InteractsWithTable,
        InteractsWithForms;

    #[Layout('frontpage.components.layouts.app')]

    public function table(Table $table): Table
    {
        $transactions = Transaction::query()->where('user_id', auth()->user()->id);

        return $table
            ->query($transactions)
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal Invoice')
                    ->date('j F Y')
                    ->searchable(),

                TextColumn::make('invoice_number')
                    ->label('Nomor Invoice')
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Nominal Transaksi')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.'))
                    ->prefix('Rp')
                    ->searchable(),

                TextColumn::make('orders.package_name')
                    ->label('Ringkasan Transaksi')
                    ->bulleted(),

                TextColumn::make('status')
                    ->label('Status Pembayaran')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending'   => 'Menunggu Pembayaran',
                        'expired'   => 'Kadaluarsa',
                        'paid'      => 'Sudah Dibayar',
                        'declined'  => 'Ditolak / Dibatalkan',
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending'   => 'warning',
                        'expired'   => 'gray',
                        'paid'      => 'success',
                        'declined'  => 'danger',
                    }),
            ])
            ->actions([
                Action::make('view')
                    ->button()
                    ->label('Lihat Transaksi')
                    ->url(fn ($record) => route('frontpage.transaction.view', ['invoice_number' => $record->invoice_number]))
            ]);
    }

    public function render()
    {
        return view('frontpage.pages.transaction.list')
            ->title('Daftar Transaksi');
    }
}
