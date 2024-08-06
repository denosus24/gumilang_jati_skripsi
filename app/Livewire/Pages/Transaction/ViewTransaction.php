<?php

namespace App\Livewire\Pages\Transaction;

use App\Models\Order;
use App\Models\Transaction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ViewTransaction extends Component implements HasForms, HasTable
{
    use InteractsWithTable,
        InteractsWithForms;

    #[Layout('frontpage.components.layouts.app')]

    public $transaction;

    public function mount($invoice_number)
    {
        $this->transaction = Transaction::where('user_id', auth()->user()->id)->where('invoice_number', $invoice_number)->first();

        if (!$this->transaction) abort(403);
    }

    public function table(Table $table): Table
    {
        $orders = Order::query()->where('transaction_id', $this->transaction->id);

        return $table
            ->query($orders)
            ->defaultGroup(Group::make('package.service.name')->label('Layanan'))
            ->columns([
                TextColumn::make('package.name')
                    ->label('Nama Paket')
                    ->description(fn ($record) => implode(', ', $record->package->includes))
                    ->wrap()
                    ->searchable(),

                TextColumn::make('quantity')
                    ->label('Jml. Pembelian Paket')
                    ->suffix(' Bulan')
                    ->alignCenter(),

                TextColumn::make('status')
                    ->label('Status Pesanan')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pesanan Baru',
                        'ongoing' => 'Dalam Pengerjaan',
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
            ])
            ->actions([
                Action::make('view')
                    ->button()
                    ->icon('tabler-eye')
                    ->label('Lihat Proyek')
                    ->url(fn ($record) => route('frontpage.order.view', ['order_number' => $record->order_number])),

                Action::make('download_report')
                    ->color('danger')
                    ->button()
                    ->label('Unduh Laporan')
                    ->icon('tabler-pdf')
                    ->url(fn ($record) => route('frontpage.order-report.download', ['order' => $record->id]))
                    ->hidden(fn ($record) => $record->status !== 'done'),
            ]);
    }

    public function render()
    {
        return view('frontpage.pages.transaction.view')
            ->title($this->transaction->invoice_number);
    }
}
