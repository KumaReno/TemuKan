<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/Item.php';

return [
    new Item(
        'dompet',
        'Dompet kulit cokelat',
        'BARANG PRIBADI',
        'hilang',
        'Gedung FKIP, lantai 2',
        'Hari ini, 09.20',
        'Aulia R.',
        'AR',
        'avatar-peach',
        'visual-wallet',
        "\u{25B0}"
    ),
    new Item(
        'tumbler',
        'Tumbler stainless silver',
        'BOTOL MINUM',
        'ditemukan',
        'Perpustakaan pusat',
        'Kemarin, 14.05',
        'Dimas N.',
        'DN',
        'avatar-mint',
        'visual-bottle',
        "\u{265C}"
    ),
    new Item(
        'payung',
        'Payung lipat warna navy',
        'AKSESORIS',
        'hilang',
        'Parkiran Fakultas Teknik',
        '22 Okt 2026, 16.30',
        'Kiki M.',
        'KM',
        'avatar-lilac',
        'visual-umbrella',
        "\u{2602}"
    ),
    new Item(
        'kunci',
        'Kunci motor, gantungan merah',
        'KUNCI',
        'ditemukan',
        'Kantin kampus',
        '21 Okt 2026, 12.10',
        'Fajar A.',
        'FA',
        'avatar-yellow',
        'visual-keys',
        "\u{26BF}"
    ),
    new Item(
        'earphone',
        'Earphone putih dalam case',
        'ELEKTRONIK',
        'hilang',
        'Ruang kelas, Gedung C',
        '20 Okt 2026, 10.45',
        'Nadia L.',
        'NL',
        'avatar-blue',
        'visual-earbuds',
        "\u{25D6}\u{25D7}"
    ),
    new Item(
        'buku',
        'Buku catatan hijau',
        'ALAT TULIS',
        'ditemukan',
        'Taman baca kampus',
        '19 Okt 2026, 08.15',
        'Sari Y.',
        'SY',
        'avatar-peach',
        'visual-book',
        "\u{25A4}"
    ),
];
