<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $fillable = [
        'admin_id',
        'admin_name',
        'action',
        'description',
    ];

}

