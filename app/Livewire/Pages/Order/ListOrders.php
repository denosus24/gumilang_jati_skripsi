<?php

namespace App\Livewire\Pages\Order;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListOrders extends Component implements HasForms, HasTable
{
    use InteractsWithTable,
        InteractsWithForms;

    #[Layout('frontpage.components.layouts.app')]

    public function render()
    {
        return view('frontpage.pages.order.list');
    }
}
