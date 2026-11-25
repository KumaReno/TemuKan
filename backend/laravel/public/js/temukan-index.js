(() => {
    const themeKey = 'temukan-theme';
    const themeButton = document.querySelector('[data-theme-toggle]');
    const filterButtons = [...document.querySelectorAll('.filter-button')];
    const cards = [...document.querySelectorAll('.item-card')];
    const searchInput = document.querySelector('#searchInput');
    const emptyState = document.querySelector('#emptyState');
    const resultCount = document.querySelector('#resultCount');
    let activeFilter = 'semua';

    const applyTheme = dark => {
        document.documentElement.classList.toggle('dark', dark);
        document.documentElement.classList.toggle('dark-theme', dark);
        document.querySelectorAll('.theme-icon').forEach(icon => {
            icon.textContent = dark ? '☀' : '☾';
        });
        themeButton?.setAttribute(
            'aria-label',
            dark ? 'Aktifkan tema terang' : 'Aktifkan tema gelap'
        );
    };

    let darkTheme = false;
    try {
        darkTheme = localStorage.getItem(themeKey) === 'dark';
    } catch (error) {
        // Keep the page usable if browser storage is unavailable.
    }
    applyTheme(darkTheme);

    themeButton?.addEventListener('click', () => {
        darkTheme = !document.documentElement.classList.contains('dark');
        applyTheme(darkTheme);
        try {
            localStorage.setItem(themeKey, darkTheme ? 'dark' : 'light');
        } catch (error) {
            // Theme changes still work for this page without persistent storage.
        }
    });

    const updateCards = () => {
        const query = (searchInput?.value || '').trim().toLocaleLowerCase('id');
        let visibleCount = 0;

        cards.forEach(card => {
            const matchesStatus = activeFilter === 'semua'
                || card.dataset.status === activeFilter;
            const matchesSearch = !query
                || (card.dataset.search || '').toLocaleLowerCase('id').includes(query);

            card.hidden = !(matchesStatus && matchesSearch);
            if (!card.hidden) visibleCount++;
        });

        if (emptyState) emptyState.hidden = visibleCount > 0;
        if (resultCount) resultCount.textContent = String(visibleCount);
    };

    filterButtons.forEach(button => button.addEventListener('click', () => {
        activeFilter = button.dataset.filter || 'semua';

        filterButtons.forEach(item => {
            const selected = item === button;
            item.classList.toggle('active', selected);
            item.setAttribute('aria-pressed', String(selected));
        });

        updateCards();
    }));

    searchInput?.addEventListener('input', updateCards);
})();
