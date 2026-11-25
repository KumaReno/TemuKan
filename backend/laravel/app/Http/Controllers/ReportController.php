<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Category;
use App\Models\Report;
use App\Services\ReportImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $reports = Report::query()
            ->with('category')
            ->orderByDesc('event_date')
            ->orderByDesc('id')
            ->get();

        return view('reports.index', [
            'reports' => $reports,
            'lostCount' => $reports->where('status', 'hilang')->count(),
            'foundCount' => $reports->where('status', 'ditemukan')->count(),
        ]);
    }

    public function create(): View
    {
        return view('reports.create', [
            'categories' => Category::query()->orderBy('name')->get(),
            'report' => new Report(),
        ]);
    }

    public function store(StoreReportRequest $request, ReportImageStorage $images): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $images->store($request->file('image'));
        }

        unset($data['image']);
        Report::query()->create($data);

        return redirect()
            ->route('reports.index')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit(Report $report): View
    {
        return view('reports.edit', [
            'categories' => Category::query()->orderBy('name')->get(),
            'report' => $report,
        ]);
    }

    public function update(
        UpdateReportRequest $request,
        Report $report,
        ReportImageStorage $images
    ): RedirectResponse {
        $data = $request->validated();
        $oldImagePath = $report->image_path;

        if ($request->hasFile('image')) {
            $data['image_path'] = $images->store($request->file('image'));
        } elseif ($request->boolean('remove_image')) {
            $data['image_path'] = null;
        }

        unset($data['image'], $data['remove_image']);
        $report->update($data);

        if ($oldImagePath !== $report->image_path) {
            $images->delete($oldImagePath);
        }

        return redirect()
            ->route('reports.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Report $report, ReportImageStorage $images): RedirectResponse
    {
        $imagePath = $report->image_path;
        $report->delete();
        $images->delete($imagePath);

        return redirect()
            ->route('reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
