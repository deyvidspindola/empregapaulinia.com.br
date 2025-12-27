<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPostingApplication extends Model
{
    protected $fillable = [
        'job_posting_id',
        'user_id',
        'company_id',
        'status',
        'cover_letter',
        'resume_path',
        'emailed_to',
        'emailed_at',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array',
        'emailed_at' => 'datetime'
    ];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
