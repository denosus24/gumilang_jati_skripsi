<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    public function getTabs(): array
    {
        return [
            Tab::make('pending')
                ->label('Pesanan Baru')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'pending')),

            Tab::make('ongoing')
                ->label('Sedang Dikerjakan')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'ongoing')),

            Tab::make('revision')
                ->label('Tahap Revisi')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'revision')),

            Tab::make('done')
                ->label('Selesai')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'done')),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->modifyQueryUsing(fn ($query) => $query->whereHas('transaction', fn ($query) => $query->where('status', '<>', 'pending')))
            ->columns([
                TextColumn::make('status')
                    ->label('Status Pesanan')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pesanan Baru',
                        'ongoing' => 'Sedang Dikerjakan',
                        'revision' => 'Tahap Revisi',
                        'done' => 'Selesai',
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'ongoing' => 'info',
                        'revision' => 'info',
                        'done' => 'success',
                    }),

                TextColumn::make('order_number')
                    ->label('No. Pesanan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Nama Pemesan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('package.name')
                    ->formatStateUsing(fn ($record) => $record->package->service->name . ' / ' . $record->package->name)
                    ->wrap()
                    ->label('Layanan Dipesan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.'))
                    ->prefix('Rp'),
            ])
            ->emptyStateIcon('tabler-circle-x')
            ->emptyStateDescription('Belum ada pesanan baru.')
            ->filters([
                //
            ])
            ->actions([
                //
            ]);
    }
}
