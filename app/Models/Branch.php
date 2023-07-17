<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_name',
        'open_at',
        'closed_at',
        'address',
        'phone',
        'created_by',
        'updated_by',
        'is_active',
    ];
}
