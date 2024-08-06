<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'service_id'        => Service::where('code', 'SMM')->first()->id,
                'code'              => 'SMM-BASIC',
                'name'              => 'Paket Basic (15 Postingan)',
                'description'       => 'Jasa ini dibuat oleh tim digital dan creative terbaik yang telah diseleksi dan dibimbing oleh Gumilang Jati',
                'price'             => 799000,
                'fixed_discount'    => 400000,
                'estimated_days'    => 20,
                'includes'          => [
                    '15 Design Instagram Feeds',
                    '2 Instagram Story',
                    'Content Planning',
                    'Free Highlight Cover (5)',
                    'Copywriting',
                    'Hashtag',
                ],
            ],
            [
                'service_id'        => Service::where('code', 'SMM')->first()->id,
                'code'              => 'SMM-FULL',
                'name'              => 'Paket Full Package (30 Postingan)',
                'description'       => 'Jasa ini dibuat oleh tim digital dan creative terbaik yang telah diseleksi dan dibimbing oleh Gumilang Jati',
                'price'             => 1500000,
                'fixed_discount'    => 1000000,
                'estimated_days'    => 30,
                'includes'          => [
                    '30 Design Instagram Feeds/Story',
                    '2 Instagram Story',
                    'Content Planning',
                    'Free Highlight Cover (5)',
                    'Copywriting',
                    'Hashtag',
                ],
            ],
            [
                'service_id'        => Service::where('code', 'SMM-SHORT-VIDEO')->first()->id,
                'code'              => 'SMM-SHORT-VIDEO-ESSENTIAL',
                'name'              => 'Paket Silver',
                'description'       => 'Jasa ini dibuat oleh tim digital dan creative terbaik yang telah diseleksi dan dibimbing oleh Gumilang Jati',
                'price'             => 3000000,
                'fixed_discount'    => 1500000,
                'estimated_days'    => 14,
                'includes'          => [
                    '15 Short Video',
                    'Revisi Minor 2x',
                    'Video HD',
                    'Konten kreatif dan menarik',
                    'Durasi maks. 1 menit per video',
                    'Durasi pengerjaan 14 hari',
                ],
            ],
            [
                'service_id'        => Service::where('code', 'SMM-SHORT-VIDEO')->first()->id,
                'code'              => 'SMM-SHORT-VIDEO-ESSENTIAL',
                'name'              => 'Paket Gold',
                'description'       => 'Jasa ini dibuat oleh tim digital dan creative terbaik yang telah diseleksi dan dibimbing oleh Gumilang Jati',
                'price'             => 6000000,
                'fixed_discount'    => 3000000,
                'estimated_days'    => 21,
                'includes'          => [
                    '30 Short Video',
                    'Revisi Minor 2x',
                    'Video HD',
                    'Konten kreatif dan menarik',
                    'Durasi maks. 1 menit per video',
                    'Durasi pengerjaan 21 hari',
                ],
            ],
            [
                'service_id'        => Service::where('code', 'SMM-SHORT-VIDEO')->first()->id,
                'code'              => 'SMM-SHORT-VIDEO-ESSENTIAL',
                'name'              => 'Paket Pemula',
                'description'       => 'Jasa ini dibuat oleh tim digital dan creative terbaik yang telah diseleksi dan dibimbing oleh Gumilang Jati',
                'price'             => 499000,
                'fixed_discount'    => 0,
                'estimated_days'    => 7,
                'includes'          => [
                    '5 Short Video',
                    'Revisi Minor 2x',
                    'Video HD',
                    'Konten kreatif dan menarik',
                    'Durasi maks. 1 menit per video',
                    'Durasi pengerjaan 7 hari',
                ],
            ],
            [
                'service_id'        => Service::where('code', 'KOL-TIKTOK')->first()->id,
                'code'              => 'KOL-TIKTOK-NANO',
                'name'              => 'KOL Nano Influencer',
                'description'       => 'Jasa ini dibuat oleh tim digital dan creative terbaik yang telah diseleksi dan dibimbing oleh Gumilang Jati',
                'price'             => 100000,
                'fixed_discount'    => 0,
                'estimated_days'    => 0,
                'includes'          => [
                    'Min. 10 Influencer dengan < 10rb Followers',
                    'Revisi Minor 2x',
                    'Video HD',
                    'Durasi maks. 1 menit per video',
                ],
            ],
            [
                'service_id'        => Service::where('code', 'KOL-TIKTOK')->first()->id,
                'code'              => 'KOL-TIKTOK-MICRO',
                'name'              => 'KOL Micro Influencer',
                'description'       => 'Jasa ini dibuat oleh tim digital dan creative terbaik yang telah diseleksi dan dibimbing oleh Gumilang Jati',
                'price'             => 250000,
                'fixed_discount'    => 0,
                'estimated_days'    => 0,
                'includes'          => [
                    'Min. 10 Influencer dengan 10rb – 100rb Followers',
                    'Revisi Minor 2x',
                    'Video HD',
                    'Durasi maks. 1 menit per video',
                ],
            ],
            [
                'service_id'        => Service::where('code', 'KOL-TIKTOK')->first()->id,
                'code'              => 'KOL-TIKTOK-MACRO',
                'name'              => 'KOL Macro Influencer',
                'description'       => 'Jasa ini dibuat oleh tim digital dan creative terbaik yang telah diseleksi dan dibimbing oleh Gumilang Jati',
                'price'             => 500000,
                'fixed_discount'    => 0,
                'estimated_days'    => 0,
                'includes'          => [
                    'Min. 10 Influencer dengan 100rb – 1jt Followers',
                    'Revisi Minor 2x',
                    'Video HD',
                    'Durasi maks. 1 menit per video',
                ],
            ],
            [
                'service_id'        => Service::where('code', 'KOL-TIKTOK')->first()->id,
                'code'              => 'KOL-TIKTOK-MEGA',
                'name'              => 'KOL Mega Influencer',
                'description'       => 'Jasa ini dibuat oleh tim digital dan creative terbaik yang telah diseleksi dan dibimbing oleh Gumilang Jati',
                'price'             => 5000000,
                'fixed_discount'    => 0,
                'estimated_days'    => 0,
                'includes'          => [
                    'Min. 10 Influencer dengan 100rb – 1jt Followers',
                    'Revisi Minor 2x',
                    'Video HD',
                    'Durasi maks. 1 menit per video',
                ],
            ],
        ];


        foreach ($packages as $package) {
            if ($package['service_id']) {
                Package::firstOrCreate(['service_id' => $package['service_id'], 'code' => $package['code']], $package);
            }
        }
    }
}
