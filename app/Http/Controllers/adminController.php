<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use Storage;
use Hash;

class adminController extends Controller
{
    public function __construct(){
        date_default_timezone_set('Asia/Manila');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if($_SESSION['role']->id > 1){
            return redirect('/dashboard');
        }
    }
    public function studentManagement(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['users'] = DB::table('user_profile')
            ->leftJoin('users', 'users.id_user', '=', 'user_profile.id')
            ->where('users.id_user_role', 4)
            ->select('user_profile.*', 'users.del_status')
            ->get();
        return view('studentmanagement', $data);
    }
    public function teacherManagement(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['users'] = DB::table('user_profile')
            ->leftJoin('users', 'users.id_user', '=', 'user_profile.id')
            ->where('users.id_user_role', 3)
            ->select('user_profile.*')
            ->get();
        return view('teachermanagement', $data);
    }
    public function postteacherManagement(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $check = DB::table("user_profile")
            ->where('account_id', $request->account_id)
            ->count();
        if($check > 0){
            return redirect()->back()->with('message', '<script>
                    $(document).ready(function(){
                        toastr.error("Teacher account already exists!");
                    })</script>');
        }
        else{
            $data['account_id'] = $request->account_id;
            $data['account_id_pic'] = "default_pic.png";
            $data['picture'] = "default_pic.png";
            $data['first_name'] = $request->first_name;
            $data['middle_name'] = $request->middle_name;
            $data['last_name'] = $request->last_name;
            $data['birthday'] = $request->birthday;
            $data['gender'] = $request->gender;
            $data['nationality'] = $request->nationality;
            $data['civil_status'] = $request->civil_status;
            $data['religion'] = $request->religion;
            $data['email'] = $request->email;
            $data['contact'] = $request->contact;
            $data['address'] = $request->address;
            DB::table('user_profile')
                ->insert($data);
            $profile = DB::table('user_profile')
                ->orderBy('id', 'desc')
                ->first();

            $file = $request->dp_picture;
            if($file != null){
                $extname = $file->extension();
                $filename = $profile->id;
                $data['picture'] = $filename . '.' . $extname;
                $file->storeAs('/dp/', $filename .'.' . $extname,['disk' => 'public_uploads']);
                DB::table('user_profile')
                    ->where('id', $profile->id)
                    ->update($data);
            }
            $file = $request->id_picture;
            if($file != null){
                $extname = $file->extension();
                $filename = $profile->id;
                $data['account_id_pic'] = $filename . '.' . $extname;
                $file->storeAs('/account-id/', $filename .'.' . $extname,['disk' => 'public_uploads']);
                DB::table('user_profile')
                    ->where('id', $profile->id)
                    ->update($data);
            }
            $user['id_user_role'] = 3;
            $user['id_user'] = $profile->id;
            $user['username'] = $request->username;
            $user['password'] = Hash::make($request->password);
            $user['account_status'] = 1;
            DB::table('users')->insert($user);
            return redirect()->back()->with('message', '<script>
                    $(document).ready(function(){
                        toastr.success("Teacher successfully added!");
                    })</script>');
        }
    }
    public function poststudentManagement(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $check = DB::table("user_profile")
            ->where('account_id', $request->account_id)
            ->count();
        if($check > 0){
            return redirect()->back()->with('message', '<script>
                    $(document).ready(function(){
                        toastr.error("Student account already exists!");
                    })</script>');
        }
        else{
            $data['account_id'] = $request->account_id;
            $data['account_id_pic'] = "default_pic.png";
            $data['picture'] = "default_pic.png";
            $data['first_name'] = $request->first_name;
            $data['middle_name'] = $request->middle_name;
            $data['last_name'] = $request->last_name;
            $data['birthday'] = $request->birthday;
            $data['gender'] = $request->gender;
            $data['nationality'] = $request->nationality;
            $data['civil_status'] = $request->civil_status;
            $data['religion'] = $request->religion;
            $data['email'] = $request->email;
            $data['contact'] = $request->contact;
            $data['address'] = $request->address;
            DB::table('user_profile')
                ->insert($data);
            $profile = DB::table('user_profile')
                ->orderBy('id', 'desc')
                ->first();

            $file = $request->dp_picture;
            if($file != null){
                $extname = $file->extension();
                $filename = $profile->id;
                $data['picture'] = $filename . '.' . $extname;
                $file->storeAs('/dp/', $filename .'.' . $extname,['disk' => 'public_uploads']);
                DB::table('user_profile')
                    ->where('id', $profile->id)
                    ->update($data);
            }
            $file = $request->id_picture;
            if($file != null){
                $extname = $file->extension();
                $filename = $profile->id;
                $data['account_id_pic'] = $filename . '.' . $extname;
                $file->storeAs('/account-id/', $filename .'.' . $extname,['disk' => 'public_uploads']);
                DB::table('user_profile')
                    ->where('id', $profile->id)
                    ->update($data);
            }
            $user['id_user_role'] = 4;
            $user['id_user'] = $profile->id;
            $user['username'] = $request->username;
            $user['password'] = Hash::make($request->password);
            $user['account_status'] = 1;
            DB::table('users')->insert($user);
            return redirect()->back()->with('message', '<script>
                    $(document).ready(function(){
                        toastr.success("Teacher successfully added!");
                    })</script>');
        }
    }
    public function updateuserinfo(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['account_id'] = $request->account_id;
        $data['first_name'] = $request->first_name;
        $data['middle_name'] = $request->middle_name;
        $data['last_name'] = $request->last_name;
        $data['birthday'] = $request->birthday;
        $data['gender'] = $request->gender;
        $data['nationality'] = $request->nationality;
        $data['civil_status'] = $request->civil_status;
        $data['religion'] = $request->religion;
        $data['email'] = $request->email;
        $data['contact'] = $request->contact;
        $data['address'] = $request->address;
        DB::table('user_profile')
            ->where('id', $request->id)
            ->update($data);

        $profile = DB::table('user_profile')
            ->where('id', $request->id)
            ->first();

        $file = $request->dp_picture;
        if($file != null){
            $extname = $file->extension();
            $filename = $profile->id;
            $data['picture'] = $filename . '.' . $extname;
            $file->storeAs('/dp/', $filename .'.' . $extname,['disk' => 'public_uploads']);
            DB::table('user_profile')
                ->where('id', $profile->id)
                ->update($data);
        }
        $file = $request->id_picture;
        if($file != null){
            $extname = $file->extension();
            $filename = $profile->id;
            $data['account_id_pic'] = $filename . '.' . $extname;
            $file->storeAs('/account-id/', $filename .'.' . $extname,['disk' => 'public_uploads']);
            DB::table('user_profile')
                ->where('id', $profile->id)
                ->update($data);
        }
        $user = DB::table('users')
            ->where('id_user', $profile->id)
            ->first();
        if($user->id_user_role == 4){
            return redirect()->back()->with('message', '<script>
                    $(document).ready(function(){
                        toastr.success("Student successfully Updated!");
                    })</script>');
        }
        else{
            return redirect()->back()->with('message', '<script>
                    $(document).ready(function(){
                        toastr.success("Teacher successfully Updated!");
                    })</script>');
        }
    }
    public function disableuser(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        DB::table('users')
            ->where('id_user', $request->id)
            ->update(['del_status' => 0]);
    }
    public function enableuser(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        DB::table('users')
            ->where('id_user', $request->id)
            ->update(['del_status' => 1]);
    }
    public function roommanagement(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['categories'] = DB::table('categories')
            ->where('id_category_type', 7)
            ->get();
        $data['header_title'] = "Rooms";
        return view('categoriesmanagement', $data);
    }
    public function sectionmanagement(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['categories'] = DB::table('categories')
            ->where('id_category_type', 6)
            ->get();
        $data['header_title'] = "Sections";
        return view('categoriesmanagement', $data);
    }
    public function subjectmanagement(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['categories'] = DB::table('categories')
            ->where('id_category_type', 8)
            ->get();
        $data['header_title'] = "Subjects";
        return view('categoriesmanagement', $data);
    }
    public function materialsmanagement(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['categories'] = DB::table('categories')
            ->where('id_category_type', 9)
            ->get();
        $data['header_title'] = "Learning Materials Category";
        return view('categoriesmanagement', $data);
    }
    public function timemanagement(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['categories'] = DB::table('categories')
            ->where('id_category_type', 10)
            ->get();
        $data['header_title'] = "Time Category";
        return view('categoriesmanagement', $data);
    }
    public function daysmanagement(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['categories'] = DB::table('categories')
            ->where('id_category_type', 11)
            ->get();
        $data['header_title'] = "Days Category";
        return view('categoriesmanagement', $data);
    }
    public function addcategory(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['id_category_type'] = $request->id_category_type;
        $data['id_main'] = 0;
        $data['category'] = $request->category;
        $data['description'] = $request->description;
        DB::table('categories')
            ->insert($data);
        if($request->id_category_type == 6){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Section successfully added!");
                })</script>');
        }
        elseif($request->id_category_type == 8){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Subject successfully added!");
                })</script>');
        }
        elseif($request->id_category_type == 7){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Room successfully added!");
                })</script>');
        }
        elseif($request->id_category_type == 9){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Learning Materials Category successfully added!");
                })</script>');
        }
        elseif($request->id_category_type == 10){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Time Category successfully added!");
                })</script>');
        }
        elseif($request->id_category_type == 11){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Days Category successfully added!");
                })</script>');
        }
    }
    public function updatecategory(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['category'] = $request->category;
        $data['description'] = $request->description;
        DB::table('categories')
            ->where('id', $request->id)
            ->update($data);
        if($request->id_category_type == 6){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Section successfully updated!");
                })</script>');
        }
        elseif($request->id_category_type == 8){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Subject successfully updated!");
                })</script>');
        }
        elseif($request->id_category_type == 7){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Room successfully updated!");
                })</script>');
        }
        elseif($request->id_category_type == 9){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Learning Materials Category successfully updated!");
                })</script>');
        }
        elseif($request->id_category_type == 10){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Time Category successfully updated!");
                })</script>');
        }
        elseif($request->id_category_type == 11){
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Days Category successfully updated!");
                })</script>');
        }
    }
    public function disablecategory(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        DB::table('categories')
            ->where('id', $request->id)
            ->update(['del_status' => 0]);
    }
    public function enablecategory(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        DB::table('categories')
            ->where('id', $request->id)
            ->update(['del_status' => 1]);
    }
    public function publicfeed(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['feed'] = DB::table('feed')
            ->leftJoin('user_profile', 'user_profile.id', '=', 'feed.id_user')
            ->where('feed.del_status', 1)
            ->where('feed.feed_category', 0)
            ->select('feed.*', 'user_profile.first_name', 'user_profile.middle_name', 'user_profile.last_name', 'user_profile.picture')
            ->orderBy('feed.created_at', 'desc')
            ->get();
        return view('feed', $data);
    }
    public function deletepublicfeed(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $feed = DB::table('feed')
            ->where('id', $request->id)
            ->update(['del_status' => 0]);
    }
    public function postfeedcomment(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['id_feed'] = $request->id;
        $data['id_user'] = $_SESSION['user_profile']->id;
        $data['description'] = $request->description;
        $data['created_at'] = date('Y-m-d H:i:s');
        $feed = DB::table('feed_comments')
            ->insert($data);
        return $request->id;
    }
    public function postpublicfeed(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['id_user'] = Auth::user()->id_user;
        if($request->id_class == null){
            $data['feed_category'] = 0;
        }
        else{
            $data['feed_category'] = $request->id_class;
        }
        $data['description'] = $request->description;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['attached_file'] = "";
        DB::table('feed')
            ->insert($data);

        $feed = DB::table('feed')
            ->orderBy('id', 'desc')
            ->first();
        $file_img = $request->attached_fileInput_img;
        $file_file = $request->attached_fileInput_file;
        $file_video = $request->attached_fileInput_video;
        if($file_img != null){
            $extname = $file_img->extension();
            $filename = $feed->id;
            $data['attached_file'] = $filename . '.' . $extname;
            $file_img->storeAs('/feed/public/', $filename .'.' . $extname,['disk' => 'public_uploads']);
            DB::table('feed')
                ->where('id', $feed->id)
                ->update($data);
        }
        if($file_file != null){
            $extname = $file_file->extension();
            $filename = $feed->id;
            $data['attached_file'] = $filename . '.' . $extname;
            $file_file->storeAs('/feed/public/', $filename .'.' . $extname,['disk' => 'public_uploads']);
            DB::table('feed')
                ->where('id', $feed->id)
                ->update($data);
        }
        if($file_video != null){
            $extname = $file_video->extension();
            $filename = $feed->id;
            $data['attached_file'] = $filename . '.' . $extname;
            $file_video->storeAs('/feed/public/', $filename .'.' . $extname,['disk' => 'public_uploads']);
            DB::table('feed')
                ->where('id', $feed->id)
                ->update($data);
        }
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Thread successfully posted!");
                })</script>');
    }
}
