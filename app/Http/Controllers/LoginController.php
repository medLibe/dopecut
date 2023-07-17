<?php

namespace App\Http\Controllers;

use App\Models\BookCart;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function handleAdmin(Request $request)
    {
        Validator::make($request->all(), [
            'username'  => 'required',
            'password'  => 'required'
        ],[
            'username.required' => 'Username field is required.',
            'password.required' => 'Password field is required.',
        ]);

        $credentials = $request->only('username','password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if($user->role_id == 1) {
                    return redirect()->intended('/admin/dashboard')
                                     ->with('success', 'Welcome to Admin Page');
                }else{
                    return redirect('/login/admin')
                                        ->withInput()
                                        ->with('error', 'Your credentials do not math our records.');
                }
                return redirect()->intended('/login/admin')
                                 ->withInput()
                                 ->with('error', 'Your credentials do not math our records.');
            }

        return redirect('/login/admin')
                                ->withInput()
                                ->with('error', 'Your credentials do not match our records.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleCallback(Request $request)
    {
        try{
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->id)->first();

            if($findUser){
                Auth::login($findUser);

                $cart = BookCart::where('user_id', Auth::user()->id)
                                ->where('is_active', 1)
                                ->count();

                $request->session()->put('countCart', $cart);
                return redirect('/book');
            }else{
                $newUser = User::create([
                    'name'          => $user->name,
                    'email'         => $user->email,
                    'google_id'     => $user->id,
                    'role_id'       => 2,
                    'created_by'    => $user->name,
                    'updated_by'    => $user->name,
                ]);

                Auth::login($newUser);

                $cart = BookCart::where('user_id', Auth::user()->id)
                                ->where('is_active', 1)
                                ->count();
                                
                $request->session()->put('countCart', $cart);

                return redirect('/book');
            }
        }catch(Exception $err){
            return response([
                'success'   => false,
                'status'    => 401,
                'message'   => $err->getMessage(),
            ]);
        }
    }
    

    public function logout(Request $request)
    {
        $role_id = Auth::user()->role_id;
        
        if($role_id == 1){
            $url = '/admin/dashboard';
        }else{
            $url = '/';
        }


        $request->session()->flush();
        Auth::logout();
        
        return redirect($url);
    }
}
