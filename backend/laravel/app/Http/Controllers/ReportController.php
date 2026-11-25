<?php

namespace App\Http\Controllers;

use App\Models\Report;
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

        $lostCount = $reports->where('status', 'hilang')->count();
        $foundCount = $reports->where('status', 'ditemukan')->count();

        return view('reports.index', compact('reports', 'lostCount', 'foundCount'));
    }
}
