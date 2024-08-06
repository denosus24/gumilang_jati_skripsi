<?php

namespace App\Filament\Admin\Resources\TransactionResource\Pages;

use App\Filament\Admin\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
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
                    ->url(fn ($record) => static::getResource()::getUrl('view', ['record' => $record]))
            ]);
    }
}
