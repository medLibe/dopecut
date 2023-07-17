<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'price',
        'created_by',
        'updated_by',
        'is_active',
    ];

    function getUserCart($user_id)
    {
        $data = DB::table('book_carts')
                    ->join('services', 'services.id', '=', 'book_carts.service_id')
                    ->select('book_carts.*', 'services.service_name', 'services.price', 'services.estimation', 'services.thumbnail')
                    ->where('user_id', $user_id)
                    ->where('book_carts.is_active', 1)
                    ->get();

        return $data;
    }
}
