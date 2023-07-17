<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HairArtist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'ha_name',
        'rating',
        'gender_specialist',
        'day_off',
        'created_by',
        'updated_by',
        'is_active',
    ];
}
