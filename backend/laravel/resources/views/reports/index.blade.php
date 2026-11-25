<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#10243a">
    <meta name="description" content="Temukan barang hilang dan bantu teman kampus menemukan kembali barangnya.">
    <script>
        tailwind = {
            config: {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            navy: '#10243a',
                            'navy-2': '#183650',
                            orange: '#f28a46',
                            'orange-dark': '#da7131',
                            ink: '#172a3d',
                            muted: '#758392',
                            line: '#e7ebee',
                            paper: '#fff',
                            soft: '#f7f8f7',
                            mint: '#e7f4ee',
                        },
                        fontFamily: {
                            sans: ['DM Sans', 'Arial', 'sans-serif'],
                            heading: ['Manrope', 'sans-serif'],
                        },
                        maxWidth: {
                            container: '1120px',
                            'container-wide': '1320px',
                        },
                    },
                },
            },
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        try {
            if (localStorage.getItem('temukan-theme') === 'dark') {
                document.documentElement.classList.add('dark', 'dark-theme');
            }
        } catch (error) {
            // Theme preference is optional when browser storage is unavailable.
        }
    </script>
    <title>TemuKan — Lost &amp; Found Kampus</title>
    <link rel="stylesheet" href="{{ asset('css/temukan.css') }}">
    <script src="{{ asset('js/temukan-index.js') }}" defer></script>
