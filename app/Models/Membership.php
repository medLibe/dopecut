<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'duration',
        'created_by',
        'updated_by',
        'is_active',
    ];

    function getMembership()
    {
        $data = DB::table('memberships')
                    ->rightJoin('users', 'users.id', '=', 'memberships.user_id')
                    ->select('memberships.*', 'users.name', 'users.no_hp')
                    ->where('memberships.is_active', 1)
                    ->get();
        return $data;
    }
}
