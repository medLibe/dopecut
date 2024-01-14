<?php

namespace App\Http\Controllers;

use App\Models\ArticlePost;
use App\Models\BookTransaction;
use App\Models\BookTransactionDetail;
use App\Models\HairArtist;
use App\Models\HairArtistSchedule;
use App\Models\Membership;
use App\Models\MembershipAbsent;
use App\Models\Service;
use App\Models\TimeOperation;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class UnmasterController extends Controller
{
    protected $book_transaction;
    protected $book_transaction_detail;
    protected $service;
    protected $time_operation;
    protected $branch;
    protected $branch_service;
    protected $user;
    protected $service_detail;
    protected $hair_artist;
    protected $ha_schedule;
    protected $article_post;
    protected $membership;
    protected $membership_absent;

    function __construct()
    {
        $this->book_transaction = new BookTransaction();
        $this->book_transaction_detail = new BookTransactionDetail();
        $this->service = new Service();
        $this->time_operation = new TimeOperation();
        $this->user = new User();
        $this->hair_artist = new HairArtist();
        $this->ha_schedule = new HairArtistSchedule();
        $this->article_post = new ArticlePost();
        $this->membership = new Membership();
        $this->membership_absent = new MembershipAbsent();
    }

    public function index(Request $request)
    {
        $booked = $this->book_transaction->where('is_active', '!=', 0)->count();
        $service = $this->service->where('is_active', 1)->count();
        $hair_artist = $this->hair_artist->where('is_active', 1)->count();
        return view('admin.dashboard', [
            'page'             => 'Dashboard',
            'booked'           => $booked,
            'service'          => $service,
            'hair_artist'      => $hair_artist,
        ]);
    }

    public function bookList()
    {
        $getBook = $this->book_transaction->select('id', 'book_no')->get();
        return view('admin.book', [
            'page'  => 'Booking Data',
            'book'  => $getBook,
        ]);
    }

    public function getBookList(Request $request)
    {
        if($request->ajax()){
            $data = $this->book_transaction->getAllBookTransaction();

            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('book_date', function($row){
                                $bookTime = '<span>' . date('d-m-Y', strtotime($row->book_date)) .'</span>';
                                return $bookTime;
                            })
                            ->addColumn('phone', function($row){
                                if($row->phone == null){
                                    return '<div class="text-center">N/A</div>';
                                }else{
                                    return '<div class="text-center">' . $row->phone . '</div>';
                                }
                            })
                            ->addColumn('book_time', function($row){
                                $bookTime = '<span>' . $row->book_time .' WIB</span>';
                                return $bookTime;
                            })
                            ->addColumn('action', function($row){
                                if($row->is_active == 1){
                                    $actionBtn = '<div class="text-center"><button class="btn btn-sm btn-primary detailBtn" data-toggle="modal" data-target="#detail-booking'. $row->id .'" id="btn' . $row->id .'">
                                    <i class="fas fa-eye"></i></button> <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#cancel-booking'. $row->id .'">
                                    <i class="fas fa-ban"></i></button></div>';
                                }else{
                                    $actionBtn = '<div class="text-center"><button class="btn btn-sm btn-primary detailBtn" data-toggle="modal" data-target="#detail-booking'. $row->id .'" id="btn' . $row->id .'">
                                    <i class="fas fa-eye"></i></button></div>';
                                }

                                return $actionBtn;
                            })
                            ->rawColumns(['book_date', 'phone', 'book_time', 'action'])
                            ->make(true);
        }
    }

    public function getBookDetailList(Request $request, $book_transaction_id)
    {
        if($request->ajax()){
            $data = $this->book_transaction_detail->getBookTransactionDetail($book_transaction_id);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'data'      => $data,
            ]);
        }
    }

    public function doBook(Request $request)
    {
        $service = $this->service->where('is_active', 1)->get();
        $generateTransactionNo = strtoupper(Str::random(6)) . $request->user_id . date('my');
        $hair_artist = $this->hair_artist->where('is_active', 1)->get();

        return view('admin.book_create', [
            'page'              => 'Tambah Booking',
            'service'           => $service,
            'book_no'           => $generateTransactionNo,
            'hair_artist'       => $hair_artist,
        ]);
    }

    public function getHaSchedule(Request $request)
    {
        if($request->ajax()){
            if($request->book_date == null){
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
            $picked_day = date('l', strtotime($request->book_date));

            if($days[$day_off] == $picked_day){
                return response()->json([
                    'success'       => true,
                    'status'        => 200,
                    'data'          => [],
                ]);
            }

            $arr = [
                'ha_id'         => $request->ha_id,
                'picked_date'   => $request->book_date,
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

    public function createBook(Request $request)
    {
        $dateObj = date_create_from_format('d/m/Y', $request->book_date);
        $book_date = date_format($dateObj, 'Y-m-d');

        $insertID = $this->book_transaction::create([
            'user_id'       => null,
            'name'          => $request->name,
            'book_date'     => $book_date,
            'book_time'     => $request->book_time,
            'ha_id'         => $request->ha_id,
            'book_no'       => $request->book_no,
            'gender'        => $request->gender,
            'phone'         => $request->phone,
            'book_type'     => 2,
            'created_by'    => Auth::user()->username,
            'updated_by'    => Auth::user()->username,
        ]);

        $this->ha_schedule::create([
            'book_transaction_id'   => $insertID->id,
            'ha_id'                 => $request->ha_id,
            'schedule_time'         => $request->book_time,
            'schedule_date'         => $book_date,
            'schedule_type'         => 2,
            'created_by'            => Auth::user()->username,
            'updated_by'            => Auth::user()->username,
        ]);

        foreach($request->service_id as $key => $val){
            $service_id = $request->service_id[$key];

            $this->book_transaction_detail::create([
                'book_transaction_id'   => $insertID->id,
                'service_id'            => $service_id,
                'price'                 => 0,
                'created_by'            => Auth::user()->username,
                'updated_by'            => Auth::user()->username,
            ]);
        }

        return redirect()->to('/admin/book')->with('success', 'Booking #' . $request->book_no .' berhasil ditambahkan.');
    }

    public function updateBook(Request $request)
    {
        if($request->ajax()){

            $this->book_transaction->where('id', $request->book_id)->update([
                'is_active'     => 2,
                'cancel_reason' => $request->cancel_reason,
                'updated_by'    => $request->creator,
            ]);

            $this->ha_schedule->where('book_transaction_id', $request->book_id)->update([
                'is_active'     => 2,
                'updated_by'    => $request->creator,
            ]);

            $this->book_transaction_detail->where('book_transaction_id', $request->book_id)->update([
                'is_active'     => 2,
                'updated_by'    => $request->creator,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Book ID #' . $request->book_no . ' has been canceled.',
            ]);
        }
    }

    public function haScheduleList()
    {
        $hair_artist = $this->hair_artist->get();
        return view('admin.ha_schedule', [
            'page'          => 'Schedule',
            'hair_artist'   => $hair_artist,
        ]);
    }

    public function getHaScheduleList(Request $request, $schedule_type)
    {
        if($request->ajax()){
            $data = $this->ha_schedule->getAllHaSchedule($schedule_type);

            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('schedule_date', function($row){
                                $spanDate = '<span>' . date('d-m-Y', strtotime($row->schedule_date)) .'</span>';

                                return $spanDate;
                            })
                            ->addColumn('schedule_time', function($row){
                                $time = $row->schedule_time == null ? '-' : $row->schedule_time;

                                return $time;
                            })
                            ->rawColumns(['schedule_date', 'schedule_time'])
                            ->make(true);
        }
    }

    public function createHaSchedule(Request $request)
    {
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'ha_id'         => 'required',
                'schedule_date' => 'required',
                'description'   => 'required',
            ],
            [
                'ha_id.required'            => 'Hair Artist tidak boleh kosong.',
                'schedule_date.required'    => 'Tanggal tidak boleh kosong.',
                'description.required'      => 'Keterangan tidak boleh kosong.',
            ]);

            $isLeaveExist = $this->ha_schedule->where('ha_id', $request->ha_id)
                                              ->where('schedule_date', $request->schedule_date)
                                              ->first();

            if($validator->fails()){
                return response()->json([
                    'data'      => [],
                    'message'   => $validator->errors(),
                    'success'   => false,
                    'status'    => 401,
                ]);
            }

            if($isLeaveExist !== null)
            {
                return response()->json([
                    'message'   => 'Kamu sudah mengajukan cuti pada tanggal tersebut.',
                    'success'   => false,
                    'status'    => 400,
                ]);
            }

            $this->ha_schedule->create([
                'ha_id'         => $request->ha_id,
                'schedule_date' => $request->schedule_date,
                'schedule_time' => null,
                'schedule_type' => 3,
                'description'   => $request->description,
                'created_by'    => $request->creator,
                'updated_by'    => $request->creator,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Manual day off berhasil ditambahkan.',
            ]);
        }
    }
    /**
     * End Hair Artist Schedules
     */

    //  Start Article
    public function articleList()
    {
        $getArticle = $this->article_post->get();

        return view('admin.article', [
            'page'    => 'Artikel',
            'article' => $getArticle,
        ]);
    }

    public function getArticleList(Request $request)
    {
        if($request->ajax()){
            $data = $this->article_post->getAllArticle();

            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('created_at', function($row){
                                $created_at = '<span>' . date('d M Y', strtotime($row->created_at)) .'</span>';
                                return $created_at;
                            })
                            ->addColumn('status', function($row){
                                $row->is_active == 1 ? $status = '<span class="badge bg-primary">Active</span>' : $status = '<span class="badge bg-warning">Takedown</span>';

                                return $status;
                            })
                            ->addColumn('action', function($row){
                                $actionBtn = '<div><a href="/admin/article/edit/' . $row->slug . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a> <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#takedownModal' . $row->id . '"><i class="fas fa-trash"></i></button></div>';

                                return $actionBtn;
                            })
                            ->rawColumns(['created_at', 'status', 'action'])
                            ->make(true);
        }
    }

    public function postArticle()
    {
        return view('admin.article_create', [
            'page'  => 'Artikel Baru',
        ]);
    }

    public function slugGenerate($title)
    {
        $addHyphen = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));

        // remove '-' redundance
        $rmvReHyphen = preg_replace('/-+/', '-', $addHyphen);

        // remove '-' in first and last slug
        $slug = trim($rmvReHyphen, '-');

        return $slug;
    }

    public function createArticle(Request $request)
    {
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'title'            => 'required',
                'author'           => 'required',
                'content'          => 'required',
                'image_headline'   => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
                'content_headline' => 'required',
            ],
            [
                'title.required'           => 'Judul artikel tidak kosong.',
                'author.required'          => 'Penulis artikel tidak boleh kosong.',
                'content.required'         => 'Kontent artikel tidak boleh kosong.',
                'image_headline.required'  => 'Gambar headline untuk artikel tidak boleh kosong.',
                'image_headline.image'     => 'Gambar headline bukan berupa file gambar.',
                'image_headline.mimes'     => 'Gambar headline harus file berupa jpeg,jpg,png,svg.',
                'content_headline.required'=> 'Kontent headline untuk artikel tidak boleh kosong.',
            ]);

            if($validator->fails()){
                return response()->json([
                    'data'      => [],
                    'message'   => $validator->errors(),
                    'success'   => false,
                    'status'    => 401,
                ]);
            }

            $image_headline = "data:image/png;base64,".base64_encode(file_get_contents($request->file('image_headline')));
            $append_image = '<img src="' . $image_headline .'" class="img-top img-headline" alt="Image Blog">';

            $this->article_post->create([
                'title'             => $request->title,
                'author'            => $request->author,
                'content'           => $request->content,
                'image_headline'    => $append_image,
                'content_headline'  => $request->content_headline,
                'slug'              => $this->slugGenerate($request->title),
                'created_by'        => Auth::user()->username,
                'updated_by'        => Auth::user()->username,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'redirect'  => '/admin/article',
                'message'   => 'Artikel baru berhasil ditambahkan.',
            ], 200);
        }
    }

    public function editArticle($slug)
    {
        $getArticle = $this->article_post->where('slug', $slug)->first();

        return view('admin.article_edit', [
            'page'      => 'Ubah Artikel',
            'article'   => $getArticle,
        ]);
    }

    public function updateArticle(Request $request)
    {
        if($request->ajax()){
            if($request->file('image_headline') != null){
                $image_headline = "data:image/png;base64,".base64_encode(file_get_contents($request->file('image_headline')));
                $append_image = '<img src="' . $image_headline .'" class="img-top img-headline" alt="Image Blog">';

                $this->article_post->where('id', $request->article_id)->update([
                    'title'             => $request->title,
                    'author'            => $request->author,
                    'content'           => $request->content,
                    'image_headline'    => $append_image,
                    'content_headline'  => $request->content_headline,
                    'slug'              => $this->slugGenerate($request->title),
                    'updated_by'        => Auth::user()->username,
                ]);

            }else{
                $this->article_post->where('id', $request->article_id)->update([
                    'title'             => $request->title,
                    'author'            => $request->author,
                    'content'           => $request->content,
                    'content_headline'  => $request->content_headline,
                    'slug'              => $this->slugGenerate($request->title),
                    'updated_by'        => Auth::user()->username,
                ]);
            }

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'redirect'  => '/admin/article',
                'message'   => 'Artikel berhasil diubah.',
            ], 200);
        }
    }

    public function takedownArticle($slug)
    {
        $this->article_post->where('slug', $slug)->update([
            'is_active'     => 2,
            'updated_by'    => Auth::user()->username,
        ]);

        return redirect('/admin/article')->with('success', 'Artikel berhasil ditakedown');
    }

    /**
     * Membership
     */
    public function membership()
    {
        $getMember = $this->membership->getMembership();
        return view('admin.membership', [
            'page'      => 'Membership',
            'view_mode' => false,
            'member'    => $getMember
        ]);
    }

    public function fetchMembership()
    {
        try{
            $getMember = $this->membership->getMembership();

            return response()->json([
                'success'   => true,
                'data'      => $getMember,
            ]);

        }catch(Exception $err){
            return response()->json([
                'success'   => false,
                'message'   => $err->getMessage(),
            ], 500);
        }
    }

    public function getMembership(Request $request)
    {
        try{
            if($request->ajax()){
                $data = $this->membership->getMembership();

                return DataTables::of($data)
                                ->addColumn('start_date', function($row) {
                                    $start_date = date('d-m-Y', strtotime($row->start_date));
                                    return $start_date;
                                })
                                ->addColumn('end_date', function($row) {
                                    $end_date = date('d-m-Y', strtotime($row->end_date));
                                    return $end_date;
                                })
                                ->addColumn('status', function($row) {
                                    if($row->is_active == 1){
                                        $status = '<div class="badge badge-success">Aktif</div>';
                                    }else{
                                        $status = '<div class="badge badge-secondary">Tidak Aktif</div>';
                                    }

                                    return $status;
                                })
                                ->addColumn('action', function($row){
                                    $actionBtn = '<div class="text-center"><a href="/admin/member/' . $row->id . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></div>';

                                    return $actionBtn;
                                })
                                ->rawColumns(['start_date', 'end_date', 'status', 'action'])
                                ->make(true);
            }
        }catch(Exception $err){
            return response()->json([
                'success'   => false,
                'message'   => $err->getMessage(),
            ], 500);
        }
    }

    public function existMember(Request $request)
    {
        try {
            $getMember = $this->user->select('no_hp')->where('no_hp', $request->no_hp)->first();

            return response()->json([
                'success'       => true,
                'is_available'  => $getMember,
            ]);

        } catch (Exception $err) {
            return response()->json([
                'success'   => false,
                'message'   => $err->getMessage(),
            ], 500);
        }
    }


    public function storeMembership(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'no_hp'         => 'required|numeric|unique:users',
                'name'          => 'required',
                'start_date'    => 'required|date',
            ],
            [
                'no_hp.required'        => 'No. HP tidak boleh kosong.',
                'no_hp.numeric'         => 'No. HP hanya boleh mengandung angka.',
                'no_hp.unique'          => 'No. HP sudah terdaftar menjadi member, silahkan lakukan absen.',
                'name.required'         => 'Nama tidak boleh kosong.',
                'start_date.required'   => 'Tanggal awal member tidak boleh kosong.',
                'start_date.date'       => 'Format tanggal tidak sesuai.',
            ]);

            if($validator->fails()){
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->errors(),
                ], 400);
            }

            $storeUser = $this->user->create([
                'no_hp'         => $request->no_hp,
                'name'          => $request->name,
                'role_id'       => 2,
                'created_by'    => Auth::user()->username,
                'updated_by'    => Auth::user()->username,
            ]);

            $this->membership->create([
                'user_id'       => $storeUser->id,
                'start_date'    => $request->start_date,
                'end_date'      => $request->end_date,
                'duration'      => 365,
                'created_by'    => Auth::user()->username,
                'updated_by'    => Auth::user()->username,
            ]);

            return response()->json([
                'success'   => true,
                'message'   => 'Member baru berhasil ditambahkan.',
            ]);

        } catch (Exception $err) {
            return response()->json([
                'success'   => false,
                'message'   => $err->getMessage(),
            ]);
        }
    }

    public function getMembershipById($id)
    {
        return view('admin.membership', [
            'page'      => 'Absen Membership',
            'view_mode' => true,
            'member_id' => $id,
        ]);
    }

    public function getMembershipAbsentById(Request $request, $id)
    {
        try{
            if($request->ajax()){
                $data = $this->membership_absent->select('created_at')->where('membership_id', $id)->get();

                return DataTables::of($data)
                    ->addColumn('created_at', function ($row) {
                        $created_at = date('d-m-Y H:i:s', strtotime($row->created_at));

                        return $created_at;
                    })
                    ->rawColumns(['created_at'])
                    ->make(true);
            }
        }catch(Exception $err){
            return response()->json([
                'success'   => false,
                'message'   => $err->getMessage(),
            ], 500);
        }
    }


    public function membershipAbsent(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'membership_id' => 'required',
            ],
            [
                'membership_id.required'    => 'No. HP tidak boleh kosong.',
            ]);

            if($validator->fails()){
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->errors(),
                ], 400);
            }

            $this->membership_absent->create([
                'membership_id' => $request->membership_id,
                'created_by'    => Auth::user()->username,
                'updated_by'    => Auth::user()->username,
            ]);

            return response()->json([
                'success'   => true,
                'message'   => 'Member berhasil di absen.',
            ]);

        } catch (Exception $err) {
            return response()->json([
                'success'   => false,
                'message'   => $err->getMessage(),
            ]);
        }
    }
}
