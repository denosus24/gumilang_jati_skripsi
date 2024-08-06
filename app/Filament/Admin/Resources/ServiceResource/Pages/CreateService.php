<?php

namespace App\Filament\Admin\Resources\ServiceResource\Pages;

use App\Filament\Admin\Resources\ServiceResource;
use App\Models\ServiceCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected static ?string $title = 'Tambah Layanan';

    protected static ?string $breadcrumb = 'Tambah Layanan';

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Layanan')
                ->description('Isikan dengan detail informasi mengenai kode dan nama layanan')
                ->schema([
                    Select::make('service_category_id')
                        ->options(ServiceCategory::all()->pluck('name', 'id'))
                        ->native(false)
                        ->label('Jenis Layanan')
                        ->required()
                        ->columnSpan(1),

                    TextInput::make('code')
                        ->label('Kode Layanan')
                        ->placeholder('Contoh: SMM-01')
                        ->required()
                        ->columnSpan(1),

                    TextInput::make('name')
                        ->label('Nama Layanan')
                        ->placeholder('Contoh: Social Media Management')
                        ->required()
                        ->columnSpan(2),
                ])
                ->columns(3),

            Section::make('Gambar Portfolio')
                ->description('Isikan gambar portfolio dalam ukuran landscape sebagai slider')
                ->schema([
                    FileUpload::make('images')
                        ->label('Gambar Portfolio')
                        ->directory('services')
                        ->multiple()
                        ->required()
                        ->image()
                        ->maxSize('5120')
                        ->panelLayout('grid'),
                ]),

            Section::make('Deskripsi Layanan')
                ->description()
                ->schema([
                    RichEditor::make('description')
                        ->label('Deskripsi Layanan')
                        ->placeholder('Contoh: Social Media Management adalah layanan dari Gumilang Jati di mana kamu tidak perlu repot mengurus konten sosial media.'),
                ]),

            Section::make('Keunggulan Layanan')
                ->description()
                ->schema([
                    Repeater::make('advantages')
                        ->label('Daftar Keunggulan Layanan')
                        ->simple(
                            TextInput::make('advantages')
                                ->label('Keunggulan Layanan')
                                ->placeholder('Contoh: Harga kompetitif'),
                        ),
                ]),

            Section::make('Siapa yang Membutuhkan')
                ->description()
                ->schema([
                    Repeater::make('people_in_needs')
                        ->label('Daftar Kriteria Pelanggan')
                        ->simple(
                            TextInput::make('people_in_needs')
                                ->label('Kriteria Pelanggan')
                                ->placeholder('Contoh: Kamu yang kerepotan urus sosial media'),
                        ),
                ]),

            Section::make('Pertanyaan Sering Ditanyakan (FAQ)')
                ->description()
                ->schema([
                    Repeater::make('faqs')
                        ->label('Daftar FAQ')
                        ->schema([
                            TextInput::make('question')
                                ->label('Pertanyaan')
                                ->placeholder('Contoh: Mengapa harus memilih kami?'),

                            Textarea::make('answer')
                                ->label('Jawaban')
                                ->placeholder('Contoh: Karena dengan harga kompetitif kamu bisa mendapatkan kualitas terbaik'),
                        ]),
                ]),
        ])
            ->columns(3);
    }
}
