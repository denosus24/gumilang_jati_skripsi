<?php

namespace App\Livewire\Pages\ServiceCategory;

use App\Models\ServiceCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ListServiceCategories extends Component
{
    #[Layout('frontpage.components.layouts.app')]

    public $code;
    public $serviceCategory;

    public function mount(string $code)
    {
        $this->serviceCategory  = ServiceCategory::where('code', $code)->first();
    }

    public function render()
    {
        return view('frontpage.pages.service-categories.index')
            ->title('Layanan ' . $this->serviceCategory->name);
    }
}
