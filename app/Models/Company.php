<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    
    protected $fillable = [
        'user_id',
        'name',
        'trade_name',
        'tax_id',
        'industry',
        'company_size',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'zip',
        'country',
        'phone',
        'website',
        'logo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(JobPosting::class);
    }

}
