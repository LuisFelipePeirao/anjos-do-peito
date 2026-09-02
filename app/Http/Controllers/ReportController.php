<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reports\ReportFilterRequest;
use App\Services\ReportService;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reports) {}

    public function index(ReportFilterRequest $request): View
    {
        return view('pages.reports.index', $this->reports->indexData($request->filters()));
    }
}
