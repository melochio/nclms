<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class globalController extends Controller
{
    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function index(Request $request){
        return redirect('/login');
    }
    public function checkauth(){
        if(Auth::user() == null){
            return true;
        }
        else{
            return false;
        }
    }
    public function getClassInvitations(Request $request){
        $user = \Auth::user();
        $class_invitations = DB::table('users')
            ->leftJoin('class_people', 'class_people.id_user', '=', 'users.id')
            ->where('users.id', $user->id)
            ->where('users.del_status', 1)
            ->where('class_people.status', 0)
            ->get();
        return $class_invitations;
    }
    public function getDashboardStatistics(Request $request){
        $data['students_count'] = DB::table('users')
            ->where('id_user_role', 4)
            ->where('account_status', 1)
            ->where('del_status', 1)
            ->count();
        $data['teachers_count'] = DB::table('users')
            ->where('id_user_role', 3)
            ->where('account_status', 1)
            ->where('del_status', 1)
            ->count();
        if(Auth::user()->id_user_role == 1){
            $data['classes_count'] = DB::table('classes')
                ->where('del_status', 1)
                ->count();
        }
        if(Auth::user()->id_user_role == 4){
            $data['classes_count'] = DB::table('class_people')
                ->leftJoin('classes', 'classes.id', '=', 'class_people.id_class')
                ->leftJoin('students', 'class_people.id_user', '=', 'students.id_student')
                ->where('class_people.status', 1)
                ->where('classes.del_status', 1)
                ->count();
        }
        if(Auth::user()->id_user_role == 3){
            $data['classes_count'] = DB::table('class_people')
                ->leftJoin('classes', 'classes.id', '=', 'class_people.id_class')
                ->leftJoin('user_profile', 'class_people.id_user', '=', 'user_profile.id')
                ->where('class_people.status', 1)
                ->where('classes.del_status', 1)
                ->count();
        }
        return $data;
    }
    public function fetch_assessmentresponse(Request $request){
        $data = DB::table('assignment_response')
            ->where('id_assignment', $request->id)
            ->where('id_student', $request->id_student)
            ->first();
        return $data;
    }
    public function fetch_assessment(Request $request){
        $data = DB::table('assignments')
            ->where('id', $request->id)
            ->first();
        return $data;
    }
    public function fetch_quiz(Request $request){
        $data = DB::table('quizzes')
            ->where('id', $request->id)
            ->first();
        return $data;
    }
    public function fetch_quiznresponse(Request $request){
        $data = DB::table('quizzes_response')
            ->leftJoin('quizzes', 'quizzes.id', '=', 'quizzes_response.id_quizzes')
            ->where('quizzes_response.id', $request->id)
            ->select('quizzes_response.*', 'quizzes.question')
            ->first();
        return $data;
    }
    public function fetch_quizresponse(Request $request){
        $data = DB::table('quizzes_response')
            ->where('id_quizzes', $request->id)
            ->where('id_student', $request->id_student)
            ->first();
        return $data;
    }
    public function fetch_materials(Request $request){
        $data = DB::table('learning_materials')
            ->where('id', $request->id)
            ->first();
        return $data;
    }
    public function fetch_verifyuserbyid(Request $request){
        $data['count'] = DB::table('user_profile')
            ->where('account_id', $request->id)
            ->count();
        $data['user'] = DB::table('user_profile')
            ->where('account_id', $request->id)
            ->select('first_name', 'last_name')
            ->first();
        return $data;
    }
    public function checkclasspeople(Request $request){
        $user = DB::table('user_profile')
            ->where('account_id', $request->account_id)
            ->first();
        $check = DB::table('class_people')
            ->where('id_user', $user->id)
            ->where('id_class', $request->id_class)
            ->where('del_status', 1)
            ->count();
        return $check;
    }
    public function account_disabled(Request $request){
        return view('auth.accountdisabled');
    }
    public function fetchuserprofile(Request $request){
        $data = DB::table('user_profile')
            ->where('id', $request->id)
            ->first();
        return $data;
    }
    public function fetchcategory(Request $request){
        $data = DB::table('categories')
            ->where('id', $request->id)
            ->first();
        return $data;
    }
    public function fetchclass(Request $request){
        $data = DB::table('classes')
            ->where('id', $request->id)
            ->first();
        return $data;
    }
    public function fetchfeedbyid(Request $request){
        $data = DB::table('feed')
            ->where('id', $request->id)
            ->first();
        return $data;
    }
    public function fetchfeedcomments(Request $request){
        $data = DB::table('feed_comments')
        ->leftJoin('user_profile', 'user_profile.id', '=', 'feed_comments.id_user')
            ->where('id_feed', $request->id)
            ->select('feed_comments.*', 'user_profile.first_name', 'user_profile.middle_name', 'user_profile.last_name', 'user_profile.picture', DB::raw("DATE_FORMAT(feed_comments.created_at, '%b %d, %Y - %h:%i %p') as created_at"))
            ->get();
        return $data;
    }
}
