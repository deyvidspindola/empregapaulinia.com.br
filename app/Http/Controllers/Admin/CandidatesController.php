<?php

namespace App\Http\Controllers\Admin;

use App\Models\Candidate;
use App\Http\Controllers\Controller;

class CandidatesController extends Controller
{
    
    public function __construct(
        protected Candidate $candidate
    )
    {}

    public function index()
    {
        $candidates = $this->candidate->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.candidatos.index', compact('candidates'));
    }

}
