<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Report;
use Illuminate\Database\Seeder;

class TemuKanSeeder extends Seeder
{
    public function run(): void
    {
        $reports = [
            [
                'name' => 'Dompet kulit cokelat',
                'category' => 'Barang pribadi',
                'status' => 'hilang',
                'description' => 'Dompet kulit warna cokelat dengan tekstur sederhana.',
                'location' => 'Gedung FKIP, lantai 2',
                'event_date' => '2026-11-11',
                'reporter_name' => 'Aulia R.',
            ],
            [
                'name' => 'Tumbler stainless silver',
                'category' => 'Botol minum',
                'status' => 'ditemukan',
                'description' => 'Tumbler stainless warna silver ditemukan di perpustakaan.',
                'location' => 'Perpustakaan pusat',
                'event_date' => '2026-11-10',
                'reporter_name' => 'Dimas N.',
            ],
            [
                'name' => 'Payung lipat warna navy',
                'category' => 'Aksesori',
                'status' => 'hilang',
                'description' => 'Payung lipat berwarna navy, kemungkinan tertinggal di sekitar parkiran.',
                'location' => 'Parkiran Fakultas Teknik',
                'event_date' => '2026-10-22',
                'reporter_name' => 'Kiki M.',
            ],
            [
                'name' => 'Kunci motor, gantungan merah',
                'category' => 'Kunci',
                'status' => 'ditemukan',
                'description' => 'Satu set kunci motor dengan gantungan berwarna merah.',
                'location' => 'Kantin kampus',
                'event_date' => '2026-10-21',
                'reporter_name' => 'Fajar A.',
            ],
            [
                'name' => 'Earphone putih dalam case',
                'category' => 'Elektronik',
                'status' => 'hilang',
                'description' => 'Earphone warna putih yang disimpan di dalam case kecil.',
                'location' => 'Ruang kelas, Gedung C',
                'event_date' => '2026-10-20',
                'reporter_name' => 'Nadia L.',
            ],
            [
                'name' => 'Buku catatan hijau',
                'category' => 'Alat tulis',
                'status' => 'ditemukan',
                'description' => 'Buku catatan bersampul hijau ditemukan di taman baca kampus.',
                'location' => 'Taman baca kampus',
                'event_date' => '2026-10-19',
                'reporter_name' => 'Sari Y.',
            ],
        ];

        foreach ($reports as $reportData) {
            $category = Category::firstOrCreate([
                'name' => $reportData['category'],
            ]);

            unset($reportData['category']);
            $reportData['category_id'] = $category->id;

            Report::updateOrCreate(
                [
                    'name' => $reportData['name'],
                    'location' => $reportData['location'],
                ],
                $reportData
            );
        }
    }
}
