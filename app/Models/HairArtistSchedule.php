<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HairArtistSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_transaction_id',
        'ha_id',
        'schedule_date',
        'schedule_time',
        'schedule_type',
        'description',
        'created_by',
        'updated_by',
        'is_active',
    ];

    function getHaSchedule($arr)
    {
        $data = DB::table('hair_artist_schedules')
                ->selectRaw('schedule_time as time')
                ->where('ha_id', $arr['ha_id'])
                ->where('schedule_date', $arr['picked_date'])
                ->get();

        return $data;
    }

    function getAllHaSchedule($schedule_type)
    {
        if($schedule_type == 1){
            $data = DB::table('hair_artist_schedules')
                    ->join('hair_artists', 'hair_artists.id', '=', 'hair_artist_schedules.ha_id')
                    ->select("hair_artist_schedules.*", 'hair_artists.ha_name')
                    ->where('hair_artist_schedules.schedule_type', '<', 3)
                    ->get();
    
            return $data;
        }else{
            $data = DB::table('hair_artist_schedules')
                    ->join('hair_artists', 'hair_artists.id', '=', 'hair_artist_schedules.ha_id')
                    ->select("hair_artist_schedules.*", 'hair_artists.ha_name')
                    ->where('hair_artist_schedules.schedule_type', 3)
                    ->get();

            return $data;
        }
    }
}
