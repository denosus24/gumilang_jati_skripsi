<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'service_category_id' => ServiceCategory::where('code', 'SMM')->first()->id,
                'code' => 'SMM',
                'name' => 'Social Media Management',
                'summary' => 'Paket manajemen media sosial yang dirancang khusus untuk meningkatkan brand awareness dari bisnis kamu melalui Instagram',
                'description' => 'Saat ini, semakin banyak cara untuk mempromosikan bisnis dan produkmu, salah satunya dengan menggunakan sosial media! <br>
                Konten-konten yang disajikan harus bisa menjadi daya tarik customer, supaya bisnis dan produkmu terus menjadi yang terdepan. Dengan paket Social Media Management dari Gumilang Jati, kamu sudah tidak perlu pusing untuk mengurus konten di sosial media. Layanan manajemen media sosial yang menyediakan solusi lengkap untuk memenuhi semua kebutuhan konten social media, mulai dari: content planing, design, copywriting, hingga hashtag sudah kami buatkan di Gumilang Jati. <br>      
                Dengan menggabungkan keahlian dalam desain grafis dan editing short video yang bisa kamu tambahkan di add-ons, kami menawarkan paket manajemen media sosial yang dirancang khusus untuk meningkatkan brand awareness dari Bisnis kamu! <br>
                Buat bisnis kamu dikenal di dunia digital dan dapatkan lebih banyak pelanggan.',
                'people_in_needs' => [
                    'Meningkatkan brand awareness dengan melalui sosial media',
                    'Memperkenalkan produk dengan media sosial',
                    'Meningkatkan pengunjung ke profil instagram',
                    'Ingin meningkatkan interaksi dengan calon kustomer atau loyal kustomer',
                ],
                'advantages' => [
                    'Desain Sosial media disesuaikan dengan brand image kamu',
                    'Partner Startner adalah desainer yang telah berpengalaman',
                    'Konten sosial media menggunakan pillar yang telah diriset',
                    'Jasa sosial media startner sudah meliputi copywriting dan desain',
                ],
                'images' => [
                    'services/smm-service-portfolio-1.webp',
                    'services/smm-service-portfolio-2.webp',
                    'services/smm-service-portfolio-3.webp',
                    'services/smm-service-portfolio-4.webp',
                ],
                'faqs' => [
                    [
                        'question' => 'Apa saja isi kontennya setelah membeli product ini?',
                        'answer' => 'Isi konten berupa reels, story dan post',
                    ],
                    [
                        'question' => 'Berapa lama pengerjaan maksimal di Product ini?',
                        'answer' => 'Semaksimal mungkin pengerjaan di lakukan dalam waktu 1 bulan, tidak lebih',
                    ],
                    [
                        'question' => 'Siapa yang upload untuk product ini?',
                        'answer' => 'Kamu yang akan menguploadnya, tapi kami memiliki ads on admin sosmed untuk mengupload videonya',
                    ],
                    [
                        'question' => 'Apakah ada revisi design?',
                        'answer' => 'Ada, revisi minor 2 kali',
                    ]
                ],
            ],
            [
                'service_category_id' => ServiceCategory::where('code', 'SMM')->first()->id,
                'code' => 'SMM-SHORT-VIDEO',
                'name' => 'Konten Video Pendek',
                'summary' => 'Temukan daya tarik bisnis mu lewat short video yang memikat! Dirancang secara kreatif, beragam, dan bisa kamu gunakan di berbagai sosial media.',
                'description' => 'Temukan daya tarik bisnis mu lewat short video yang memikat! Dirancang secara kreatif, beragam, dan bisa kamu gunakan di berbagai sosial media.',
                'people_in_needs' => [
                    'Brand baru yang ingin dikenal',
                    'UMKM/perusahaan yang ingin menjangkau market lebih besar',
                    'UMKM/perusahaan yang ingin meningkatkan brand awareness',
                    'Perusahaan/brand/UMKM yang ingin meningkatkan penjualan',
                    'Siapapun yang membutuhkan video konten untuk memaksimalkan potensi market pada TikTok dan Reels',
                ],
                'images' => [
                    'services/smm-short-video-portfolio-1.webp',
                    'services/smm-short-video-portfolio-2.webp',
                    'services/smm-short-video-portfolio-3.webp',
                    'services/smm-short-video-portfolio-4.webp',
                ],
                'advantages' => [
                    'Konten Video Singkat yang disesuaikan dengan brand image kamu',
                    'Partner Startner adalah content creator yang telah berpengalaman',
                    'Konten sosial media menggunakan pillar yang telah diriset',
                    'Jasa sosial media startner sudah meliputi copywriting dan editing',
                ],
                'faqs' => [
                    [
                        'question' => 'Apa saja isi kontennya setelah membeli product ini?',
                        'answer' => 'Isi konten berupa reels, story dan post',
                    ],
                    [
                        'question' => 'Berapa lama pengerjaan maksimal di Product ini?',
                        'answer' => 'Semaksimal mungkin pengerjaan di lakukan dalam waktu 1 bulan, tidak lebih',
                    ],
                    [
                        'question' => 'Siapa yang upload untuk product ini?',
                        'answer' => 'Kamu yang akan menguploadnya, tapi kami memiliki ads on admin sosmed untuk mengupload videonya',
                    ],
                    [
                        'question' => 'Apakah ada revisi design?',
                        'answer' => 'Ada, revisi minor 2 kali',
                    ]
                ],
            ],
            [
                'service_category_id' => ServiceCategory::where('code', 'KOL')->first()->id,
                'code' => 'KOL-TIKTOK',
                'name' => 'KOL untuk Tiktok',
                'summary' => 'Temukan daya tarik bisnis mu lewat short video yang memikat! Dirancang secara kreatif, beragam, dan bisa kamu gunakan di berbagai sosial media.',
                'description' => 'Temukan daya tarik bisnis mu lewat short video yang memikat! Dirancang secara kreatif, beragam, dan bisa kamu gunakan di berbagai sosial media.',
                'people_in_needs' => [
                    'Brand baru yang ingin dikenal',
                    'UMKM/perusahaan yang ingin menjangkau market lebih besar',
                    'UMKM/perusahaan yang ingin meningkatkan brand awareness',
                    'Perusahaan/brand/UMKM yang ingin meningkatkan penjualan',
                    'Siapapun yang membutuhkan video konten untuk memaksimalkan potensi market pada TikTok dan Reels',
                ],
                'images' => [
                    'services/kol-tiktok-portfolio-4.webp',
                    'services/kol-tiktok-portfolio-1.webp',
                    'services/kol-tiktok-portfolio-2.webp',
                    'services/kol-tiktok-portfolio-3.webp',
                ],
                'advantages' => [
                    'Konten Video Singkat yang disesuaikan dengan brand image kamu',
                    'Partner Startner adalah content creator yang telah berpengalaman',
                    'Konten sosial media menggunakan pillar yang telah diriset',
                    'Jasa sosial media startner sudah meliputi copywriting dan editing',
                ],
                'faqs' => [
                    [
                        'question' => 'Apa saja isi kontennya setelah membeli product ini?',
                        'answer' => 'Isi konten berupa reels, story dan post',
                    ],
                    [
                        'question' => 'Berapa lama pengerjaan maksimal di Product ini?',
                        'answer' => 'Semaksimal mungkin pengerjaan di lakukan dalam waktu 1 bulan, tidak lebih',
                    ],
                    [
                        'question' => 'Siapa yang upload untuk product ini?',
                        'answer' => 'Kamu yang akan menguploadnya, tapi kami memiliki ads on admin sosmed untuk mengupload videonya',
                    ],
                    [
                        'question' => 'Apakah ada revisi design?',
                        'answer' => 'Ada, revisi minor 2 kali',
                    ]
                ],
            ]
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['code' => $service['code']], $service);
        }
    }
}
