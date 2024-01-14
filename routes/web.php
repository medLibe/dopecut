<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\UnmasterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CustomerController::class, 'index']);
Route::get('/login/admin', [LoginController::class, 'index']);
Route::get('/article', [CustomerController::class, 'article']);
Route::get('/article/{any}', [CustomerController::class, 'viewArticle']);
Route::post('/article/hit/{any}', [CustomerController::class, 'hitArticle']);
Route::post('/article/like/{id}', [CustomerController::class, 'likeArticle']);
Route::post('/login/admin/auth', [LoginController::class, 'handleAdmin']);
Route::get('/login/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [LoginController::class, 'handleCallback']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['loginMiddleware:2']], function() {
    Route::controller(CustomerController::class)->group(function() {
        Route::get('/book', 'book');
        Route::get('/book/hair-artist', 'getHairArtist');
        Route::get('/book/ha-schedule', 'getHaSchedule');
        Route::get('/book/service/{any}', 'getService');
        Route::get('/book/detail/{any}', 'bookTransactionDetail');
        Route::post('/book/create', 'createBook');
        Route::get('/book/save-phone/{any}', 'savePhoneCustomer');
        Route::get('/book/send-mail/{any}', 'sendBookMail');
        Route::get('/book/history', 'bookHistory');
        Route::post('/book/cancel/{id}', 'bookCancel');
        Route::get('/book/mail', 'test');
    });
});

Route::group(['middleware' => ['loginAdminMiddleware:1']], function() {
    Route::controller(MasterController::class)->group(function() {
        // Master Service
        Route::get('/admin/service', 'index');
        // Route::get('/admin/service-byid/{id}', 'getServiceById');
        Route::get('/admin/service/list', 'getServiceList');
        // Route::get('/admin/service/edit/{any}', 'editService');
        Route::post('/admin/service/create', 'createService');
        Route::post('/admin/service/update/{id}', 'updateService');
        // Route::post('/admin/service/update-thumbnail/{id}', 'updateThumbnailService');

        // Master Time Operation
        Route::get('/admin/time-operation', 'timeOperationList');
        Route::get('/admin/time-operation/list', 'getTimeOperationList');
        Route::post('/admin/time-operation/create', 'createTimeOperation');
        Route::post('/admin/time-operation/update/{id}', 'updateTimeOperation');

         // Master User
         Route::get('/admin/user', 'userList');
         Route::get('/admin/user/list', 'getUserList');
         Route::post('/admin/user/create', 'createUser');
         Route::post('/admin/user/update/{id}', 'updateUser');

        // Master Kapster
        Route::get('/admin/hair-artist', 'hairArtistList');
        Route::get('/admin/hair-artist/list', 'getHairArtistList');
        Route::post('/admin/hair-artist/create', 'createHairArtist');
        Route::get('/admin/hair-artist/edit/{any}', 'editHairArtist');
        Route::post('/admin/hair-artist/update/{id}', 'updateHairArtist');
        Route::post('/admin/hair-artist/update-profile/{id}', 'updateProfileHairArtist');
        Route::get('/admin/hair-artist/day-off', 'dayOffHairArtist');
        Route::get('/admin/ha-schedule/day-off', 'dayOffHaList');
    });

    Route::controller(UnmasterController::class)->group(function() {
        Route::get('/admin/dashboard', 'index');

        // Booking Data
        Route::get('/admin/book', 'bookList');
        Route::get('/admin/book/list', 'getBookList');
        Route::get('/admin/book/create', 'doBook');
        Route::get('/admin/book/create-process', 'createBook');
        Route::get('/admin/book/detail-list/{id}', 'getBookDetailList');
        Route::post('/admin/book/update', 'updateBook');

        // Post Article
        Route::get('/admin/article', 'articleList');
        Route::get('/admin/article/list', 'getArticleList');
        Route::get('/admin/article/post', 'postArticle');
        Route::post('/admin/article/create', 'createArticle');
        Route::get('/admin/article/{any}', 'previewArticle');
        Route::get('/admin/article/edit/{any}', 'editArticle');
        Route::post('/admin/article/update', 'updateArticle');
        Route::get('/admin/article/takedown/{any}', 'takedownArticle');

        // Kapster Schedule
        Route::get('/admin/ha-schedule', 'haScheduleList');
        Route::get('/admin/ha-schedule/id-{id}', 'getHaSchedule');
        Route::get('/admin/ha-schedule/list/{id}', 'getHaScheduleList');
        Route::post('/admin/ha-schedule/create', 'createHaSchedule');
        //  Route::get('/admin/ha-schedule/status/{id}', 'statusHaSchedule');
        //  Route::get('/admin/ha-schedule/check/{id}', 'checkHaSchedule');

        // Customer Membership
        Route::get('/admin/membership', 'membership');
        Route::get('/admin/member', 'getMembership');
        Route::get('/admin/member-fetch', 'fetchMembership');
        Route::post('/admin/exist-member', 'existMember');
        Route::post('/admin/member', 'storeMembership');
        Route::get('/admin/member/{id}', 'getMembershipById');
        Route::get('/admin/member-absent/{id}', 'getMembershipAbsentById');
        Route::post('/admin/member-absent', 'membershipAbsent');
    });
});
