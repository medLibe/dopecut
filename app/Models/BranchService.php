<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BranchService extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'service_id',
        'created_by',
        'updated_by',
        'is_active',
    ];

    function getBranchService($branch_id)
    {
        $data = DB::table('branch_services')
                ->join('branches', 'branches.id', '=', 'branch_services.branch_id')
                ->join('services', 'services.id', '=', 'branch_services.service_id')
                ->selectRaw('services.thumbnail, services.service_name, services.price, branch_services.branch_id, branch_services.service_id,
                CASE 
                    WHEN estimation >= 60 THEN 
                        CASE 
                            WHEN FLOOR(estimation % 60) = 0 
                                THEN CONCAT(FLOOR(estimation/60), " jam")
                            ELSE CONCAT(FLOOR(estimation/60), " jam", " ", estimation % 60, " menit") 
                        END
                    ELSE CONCAT(estimation, " menit") 
                END AS estimation')
                ->where('services.is_active', 1)
                ->where('branches.id', $branch_id)
                ->get();

        return $data;
    }

    function getAllBranchService()
    {
        $data = DB::table('branch_services')
                ->join('branches', 'branches.id', '=', 'branch_services.branch_id')
                ->join('services', 'services.id', '=', 'branch_services.service_id')
                ->select('services.service_name', 'services.estimation', 'services.price', 'branch_services.id',
                        'branch_services.branch_id', 'branch_services.service_id', 'branches.branch_name')
                ->where('services.is_active', 1)
                ->get();

        return $data;
    }

    function checkBranchService($arr)
    {
        $data = DB::table('branch_services')
                    ->where('branch_id', $arr['branch_id'])
                    ->where('service_id', $arr['service_id'])
                    ->first();

        return $data;
    }
}
