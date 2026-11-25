<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#10243a">
    <script>tailwind = { config: { darkMode: 'class', theme: { extend: { colors: { navy: '#10243a', orange: '#f28a46', ink: '#172a3d' }, fontFamily: { sans: ['DM Sans', 'Arial', 'sans-serif'], heading: ['Manrope', 'sans-serif'] } } } };</script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>try { if (localStorage.getItem('temukan-theme') === 'dark') document.documentElement.classList.add('dark', 'dark-theme'); } catch (error) {}</script>
    <title>Lapor Barang — TemuKan</title>
    <link rel="stylesheet" href="{{ asset('css/temukan.css') }}">
    <script src="{{ asset('js/temukan-index.js') }}" defer></script>
</head>
<body>
    @include('reports.partials.header')

    <main class="form-page">
        <div class="container form-layout">
            <div class="form-intro">
                <a class="back-link" href="{{ route('reports.index') }}">← Kembali ke beranda</a>
                <span class="eyebrow">BANTU KOMUNITAS KAMPUS</span>
                <h1>Satu laporan,<br><span>satu harapan.</span></h1>
                <p>Semakin jelas informasinya, semakin besar peluang barang kembali ke pemiliknya.</p>
                <div class="form-tip"><span>✳</span><p><strong>Tips laporan yang baik</strong><br>Ceritakan ciri khusus barang dan lokasi secara detail. Hindari membagikan informasi sensitif.</p></div>
                <div class="form-doodle" aria-hidden="true">⌕</div>
            </div>

            <section class="form-panel" aria-labelledby="form-title">
                <div class="form-panel-head">
                    <span class="eyebrow">FORMULIR LAPORAN</span>
                    <h2 id="form-title">Detail barang</h2>
                    <p>Isi informasi berikut dengan lengkap.</p>
                </div>
                <form action="{{ route('reports.store') }}" method="post" enctype="multipart/form-data">
                    @include('reports.partials.form', ['submitLabel' => 'Kirim laporan'])
                </form>
            </section>
        </div>
    </main>

    @include('reports.partials.footer')
</body>
</html>
