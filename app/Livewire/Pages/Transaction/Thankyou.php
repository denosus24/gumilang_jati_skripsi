<?php

namespace App\Livewire\Pages\Transaction;

use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class Thankyou extends Component
{
    #[Layout('frontpage.components.layouts.app')]

    #[Url]
    public $merchantOrderId;

    public function render()
    {
        $invoiceNumber = explode('_', $this->merchantOrderId)[0];

        Transaction::where('invoice_number', $invoiceNumber)->update(['status' => 'paid']);

        return view('frontpage.pages.transaction.thankyou')
            ->title('Terima kasih telah menggunakan jasa kami');
    }
}
