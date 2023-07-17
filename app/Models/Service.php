<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'thumbnail',
        'service_name',
        'estimation',
        'gender_service',
        'sub_service',
        'price',
        'tentative_price',
        'created_by',
        'updated_by',
        'is_active',
    ];

    function getAllService()
    {
        $data = DB::table('services')
                    ->select(DB::raw('
                            id, service_name, CONCAT("Rp ", FORMAT(price, 0, "id_ID")) AS price,
                            CASE
                                WHEN estimation>=60
                                THEN CONCAT(
                                    FLOOR(estimation / 60), " jam",
                                    IF(estimation % 60 = 0, "", CONCAT(" ", estimation % 60, " menit"))
                                  )
                            ELSE
                                CONCAT(estimation, " menit")
                            END AS estimation,
                            thumbnail, gender_service, tentative_price'))
                    ->where('is_active', 1)
                    ->get();
        return $data;
    }
}
