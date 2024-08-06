<?php

namespace App\Livewire\Pages;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Home extends Component
{
    #[Layout('frontpage.components.layouts.app')]
    #[Title('Halaman Utama')]

    public $services;

    public function mount()
    {
        $this->services = Service::all();
    }

    public function render()
    {
        return view('frontpage.pages.home');
    }
}
