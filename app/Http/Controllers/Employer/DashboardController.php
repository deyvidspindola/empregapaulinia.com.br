<?php

namespace App\Http\Controllers\Employer;

use App\Services\Employer\DashboardService;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $companyDashboardService
    ) {}
    
    public function index()
    {
        $data = $this->companyDashboardService->getDashboardData();
        return view('employer.dashboard', compact('data'));
    }
}
