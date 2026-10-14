(() => {
  const REPORTS_KEY = 'temukan-reports';
  const THEME_KEY = 'temukan-theme';
  const readReports = () => {
    try { const rows = JSON.parse(localStorage.getItem(REPORTS_KEY) || '[]'); return Array.isArray(rows) ? rows : []; }
    catch { return []; }
  };
  const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[char]));

  // Theme setting is shared by all pages.
  const themeButton = document.querySelector('[data-theme-toggle]');
  const applyTheme = dark => {
    document.documentElement.classList.toggle('dark', dark);
    document.documentElement.classList.toggle('dark-theme', dark);
    document.querySelectorAll('.theme-icon').forEach(icon => { icon.textContent = dark ? '☀' : '☾'; });
    themeButton?.setAttribute('aria-label', dark ? 'Aktifkan tema terang' : 'Aktifkan tema gelap');
  };
  let darkTheme = false;
  try { darkTheme = localStorage.getItem(THEME_KEY) === 'dark'; } catch {}
  applyTheme(darkTheme);
  themeButton?.addEventListener('click', () => {
    darkTheme = !document.documentElement.classList.contains('dark');
    applyTheme(darkTheme);
    try { localStorage.setItem(THEME_KEY, darkTheme ? 'dark' : 'light'); } catch {}
  });

  const filterButtons = [...document.querySelectorAll('.filter-button')];
  const grid = document.querySelector('#itemGrid');
  const searchInput = document.querySelector('#searchInput');
  const emptyState = document.querySelector('#emptyState');
  const resultCount = document.querySelector('#resultCount');
  let activeFilter = 'semua';
  const reportDate = date => {
    if (!date) return '';
    const parsed = new Date(`${date}T12:00:00`);
    return Number.isNaN(parsed.getTime()) ? date : new Intl.DateTimeFormat('id-ID', { day:'numeric', month:'short', year:'numeric' }).format(parsed);
  };
  function addReportCard(item) {
    if (!grid) return;
    const card = document.createElement('article');
    const queryData = [item.name,item.category,item.location,item.description,item.status].join(' ').toLocaleLowerCase('id');
    card.className = 'item-card overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800';
    card.dataset.status = item.status;
    card.dataset.search = queryData;
    const visual = item.image
      ? `<img class="absolute inset-0 h-full w-full object-cover" src="${item.image}" alt="Foto ${esc(item.name)}"><span class="absolute bottom-3 left-3 rounded bg-white/90 px-2 py-1 text-[10px] font-bold text-slate-700">${esc(item.category)}</span>`
      : `<span class="text-6xl text-[#735541]">${item.status === 'hilang' ? '⌕' : '✳'}</span><span class="absolute bottom-3 left-3 text-[10px] font-bold tracking-widest text-slate-600">${esc(item.category)}</span>`;
    const tagStyle = item.status === 'hilang' ? 'bg-orange-50 text-orange-700' : 'bg-emerald-50 text-emerald-700';
    card.innerHTML = `<a class="relative grid h-36 place-items-center bg-slate-200 sm:h-44" href="detail.html?id=${encodeURIComponent(item.id)}" aria-label="Lihat detail ${esc(item.name)}">${visual}</a><div class="p-4"><div class="item-meta flex items-center justify-between"><span class="rounded px-2 py-1 text-[10px] font-bold ${tagStyle}">● ${item.status === 'hilang' ? 'Hilang' : 'Ditemukan'}</span><span class="text-[10px] text-slate-400">${esc(reportDate(item.date))}</span></div><h3 class="mt-3 font-bold text-navy dark:text-white"><a href="detail.html?id=${encodeURIComponent(item.id)}">${esc(item.name)}</a></h3><p class="mt-1 text-xs text-slate-500 dark:text-slate-400">⌖ ${esc(item.location)}</p><div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3 dark:border-slate-700"><span class="text-xs text-slate-500">${esc(item.reporter || 'Warga kampus')}</span><a class="text-orange" href="detail.html?id=${encodeURIComponent(item.id)}" aria-label="Buka detail">↗</a></div></div>`;
    grid.prepend(card);
  }
  function updateCards() {
    const query = (searchInput?.value || '').trim().toLocaleLowerCase('id');
    const allCards = [...document.querySelectorAll('.item-card')];
    let visible = 0;
    allCards.forEach(card => {
      const statusMatches = activeFilter === 'semua' || card.dataset.status === activeFilter;
      const textMatches = !query || (card.dataset.search || card.textContent).toLocaleLowerCase('id').includes(query);
      card.hidden = !(statusMatches && textMatches);
      if (!card.hidden) visible++;
    });
    if (emptyState) emptyState.hidden = visible !== 0;
    if (resultCount) resultCount.textContent = String(visible);
    filterButtons.forEach(button => {
      const count = button.dataset.filter === 'semua' ? allCards.length : allCards.filter(card => card.dataset.status === button.dataset.filter).length;
      const badge = button.querySelector('span');
      if (badge) badge.textContent = String(count);
    });
  }
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

  async function loadItems() {
    if (!grid) return;
    grid.textContent = 'Mengambil data barang...';
    try {
      const response = await fetch('https://jsonplaceholder.typicode.com/posts?_limit=6');
      if (!response.ok) throw new Error(`Permintaan gagal (${response.status})`);
      const items = await response.json();
      if (!Array.isArray(items)) throw new TypeError('Format data API tidak valid');

      grid.replaceChildren();
      items.forEach(item => {
        const status = item.id % 2 === 0 ? 'ditemukan' : 'hilang';
        const title = String(item.title || `Barang demo ${item.id}`).replace(/\b\w/g, letter => letter.toUpperCase());
        const description = String(item.body || 'Data contoh dari API.');
        const locationName = `Area kampus ${item.userId || 1}`;
        const statusLabel = status === 'hilang' ? 'Hilang' : 'Ditemukan';
        const statusClasses = status === 'hilang' ? 'bg-orange-50 text-orange-700' : 'bg-emerald-50 text-emerald-700';
        const article = document.createElement('article');
        article.className = 'item-card overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800';
        article.dataset.status = status;
        article.dataset.search = `${title} ${description} ${locationName} barang kampus ${status}`.toLocaleLowerCase('id');
        article.innerHTML = `<a class="item-visual relative grid h-44 place-items-center overflow-hidden bg-[#e6e9d8]" href="detail.html?id=api-${encodeURIComponent(item.id)}" aria-label="Lihat detail ${esc(title)}"><span class="text-6xl text-[#735541]">${status === 'hilang' ? '⌕' : '✳'}</span><span class="absolute bottom-3 left-3 text-[10px] font-bold tracking-widest text-slate-600">BARANG KAMPUS</span></a><div class="item-content p-4"><div class="item-meta flex items-center justify-between"><span class="rounded px-2 py-1 text-[10px] font-bold ${statusClasses}">● ${statusLabel}</span><span class="item-date text-[10px] text-slate-400">Data demo</span></div><h3 class="mt-3 font-bold text-navy dark:text-white"><a href="detail.html?id=api-${encodeURIComponent(item.id)}">${esc(title)}</a></h3><p class="item-location mt-1 text-xs text-slate-500 dark:text-slate-400">⌖ ${esc(locationName)}</p><p class="mt-2 line-clamp-2 text-xs text-slate-500 dark:text-slate-400">${esc(description)}</p><div class="item-footer mt-4 flex items-center justify-between border-t border-slate-100 pt-3 dark:border-slate-700"><span class="reporter text-xs text-slate-500">Data dari API</span><a class="text-orange" href="detail.html?id=api-${encodeURIComponent(item.id)}" aria-label="Buka detail">↗</a></div></div>`;
        grid.append(article);
      });

      // Keep locally submitted reports available alongside the demo API cards.
      readReports().forEach(addReportCard);
      updateCards();
    } catch (error) {
      console.error('Gagal mengambil data barang:', error);
      grid.textContent = 'Gagal mengambil data';
      readReports().forEach(addReportCard);
      updateCards();
    }
  }

  // Local image preview and base64 conversion for reports.
  const imageInput = document.querySelector('#itemImage');
  const preview = document.querySelector('#imagePreview');
  const previewPhoto = document.querySelector('#imagePreviewPhoto');
  let uploadedImage = '';
  imageInput?.addEventListener('change', () => {
    const file = imageInput.files?.[0];
    if (!file) { uploadedImage = ''; if (preview) preview.hidden = true; return; }
    if (!file.type.startsWith('image/')) { imageInput.value = ''; return; }
    const reader = new FileReader();
    reader.onload = () => {
      uploadedImage = String(reader.result || '');
      if (previewPhoto) previewPhoto.src = uploadedImage;
      if (preview) preview.hidden = false;
    };
    reader.readAsDataURL(file);
  });
  document.querySelector('#removeImage')?.addEventListener('click', () => {
    uploadedImage = '';
    if (imageInput) imageInput.value = '';
    if (previewPhoto) previewPhoto.removeAttribute('src');
    if (preview) preview.hidden = true;
  });

  const reportForm = document.querySelector('#reportForm');
  reportForm?.addEventListener('submit', event => {
    event.preventDefault();
    const feedback = document.querySelector('#formFeedback');
    if (!reportForm.reportValidity()) return;
    const fields = new FormData(reportForm);
    const item = {
      id: `laporan-${Date.now()}-${Math.random().toString(36).slice(2,7)}`,
      name: String(fields.get('itemName')).trim(),
      description: String(fields.get('itemDescription')).trim(),
      category: String(fields.get('itemCategory')),
      location: String(fields.get('itemLocation')).trim(),
      date: String(fields.get('itemDate')),
      status: String(fields.get('reportType')),
      reporter: String(fields.get('reporterName')).trim(),
      contact: String(fields.get('contact')).trim(),
      image: uploadedImage,
      createdAt: new Date().toISOString()
    };
    try {
      const reports = readReports();
      reports.unshift(item);
      localStorage.setItem(REPORTS_KEY, JSON.stringify(reports));
      feedback.textContent = 'Laporan berhasil disimpan di perangkat ini. Membuka daftar barang…';
      window.setTimeout(() => { location.href = 'index.html#daftar'; }, 900);
    } catch (error) {
      feedback.textContent = 'Penyimpanan penuh. Coba gunakan foto yang lebih kecil atau hapus beberapa laporan tersimpan.';
    }
  });

  const itemDetails = {
    dompet: { title:'Dompet kulit cokelat', status:'hilang', location:'Gedung FKIP, lantai 2', date:'Hari ini, 09.20', time:'Hari ini, 09.20 WIB', reporter:'Aulia R.', lead:'Sebuah dompet kulit warna cokelat dengan tekstur sederhana.', visual:'visual-wallet', symbol:'▰', label:'BARANG PRIBADI' },
    tumbler: { title:'Tumbler stainless silver', status:'ditemukan', location:'Perpustakaan pusat', date:'Kemarin, 14.05', time:'Kemarin, 14.05 WIB', reporter:'Dimas N.', lead:'Tumbler stainless warna silver ditemukan di area perpustakaan.', visual:'visual-bottle', symbol:'♜', label:'BOTOL MINUM' },
    payung: { title:'Payung lipat warna navy', status:'hilang', location:'Parkiran Fakultas Teknik', date:'22 Okt 2026, 16.30', time:'22 Okt 2026, 16.30 WIB', reporter:'Kiki M.', lead:'Payung lipat berwarna navy, kemungkinan tertinggal di sekitar parkiran.', visual:'visual-umbrella', symbol:'☂', label:'AKSESORIS' },
    kunci: { title:'Kunci motor, gantungan merah', status:'ditemukan', location:'Kantin kampus', date:'21 Okt 2026, 12.10', time:'21 Okt 2026, 12.10 WIB', reporter:'Fajar A.', lead:'Satu set kunci motor dengan gantungan berwarna merah.', visual:'visual-keys', symbol:'⚿', label:'KUNCI' },
    earphone: { title:'Earphone putih dalam case', status:'hilang', location:'Ruang kelas, Gedung C', date:'20 Okt 2026, 10.45', time:'20 Okt 2026, 10.45 WIB', reporter:'Nadia L.', lead:'Earphone warna putih yang disimpan di dalam case kecil.', visual:'visual-earbuds', symbol:'◖◗', label:'ELEKTRONIK' },
    buku: { title:'Buku catatan hijau', status:'ditemukan', location:'Taman baca kampus', date:'19 Okt 2026, 08.15', time:'19 Okt 2026, 08.15 WIB', reporter:'Sari Y.', lead:'Buku catatan bersampul hijau ditemukan di taman baca kampus.', visual:'visual-book', symbol:'▤', label:'ALAT TULIS' }
  };
  const params = new URLSearchParams(location.search);
  const itemId = params.get('id') || 'dompet';
  const selectedItem = itemDetails[itemId] || readReports().find(item => item.id === itemId);
  if (selectedItem && document.querySelector('#detailTitle')) {
    document.title = `${selectedItem.title || selectedItem.name} — TemuKan`;
    document.querySelector('#detailTitle').textContent = selectedItem.title || selectedItem.name;
    document.querySelector('#detailLead').textContent = selectedItem.lead || selectedItem.description;
    document.querySelector('#detailLocation').textContent = selectedItem.location;
    document.querySelector('#detailDate').textContent = selectedItem.date;
    document.querySelector('#detailTime').textContent = selectedItem.time || reportDate(selectedItem.date);
    document.querySelector('#detailReporter').textContent = selectedItem.reporter || 'Warga kampus';
    const status = document.querySelector('#detailStatus');
    status.className = `tag tag-${selectedItem.status === 'hilang' ? 'lost' : 'found'}`;
    status.innerHTML = `<i></i> ${selectedItem.status === 'hilang' ? 'Hilang' : 'Ditemukan'}`;
    const visual = document.querySelector('#detailVisual');
    const visualBg = ({'visual-bottle':'bg-[#dcebed]','visual-umbrella':'bg-[#e4e2ef]','visual-keys':'bg-[#f5e5d5]','visual-earbuds':'bg-[#e7eaf1]','visual-book':'bg-[#dcebdc]'})[selectedItem.visual] || 'bg-[#e6e9d8]';
    visual.className = `detail-visual relative grid h-72 place-items-center overflow-hidden rounded-2xl md:h-[440px] ${selectedItem.image ? 'bg-slate-200' : visualBg}`;
    if (selectedItem.image) {
      visual.innerHTML = `<img class="absolute inset-0 h-full w-full object-cover" src="${selectedItem.image}" alt="Foto ${esc(selectedItem.title || selectedItem.name)}"><span class="absolute bottom-5 left-5 rounded bg-white/90 px-2 py-1 text-xs font-bold text-slate-700">${esc(selectedItem.category || 'BARANG')}</span>`;
    } else {
      visual.innerHTML = `<span class="text-8xl text-[#735541]">${selectedItem.symbol || '⌕'}</span><span class="absolute bottom-5 left-5 text-xs font-bold tracking-widest">${esc(selectedItem.label || selectedItem.category || 'BARANG')}</span><span class="absolute right-6 top-5 text-3xl text-white">✦</span><span class="absolute bottom-5 right-5 text-xs text-slate-500">TemuKan · Lost &amp; Found Kampus</span>`;
    }
    const claimButton = document.querySelector('[data-open-modal]');
    if (selectedItem.status === 'ditemukan' && claimButton) claimButton.innerHTML = 'Klaim barang ini <span>↗</span>';
  } else if (document.querySelector('#detailTitle')) {
    const apiId = itemId.match(/^api-(\d+)$/)?.[1];
    if (apiId) {
      const loadApiDetail = async () => {
        try {
          const response = await fetch(`https://jsonplaceholder.typicode.com/posts/${apiId}`);
          if (!response.ok) throw new Error('Gagal mengambil detail barang');
          const item = await response.json();
          const statusValue = Number(item.id) % 2 === 0 ? 'ditemukan' : 'hilang';
          document.title = `${item.title} — TemuKan`;
          document.querySelector('#detailTitle').textContent = String(item.title || 'Barang demo').replace(/\b\w/g, letter => letter.toUpperCase());
          document.querySelector('#detailLead').textContent = item.body || 'Data contoh dari API.';
          document.querySelector('#detailLocation').textContent = `Area kampus ${item.userId || 1}`;
          document.querySelector('#detailDate').textContent = 'Data demo API';
          document.querySelector('#detailTime').textContent = 'Disediakan oleh JSONPlaceholder';
          document.querySelector('#detailReporter').textContent = 'Data API';
          const status = document.querySelector('#detailStatus');
          status.className = `tag tag-${statusValue === 'hilang' ? 'lost' : 'found'}`;
          status.innerHTML = `<i></i> ${statusValue === 'hilang' ? 'Hilang' : 'Ditemukan'}`;
          const claimButton = document.querySelector('[data-open-modal]');
          if (statusValue === 'ditemukan' && claimButton) claimButton.innerHTML = 'Klaim barang ini <span>↗</span>';
        } catch (error) {
          console.error(error);
          document.querySelector('#detailTitle').textContent = 'Gagal mengambil data';
        }
      };
      loadApiDetail();
    } else {
      document.querySelector('#detailTitle').textContent = 'Barang tidak ditemukan';
      document.querySelector('#detailLead').textContent = 'Laporan ini mungkin sudah dihapus dari penyimpanan browser.';
    }
  }

  const modal = document.querySelector('#claimModal');
  const openModal = document.querySelector('[data-open-modal]');
  const closeModal = document.querySelector('[data-close-modal]');
  const closeClaimModal = () => {
    if (!modal) return;
    modal.hidden = true;
    document.body.classList.remove('modal-open');
    openModal?.focus();
  };
  openModal?.addEventListener('click', () => {
    modal.hidden = false;
    document.body.classList.add('modal-open');
    modal.querySelector('input')?.focus();
  });
  closeModal?.addEventListener('click', closeClaimModal);
  modal?.addEventListener('click', event => { if (event.target === modal) closeClaimModal(); });
  document.addEventListener('keydown', event => { if (event.key === 'Escape' && modal && !modal.hidden) closeClaimModal(); });
  document.querySelector('#claimForm')?.addEventListener('submit', event => {
    event.preventDefault();
    const form = event.currentTarget;
    if (!form.reportValidity()) return;
    document.querySelector('#claimFeedback').textContent = 'Klaim berhasil dikirim. Pelapor dapat menghubungimu untuk verifikasi lebih lanjut.';
    form.reset();
  });

  document.addEventListener('DOMContentLoaded', loadItems);
})();
