<header class="h-[78px] border-b border-[#eff1f2] bg-white dark:border-[#30404e] dark:bg-[#192633] max-[580px]:h-[66px] min-[1500px]:h-[88px]">
    <nav class="mx-auto flex h-full w-[min(1120px,calc(100%-56px))] items-center justify-between max-[800px]:w-[calc(100%-36px)] max-[580px]:w-[calc(100%-32px)] min-[1500px]:w-[min(1320px,calc(100%-56px))]" aria-label="Navigasi utama">
        <a class="flex items-center gap-[3px] font-heading text-xl font-extrabold tracking-[-1px] text-navy dark:text-slate-100" href="{{ route('reports.index') }}">
            <span class="mr-[7px] grid h-[29px] w-[29px] place-items-center rounded-[9px] bg-orange text-[15px] tracking-normal text-white">T</span>
            Temu<span class="text-orange">Kan</span>
        </a>
        <div class="flex items-center gap-3">
            <a class="text-[13px] font-semibold text-[#788391] transition-colors hover:text-navy dark:text-slate-400 dark:hover:text-white" href="{{ route('reports.index') }}">Beranda</a>
            <button class="grid h-[38px] w-[38px] place-items-center rounded-full border border-[#e7ebee] bg-white text-lg text-ink transition-transform hover:rotate-[-12deg] hover:border-orange dark:border-[#30404e] dark:bg-[#192633] dark:text-slate-100" data-theme-toggle type="button" aria-label="Aktifkan tema gelap" title="Ganti tema">
                <span class="theme-icon" aria-hidden="true">◐</span>
            </button>
        </div>
    </nav>
</header>
