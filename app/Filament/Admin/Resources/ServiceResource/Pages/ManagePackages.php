<?php

namespace App\Filament\Admin\Resources\ServiceResource\Pages;

use App\Filament\Admin\Resources\ServiceResource;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ManagePackages extends ManageRelatedRecords
{
    protected static string $resource = ServiceResource::class;

    protected static string $relationship = 'packages';

    protected static ?string $title = 'Paket Layanan';

    public function getTitle(): string|Htmlable
    {
        return 'Paket Layanan: ' . $this->record->name;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Kode Paket')
                    ->placeholder('Contoh: SMM-01-PKG-BASIC')
                    ->required()
                    ->columnSpan(1),

                TextInput::make('name')
                    ->label('Nama Paket')
                    ->placeholder('Contoh: Paket Basic')
                    ->required()
                    ->columnSpan(2),

                RichEditor::make('description')
                    ->label('Deskripsi Paket')
                    ->disableToolbarButtons(['image'])
                    ->required()
                    ->columnSpanFull(),

                Fieldset::make('Ketentuan Paket Layanan')
                    ->schema([
                        TextInput::make('price')
                            ->label('Harga Dasar')
                            ->placeholder('Contoh: 20.000')
                            ->prefix('Rp')
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('final_price')
                            ->label('Harga Akhir')
                            ->placeholder('Contoh: 10.000')
                            ->live(debounce: '1s')
                            ->prefix('Rp')
                            ->formatStateUsing(fn (callable $get) => $get('price') - $get('fixed_discount'))
                            ->afterStateUpdated(function (callable $set, callable $get, $state) {
                                $percentageDiscount = round(($get('price') - $state) / $get('price') * 100);
                                $fixedDiscount = $get('price') - $state;

                                $set('percentage_discount', $percentageDiscount);
                                $set('fixed_discount', $fixedDiscount);
                            })
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('percentage_discount')
                            ->label('Persentase Diskon')
                            ->placeholder('Contoh: 20')
                            ->live(debounce: '1s')
                            ->suffix('%')
                            ->formatStateUsing(fn (callable $get) => round($get('fixed_discount') / $get('price') * 100))
                            ->readOnly()
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('fixed_discount')
                            ->label('Nominal Diskon')
                            ->placeholder('Contoh: 20.000')
                            ->prefix('Rp')
                            ->live(debounce: '1s')
                            ->formatStateUsing(fn (callable $get) => $get('price') * $get('percentage_discount') / 100)
                            ->readOnly()
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('estimated_days')
                            ->label('Estimasi Pengerjaan')
                            ->placeholder('Contoh: 1 - 2')
                            ->suffix('Hari')
                            ->required()
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),

                Repeater::make('includes')
                    ->label('Layanan Termasuk')
                    ->simple(
                        TextInput::make('includes')
                            ->label('Layanan Termasuk')
                            ->placeholder('Contoh: Pembuatan Poster Iklan 1:1')
                    )
                    ->required()
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->contentGrid([
                'md' => '2',
                'xl' => '3',
            ])
            ->columns([
                Stack::make([
                    TextColumn::make('code')
                        ->label('Kode Paket')
                        ->searchable()
                        ->sortable(),

                    TextColumn::make('name')
                        ->label('Nama Paket')
                        ->searchable()
                        ->description(fn ($record) => strip_tags($record->description))
                        ->searchable()
                        ->sortable(),

                    TextColumn::make('price')
                        ->label('Harga Dasar')
                        ->prefix('Rp')
                        ->extraAttributes(['class' => 'text-lg font-bold'])
                        ->formatStateUsing(fn ($record) => number_format($record->price - $record->fixed_discount, 0, ',', '.')),

                    TextColumn::make('fixed_discount')
                        ->label('Diskon')
                        ->badge()
                        ->prefix('Diskon: ')
                        ->formatStateUsing(fn ($record) => round($record->fixed_discount / $record->price * 100))
                        ->color('danger')
                        ->suffix('%'),
                ]),
            ])
            ->emptyStateIcon('tabler-mood-sad-dizzy')
            ->emptyStateDescription('Belum ada daftar paket. Silakan klik tombol "Tambah Paket Baru".')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Paket Baru')
                    ->icon('tabler-plus'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Paket Baru')
                    ->icon('tabler-plus')
                    ->modalHeading('Tambah Paket Baru')
                    ->mutateFormDataUsing(function ($data) {
                        unset($data['final_price']);
                        unset($data['percentage_discount']);

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button()
                    ->icon('tabler-edit')
                    ->modalHeading('Edit Paket')
                    ->mutateFormDataUsing(function ($data) {
                        unset($data['final_price']);
                        unset($data['percentage_discount']);

                        return $data;
                    }),

                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->icon('tabler-trash'),
            ]);
    }
}
