<?php

namespace App\Livewire\Pages\Auth;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Component as FormComponent;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Profile extends Component implements HasForms, HasActions
{
    use InteractsWithForms,
        InteractsWithActions,
        InteractsWithFormActions;


    #[Layout('frontpage.components.layouts.app')]
    #[Title('Profil Saya')]

    public $user;
    public $title;
    public ?array $data = [];

    public function mount()
    {
        $this->user = User::find(auth()->user()->id);
        $this->title = 'Profil Saya';

        $this->form->fill($this->user->toArray());
    }

    public function getMaxWidth(): MaxWidth|string|null
    {
        return MaxWidth::SixExtraLarge;
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Ubah Profil')
                ->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->label('Nama Lengkap')
                                ->placeholder('Masukkan nama lengkap Anda')
                                ->columnSpan(1),

                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique(User::class, ignorable: $this->user)
                                ->maxLength(255)
                                ->label('Email')
                                ->placeholder('Masukkan alamat email akun Anda')
                                ->columnSpan(1),

                            TextInput::make('phone_number')
                                ->numeric()
                                ->maxLength(255)
                                ->label('Nomor Telepon')
                                ->placeholder('Masukkan nomor telepon Anda')
                                ->columnSpan(1),
                        ])
                        ->columns(1)
                        ->columnSpan(1),

                    Grid::make()->columnSpan(1),

                    FileUpload::make('avatar')
                        ->label('Foto Profil')
                        ->avatar()
                        ->moveFiles()
                        ->directory('avatars'),
                ])
                ->columns(3),
        ])
            ->statePath('data');
    }

    public function updateProfile()
    {
        $this->validate();

        $data = $this->form->getState();

        $this->user->update($data);

        Notification::make()
            ->title('Berhasil memperbaharui profil')
            ->success()
            ->send();
    }

    public function getUpdatePasswordAction()
    {
        return Action::make('update_password')
            ->form([
                TextInput::make('old_password')
                    ->password()
                    ->revealable()
                    ->required()
                    ->rule(RulesPassword::default())
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->same('passwordConfirmation')
                    ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'))
                    ->label('Kata Sandi')
                    ->placeholder('* * * * * *'),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required()
                    ->rule(RulesPassword::default())
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->same('passwordConfirmation')
                    ->label('Kata Sandi')
                    ->placeholder('* * * * * *'),

                TextInput::make('passwordConfirmation')
                    ->password()
                    ->revealable()
                    ->required()
                    ->dehydrated(false)
                    ->label('Konfirmasi Kata Sandi')
                    ->placeholder('* * * * * *')
            ]);
    }

    public function render()
    {
        return view('frontpage.pages.auth.profile');
    }
}
