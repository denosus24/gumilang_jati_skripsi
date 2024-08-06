<?php

namespace App\Livewire\Components;

use App\Models\Cart;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use LaraZeus\Quantity\Components\Quantity;
use Livewire\Component;

class CartComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public Cart $cart;
    public ?array $data = [];

    public function mount()
    {
        $this->form->fill($this->cart->toArray());
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Quantity::make('quantity')
                ->label('Jumlah paket')
                ->maxValue(12)
                ->live()
                ->afterStateUpdated(function ($record, callable $set, int $state) {
                    if ($state < 1) {
                        $record->delete();

                        $this->dispatch('refreshCart');
                    } else {
                        $record->quantity = $state;
                        $record->save();

                        $this->dispatch('updateOrderAmount', total: $this->getOrderAmount());
                    }
                }),

        ])
            ->statePath('data')
            ->model($this->cart);
    }

    protected function getOrderAmount(): int
    {
        $carts = Cart::where('user_id', auth()->user()->id)->get();

        return $carts->sum(function ($item) {
            if ($item->budget > 0) {
                return $item->budget;
            } else {
                return $item->quantity * ($item->package->price - $item->package->fixed_discount);
            }
        });
    }

    public function render()
    {
        return <<<'HTML'
        <div>
        {{ $this->form }}
        </div>
        HTML;
    }
}
