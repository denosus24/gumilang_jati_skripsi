<?php

namespace App\Filament\Admin\Pages;

use App\Models\ChMessage;
use Filament\Pages\Page;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $title = 'Kotak Masuk';

    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return ChMessage::userUnread()->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'danger';
    }

    public function mount()
    {
        redirect()->route('message');
    }
}
