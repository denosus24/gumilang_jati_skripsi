<?php

namespace App\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Model::unguard();

        FilamentColor::register([
            'primary' => Color::hex('#2E66AF'),
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'success' => Color::Green,
            'warning' => Color::Amber,
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::anonymousComponentPath(__DIR__ . '/../../resources/views/frontpage/components', 'frontpage');
    }
}
