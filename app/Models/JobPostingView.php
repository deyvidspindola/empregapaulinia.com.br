<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPostingView extends Model
{
    protected $fillable = [
        'job_posting_id','user_id','session_id','ip','user_agent','viewed_on',
    ];
}
