<?php

namespace App\Http\Controllers\Admin;

use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CandidatesController extends Controller
{
    
    public function __construct(
        protected Candidate $candidate
    )
    {}

    public function index()
    {
        $candidates = $this->candidate->all();
        return view('admin.candidates.index', compact('candidates'));
    }

}
