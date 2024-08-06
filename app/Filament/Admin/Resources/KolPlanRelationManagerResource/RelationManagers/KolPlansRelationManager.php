<?php

namespace App\Filament\Admin\Resources\KolPlanRelationManagerResource\RelationManagers;

use App\Models\KolPlan;
use App\Models\Setting;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KolPlansRelationManager extends RelationManager
{
    protected static string $relationship = 'kol_plans';

    public $realCost;
    public $setting;

    public function mount(): void
    {
        $this->setting = Setting::first();
        $this->realCost = $this->getOwnerRecord()->amount - ($this->getOwnerRecord()->amount * $this->setting->kol_fee_percentage / 100);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->recordAction('edit_perform')
            ->heading('Laporan Proyek - Manajemen KOL')
            ->headerActions([
                $this->createAction(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->rowIndex()
                    ->sortable(),

                Tables\Columns\TextColumn::make('influencer_name')
                    ->label('Nama Influencer')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('cost')
                    ->label('Biaya (Cost)')
                    ->prefix('Rp')
                    ->formatStateUsing(fn ($state) => isset($state) ? number_format($state, 0, ',', '.') : '-')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_followers')
                    ->label('Jumlah Pengikut (Followers)')
                    ->formatStateUsing(fn ($state) => isset($state) ? number_format($state, 0, ',', '.') : '-')
                    ->sortable()
                    ->searchable(),

                ColumnGroup::make('Performa')
                    ->columns([
                        Tables\Columns\TextColumn::make('views')
                            ->label('Tayangan (Views)')
                            ->formatStateUsing(fn ($state) => !empty($state) ? number_format($state, 0, ',', '.') : '-')
                            ->default(0)
                            ->sortable()
                            ->searchable(),

                        Tables\Columns\TextColumn::make('likes')
                            ->label('Disukai (Likes)')
                            ->formatStateUsing(fn ($state) => !empty($state) ? number_format($state, 0, ',', '.') : '-')
                            ->default(0)
                            ->sortable()
                            ->searchable(),

                        Tables\Columns\TextColumn::make('comments')
                            ->label('Komentar (Comments)')
                            ->formatStateUsing(fn ($state) => !empty($state) ? number_format($state, 0, ',', '.') : '-')
                            ->default(0)
                            ->sortable()
                            ->searchable(),

                        Tables\Columns\TextColumn::make('shares')
                            ->label('Dibagikan (Shares)')
                            ->formatStateUsing(fn ($state) => !empty($state) ? number_format($state, 0, ',', '.') : '-')
                            ->default(0)
                            ->sortable()
                            ->searchable(),

                        Tables\Columns\TextColumn::make('direct_purchases')
                            ->label('Pembelian (Direct Purchases)')
                            ->formatStateUsing(fn ($state) => !empty($state) ? number_format($state, 0, ',', '.') : '-')
                            ->default(0)
                            ->sortable()
                            ->searchable(),

                        Tables\Columns\TextColumn::make('cpm')
                            ->label('CPM')
                            ->prefix('Rp')
                            ->formatStateUsing(fn ($state) => !empty($state) ? number_format($state, 0, ',', '.') : '-')
                            ->default(0)
                            ->sortable()
                            ->searchable(),
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('edit_perform')
                        ->label('Edit Performa Influencer')
                        ->icon('tabler-graph')
                        ->form([
                            TextInput::make('post_url')
                                ->label('Link Postingan')
                                ->placeholder('Contoh: https://instagram.com/videos')
                                ->required(),

                            TextInput::make('views')
                                ->label('Jumlah Tayangan')
                                ->placeholder('Contoh: 100.000')
                                ->mask(RawJs::make('$money($input, \',\', \'.\', )'))
                                ->required(),

                            TextInput::make('likes')
                                ->label('Jumlah Disukai (Likes)')
                                ->placeholder('Contoh: 10.000')
                                ->mask(RawJs::make('$money($input, \',\', \'.\', )'))
                                ->required(),

                            TextInput::make('comments')
                                ->label('Jumlah Komentar (Comments)')
                                ->placeholder('Contoh: 10.000')
                                ->mask(RawJs::make('$money($input, \',\', \'.\', )'))
                                ->required(),

                            TextInput::make('shares')
                                ->label('Jumlah Dibagikan (Shares)')
                                ->placeholder('Contoh: 10.000')
                                ->mask(RawJs::make('$money($input, \',\', \'.\', )'))
                                ->required(),

                            TextInput::make('direct_purchases')
                                ->label('Jumlah Pembelian (Direct Purchases)')
                                ->placeholder('Contoh: 100.000')
                                ->mask(RawJs::make('$money($input, \',\', \'.\', )'))
                                ->required(),
                        ])
                        ->fillForm(fn ($record) => $record->toArray())
                        ->action(function ($data, $record) {
                            $data['views'] = preg_replace("/[^0-9]/", '', $data['views']);
                            $data['likes'] = preg_replace("/[^0-9]/", '', $data['likes']);
                            $data['comments'] = preg_replace("/[^0-9]/", '', $data['comments']);
                            $data['shares'] = preg_replace("/[^0-9]/", '', $data['shares']);
                            $data['direct_purchases'] = preg_replace("/[^0-9]/", '', $data['direct_purchases']);

                            $record->update($data);

                            Notification::make()
                                ->title('Berhasil memperbaharui performa influencer')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('edit')
                        ->label('Edit Influencer')
                        ->color('info')
                        ->icon('tabler-edit')
                        ->form([
                            TextInput::make('influencer_name')
                                ->label('Nama Influencer')
                                ->placeholder('Contoh: Atta Halilintar')
                                ->required(),

                            TextInput::make('influencer_url')
                                ->label('Link Influencer')
                                ->placeholder('Contoh: https://instagram.com/attahalilintar')
                                ->required(),

                            TextInput::make('total_followers')
                                ->label('Jumlah Pengikut (Followers)')
                                ->placeholder('Contoh: 10.000')
                                ->mask(RawJs::make('$money($input, \',\', \'.\', )'))
                                ->required(),

                            TextInput::make('cost')
                                ->label('Biaya (Cost)')
                                ->prefix('Rp')
                                ->mask(RawJs::make('$money($input, \',\', \'.\', )'))
                                ->rules([
                                    fn ($record) => function ($attribute, $value, $fail) use ($record) {
                                        $currentCost    = preg_replace("/[^0-9]/", '', $value);
                                        $submittedCost  = KolPlan::where('order_report_id', $this->getOwnerRecord()->order_report->id)
                                            ->where('id', '<>', $record->id)
                                            ->sum('cost');

                                        if ($currentCost + $submittedCost > $this->realCost) {
                                            $remainingCost = $this->realCost - $submittedCost;

                                            $fail('Biaya (cost) melebihi anggaran (budget) yang ditentukan pelanggan. Sisa anggaran Rp' . number_format(abs($remainingCost), 0, ',', '.'));
                                        }
                                    }
                                ])
                                ->placeholder('Contoh: 100.000')
                                ->required(),
                        ])
                        ->fillForm(fn ($record) => $record->toArray())
                        ->action(function ($data, $record) {
                            $data['cost'] = preg_replace("/[^0-9]/", '', $data['cost']);
                            $data['total_followers'] = preg_replace("/[^0-9]/", '', $data['total_followers']);

                            $record->update($data);

                            Notification::make()
                                ->title('Berhasil menambahkan influencer')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('delete')
                        ->label('Hapus Influencer')
                        ->color('danger')
                        ->icon('tabler-trash')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->delete();

                            Notification::make()
                                ->title('Berhasil menghapus influencer')
                                ->success()
                                ->send();
                        }),
                ])
            ], position: ActionsPosition::BeforeCells)
            ->bulkActions([
                //
            ]);
    }

    public function createAction(): Tables\Actions\Action
    {
        return Tables\Actions\Action::make('create')
            ->label('Tambah Influencer')
            ->icon('tabler-plus')
            ->form([
                TextInput::make('influencer_name')
                    ->label('Nama Influencer')
                    ->placeholder('Contoh: Atta Halilintar')
                    ->required(),

                TextInput::make('influencer_url')
                    ->label('Link Influencer')
                    ->placeholder('Contoh: https://instagram.com/attahalilintar')
                    ->required(),

                TextInput::make('total_followers')
                    ->label('Jumlah Pengikut (Followers)')
                    ->mask(RawJs::make('$money($input, \',\', \'.\', )'))
                    ->placeholder('Contoh: 10.000')
                    ->required(),

                TextInput::make('cost')
                    ->label('Biaya (Cost)')
                    ->prefix('Rp')
                    ->mask(RawJs::make('$money($input, \',\', \'.\', )'))
                    ->rules([
                        fn () => function ($attribute, $value, $fail) {
                            $currentCost    = preg_replace("/[^0-9]/", '', $value);
                            $submittedCost  = KolPlan::where('order_report_id', $this->getOwnerRecord()->order_report->id)->sum('cost');

                            if ($currentCost + $submittedCost > $this->realCost) {
                                $remainingCost = $this->realCost - $submittedCost;

                                $fail('Biaya (cost) melebihi anggaran (budget) yang ditentukan pelanggan. Sisa anggaran Rp' . number_format(abs($remainingCost), 0, ',', '.'));
                            }
                        }
                    ])
                    ->live()
                    ->placeholder('Contoh: 100.000')
                    ->required(),
            ])
            ->action(function ($data) {
                $data['cost'] = preg_replace("/[^0-9]/", '', $data['cost']);
                $data['total_followers'] = preg_replace("/[^0-9]/", '', $data['total_followers']);

                KolPlan::create(array_merge(['order_report_id' => $this->getOwnerRecord()->order_report->id], $data));

                Notification::make()
                    ->title('Berhasil menambahkan influencer')
                    ->success()
                    ->send();
            });
    }
}
