<?php

namespace App\Filament\Admin\Resources\ServiceResource\Pages;

use App\Filament\Admin\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected static ?string $breadcrumb = 'Daftar Layanan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Layanan Baru')
                ->icon('tabler-plus'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('index')
                    ->label('Nomor')
                    ->rowIndex(),

                ImageColumn::make('images.0')
                    ->label('Thumbnail Layanan')
                    ->default(asset('images/no-image.png'))
                    ->size('100px')
                    ->searchable(),

                TextColumn::make('code')
                    ->label('Kode Layanan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Layanan')
                    ->description(fn ($record) => substr(strip_tags($record->description), 0, 120))
                    ->wrap()
                    ->searchable()
                    ->sortable(),
            ])
            ->emptyStateIcon('tabler-mood-sad-dizzy')
            ->emptyStateDescription('Belum ada daftar layanan. Silakan klik tombol "Tambah Layanan Baru".')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Layanan Baru')
                    ->icon('tabler-plus'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view_packages')
                    ->label('Daftar Paket')
                    ->color('warning')
                    ->icon('tabler-folder')
                    ->url(fn ($record) => static::getResource()::getUrl('packages', ['record' => $record]))
                    ->button(),

                Tables\Actions\EditAction::make()
                    ->color('info')
                    ->icon('tabler-edit')
                    ->button(),

                Tables\Actions\DeleteAction::make()
                    ->icon('tabler-trash')
                    ->button(),
            ]);
    }
}
