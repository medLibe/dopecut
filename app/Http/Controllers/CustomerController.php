<?php

namespace App\Http\Controllers;

use App\Mail\TransactionBookMail;
use App\Models\ArticlePost;
use App\Models\BookCart;
use App\Models\BookTransaction;
use App\Models\BookTransactionDetail;
use App\Models\HairArtist;
use App\Models\HairArtistSchedule;
use App\Models\HitPost;
use App\Models\LikePost;
use App\Models\Service;
use App\Models\TimeOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use NumberFormatter;

class CustomerController extends Controller
{
    protected $service;
    protected $time_operation;
    protected $book_cart;
    protected $hair_artist;
    protected $book_transaction;
    protected $book_transaction_detail;
    protected $ha_schedule;
    protected $article_post;
    protected $hit_post;
    protected $like_post;

    public function __construct()
    {
        $this->service = new Service();
        $this->time_operation = new TimeOperation();
        $this->book_cart = new BookCart();
        $this->hair_artist = new HairArtist();
        $this->book_transaction = new BookTransaction();
        $this->book_transaction_detail = new BookTransactionDetail();
        $this->ha_schedule = new HairArtistSchedule();
        $this->article_post = new ArticlePost();
        $this->hit_post = new HitPost();
        $this->like_post = new LikePost();
    }

    public function index(Request $request)
    {
        $service = new Service();
        $menService = $service->where('gender_service', 1)->get();
        $womenService = $service->where('gender_service', 2)->get();
        $article_post = $this->article_post->getRandomArticle();

        return view('customer.home', [
            'men_service'   => $menService,
            'women_service' => $womenService,
            'article'       => $article_post,
        ]);
    }

    public function book(Request $request)
    {
        $idr = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        $service = $this->service->where('is_active', 1)->get();

        return view('customer.book', [
            'service' => $service,
            'idr'     => $idr,
        ]);
    }

    public function bookTransactionDetail(Request $request, $book_transaction_no){
        $month = [
            '01'    => 'Januari',
            '02'    => 'Februari',
            '03'    => 'Maret',
            '04'    => 'April',
            '05'    => 'Mei',
            '06'    => 'Juni',
            '07'    => 'Juli',
            '08'    => 'Agustus',
            '09'    => 'September',
            '10'    => 'Oktober',
            '11'    => 'November',
            '12'    => 'Desember',
        ];
        $getTransaction = $this->book_transaction->getBookTransaction($book_transaction_no);
        $getTransactionDetail = $this->book_transaction_detail->getBookTransactionDetail($getTransaction->id);
        $idr = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);

