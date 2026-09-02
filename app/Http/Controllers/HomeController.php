<?php

namespace App\Http\Controllers;

use App\Services\HomeDashboardService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private readonly HomeDashboardService $dashboard) {}

    public function __invoke(): View
    {
        return view('pages.home', $this->dashboard->indexData());
    }
}
