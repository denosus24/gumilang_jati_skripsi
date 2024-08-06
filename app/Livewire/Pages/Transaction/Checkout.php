<?php

namespace App\Livewire\Pages\Transaction;

use App\Helpers\DuitkuTransaction;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderReport;
use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use LaraZeus\Quantity\Components\Quantity;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Checkout extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    #[Layout('frontpage.components.layouts.app')]

    public $carts;
    public ?array $data = [];
    public $orderAmount = 0;

    protected $listeners = [
        'refreshCart' => '$refresh',
    ];

    public function mount()
    {
        $this->carts         = Cart::where('user_id', auth()->user()->id)->get();
        $this->orderAmount  = $this->carts->sum(fn ($item) => $item->quantity * ($item->package->price - $item->package->fixed_discount));
    }

    public function removeCartAction(): Action
    {
        return Action::make('remove_cart')
            ->hiddenLabel()
            ->icon('tabler-trash')
            ->link()
            ->color('danger')
            ->requiresConfirmation();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('phone_number')
                ->label('Nomor Telepon / Whatsapp')
                ->placeholder('Contoh: 083814702744')
                ->required(),

            Textarea::make('briefs')
                ->label('Detail Kebutuhan')
                ->placeholder('Contoh: Saya memiliki kebutuhan untuk desain instagram saya yaitu, @foodies, yang berisi tentang review makanan')
                ->rows(5)
                ->required(),

            Textarea::make('note')
                ->rows(3)
                ->placeholder('Contoh: Jangan gunakan warna yang bertabrakan / komplementer')
                ->label('Catatan'),
        ])
            ->statePath('data');
    }

    public function checkout()
    {
        $transaction = new Transaction();

        $carts = Cart::where('user_id', auth()->user()->id)->get();

        $baseAmount     = $carts->sum(function ($item) {
            return ($item->budget > 0) ? $item->budget : $item->quantity * $item->package->price;
        });
        $discountAmount = $carts->sum(fn ($item) => $item->quantity * $item->package->fixed_discount);
        $amount         = $carts->sum(function ($item) {
            return ($item->budget > 0) ? $item->budget : $item->quantity * ($item->package->price - $item->package->fixed_discount);
        });

        $transaction->invoice_number    = 'INV-' . date('YmdHi');
        $transaction->user_id           = auth()->user()->id;
        $transaction->user_name         = auth()->user()->name;
        $transaction->base_amount       = $baseAmount;
        $transaction->discount_amount   = $discountAmount;
        $transaction->amount            = $amount;
        $transaction->phone_number      = $this->data['phone_number'];
        $transaction->save();

        foreach ($carts as $cart) {
            $order = new Order();
            $order->order_number        = 'ORDER-' . time();
            $order->transaction_id      = $transaction->id;
            $order->user_id             = $transaction->user_id;
            $order->package_id          = $cart->package_id;
            $order->user_name           = $transaction->user->name;
            $order->package_name        = $cart->package->service->name . ' / ' . $cart->package->name;
            $order->quantity            = $cart->quantity;
            $order->base_amount         = $cart->budget > 0 ? $cart->budget : $cart->package->price;
            $order->discount_amount     = $cart->package->fixed_discount;
            $order->amount              = $cart->budget > 0 ? $cart->budget : $cart->package->price - $cart->package->fixed_discount;
            $order->phone_number        = $this->data['phone_number'];
            $order->briefs              = $this->data['briefs'];
            $order->note                = $this->data['note'] ?? '';
            $order->save();

            $orderReport = new OrderReport();
            $orderReport->order_id = $order->id;
            $orderReport->save();
        }

        $duitkuTransaction  = new DuitkuTransaction();
        $duitkuInvoice      = $duitkuTransaction->createInvoice($transaction);

        Cart::where('user_id', auth()->user()->id)->delete();

        return redirect()->to($duitkuInvoice['paymentUrl']);
    }

    #[On('updateOrderAmount')]
    public function updateOrderAmount($total)
    {
        $this->orderAmount = $total;
    }

    public function render()
    {
        return view('frontpage.pages.transaction.checkout')
            ->title('Checkout Pesanan');
    }
}
