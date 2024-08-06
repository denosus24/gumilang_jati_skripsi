<?php

namespace App\Filament\Admin\Resources\CustomerResource\Pages;

use App\Filament\Admin\Resources\CustomerResource;
use Filament\Actions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->modifyQueryUsing(fn ($query) => $query->where('role', 'customer'))
            ->columns([
                TextColumn::make('index')
                    ->label('Nomor')
                    ->rowIndex(),

                ImageColumn::make('avatar')
                    ->label('Foto Profil')
                    ->default(asset('images/no-image.png'))
                    ->size('50px')
                    ->circular()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone_number')
                    ->label('No. Telepon')
                    ->searchable()
                    ->sortable(),
            ])
            ->emptyStateIcon('tabler-mood-sad-dizzy')
            ->emptyStateDescription('Belum ada daftar pelanggan.')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('reset_password')
                    ->label('Reset Kata Sandi')
                    ->form([
                        Placeholder::make('name')
                            ->label('Nama Pelanggan')
                            ->content(fn ($record) => $record->name),

                        Placeholder::make('email')
                            ->label('Email Pelanggan')
                            ->content(fn ($record) => $record->email),

                        TextInput::make('password')
                            ->label('Kata Sandi Baru')
                            ->placeholder('Masukkan kata sandi baru')
                            ->required()
                            ->password()
                            ->revealable(),

                        TextInput::make('passwordConfirmation')
                            ->label('Konfirmasi Kata Sandi Baru')
                            ->placeholder('Masukkan konfirmasi kata sandi baru')
                            ->required()
                            ->same('password')
                            ->password()
                            ->revealable(),
                    ])
                    ->action(function ($data, $record) {
                        $record->update(['password' => password_hash($data['password'], PASSWORD_DEFAULT)]);

                        Notification::make()
                            ->title('Berhasil mereset kata sandi')
                            ->success()
                            ->send();
                    })
                    ->modalSubmitActionLabel('Reset Kata Sandi')
                    ->modalWidth(MaxWidth::Large)
                    ->color('info')
                    ->icon('tabler-lock')
                    ->button(),

                Tables\Actions\DeleteAction::make()
                    ->icon('tabler-trash')
                    ->button(),
            ]);
    }
}
