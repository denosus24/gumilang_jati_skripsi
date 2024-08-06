<?php

namespace App\Livewire\Pages\Service;

use App\Models\Cart;
use App\Models\Package;
use App\Models\Service;
use Filament\Forms\Components\Component as FilamentComponent;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use LaraZeus\Quantity\Components\Quantity;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ViewService extends Component implements HasForms
{
    use InteractsWithForms;

    #[Layout('frontpage.components.layouts.app')]

    public $code;
    public $service;
    public $selectedPackage;
    public ?array $data = [];

    public function mount(string $code)
    {
        $this->service  = Service::where('code', $code)->first();
        $this->selectedPackage = Package::where('service_id', $this->service->id)->first();

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Quantity::make('quantity')
                ->label('Mau ambil berapa bulan?')
                ->default(1)
                ->minValue(1)
                ->maxValue(12),

            Select::make('package_id')
                ->options($this->service->packages->pluck('name', 'id'))
                ->label('Paket Dipilih')
                ->default(fn () => $this->service->packages->count() < 1 ? 0 : $this->service->packages[0]->id)
                ->live()
                ->afterStateUpdated(function ($state, $set) {
                    $this->selectedPackage = Package::find($state);

                    $set('budgetPlaceholder', number_format($this->selectedPackage->price, 0, ',', '.'));
                })
                ->native(false)
                ->required(),
        ])
            ->statePath('data');
    }

    public function create()
    {
        $this->validate();

        if (!auth()->user()) {
            return redirect()->route('frontpage.auth.login');
        }

        Cart::updateOrCreate(
            [
                'user_id'   => auth()->user()->id,
                'package_id' => $this->data['package_id'],
            ],
            [
                'quantity'  => $this->data['quantity'],
            ]
        );

        return redirect()->route('frontpage.checkout');
    }

    public function render()
    {
        return view('frontpage.pages.service.view')
            ->title('Layanan ' . $this->service->name);
    }
}
