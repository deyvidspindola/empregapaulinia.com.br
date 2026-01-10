<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSend extends Model
{
    use HasFactory;

    protected $fillable = [
        'type','user_id','meta','status','error_message','sent_at'
    ];

    protected $casts = [
        'meta' => 'array',
        'sent_at' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}