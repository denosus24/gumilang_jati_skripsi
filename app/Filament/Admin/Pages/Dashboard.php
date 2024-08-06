<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'tabler-home';

    protected static ?string $title = 'Halaman Utama';

    protected static string $view = 'filament.admin.pages.dashboard';
}
