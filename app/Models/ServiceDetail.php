<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'thumbnail',
        'sd_name',
        'url_service',
        'description',
        'created_by',
        'updated_by',
        'is_active',
    ];

    function getServiceDetail($service_id)
    {
        $data = DB::table('service_details')
                ->join('services', 'services.id', '=', 'service_details.service_id')
                ->select('service_details.*', 'services.service_name')
                ->where('services.id', $service_id)
                ->get();

        return $data;
    }

    function getAllServiceDetail()
    {
        $data = DB::table('service_details')
                ->join('services', 'services.id', '=', 'service_details.service_id')
                ->select('service_details.*', 'services.service_name')
                ->where('service_details.is_active', 1)
                ->get();

        return $data;
    }

    function getServiceDetailById($service_detail_id)
    {
        $data = DB::table('service_details')
                ->join('services', 'services.id', '=', 'service_details.service_id')
                ->select('service_details.*', 'services.service_name')
                ->where('service_details.id', $service_detail_id)
                ->first();

        return $data;
    }
}
