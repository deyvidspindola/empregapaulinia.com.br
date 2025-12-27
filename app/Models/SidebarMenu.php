<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SidebarMenu extends Model
{
    protected $fillable = [
        'label',
        'route',
        'icon',
        'role',
        'position',
    ];
}
