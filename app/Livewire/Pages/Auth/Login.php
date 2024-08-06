<?php

namespace App\Livewire\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Login extends BaseLogin
{
    #[Layout('frontpage.components.layouts.app')]
    #[Title('Masuk Akun')]

    protected static string $view = 'frontpage.pages.auth.login';

    public ?array $data = [];

    public function mount(): void
    {
        if (Auth::check()) {
            redirect()->intended(route('frontpage.home'));
        }

        $this->form->fill();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->placeholder('Masukkan email kamu')
            ->label('Email')
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->placeholder('* * * * * *')
            ->label('Kata Sandi')
            ->password()
            ->autocomplete('current-password')
            ->required()
            ->revealable()
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label('Ingat saya');
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label('Masuk Akun')
            ->submit('authenticate');
    }

    public function authenticateWithRedirection()
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        if (!Auth::attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = Auth::user();

        if ($user->role !== 'customer') {
            Auth::logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return redirect()->route('frontpage.home');
    }


    public function registerAction(): Action
    {
        return Action::make('register')
            ->link()
            ->url(route('frontpage.auth.register'))
            ->color(Color::hex('#329bFd'))
            ->label('Daftar Sekarang');
    }
}