</head>
<body>
    <header class="h-[78px] border-b border-[#eff1f2] bg-white dark:border-[#30404e] dark:bg-[#192633] max-[580px]:h-[66px] min-[1500px]:h-[88px]">
        <nav class="mx-auto flex h-full w-[min(1120px,calc(100%-56px))] items-center justify-between max-[800px]:w-[calc(100%-36px)] max-[580px]:w-[calc(100%-32px)] min-[1500px]:w-[min(1320px,calc(100%-56px))]" aria-label="Navigasi utama">
            <a class="flex items-center gap-[3px] font-heading text-xl font-extrabold tracking-[-1px] text-navy dark:text-slate-100" href="{{ route('reports.index') }}">
                <span class="mr-[7px] grid h-[29px] w-[29px] place-items-center rounded-[9px] bg-orange text-[15px] tracking-normal text-white">T</span>
                Temu<span class="text-orange">Kan</span>
            </a>
            <div class="ml-[75px] flex items-center gap-[34px] max-[800px]:ml-0 max-[800px]:gap-[18px] max-[580px]:hidden">
                <a class="text-[13px] font-semibold text-navy dark:text-slate-200" href="{{ route('reports.index') }}">Beranda</a>
                <a class="text-[13px] font-semibold text-[#788391] transition-colors hover:text-navy dark:text-slate-400 dark:hover:text-white" href="#daftar">Jelajahi</a>
            </div>
            <div class="flex items-center gap-3">
                <button class="grid h-[38px] w-[38px] place-items-center rounded-full border border-[#e7ebee] bg-white text-lg text-ink transition-transform hover:rotate-[-12deg] hover:border-orange dark:border-[#30404e] dark:bg-[#192633] dark:text-slate-100" data-theme-toggle type="button" aria-label="Aktifkan tema gelap" title="Ganti tema">
                    <span class="theme-icon" aria-hidden="true">☾</span>
                </button>
                <a class="inline-flex min-h-[40px] items-center gap-3 rounded-[7px] bg-navy px-4 text-xs font-bold text-white transition hover:-translate-y-px hover:bg-[#203e58] dark:bg-orange dark:text-navy" href="#daftar">
                    <span class="text-lg font-normal text-[#f6a16c]" aria-hidden="true">＋</span>
                    Lihat Laporan
                </a>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero container">
            <div class="hero-copy">
                <span class="eyebrow"><span class="status-dot"></span> KOMUNITAS LOST &amp; FOUND KAMPUS</span>
                <h1>Barang hilang?<br><span>Mungkin ada di sini.</span></h1>
                <p>Tempat sederhana untuk mempertemukan barang yang hilang dengan pemiliknya. Yuk, bantu sesama warga kampus.</p>
                <div class="hero-actions">
                    <a class="button button-primary" href="#daftar">Lihat laporan <span aria-hidden="true">↗</span></a>
                    <a class="text-link" href="#daftar">Jelajahi barang <span aria-hidden="true">↓</span></a>
                </div>
                <div class="hero-note">
                    <span class="note-icon">✳</span>
                    <span><strong>Temukan, kembalikan, bahagiakan.</strong><br>Setiap bantuan kecil berarti.</span>
                </div>
            </div>
            <div class="hero-art" aria-hidden="true">
                <div class="orbit orbit-one"></div>
                <div class="orbit orbit-two"></div>
                <div class="hero-spark spark-one">✦</div>
                <div class="hero-spark spark-two">✧</div>
                <div class="hero-card hero-card-main">
                    <span class="hero-card-icon">⌕</span>
                    <div><strong>Dicari pemiliknya</strong><small>Barangmu bisa jadi berikutnya</small></div>
                    <span class="hero-arrow">↗</span>
                </div>
                <div class="hero-float float-orange">✦</div>
                <div class="hero-float float-blue">✓</div>
                <div class="hero-caption">Bersama, kita temukan kembali.</div>
            </div>
        </section>

        <section class="stats container" aria-label="Ringkasan komunitas">
            <div><strong>{{ $reports->count() }}</strong><span>laporan barang</span></div>
            <div><strong>{{ $lostCount }}</strong><span>barang hilang</span></div>
            <div><strong>{{ $foundCount }}</strong><span>barang ditemukan</span></div>
            <div class="stats-message">Kebaikan kecil, dampak besar <span>↗</span></div>
        </section>

        <section class="listing-section" id="daftar">
            <div class="container">
                <div class="section-heading">
                    <div>
                        <span class="eyebrow">PAPAN PENGUMUMAN</span>
                        <h2>Temuan terbaru</h2>
                        <p>Siapa tahu, salah satunya barang yang sedang kamu cari.</p>
                    </div>
                    <span class="text-link desktop-link">Data laporan dari database TemuKan</span>
                </div>

                <div class="filter-bar" role="group" aria-label="Filter status barang">
                    <div class="filter-tabs">
                        <button class="filter-button active" type="button" data-filter="semua" aria-pressed="true">Semua <span>{{ $reports->count() }}</span></button>
                        <button class="filter-button" type="button" data-filter="hilang" aria-pressed="false">Hilang <span>{{ $lostCount }}</span></button>
                        <button class="filter-button" type="button" data-filter="ditemukan" aria-pressed="false">Ditemukan <span>{{ $foundCount }}</span></button>
                    </div>
                    <label class="search-box">
                        <span aria-hidden="true">⌕</span>
                        <input id="searchInput" type="search" placeholder="Cari barang..." aria-label="Cari barang">
                    </label>
                </div>

                <div class="item-grid" id="itemGrid">
                    @forelse ($reports as $index => $report)
                        @php
                            $categoryName = $report->category->name;
                            [$visualClass, $symbol] = match ($categoryName) {
                                'Barang pribadi' => ['visual-wallet', '▰'],
                                'Botol minum' => ['visual-bottle', '♜'],
                                'Aksesori' => ['visual-umbrella', '☂'],
                                'Kunci' => ['visual-keys', '⚿'],
                                'Elektronik' => ['visual-earbuds', '◖◗'],
                                'Alat tulis' => ['visual-book', '▤'],
                                default => ['visual-book', '▤'],
                            };
                            $searchText = strtolower(implode(' ', [
                                $report->name,
                                $categoryName,
                                $report->location,
                                $report->status,
                            ]));
                        @endphp
                        <article class="item-card" data-number="{{ $index + 1 }}" data-status="{{ $report->status }}" data-search="{{ $searchText }}">
                            <div class="item-visual {{ $visualClass }}" aria-hidden="true">
                                <span class="visual-symbol">{{ $symbol }}</span>
                                <span class="visual-label">{{ $categoryName }}</span>
                                <span class="visual-scribble">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="item-content">
                                <div class="item-meta">
                                    <span class="tag {{ $report->status === 'hilang' ? 'tag-lost' : 'tag-found' }}"><i></i> {{ ucfirst($report->status) }}</span>
                                    <span class="item-date">{{ $report->event_date->format('d M Y') }}</span>
                                </div>
                                <h3>{{ $report->name }}</h3>
                                <p class="item-location"><span>⌖</span> {{ $report->location }}</p>
                                <div class="item-footer">
                                    <span class="reporter"><span class="avatar avatar-peach">{{ collect(explode(' ', $report->reporter_name))->map(fn ($part) => mb_substr($part, 0, 1))->take(2)->implode('') }}</span> {{ $report->reporter_name }}</span>
                                    <span class="card-arrow" aria-hidden="true">↗</span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="empty-state" id="emptyState">
                            <span>⌕</span>
                            <h3>Belum ada laporan barang</h3>
                            <p>Laporan yang tersimpan di database akan muncul di sini.</p>
                        </div>
                    @endforelse
                </div>

                @if ($reports->isNotEmpty())
                    <div class="empty-state" id="emptyState" hidden>
                        <span>⌕</span>
                        <h3>Belum ada barang yang cocok</h3>
                        <p>Coba kata kunci atau filter yang lain.</p>
                    </div>
                    <div class="listing-bottom">
                        <span>Menampilkan <strong id="resultCount">{{ $reports->count() }}</strong> dari {{ $reports->count() }} barang</span>
                        <a class="button button-outline" href="#daftar">Jelajahi laporan</a>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <a class="brand brand-footer" href="{{ route('reports.index') }}"><span class="brand-mark">T</span> Temu<span>Kan</span></a>
            <span>Ruang kecil untuk saling membantu di kampus.</span>
            <span>© {{ now()->year }} TemuKan</span>
        </div>
    </footer>
</body>
</html>
