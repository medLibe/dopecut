<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_post_id',
        'ip_address',
        'created_by',
        'updated_by',
        'is_active',
    ];
}
