<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BranchOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'operation_time',
        'type',
        'created_by',
        'updated_by',
        'is_active',
    ];

    function getBranchOperation($branch_id)
    {
        $data = DB::table('branch_operations')
                  ->join('branches', 'branches.id', 'branch_operations.branch_id')
                  ->select('branch_operations.*', 'branches.branch_name')
                  ->where('branch_id', $branch_id)
                  ->get();

        return $data;
    }

    function getBranchOperationWithTime($operation_time)
    {
        $data = DB::table('branch_operations')
                  ->join('branches', 'branches.id', 'branch_operations.branch_id')
                  ->select('branch_operations.*', 'branches.branch_name')
                  ->whereNotIn('operation_time', $operation_time)
                  ->get();

        return $data;
    }

    function getAllBranchOperation()
    {
        $data = DB::table('branch_operations')
                  ->join('branches', 'branches.id', 'branch_operations.branch_id')
                  ->select('branch_operations.*', 'branch_operations.operation_time', 'branches.branch_name')
                  ->where('branch_operations.is_active', 1)
                  ->get();

        return $data;
    }
}
