<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomeService;

class HomeController extends Controller
{

    public function __construct(
        private HomeService $homeService
    )
    {}

    public function index()
    {
        $data = $this->homeService->getHomeData();
        return view('welcome', compact('data'));
    }
}
