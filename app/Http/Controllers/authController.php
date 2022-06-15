<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use Hash;
use Mail;
use App\Mail\NotifyMail;

class authController extends Controller
{
    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function getLogin(){
        if(!app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/dashboard');
        }
        return view('auth.login');
    }
    public function postLogin(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $_SESSION['user_profile'] = DB::table('user_profile')
                ->where('id', Auth::user()->id_user)
                ->first();
            $_SESSION['role'] = DB::table('users')
                ->leftJoin('user_role', 'user_role.id', '=', 'users.id_user_role')
                ->where('users.id', Auth::user()->id)
                ->select('user_role.id', 'user_role.role')
                ->first();
            if(Auth::user()->del_status == 1){
                return redirect()->intended('/dashboard');
            }
            else{
                return redirect()->intended('/account_disabled');
            }
        }
    }
    public function changepassword(Request $request){
        DB::table('users')->where('id', $request->id)->update(['password' => Hash::make($request->newpassword), 'account_status' => 1]);
        $user = DB::table('users')->where('id', $request->id)->first();
        Auth::loginUsingId($request->id);
        $request->session()->regenerate();
        $_SESSION['user_profile'] = DB::table('user_profile')
            ->where('id', Auth::user()->id_user)
            ->first();
        $_SESSION['role'] = DB::table('users')
            ->leftJoin('user_role', 'user_role.id', '=', 'users.id_user_role')
            ->where('users.id', Auth::user()->id)
            ->select('user_role.id', 'user_role.role')
            ->first();
        if(Auth::user()->del_status == 1){
            return redirect()->intended('/dashboard');
        }
        else{
            return redirect()->intended('/account_disabled');
        }
    }
    public function checkcurrentpassword(Request $request){
        $data = Hash::check($request->current, $_SESSION['pwd']);
        return $data;
    }
    public function fetchaccountstatus(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            if(Auth::user()->account_status == 0){
                $data['status'] = 1;
                $data['id'] = Auth::user()->id;
                $_SESSION['pwd'] = Auth::user()->password;
            }
            else{
                $data['status'] = 2;
                $data['id'] = Auth::user()->id;
            }
        }
        else{
            $data['status'] = 0;
            $data['id'] = 0;
        }
        Auth::logout();

        return $data;
    }
    public function hashcheck(Request $request){
        $data = Hash::check($request->userInput, Auth::user()->password);
        return json_encode($data);
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if (!session_status() === PHP_SESSION_NONE) {
            session_destroy();
        }
        return redirect('/login');
    }
    public function postlostpassword(Request $request){
        $userdata = DB::table('user_profile')
            ->leftJoin('users', 'user_profile.id', '=', 'users.id_user')
            ->where('user_profile.account_id', $request->studentid)
            ->select('users.id', 'user_profile.first_name', 'user_profile.email')
            ->first();
        if($userdata != null){
            $mailData = [
                'title' => "Password Reset",
                'body1' => "Good day ".$userdata->first_name."!,",
                'body2' => "We've noticed you have requested for a password reset. To reset your password please clink the link below:",
                'body3' => "<a href='http://localhost:8000/resetpassword?id=".$userdata->id."'>Password Reset Link</a>",
            ];
             
            Mail::to($userdata->email)
            ->send(new NotifyMail($mailData));
               
            return redirect('/login');
        }
        else{
            return redirect('/');
        }
    }
    public function getresetpassword(Request $request){
        $data['user'] = DB::table('user_profile')
            ->leftJoin('users', 'user_profile.id', '=', 'users.id_user')
            ->where('users.id', $request->id)
            ->select('users.id', 'user_profile.first_name', 'user_profile.email')
            ->first();
        return view('auth.resetpassword', $data);
    }
    public function postresetpassword(Request $request){
        DB::table('users')->where('id', $request->id)
            ->update(['password' => Hash::make($request->password)]);
            return redirect('/login');
    }
}
