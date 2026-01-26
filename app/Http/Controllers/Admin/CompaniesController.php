<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompaniesController extends Controller
{
    
    public function __construct(
        protected Company $company
    )
    {}

    public function index()
    {
        $companies = $this->company->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.empresas.index', compact('companies'));
    }
}
