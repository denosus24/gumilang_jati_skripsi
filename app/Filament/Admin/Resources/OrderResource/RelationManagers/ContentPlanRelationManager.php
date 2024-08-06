<?php

namespace App\Filament\Admin\Resources\OrderResource\RelationManagers;

use App\Models\ContentPlan;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ContentPlanRelationManager extends RelationManager
{
    protected static string $relationship = 'content_plans';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->heading('Laporan Proyek - Manajemen Sosial Media')
            ->headerActions([
                $this->createAction(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->rowIndex()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('asset')
                    ->label('Berkas Postingan')
                    ->url(fn ($state) => asset($state))
                    ->alignCenter()
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Postingan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('caption')
                    ->label('Caption Postingan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('content_plan_revisions_count')
                    ->counts('content_plan_revisions')
                    ->label('Sudah Direvisi')
                    ->suffix(' kali'),

                Tables\Columns\TextColumn::make('content_plan_revisions')
                    ->label('Detail Revisi Terakhir')
                    ->formatStateUsing(function ($record) {
                        $latestRevision = $record->content_plan_revisions()->latest()->first();

                        return $latestRevision?->detail ?? '';
                    })
                    ->html()
                    ->default('-'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status Konten')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'uploaded'  => 'Terunggah. Menunggu Respon Client',
                        'revision_submitted'  => 'Revisi Terunggah. Menunggu Respon Client',
                        'revision'  => 'Perlu Revisi',
                        'done'      => 'Sudah Sesuai',
                    })
                    ->color(fn ($state) => match ($state) {
                        'uploaded'  => 'warning',
                        'revision_submitted'  => 'warning',
                        'revision'  => 'info',
                        'done'      => 'success',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('revise')
                    ->label('Revisi Konten')
                    ->button()
                    ->icon('tabler-edit')
                    ->form([
                        Placeholder::make('detail')
                            ->label('Detail Revisi')
                            ->content(fn ($state) => new HtmlString($state)),

                        TextInput::make('title')
                            ->label('Judul Postingan')
                            ->placeholder('Contoh: Pasti hebat! Gunakan content planner dari Gumilangjati SMM')
                            ->required(),

                        Textarea::make('caption')
                            ->label('Caption Postingan')
                            ->placeholder('Contoh: Pasti hebat! Gunakan content planner dari Gumilangjati SMM. Coba sekarang! #contentplanner #gumilangjati')
                            ->required(),

                        FileUpload::make('asset')
                            ->image()
                            ->label('Berkas Postingan')
                            ->moveFiles()
                            ->maxFiles(5120)
                            ->getUploadedFileNameForStorageUsing(
                                fn (TemporaryUploadedFile $file): string => (string) 'content-plan-' . time() . '.' . $file->getClientOriginalExtension()
                            )
                            ->directory('reports/' . $this->getOwnerRecord()->id)
                            ->required(),
                    ])
                    ->fillForm(function ($record) {
                        $latestRevision = $record->content_plan_revisions()->latest()->first();

                        $data = $record->only(['title', 'caption']);
                        $data['detail'] = $latestRevision->detail;

                        return $data;
                    })
                    ->action(function ($data, $record) {
                        $latestRevision = $record->content_plan_revisions()->latest()->first();

                        if ($record->content_plan_revisions()->count() >= 2) {
                            $record->update(['status' => 'done']);
                            $latestRevision->update(array_merge($data, ['status' => 'done']));
                        } else {
                            $latestRevision->update(array_merge($data, ['status' => 'uploaded']));
                            $record->update(['status' => 'revision_submitted']);
                        }

                        Notification::make()
                            ->title('Berhasil mengunggah revisi konten postingan')
                            ->success()
                            ->send();
                    })
                    ->hidden(fn ($record) => $record->status !== 'revision'),
            ])
            ->bulkActions([
                //
            ]);
    }

    public function createAction(): Tables\Actions\Action
    {
        return Tables\Actions\Action::make('create')
            ->label('Tambah Konten Postingan')
            ->icon('tabler-plus')
            ->form([
                TextInput::make('title')
                    ->label('Judul Postingan')
                    ->placeholder('Contoh: Pasti hebat! Gunakan content planner dari Gumilangjati SMM')
                    ->required(),

                Textarea::make('caption')
                    ->label('Caption Postingan')
                    ->placeholder('Contoh: Pasti hebat! Gunakan content planner dari Gumilangjati SMM. Coba sekarang! #contentplanner #gumilangjati')
                    ->required(),

                FileUpload::make('asset')
                    ->image()
                    ->label('Berkas Postingan')
                    ->moveFiles()
                    ->maxFiles(5120)
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => (string) 'content-plan-' . time() . '.' . $file->getClientOriginalExtension()
                    )
                    ->directory('reports/' . $this->getOwnerRecord()->id)
                    ->required(),
            ])
            ->action(function ($data) {
                ContentPlan::create(array_merge(['order_report_id' => $this->getOwnerRecord()->order_report->id], $data));

                Notification::make()
                    ->title('Berhasil mengunggah konten postingan')
                    ->success()
                    ->send();
            });
    }
}
