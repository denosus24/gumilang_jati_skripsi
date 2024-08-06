<?php

namespace App\Filament\Admin\Resources\TransactionResource\Pages;

use App\Filament\Admin\Resources\TransactionResource;
use App\Models\Order;
use App\Models\Transaction;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class ViewTransaction extends Page
{
    protected static string $resource = TransactionResource::class;

    protected static string $view = 'filament.admin.resources.transaction-resource.view-transaction';

    public $transaction;

    protected static ?string $title = 'Lihat Transaksi';

    public function mount(Transaction $record)
    {
        $this->transaction = $record;
    }
}
