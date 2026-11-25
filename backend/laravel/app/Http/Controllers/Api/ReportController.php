<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use App\Services\ReportImageStorage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $reports = Report::query()
            ->with('category')
            ->orderByDesc('event_date')
            ->orderByDesc('id')
            ->paginate(15);

        return ReportResource::collection($reports);
    }

    public function store(StoreReportRequest $request, ReportImageStorage $images): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $images->store($request->file('image'));
        }

        unset($data['image']);
        $report = Report::query()->create($data);
        $report->load('category');

        return (new ReportResource($report))
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }

    public function show(Report $report): ReportResource
    {
        return new ReportResource($report->load('category'));
    }

    public function update(
        UpdateReportRequest $request,
        Report $report,
        ReportImageStorage $images
    ): ReportResource {
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

        return new ReportResource($report->load('category'));
    }

    public function destroy(Report $report, ReportImageStorage $images): JsonResponse
    {
        $imagePath = $report->image_path;
        $report->delete();
        $images->delete($imagePath);

        return response()->json([
            'message' => 'Laporan berhasil dihapus.',
        ], JsonResponse::HTTP_OK);
    }
}
