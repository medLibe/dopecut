<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TimeOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'time',
        'type',
        'created_by',
        'updated_by',
        'is_active',
    ];
}