        return view('customer.book_detail', [
            'transaction'           => $getTransaction,
            'transaction_detail'    => $getTransactionDetail,
            'month'                 => $month,
            'idr'                   => $idr,
        ]);
    }

    public function getHairArtist(Request $request)
    {
        if($request->ajax()){
            $data = $this->hair_artist->where('is_active', '!=', 0)->get();

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'data'      => $data,
            ]);
        }
    }

    public function getHaSchedule(Request $request)
    {
        if($request->ajax()){
            if($request->picked_date == null){
                return response()->json([
                    'success'       => false,
                    'status'        => 401,
                    'message'       => 'Pilih tanggal terlebih dahulu.',
                ]);
            }

            $days = [
                0   => 'Sunday',
                1   => 'Monday',
                2   => 'Tuesday',
                3   => 'Wednesday',
                4   => 'Thursday',
                5   => 'Friday',
                6   => 'Saturday',
            ];

            $getHairArtist = $this->hair_artist->where('id', $request->ha_id)->first();
            $day_off = $getHairArtist->day_off;
            $picked_day = date('l', strtotime($request->picked_date));

            if($days[$day_off] == $picked_day){
                return response()->json([
                    'success'       => true,
                    'status'        => 200,
                    'data'          => [],
                ]);
            }

            $arr = [
                'ha_id'         => $request->ha_id,
                'picked_date'   => $request->picked_date,
            ];

            $getHaSchedule = $this->ha_schedule->getHaSchedule($arr)->toArray();
            $ha_schedule = array_map(function($object){
                return array_values(get_object_vars($object))[0];
            }, $getHaSchedule);

            $getTimeOperation = $this->time_operation->whereNotIn('time', $ha_schedule)->get();

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'data'      => $getTimeOperation
            ]);
        }
    }

    public function getService(Request $request, $arrData)
    {
        $tobase64Decode = base64_decode($arrData);
        $toJsonDecode = json_decode($tobase64Decode);
        $gender = $toJsonDecode->gender;
        $ha_id = $toJsonDecode->ha_id;
        $book_date = $toJsonDecode->book_date;
        $book_time = $toJsonDecode->book_time;

        $getService = $this->service->where('gender_service', $gender)->get();
        $getHa = $this->hair_artist->select('ha_name')->where('id', $ha_id)->first();

        return view('customer.book_service', [
            'service'   => $getService,
            'gender'    => $gender,
            'book_time' => $book_time,
            'book_date' => $book_date,
            'ha_id'     => $ha_id,
            'ha_name'   => $getHa->ha_name,
        ]);
    }

    public function createBook(Request $request)
    {
        $generateTransactionNo = strtoupper(Str::random(6)) . $request->user_id . date('my');

        $insertID = $this->book_transaction::create([
            'user_id'       => Auth::user()->id,
            'name'          => $request->name,
            'book_date'     => $request->book_date,
            'book_time'     => $request->book_time,
            'phone'         => $request->phone,
            'ha_id'         => $request->ha_id,
            'book_no'       => $generateTransactionNo,
            'gender'        => $request->gender,
            'book_type'     => 1,
            'created_by'    => $request->name,
            'updated_by'    => $request->name,
        ]);

        $this->ha_schedule::create([
            'book_transaction_id'   => $insertID->id,
            'ha_id'                 => $request->ha_id,
            'schedule_time'         => $request->book_time,
            'schedule_date'         => $request->book_date,
            'schedule_type'         => 1,
            'created_by'            => $request->name,
            'updated_by'            => $request->name,
        ]);

        foreach($request->service_id as $key){
            $service_id = $key;

            echo $service_id;

            $this->book_transaction_detail::create([
                'book_transaction_id'   => $insertID->id,
                'service_id'            => $service_id,
                'price'                 => 0,
                'created_by'            => $request->name,
                'updated_by'            => $request->name,
            ]);
        }

        return redirect('/book/detail/' . $generateTransactionNo)
                ->with('success', 'Your book transaction has been created.');
    }

    public function sendBookMail(Request $request, $book_no)
    {
        if($request->ajax()){
            $transaction = $this->book_transaction->getBookTransaction($book_no);
            $transaction_detail = $this->book_transaction_detail->getBookTransactionDetail($transaction->id);
            $month = [
                '01'    => 'Januari',
                '02'    => 'Februari',
                '03'    => 'Maret',
                '04'    => 'April',
                '05'    => 'Mei',
                '06'    => 'Juni',
                '07'    => 'Juli',
                '08'    => 'Agustus',
                '09'    => 'September',
                '10'    => 'Oktober',
                '11'    => 'November',
                '12'    => 'Desember',
            ];

            $data = [
                'book_no'               => $transaction->book_no,
                'book_date'             => $transaction->book_date,
                'book_time'             => $transaction->book_time,
                'ha_name'               => $transaction->ha_name,
                'name'                  => $transaction->name,
                'gender'                => $transaction->gender,
                'phone'                 => $transaction->phone,
                'transaction_detail'    => $transaction_detail,
                'month'                 => $month,
            ];

            Mail::to([Auth::user()->email, 'dopecutcashier@gmail.com'])
                ->send(new TransactionBookMail($data));

            if(Mail::failures()){
                return response()->json([
                    'success'               => false,
                    'status'                => 401,
                    'message'               => 'Send mail failed, please try again later..',
                ]);
            }

            return response()->json([
                'success'               => true,
                'status'                => 200,
                'message'               => 'Your booking detail was successfully send to your email.',
            ]);
        }
    }

    public function bookHistory(Request $request)
    {
        $history = $this->book_transaction->getAllBookTransactionByUserId(Auth::user()->id);

        $month = [
            '01'    => 'Januari',
            '02'    => 'Februari',
            '03'    => 'Maret',
            '04'    => 'April',
            '05'    => 'Mei',
            '06'    => 'Juni',
            '07'    => 'Juli',
            '08'    => 'Agustus',
            '09'    => 'September',
            '10'    => 'Oktober',
            '11'    => 'November',
            '12'    => 'Desember',
        ];

        return view('customer.book_history', [
            'history'   => $history,
            'month'     => $month,
        ]);
    }

    public function bookCancel(Request $request, $book_transaction_id)
    {
        $this->book_transaction->where('id', $book_transaction_id)->update([
            'cancel_reason' => $request->cancel_reason,
            'is_active'     => 2,
            'updated_by'    => Auth::user()->name,
        ]);

        $this->ha_schedule->where('book_transaction_id', $request->book_id)->update([
            'is_active'     => 2,
            'updated_by'    => $request->creator,
        ]);

        $this->book_transaction_detail->where('book_transaction_id', $book_transaction_id)->update([
            'is_active'     => 2,
            'updated_by'    => Auth::user()->name,
        ]);

        return redirect()->back()->with('success', 'Your booked has been canceled.');
    }

    public function test(Request $request)
    {
        $month = [
            '01'    => 'Januari',
            '02'    => 'Februari',
            '03'    => 'Maret',
            '04'    => 'April',
            '05'    => 'Mei',
            '06'    => 'Juni',
            '07'    => 'Juli',
            '08'    => 'Agustus',
            '09'    => 'September',
            '10'    => 'Oktober',
            '11'    => 'November',
            '12'    => 'Desember',
        ];

        $idr = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        $getTransaction = $this->book_transaction->getBookTransaction('8JQGKW0423');
        $getTransactionDetail = $this->book_transaction_detail->getBookTransactionDetail(1);

        $data = [
            'book_no'           => $getTransaction->book_no,
            'book_date'         => $getTransaction->book_date,
            'book_time'         => $getTransaction->book_time,
            'ha_name'           => $getTransaction->ha_name,
            'name'              => $getTransaction->name,
            'phone'             => $getTransaction->phone,
            'transaction_detail'=> $getTransactionDetail,
            'month'             => $month,
        ];

        return view('customer.book_mail', [
            'data'  => $data,
        ]);
    }

    public function article()
    {
        $getArticle = $this->article_post->where('is_active', 1)->get();

        return view('customer.article_list', [
            'page'      => "Dopecut's Blog",
            'article'   => $getArticle,
        ]);
    }

    public function viewArticle($slug)
    {
        $getArticle = $this->article_post->where('slug', $slug)->first();
        $countLike = $this->like_post->where('article_post_id', $getArticle->id)->count();
        $getOtherArticle = $this->article_post->getOtherArticle($slug);

        return view('customer.article', [
            'article'   => $getArticle,
            'articles'  => $getOtherArticle,
            'like'      => $countLike,
        ]);
    }

    public function hitArticle($slug)
    {
        $getArticle = $this->article_post->where('slug', $slug)->first();

        if(Auth::user() === null){
            $this->hit_post->create([
                'article_post_id'   => $getArticle->id,
                'created_by'        => 'Guest',
                'updated_by'        => 'Guest',
            ]);
        }else{
            $this->hit_post->create([
                'article_post_id'   => $getArticle->id,
                'created_by'        => Auth::user()->name,
                'updated_by'        => Auth::user()->name,
            ]);
        }

        $url = '/article/' . $slug;

        return response()->json(['success' => true, 'redirect' => $url]);
    }

    public function likeArticle(Request $request, $id)
    {
        $like = $request->like + 1;
        $this->like_post->create([
            'article_post_id'  => $request->article_id,
            'user_id'          => Auth::user() == null ? null : Auth::user()->name,
            'created_by'       => Auth::user() == null ? 'Guest' : Auth::user()->name,
            'updated_by'       => Auth::user() == null ? 'Guest' : Auth::user()->name,
        ]);
        return response()->json([
            'success'   => true,
            'like'      => $like,
            'id'        => $id,
        ]);
    }
}
