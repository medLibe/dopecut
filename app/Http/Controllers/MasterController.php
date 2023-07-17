<?php

namespace App\Http\Controllers;

use App\Models\BookTransaction;
use App\Models\BookTransactionDetail;
use App\Models\HairArtist;
use App\Models\HairArtistSchedule;
use App\Models\Service;
use App\Models\TimeOperation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class MasterController extends Controller
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

    function __construct()
    {
        $this->book_transaction = new BookTransaction();
        $this->book_transaction_detail = new BookTransactionDetail();
        $this->service = new Service();
        $this->time_operation = new TimeOperation();
        $this->user = new User();
        $this->hair_artist = new HairArtist();
        $this->ha_schedule = new HairArtistSchedule();
    }

    public function index()
    {
        $getService = $this->service->where('is_active', 1)->get();
        return view('admin.service', [
            'page'      => 'Service',
            'service'   => $getService,
        ]);
    }

    public function getServiceList(Request $request)
    {
        if($request->ajax()){
            $data = $this->service->getAllService();

            return DataTables::of($data)
                            ->addIndexColumn()
                            // ->addColumn('thumbnail', function($row){
                            //     if($row->thumbnail !== '/assets/image/no-image.png'){
                            //         $thumbnail = '<div class="text-center"><img src="' . asset('storage/' .$row->thumbnail) .'" style="width: 60px; height: 60px;"></div>';
                            //     }else{
                            //         $thumbnail = '<div class="text-center"><img src="' . $row->thumbnail .'" style="width: 60px; height: 60px;"></div>';
                            //     }

                            //     return $thumbnail;
                            // })
                            ->addColumn('gender_service', function($row){
                                if($row->gender_service == 1){
                                    $gender = 'Pria';
                                }else{
                                    $gender = 'Wanita';
                                }

                                return $gender;
                            })
                            ->addColumn('tentative_price', function($row){
                                if($row->tentative_price == 1){
                                    $isTentative = 'Ya';
                                }else{
                                    $isTentative = 'Tidak';
                                }

                                return $isTentative;
                            })
                            ->addColumn('action', function($row){
                                // $actionBtn = '<div class="text-center"><a class="btn btn-sm btn-warning" href="/admin/service/edit/' . base64_encode(json_encode(['id' => $row->id])) .'"><i class="fas fa-edit"></i></a></div>';
                                $actionBtn = '<div class="text-center"><button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal' . $row->id .'"><i class="fas fa-edit"></i></button></div>';

                                return $actionBtn;
                            })
                            ->rawColumns(['thumbnail', 'gender_service', 'tentative_price', 'action'])
                            ->make(true);
        }
    }

    // public function createService(Request $request)
    // {
    //     if($request->ajax()){
    //         $validator = Validator::make($request->all(), [
    //             'service_name'  => 'required',
    //             'estimation'    => 'required|numeric',
    //             'price'         => 'required|numeric',
    //         ],
    //         [
    //             'service_name.required' => 'Service tidak boleh kosong.',
    //             'estimation.required'   => 'Estimasi tidak boleh kosong.',
    //             'estimation.numeric'    => 'Field estimasi harus mengandung angka.',
    //             'price.required'        => 'Estimasi tidak boleh kosong.',
    //             'price.numeric'         => 'Field harga harus mengandung angka.',
    //         ]);

    //         if($validator->fails()){
    //             return response()->json([
    //                 'data'      => [],
    //                 'message'   => $validator->errors(),
    //                 'success'   => false,
    //                 'status'    => 401,
    //             ]);
    //         }

    //         if($request->thumbnail !== null){
    //             $image_64 = $request->thumbnail;
    //             $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
    //             $replace = substr($image_64, 0, strpos($image_64, ',')+1);
    //             $image = str_replace($replace, '', $image_64);
    //             $image = str_replace(' ', '+', $image);

    //             $imageName = md5(Str::random(15).date('dmY')).'.'.$extension;
    //             Storage::disk('public')->put('/service/'.$imageName, base64_decode($image));

    //             $this->service->create([
    //                 'service_name'  => $request->service_name,
    //                 'estimation'    => $request->estimation,
    //                 'price'         => $request->price,
    //                 'thumbnail'     => 'service/'. $imageName,
    //                 'created_by'    => $request->creator,
    //                 'updated_by'    => $request->creator,
    //             ]);
    //         }else{
    //             $this->service->create([
    //                 'service_name'  => $request->service_name,
    //                 'estimation'    => $request->estimation,
    //                 'price'         => $request->price,
    //                 'thumbnail'     => '/assets/image/no-image.png',
    //                 'created_by'    => $request->creator,
    //                 'updated_by'    => $request->creator,
    //             ]);
    //         }


    //         return response()->json([
    //             'success'   => true,
    //             'status'    => 200,
    //             'message'   => 'Service berhasil ditambahkan.',
    //         ]);
    //     }
    // }

    public function createService(Request $request)
    {
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'service_name'      => 'required',
                'estimation'        => 'required|numeric',
                'price'             => 'required|numeric',
                'tentative_price'   => 'required',
                'gender_service'    => 'required',
            ],
            [
                'service_name.required'     => 'Service tidak boleh kosong.',
                'estimation.required'       => 'Estimasi tidak boleh kosong.',
                'estimation.numeric'        => 'Field estimasi harus mengandung angka.',
                'price.required'            => 'Harga tidak boleh kosong.',
                'price.numeric'             => 'Field harga harus mengandung angka.',
                'tentative_price.required'  => 'Harga tentative tidak boleh kosong.',
                'gender_service.required'   => 'Jenis service tidak boleh kosong.',
            ]);

            if($validator->fails()){
                return response()->json([
                    'data'      => [],
                    'message'   => $validator->errors(),
                    'success'   => false,
                    'status'    => 401,
                ]);
            }

            $this->service->create([
                'service_name'      => $request->service_name,
                'estimation'        => $request->estimation,
                'price'             => $request->price,
                'gender_service'    => $request->gender_service,
                'tentative_price'   => $request->tentative_price,
                'created_by'        => $request->creator,
                'updated_by'        => $request->creator,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Service berhasil ditambahkan.',
            ]);
        }
    }

    // public function editService(Request $request, $json_id)
    // {
    //     $decode_base64 = base64_decode($json_id);
    //     $json_decode_id = json_decode($decode_base64);
    //     $service_id = $json_decode_id->id;

    //     $getServiceById = $this->service->getServiceById($service_id);
    //     return view('admin.service_edit', [
    //         'page'      => 'Update Service',
    //         'service'   => $getServiceById
    //     ]);
    // }

    public function updateService(Request $request, $service_id)
    {
        if($request->ajax()){

            $this->service->where('id', $service_id)->update([
                'service_name'      => $request->service_name,
                'estimation'        => $request->estimation,
                'price'             => $request->price,
                'gender_service'    => $request->gender_service,
                'tentative_price'   => $request->tentative_price,
                'updated_by'        => $request->creator,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Service berhasil diupdate.',
            ]);
        }
    }

    // public function updateThumbnailService(Request $request, $service_id)
    // {
    //     if($request->ajax()){
    //         $getThumbnailCurrent = $this->service->select('thumbnail')->where('id', $service_id)->first();
    //         $current_path = $getThumbnailCurrent->thumbnail;

    //         if($current_path == '/assets/image/no-image.png'){
    //             $image_64 = $request->thumbnail;
    //             $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
    //             $replace = substr($image_64, 0, strpos($image_64, ',')+1);
    //             $image = str_replace($replace, '', $image_64);
    //             $image = str_replace(' ', '+', $image);

    //             $imageName = md5(Str::random(15).date('dmY')).'.'.$extension;
    //             Storage::disk('public')->put('/service/'.$imageName, base64_decode($image));

    //             $this->service->where('id', $service_id)->update([
    //                 'thumbnail'     => 'service/'. $imageName,
    //                 'updated_by'    => $request->creator,
    //             ]);
    //         }else{
    //             if(Storage::disk('public')->exists($current_path)){
    //                 Storage::disk('public')->delete($current_path);

    //                 $image_64 = $request->thumbnail;
    //                 $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
    //                 $replace = substr($image_64, 0, strpos($image_64, ',')+1);
    //                 $image = str_replace($replace, '', $image_64);
    //                 $image = str_replace(' ', '+', $image);

    //                 $imageName = md5(Str::random(15).date('dmY')).'.'.$extension;
    //                 Storage::disk('public')->put('/service/'.$imageName, base64_decode($image));

    //                 $this->service->where('id', $service_id)->update([
    //                     'thumbnail'     => 'service/'. $imageName,
    //                     'updated_by'    => $request->creator,
    //                 ]);
    //             }else{
    //                 return response()->json([
    //                     'success'   => true,
    //                     'status'    => 404,
    //                     'message'   => 'Unknown current path thumbnail.',
    //                 ]);
    //             }
    //         }
    //         return response()->json([
    //             'success'   => true,
    //             'status'    => 200,
    //             'message'   => 'Foto service berhasil diupdate.',
    //         ]);
    //     }
    // }
    /**
     * End Services
     */

    /**
     * Time Operation
     */
    public function timeOperationList()
    {
        $time_operation = $this->time_operation->where('is_active', 1)->get();
        return view('admin.time_operation', [
            'page'              => 'Jam Operasional',
            'time_operation'  => $time_operation,
        ]);
    }

    public function getTimeOperationList(Request $request)
    {
        if($request->ajax()){
            $data = $this->time_operation->where('is_active', 1)->get();

            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('operation_time', function($row){
                                $textOperationTime = '<div class="text-center">' . $row->time .' WIB</div>';

                                return $textOperationTime;
                            })
                            ->addColumn('type', function($row){
                                if($row->type == 1){
                                    $type = 'Pagi';
                                }elseif($row->type == 2){
                                    $type = 'Siang';
                                }else{
                                    $type = 'Sore';
                                }
                                $textType = '<div class="text-center">' . $type .'</div>';

                                return $textType;
                            })
                            ->addColumn('action', function($row){
                                $actionBtn = '<div class="text-center"><button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#updateModal'. $row->id .'"><i class="fas fa-edit"></i></button></div>';

                                return $actionBtn;
                            })
                            ->rawColumns(['operation_time', 'type', 'action'])
                            ->make(true);
        }
    }

    public function createTimeOperation(Request $request)
    {
        if($request->ajax()){
            $operation_time = str_replace(':', '.', $request->operation_time);

            $validator = Validator::make($request->all(), [
                'operation_time'    => 'required',
                'type'              => 'required',
            ],
            [
                'operation_time.required' => 'Jadwal tidak boleh kosong.',
                'type.required'           => 'Waktu tidak boleh kosong.',
            ]);

            if($validator->fails()){
                return response()->json([
                    'data'      => [],
                    'message'   => $validator->errors(),
                    'success'   => false,
                    'status'    => 401,
                ]);
            }

            $this->time_operation->create([
                'time'      => $operation_time,
                'type'      => $request->type,
                'created_by'=> $request->creator,
                'updated_by'=> $request->creator,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Jadwal berhasil ditambahkan.',
            ]);
        }
    }

    public function updateTimeOperation(Request $request, $time_operation_id)
    {
        if($request->ajax()){
            $operation_time = str_replace(':', '.', $request->operation_time);

            $this->time_operation->where('id', $time_operation_id)->update([
                'time'          => $operation_time,
                'type'          => $request->type,
                'updated_by'    => $request->creator,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Jadwal outlet berhasil diupdate.',
            ]);
        }
    }
    /**
     * End Time Operation
     */

    /**
     * Users
     */
    public function userList()
    {
        $user = $this->user->getUser();

        return view('admin.user', [
            'page'  => 'User',
            'user'  => $user,
        ]);
    }

    public function getUserList(Request $request)
    {
        if($request->ajax()){
            $data = $this->user->getUser();

            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('username', function($row){
                                if($row->role_id == 1){
                                    $spanUsername = '<span>' . $row->username .'</span>';
                                }else{
                                    $spanUsername = '<span>' . $row->name .'</span>';
                                }

                                return $spanUsername;
                            })
                            ->addColumn('role', function($row){
                                if($row->role_id == 1){
                                    $spanRole = '<span class="badge bg-primary">' . $row->role_name .'</span>';
                                }else{
                                    $spanRole = '<span class="badge bg-success">' . $row->role_name .'</span>';
                                }

                                return $spanRole;
                            })
                            ->addColumn('action', function($row){
                                if($row->role_id == 1){
                                    $actionBtn = '<div class="text-center"><button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#updateModal'. $row->id .'"><i class="fas fa-edit"></i></button></div>';
                                }else{
                                    $actionBtn = '<div class="text-center">-</div>';
                                }

                                return $actionBtn;
                            })
                            ->rawColumns(['username', 'role', 'action'])
                            ->make(true);
        }
    }

    public function createUser(Request $request)
    {
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'username'  => 'required',
                'password'  => 'required',
            ],
            [
                'username.required' => 'Username tidak boleh kosong.',
                'password.required' => 'Password tidak boleh kosong.',
            ]);

            if($validator->fails()){
                return response()->json([
                    'data'      => [],
                    'message'   => $validator->errors(),
                    'success'   => false,
                    'status'    => 401,
                ]);
            }

            $this->user->create([
                'username'      => $request->username,
                'password'      => Hash::make($request->password),
                'role_id'       => 1,
                'created_by'    => $request->creator,
                'updated_by'    => $request->creator,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'User berhasil ditambahkan.',
            ]);
        }
    }

    public function updateUser(Request $request, $user_id)
    {
        if($request->ajax()){
            $this->user->where('id', $user_id)->update([
                'password'      => Hash::make($request->password),
                'updated_by'    => $request->creator,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'User berhasil diupdate.',
            ]);
        }
    }
    /**
     * End Users
     */

     /**
      * Hair Artists
      */
    public function hairArtistList()
    {
        $getHa = $this->hair_artist->where('is_active', 1)->get();
        $days = [
            0   => 'Sunday',
            1   => 'Monday',
            2   => 'Tuesday',
            3   => 'Wednesday',
            4   => 'Thursday',
            5   => 'Friday',
            6   => 'Saturday',
        ];
        return view('admin.hair_artist', [
            'page' => 'Hair Artist',
            'ha'   => $getHa,
            'days' => $days,
        ]);
    }

    public function getHairArtistList(Request $request)
    {
        if($request->ajax()){
            $data = $this->hair_artist->where('is_active', '>=', 1);

            return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('profile_picture', function($row){
                                if($row->profile_picture !== '/assets/image/no-image.png'){
                                    $profile_picture = '<div class="text-center"><img src="' . asset('storage/' .$row->profile_picture) .'" style="width: 60px; height: 60px;"></div>';
                                }else{
                                    $profile_picture = '<div class="text-center"><img src="' . $row->profile_picture .'" style="width: 60px; height: 60px;"></div>';
                                }

                                return $profile_picture;
                            })
                            ->addColumn('status', function($row){
                                $days = [
                                    0   => 'Sunday',
                                    1   => 'Monday',
                                    2   => 'Tuesday',
                                    3   => 'Wednesday',
                                    4   => 'Thursday',
                                    5   => 'Friday',
                                    6   => 'Saturday',
                                ];

                                if(date('l') != $days[$row->day_off]){
                                    $spanStatus = '<span class="badge badge-success">Available</span>';
                                }else{
                                    $spanStatus = '<span class="badge badge-secondary">Unavailable</span>';
                                }

                                return $spanStatus;
                            })
                            ->addColumn('action', function($row){
                                if($row->is_active == 1){
                                    $class = 'btn-danger';
                                    $icon = '<i class="fas fa-thumbtack"></i>';
                                    $arrStatus = [
                                        'id'        => $row->id,
                                        'status'    => 2,
                                    ];
                                }else{
                                    $class = 'btn-success';
                                    $icon = '<i class="fas fa-check"></i>';
                                    $arrStatus = [
                                        'id'        => $row->id,
                                        'status'    => 1,
                                    ];
                                }

                                // $actionBtn = '<div class="text-center"><a class="btn btn-sm btn-warning" href="/admin/hair-artist/edit/' . base64_encode(json_encode(['id' => $row->id])) .'"><i class="fas fa-edit"></i></a> <a href="/admin/hair-artist/status/' . base64_encode(json_encode($arrStatus)) .'" class="btn btn-sm '. $class .'">' . $icon .'</a></div>';
                                $actionBtn = '<div class="text-center"><a class="btn btn-sm btn-warning" href="/admin/hair-artist/edit/' . base64_encode(json_encode(['id' => $row->id])) .'"><i class="fas fa-edit"></i></a> <button class="btn btn-sm btn-primary detailBtn" data-toggle="modal" data-target="#haModal'. $row->id .'"><i class="fas fa-eye"></i></button></div>';

                                return $actionBtn;
                            })
                            ->rawColumns(['profile_picture', 'status', 'action'])
                            ->make(true);
        }
    }

    public function createHairArtist(Request $request)
    {
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'ha_name'           => 'required',
                'day_off'           => 'required',
            ],
            [
                'ha_name.required'  => 'Hair Artist tidak boleh kosong.',
                'day_off.required'  => 'Day off tidak boleh kosong.',
            ]);

            if($validator->fails()){
                return response()->json([
                    'data'      => [],
                    'message'   => $validator->errors(),
                    'success'   => false,
                    'status'    => 401,
                ]);
            }

            $image_64 = $request->profile_picture;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
            $replace = substr($image_64, 0, strpos($image_64, ',')+1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);

            $imageName = md5(Str::random(15).date('dmY')).'.'.$extension;
            Storage::disk('public')->put('/kapster/'.$imageName, base64_decode($image));

            $this->hair_artist->create([
                'ha_name'           => $request->ha_name,
                'profile_picture'   => 'kapster/'. $imageName,
                'day_off'           => $request->day_off,
                'created_by'        => $request->creator,
                'updated_by'        => $request->creator,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Hair Artist berhasil ditambahkan.',
            ]);
        }
    }

    public function dayOffHairArtist(Request $request)
    {
        if($request->ajax()){
            $this->hair_artist->where('id', $request->ha_id)->update([
                'day_off'   => $request->day_off,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Day off was successfully set.'
            ]);
        }
    }

    public function editHairArtist(Request $request, $json_id)
    {
        $decode_base64 = base64_decode($json_id);
        $json_decode_id = json_decode($decode_base64);
        $ha_id = $json_decode_id->id;

        // $branch = $this->branch->where('is_active', 1)->get();
        $getHairArtistById = $this->hair_artist->where('id', $ha_id)->first();
        return view('admin.hair_artist_edit', [
            'page'  => 'Update Hair Artist',
            'ha'    => $getHairArtistById
        ]);
    }

    public function updateProfileHairArtist(Request $request, $ha_id)
    {
        if($request->ajax()){
            $getProfileCurrent = $this->hair_artist->select('profile_picture')->where('id', $ha_id)->first();
            $current_path = $getProfileCurrent->profile_picture;

            if($current_path == '/assets/image/no-image.png'){
                $image_64 = $request->profile_picture;
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',')+1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);

                $imageName = md5(Str::random(15).date('dmY')).'.'.$extension;
                Storage::disk('public')->put('/kapster/'.$imageName, base64_decode($image));

                $this->hair_artist->where('id', $ha_id)->update([
                    'profile_picture'   => 'kapster/'. $imageName,
                    'updated_by'        => $request->creator,
                ]);
            }else{
                if(Storage::disk('public')->exists($current_path)){
                    Storage::disk('public')->delete($current_path);

                    $image_64 = $request->profile_picture;
                    $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                    $replace = substr($image_64, 0, strpos($image_64, ',')+1);
                    $image = str_replace($replace, '', $image_64);
                    $image = str_replace(' ', '+', $image);

                    $imageName = md5(Str::random(15).date('dmY')).'.'.$extension;
                    Storage::disk('public')->put('/kapster/'.$imageName, base64_decode($image));

                    $this->hair_artist->where('id', $ha_id)->update([
                        'profile_picture'   => 'kapster/'. $imageName,
                        'updated_by'        => $request->creator,
                    ]);
                }else{
                    return response()->json([
                        'success'   => true,
                        'status'    => 404,
                        'message'   => 'Unknown current path profile picture.',
                    ]);
                }
            }
            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Foto Hair Artist berhasil diupdate.',
            ]);
        }
    }

    public function updateHairArtist(Request $request, $ha_id)
    {
        if($request->ajax()){
            $this->hair_artist->where('id', $ha_id)->update([
                'ha_name'       => $request->ha_name,
                'updated_by'    => $request->creator,
            ]);

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Hair Artist berhasil diupdate.',
            ]);
        }
    }
    /**
     * End Hair Artists
     */

    /**
     * Hair Artist Schedules
     */
    public function dayOffHaList()
    {
        $hair_artist = $this->hair_artist->get();
        return view('admin.ha_leave', [
            'page'          => 'Day Off',
            'hair_artist'   => $hair_artist,
        ]);
    }
}
