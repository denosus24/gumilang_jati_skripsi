<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Resources\KolPlanRelationManagerResource\RelationManagers\KolPlansRelationManager;
use App\Filament\Admin\Resources\OrderResource;
use App\Filament\Admin\Resources\OrderResource\RelationManagers\ContentPlanRelationManager;
use App\Models\ContentPlan;
use App\Models\OrderReport;
use Filament\Infolists\Components\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\HtmlString;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Section::make('Detail Pesanan')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status Pesanan')
                            ->badge()
                            ->formatStateUsing(fn ($state) => match ($state) {
                                'pending' => new HtmlString('<span class="text-lg px-3">Pesanan Baru</span>'),
                                'ongoing' => new HtmlString('<span class="text-lg px-3">Sedang Dikerjakan</span>'),
                                'revision' => new HtmlString('<span class="text-lg px-3">Tahap Revisi</span>'),
                                'done' => new HtmlString('<span class="text-lg px-3">Pesanan Selesai</span>'),
                            })
                            ->color(fn ($state) => match ($state) {
                                'pending' => 'warning',
                                'ongoing' => 'info',
                                'revision' => 'info',
                                'done' => 'success',
                            }),

                        TextEntry::make('order_number')
                            ->label('No. Pesanan')
                            ->formatStateUsing(fn ($state) => new HtmlString('<p class="text-xl font-medium">' . $state . '</p>')),

                        TextEntry::make('user_name')
                            ->label('Nama Pelanggan')
                            ->formatStateUsing(fn ($record) => $record->user_name . ' (' . $record->phone_number . ')'),

                        Split::make([
                            TextEntry::make('package_name')
                                ->label('Nama Paket yang Dipesan')
                                ->formatStateUsing(fn ($record) => $record->package_name . ' x ' . $record->quantity)
                                ->columnSpan(1),

                            TextEntry::make('kol_real_cost')
                                ->label('Anggaran KOL Pelanggan')
                                ->formatStateUsing(fn ($record) => new HtmlString('<p class="text-lg font-medium">Rp' .  number_format($record->kol_real_cost, 0, ',', '.') . '</p>'))
                                ->helperText('Anggaran KOL sudah dipotong komisi untuk aplikasi')
                                ->hidden(fn ($record) => $record->package->service->service_category->code === 'SMM'),

                            TextEntry::make('amount')
                                ->label('Total Pembelian')
                                ->formatStateUsing(fn ($record) => new HtmlString('<p class="text-lg font-medium">Rp' .  number_format($record->amount, 0, ',', '.') . '</p>')),
                        ])
                            ->columns(3),

                        TextEntry::make('briefs')
                            ->label('Briefing dari Pelanggan')
                            ->default('-')
                            ->html(),

                        Split::make([
                            TextEntry::make('order_report.description')
                                ->label('Deskripsi Laporan')
                                ->default('-')
                                ->html()
                                ->columnSpan(1),

                            TextEntry::make('order_report.attachment_link')
                                ->label('Link Berkas')
                                ->default('-')
                                ->columnSpan(1),
                        ])
                            ->columns(2)
                    ])
                    ->footerActions([
                        Action::make('edit')
                            ->label('Edit Deskripsi Laporan')
                            ->icon('tabler-edit')
                            ->form([
                                RichEditor::make('description')
                                    ->label('Deskripsi Laporan')
                                    ->placeholder('Contoh: Laporan ini sesuai dengan guidelines yang diberikan client'),

                                TextInput::make('attachment_link')
                                    ->label('Link Berkas (Opsional)')
                                    ->placeholder('Contoh: https://drive.google.com'),
                            ])
                            ->action(function ($data) {
                                if (!$this->record->order_report) {
                                    OrderReport::create(array_merge(['order_id' => $this->record->id], $data));
                                } else {
                                    $this->record->order_report->update($data);
                                }

                                Notification::make()
                                    ->title('Berhasil memperbaharui deskripsi laporan')
                                    ->success()
                                    ->send();
                            }),

                        Action::make('mark_as_ongoing')
                            ->color('info')
                            ->label('Tandai Sedang Dikerjakan')
                            ->icon('tabler-writing')
                            ->requiresConfirmation()
                            ->hidden(fn () => in_array($this->record->status, ['ongoing', 'revision', 'done']))
                            ->action(function () {
                                $this->record->update(['status' => 'ongoing']);

                                OrderReport::firstOrCreate(['order_id' => $this->record->id]);

                                Notification::make()
                                    ->title('Pesanan berubah status menjadi sedang dikerjakan')
                                    ->success()
                                    ->send();
                            }),

                        Action::make('mark_as_done')
                            ->color('success')
                            ->label('Tandai Sudah Selesai')
                            ->icon('tabler-check')
                            ->requiresConfirmation()->action(function () {
                                $this->record->update(['status' => 'done']);

                                Notification::make()
                                    ->title('Pesanan berubah status menjadi sedang dikerjakan')
                                    ->success()
                                    ->send();
                            })
                            ->hidden(function () {
                                if ($this->record->package->service->service_category->code === 'SMM') {
                                    $orderHasNotDone = ContentPlan::where('status', '<>', 'done')->where('order_report_id', $this->record->order_report->id)->count();

                                    return $orderHasNotDone > 1 || in_array($this->record->status, ['pending', 'done']);
                                } else {
                                    return in_array($this->record->status, ['pending', 'done']);
                                }
                            }),
                    ])
            ]);
    }

    public function getRelationManagers(): array
    {
        if ($this->record->package->service->service_category->code === 'SMM') {
            return [ContentPlanRelationManager::class];
        } elseif ($this->record->package->service->service_category->code === 'KOL') {
            return [KolPlansRelationManager::class];
        }
    }
}
