<?php

namespace App\Livewire\Pages\Order;

use App\Models\ContentPlan;
use App\Models\ContentPlanRevision;
use App\Models\KolPlan;
use App\Models\Order;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ViewOrder extends Component implements HasForms, HasTable
{
    use InteractsWithTable,
        InteractsWithForms;

    public $order;

    #[Layout('frontpage.components.layouts.app')]

    public function mount($order_number)
    {
        $this->order = Order::where('user_id', auth()->user()->id)->where('order_number', $order_number)->first();

        if (!$this->order) abort(403);
    }

    public function table(Table $table): Table
    {
        if (isset($this->order->order_report) && $this->order->package->service->service_category->code === 'SMM') {
            return $this->getContentPlans($table);
        } else if (isset($this->order->order_report) &&  $this->order->package->service->service_category->code === 'KOL') {
            return $this->getKolPlans($table);
        }

        return $table->heading('Laporan Proyek');
    }

    public function getContentPlans(Table $table): Table
    {
        $query = ContentPlan::query()->where('order_report_id', $this->order->order_report->id);

        return $table
            ->heading('Laporan Proyek - Manajemen Sosial Media')
            ->query($query)
            ->columns([
                TextColumn::make('no')
                    ->rowIndex()
                    ->sortable(),

                ImageColumn::make('asset')
                    ->label('Berkas Postingan')
                    ->url(fn ($state) => asset($state))
                    ->alignCenter()
                    ->openUrlInNewTab(),

                TextColumn::make('title')
                    ->label('Judul Postingan')
                    ->searchable(),

                TextColumn::make('caption')
                    ->label('Caption Postingan')
                    ->searchable(),

                TextColumn::make('content_plan_revisions_count')
                    ->counts('content_plan_revisions')
                    ->label('Sudah Direvisi')
                    ->suffix(' kali'),

                TextColumn::make('status')
                    ->label('Status Konten')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'uploaded'  => 'Terunggah. Menunggu Respon Client',
                        'revision_submitted'  => 'Revisi Terunggah. Menunggu Respon Client',
                        'revision'  => 'Menunggu Revisi',
                        'done'      => 'Sudah Sesuai',
                    })
                    ->color(fn ($state) => match ($state) {
                        'uploaded'  => 'warning',
                        'revision_submitted'  => 'info',
                        'revision'  => 'warning',
                        'done'      => 'success',
                    }),
            ])
            ->actions([
                Action::make('respond')
                    ->label('Tanggapi')
                    ->icon('tabler-send')
                    ->button()
                    ->form([
                        Checkbox::make('is_done')
                            ->label('Sudah Sesuai tidak perlu revisi')
                            ->live(),

                        RichEditor::make('detail')
                            ->label('Detail Revisi')
                            ->placeholder('Contoh: Gambar kurang menarik')
                            ->hidden(fn ($get) => $get('is_done'))
                            ->requiredIf('is_done', false),
                    ])
                    ->action(function ($data, $record) {
                        if ($data['is_done']) {
                            $record->update(['status' => 'done']);
                        } else {
                            $record->update(['status' => 'revision']);

                            $latestRevisionCount = ContentPlanRevision::where('content_plan_id', $record->id)->latest()->count();

                            ContentPlanRevision::firstOrCreate(
                                [
                                    'content_plan_id' => $record->id,
                                    'revision_no' => ($latestRevisionCount + 1),
                                ],
                                [
                                    'detail' => $data['detail'],
                                ]
                            );
                        }

                        Notification::make()
                            ->title('Berhasil mengirimkan tanggapan')
                            ->success()
                            ->send();
                    })
                    ->hidden(fn ($record) => !in_array($record->status, ['uploaded'])),

                Action::make('revision_submitted')
                    ->label('Lihat Revisi Terakhir')
                    ->icon('tabler-send')
                    ->button()
                    ->form([

                        Section::make('Hasil Revisi')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Postingan')
                                    ->disabled(),

                                TextInput::make('caption')
                                    ->label('Caption Postingan')
                                    ->disabled(),

                                FileUpload::make('asset')
                                    ->label('Berkas Postingan')
                                    ->disabled()
                                    ->openable()
                                    ->deletable(false)
                                    ->disabled(),
                            ]),

                        Section::make('Konfirmasi Hasil Revisi')
                            ->schema([
                                Checkbox::make('is_done')
                                    ->label('Sudah Sesuai tidak perlu revisi')
                                    ->live(),

                                RichEditor::make('detail')
                                    ->label('Detail Revisi')
                                    ->placeholder('Contoh: Gambar kurang menarik')
                                    ->hidden(fn ($get) => $get('is_done'))
                                    ->requiredIf('is_done', false),
                            ])

                    ])
                    ->fillForm(function ($record) {
                        $latestRevision = ContentPlanRevision::where('content_plan_id', $record->id)->latest()->first();

                        return $latestRevision->toArray();
                    })
                    ->action(function ($data, $record) {
                        $latestRevision = ContentPlanRevision::where('content_plan_id', $record->id)->latest()->first();

                        if ($data['is_done']) {
                            $latestRevision->update(['status' => 'done']);

                            $record->update(['status' => 'done']);
                        } else {
                            $latestRevision->update(['status' => 'revision']);

                            $record->update(['status' => 'revision']);

                            $latestRevisionCount = ContentPlanRevision::where('content_plan_id', $record->id)->latest()->count();

                            ContentPlanRevision::firstOrCreate(
                                [
                                    'content_plan_id' => $record->id,
                                    'revision_no' => ($latestRevisionCount + 1),
                                ],
                                [
                                    'detail' => $data['detail'],
                                ]
                            );
                        }

                        Notification::make()
                            ->title('Berhasil mengirimkan tanggapan')
                            ->success()
                            ->send();
                    })
                    ->hidden(fn ($record) => !in_array($record->status, ['revision_submitted'])),
            ]);
    }

    public function getKolPlans(Table $table): Table
    {
        $query = KolPlan::query()->where('order_report_id', $this->order->order_report->id);

        return $table
            ->heading('Laporan Proyek - Manajemen KOL')
            ->query($query)

            ->columns([
                TextColumn::make('no')
                    ->rowIndex()
                    ->sortable(),

                TextColumn::make('influencer_name')
                    ->label('Nama Influencer')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('cost')
                    ->label('Biaya (Cost)')
                    ->prefix('Rp')
                    ->formatStateUsing(fn ($state) => isset($state) ? number_format($state, 0, ',', '.') : '-')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('total_followers')
                    ->label('Jumlah Pengikut (Followers)')
                    ->formatStateUsing(fn ($state) => isset($state) ? number_format($state, 0, ',', '.') : '-')
                    ->sortable()
                    ->searchable(),

                ColumnGroup::make('Performa')
                    ->columns([
                        TextColumn::make('views')
                            ->label('Tayangan (Views)')
                            ->formatStateUsing(fn ($state) => !empty($state) ? number_format($state, 0, ',', '.') : '-')
                            ->default(0)
                            ->searchable(),

                        TextColumn::make('likes')
                            ->label('Disukai (Likes)')
                            ->formatStateUsing(fn ($state) => !empty($state) ? number_format($state, 0, ',', '.') : '-')
                            ->default(0)
                            ->searchable(),

                        TextColumn::make('comments')
                            ->label('Komentar (Comments)')
                            ->formatStateUsing(fn ($state) => !empty($state) ? number_format($state, 0, ',', '.') : '-')
                            ->default(0)
                            ->searchable(),

                        TextColumn::make('shares')
                            ->label('Dibagikan (Shares)')
                            ->formatStateUsing(fn ($state) => !empty($state) ? number_format($state, 0, ',', '.') : '-')
                            ->default(0)
                            ->searchable(),

                        TextColumn::make('direct_purchases')
                            ->label('Pembelian (Direct Purchases)')
                            ->formatStateUsing(fn ($state) => !empty($state) ? number_format($state, 0, ',', '.') : '-')
                            ->default(0)
                            ->searchable(),
                    ]),
            ])
            ->actions([
                //
            ]);
    }

    public function render()
    {
        return view('frontpage.pages.order.view')
            ->title($this->order->order_number);
    }
}
