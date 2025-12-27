<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\CompanyDashboardService;
use App\Http\Controllers\Controller;

class CompanyDashboardController extends Controller
{
    protected $companyDashboardService;

    public function __construct(CompanyDashboardService $companyDashboardService)
    {
        $this->companyDashboardService = $companyDashboardService;
    }

    public function index()
    {
        $data = $this->companyDashboardService->getDashboardData();
        return view('dashboard.dashboard', compact('data'));
    }
}
