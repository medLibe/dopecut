<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipAbsent extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_id',
        'created_by',
        'updated_by',
        'is_active',
    ];
}
