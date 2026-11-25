@csrf

<fieldset class="type-picker">
    <legend>Jenis laporan <span class="required">*</span></legend>
    <div class="type-options">
        @foreach (['hilang' => 'Barang hilang', 'ditemukan' => 'Barang ditemukan'] as $value => $label)
            <label class="type-option">
                <input type="radio" name="status" value="{{ $value }}" @checked(old('status', $report->status ?: 'hilang') === $value)>
                <span class="type-option-card">
                    <span class="type-option-icon" aria-hidden="true">{{ $value === 'hilang' ? '⌕' : '✳' }}</span>
                    <strong>{{ $label }}</strong>
                    <small>{{ $value === 'hilang' ? 'Saya kehilangan barang' : 'Saya menemukan barang' }}</small>
                </span>
            </label>
        @endforeach
    </div>
    @error('status') <small class="text-red-600" role="alert">{{ $message }}</small> @enderror
</fieldset>

<div class="field">
    <label for="name">Nama barang <span class="required">*</span></label>
    <input id="name" name="name" type="text" value="{{ old('name', $report->name) }}" maxlength="100" required autocomplete="off" placeholder="Contoh: Dompet kulit warna cokelat">
    <small>Sebutkan nama dan ciri umum barang.</small>
    @error('name') <small class="text-red-600" role="alert">{{ $message }}</small> @enderror
</div>

<div class="field">
    <label for="description">Deskripsi <span class="required">*</span></label>
    <textarea id="description" name="description" rows="3" maxlength="2000" required placeholder="Ceritakan ciri-ciri barang atau detail lain...">{{ old('description', $report->description) }}</textarea>
    @error('description') <small class="text-red-600" role="alert">{{ $message }}</small> @enderror
</div>

<div class="field">
    <label for="category_id">Kategori <span class="required">*</span></label>
    <select id="category_id" name="category_id" required>
        <option value="">Pilih kategori</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected((string) old('category_id', $report->category_id) === (string) $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
    @error('category_id') <small class="text-red-600" role="alert">{{ $message }}</small> @enderror
</div>

<div class="field">
    <label for="image">Foto barang (opsional)</label>
    <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
    <small>Format JPG, PNG, atau WebP; ukuran maksimal 2 MB.</small>
    @if ($report->image_path)
        <div class="image-preview">
            <img src="{{ asset('storage/'.$report->image_path) }}" alt="Foto {{ $report->name }}">
            <label class="remove-image"><input type="checkbox" name="remove_image" value="1"> Hapus foto saat ini</label>
        </div>
    @endif
    @error('image') <small class="text-red-600" role="alert">{{ $message }}</small> @enderror
</div>

<div class="field-row">
    <div class="field">
        <label for="location">Lokasi <span class="required">*</span></label>
        <input id="location" name="location" type="text" value="{{ old('location', $report->location) }}" maxlength="150" required placeholder="Contoh: Perpustakaan">
        @error('location') <small class="text-red-600" role="alert">{{ $message }}</small> @enderror
    </div>
    <div class="field">
        <label for="event_date">Tanggal kejadian <span class="required">*</span></label>
        <input id="event_date" name="event_date" type="date" value="{{ old('event_date', $report->event_date?->format('Y-m-d')) }}" max="{{ now()->toDateString() }}" required>
        @error('event_date') <small class="text-red-600" role="alert">{{ $message }}</small> @enderror
    </div>
</div>

<div class="field-row">
    <div class="field">
        <label for="reporter_name">Nama kamu <span class="required">*</span></label>
        <input id="reporter_name" name="reporter_name" type="text" value="{{ old('reporter_name', $report->reporter_name) }}" maxlength="100" required placeholder="Nama panggilan">
        @error('reporter_name') <small class="text-red-600" role="alert">{{ $message }}</small> @enderror
    </div>
    <div class="field">
        <label for="contact">Kontak yang bisa dihubungi</label>
        <input id="contact" name="contact" type="text" value="{{ old('contact', $report->contact) }}" maxlength="255" placeholder="Email atau nomor WA">
        @error('contact') <small class="text-red-600" role="alert">{{ $message }}</small> @enderror
    </div>
</div>

<p class="form-privacy"><span aria-hidden="true">♧</span> Kontak hanya digunakan untuk membantu proses pengembalian barang.</p>
<button class="button button-primary button-submit" type="submit">{{ $submitLabel }} <span aria-hidden="true">↗</span></button>
