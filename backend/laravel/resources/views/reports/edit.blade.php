<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#10243a">
    <script>tailwind = { config: { darkMode: 'class', theme: { extend: { colors: { navy: '#10243a', orange: '#f28a46', ink: '#172a3d' }, fontFamily: { sans: ['DM Sans', 'Arial', 'sans-serif'], heading: ['Manrope', 'sans-serif'] } } } };</script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>try { if (localStorage.getItem('temukan-theme') === 'dark') document.documentElement.classList.add('dark', 'dark-theme'); } catch (error) {}</script>
    <title>Edit Laporan — TemuKan</title>
    <link rel="stylesheet" href="{{ asset('css/temukan.css') }}">
    <script src="{{ asset('js/temukan-index.js') }}" defer></script>
</head>
<body>
    @include('reports.partials.header')

    <main class="form-page">
        <div class="container form-layout">
            <div class="form-intro">
                <a class="back-link" href="{{ route('reports.index') }}">← Kembali ke beranda</a>
                <span class="eyebrow">PERBARUI INFORMASI</span>
                <h1>Perbarui<br><span>laporan barang.</span></h1>
                <p>Pastikan informasi laporan tetap jelas dan akurat.</p>
                <div class="form-tip"><span>✳</span><p><strong>Periksa kembali</strong><br>Perubahan akan langsung tersimpan dan terlihat di daftar laporan.</p></div>
            </div>

            <section class="form-panel" aria-labelledby="form-title">
                <div class="form-panel-head">
                    <span class="eyebrow">EDIT LAPORAN #{{ $report->id }}</span>
                    <h2 id="form-title">{{ $report->name }}</h2>
                    <p>Ubah bagian yang perlu diperbarui.</p>
                </div>
                <form action="{{ route('reports.update', $report) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @include('reports.partials.form', ['submitLabel' => 'Simpan perubahan'])
                </form>
            </section>
        </div>
    </main>

    @include('reports.partials.footer')
</body>
</html>
