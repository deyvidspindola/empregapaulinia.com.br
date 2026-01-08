<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SidebarMenu extends Model
{
    protected $fillable = [
        'label',
        'route',
        'icon',
        'active',
        'role',
        'position',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d/m/Y')
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d/m/Y')
        );
    }

}
