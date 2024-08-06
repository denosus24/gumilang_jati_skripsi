<?php

namespace App\Livewire\Pages\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Register extends BaseRegister
{
    #[Layout('frontpage.components.layouts.app')]
    #[Title('Daftar Akun Gumilang Jati')]

    protected static string $view = 'frontpage.pages.auth.register';

    public function mount(): void
    {
        if (Auth::check()) {
            redirect()->intended(route('frontpage.home'));
        }

        $this->callHook('beforeFill');

        $this->form->fill();

        $this->callHook('afterFill');
    }

    public function getMaxWidth(): MaxWidth|string|null
    {
        return MaxWidth::Large;
    }

    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->required()
            ->maxLength(255)
            ->label('Nama Lengkap')
            ->placeholder('Masukkan nama lengkap Anda');
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->email()
            ->required()
            ->unique($this->getUserModel())
            ->maxLength(255)
            ->label('Email')
            ->placeholder('Masukkan alamat email akun Anda');
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->password()
            ->revealable()
            ->required()
            ->rule(Password::default())
            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'))
            ->label('Kata Sandi')
            ->placeholder('* * * * * *');
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->password()
            ->revealable()
            ->required()
            ->dehydrated(false)
            ->label('Konfirmasi Kata Sandi')
            ->placeholder('* * * * * *');
    }

    public function loginAction(): Action
    {
        return Action::make('login')
            ->link()
            ->label('Masuk Akun')
            ->url(route('frontpage.auth.login'));
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['role'] = 'customer';

        return $data;
    }

    public function registerWithRedirection()
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $this->callHook('beforeValidate');

        $data = $this->form->getState();

        $this->callHook('afterValidate');

        $data = $this->mutateFormDataBeforeRegister($data);

        $this->callHook('beforeRegister');

        $user = $this->handleRegistration($data);

        $this->form->model($user)->saveRelationships();

        $this->callHook('afterRegister');

        $this->sendEmailVerificationNotification($user);

        Auth::login($user);

        session()->regenerate();

        return redirect()->route('frontpage.home');
    }

    protected function getUserModel(): string
    {
        return User::class;
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }
}
