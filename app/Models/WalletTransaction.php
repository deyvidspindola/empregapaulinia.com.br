<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id','type','amount','reason','actor_user_id','meta','balance_after'
    ];
    protected $casts = ['meta' => 'array'];

    public function wallet(): BelongsTo { return $this->belongsTo(Wallet::class); }
}