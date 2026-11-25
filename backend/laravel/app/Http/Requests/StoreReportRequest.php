<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'status' => ['required', 'string', Rule::in(['hilang', 'ditemukan'])],
            'description' => ['required', 'string', 'min:8', 'max:2000'],
            'location' => ['required', 'string', 'min:2', 'max:150'],
            'event_date' => ['required', 'date', 'before_or_equal:today'],
            'reporter_name' => ['required', 'string', 'min:2', 'max:100'],
            'contact' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'kategori',
            'name' => 'nama barang',
            'status' => 'jenis laporan',
            'description' => 'deskripsi',
            'location' => 'lokasi',
            'event_date' => 'tanggal kejadian',
            'reporter_name' => 'nama pelapor',
            'contact' => 'kontak',
            'image' => 'foto barang',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'integer' => ':attribute tidak valid.',
            'exists' => 'Pilihan :attribute tidak tersedia.',
            'string' => ':attribute harus berupa teks.',
            'min.string' => ':attribute minimal :min karakter.',
            'max.string' => ':attribute maksimal :max karakter.',
            'in' => 'Pilih jenis laporan yang tersedia.',
            'date' => 'Format :attribute tidak valid.',
            'before_or_equal' => ':attribute tidak boleh melebihi hari ini.',
            'image' => ':attribute harus berupa file gambar.',
            'mimes' => ':attribute harus berformat JPG, PNG, atau WebP.',
            'max.file' => 'Ukuran :attribute maksimal 2 MB.',
            'boolean' => 'Pilihan hapus foto tidak valid.',
        ];
    }
}
