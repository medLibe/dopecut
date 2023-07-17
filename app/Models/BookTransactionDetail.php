<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookTransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_transaction_id',
        'service_id',
        'service_detail_id',
        'price',
        'created_by',
        'updated_by',
        'is_active',
    ];

    function getBookTransactionDetail($book_id)
    {
        $data = DB::table('book_transaction_details')
                ->join('services', 'services.id', '=', 'book_transaction_details.service_id')
                ->select('book_transaction_details.*', 'services.service_name', 'services.estimation',
                         DB::raw('CASE WHEN estimation >= 60 THEN CONCAT(FLOOR(estimation/60), " jam", " ", estimation % 60, " menit")
                         ELSE CONCAT(estimation, " menit") END AS estimation'))
                ->where('book_transaction_id', $book_id)
                ->get();

        return $data;
    }
}
