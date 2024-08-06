<?php

namespace App\Filament\Admin\Resources\TransactionResource\Tables;

use App\Filament\Admin\Resources\OrderResource;
use App\Models\Order;
use App\Models\Transaction;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListOrders extends Component implements HasTable, HasForms
{
    use InteractsWithTable,
        InteractsWithForms;

    public $transaction;

    public function mount(Transaction $transaction): void
    {
        $this->transaction = $transaction;
    }

    public function table(Table $table): Table
    {
        $orders = Order::query()->where('transaction_id', $this->transaction->id);

        return $table
            ->query($orders)
            ->modifyQueryUsing(fn ($query) => $query->whereHas('transaction', fn ($query) => $query->where('status', '<>', 'pending')))
            ->defaultSort('id', 'desc')
            ->recordUrl(fn ($record) => OrderResource::getUrl('view', ['record' => $record]))
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
                Action::make('view')
                    ->label('Lihat Pesanan')
                    ->icon('tabler-eye')
                    ->button()
                    ->url(fn ($record) => OrderResource::getUrl('view', ['record' => $record])),
            ]);
    }

    public function render()
    {
        return <<<'blade'
                <div>
                    {{ $this->table }}
                </div>
             blade;
    }
}
