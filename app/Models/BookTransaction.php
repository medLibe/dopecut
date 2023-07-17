<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'book_date',
        'name',
        'book_time',
        'ha_id',
        'book_no',
        'phone',
        'gender',
        'book_type',
        'cancel_reason',
        'created_by',
        'updated_by',
        'is_active',
    ];

    function getAllBookTransaction()
    {
        $data = DB::table('book_transactions')
                  ->join('hair_artists', 'hair_artists.id', '=', 'book_transactions.ha_id')
                  ->select('book_transactions.*', 'hair_artists.ha_name')
                  ->orderBy('booK_date', 'DESC')
                  ->get();
                  
        return $data;
    }

    function getAllBookTransactionByUserId($user_id)
    {
        $data = DB::table('book_transactions')
                  ->join('hair_artists', 'hair_artists.id', '=', 'book_transactions.ha_id')
                  ->select('book_transactions.*', 'hair_artists.ha_name')
                  ->where('book_transactions.user_id', $user_id)
                  ->orderBy('book_date', 'DESC')
                  ->get();
                  
        return $data;
    }

    function getBookTransaction($book_transaction_no)
    {
        $data = DB::table('book_transactions')
                  ->join('hair_artists', 'hair_artists.id', '=', 'book_transactions.ha_id')
                  ->select('book_transactions.*', 'hair_artists.ha_name')
                  ->where('book_no', $book_transaction_no)
                  ->first();
                  
        return $data;
    }

    function checkBookTransaction($arr)
    {
        $data = DB::table('book_transactions')
                  ->select('book_time')
                  ->where('book_date', $arr['date'])
                  ->where('ha_id', $arr['ha_id'])
                  ->where('is_active', 1)
                  ->get();

        return $data;
    }
}
