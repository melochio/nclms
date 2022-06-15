<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use Storage;
use App\Mail\NotifyMail;

class studentController extends Controller
{
    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function index(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['class_invitation'] = \App::call('App\Http\Controllers\globalController@getClassInvitations');
        $data['report'] = \App::call('App\Http\Controllers\globalController@getDashboardStatistics');
        return view('student.index', $data);
    }
    public function getprofile(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        return view('student.profile');
    }
    public function postprofile(Request $request){
        $profile['first_name'] = $request->first_name;
        $profile['last_name'] = $request->last_name;
        $profile['middle_name'] = $request->middle_name;
        $profile['email'] = $request->email;
        $profile['contact'] = $request->contact;
        $profile['address'] = $request->address;
        $file = $request->file;
        if($file != null){
            $profile['picture'] = $_SESSION['user_profile']->id . '.jpg';
            Storage::disk('public_uploads')->put('/dp/'.$profile['picture'], file_get_contents($file));
        }
        DB::table('user_profile')->where('id', Auth::user()->id_user)->update($profile);
        if($request->current_password != ""){
            if(Hash::check($request->current_password, Auth::user()->password)){
                DB::table('users')->where('id', Auth::user()->id)->update(['password' => Hash::make($request->new_password)]);
            }
        }
        $_SESSION['user_profile'] = DB::table('user_profile')
            ->where('id', Auth::user()->id_user)
            ->first();
        return redirect('/profile')->with('message', '<script>
            $(document).ready(function(){
                toastr.success("Profile has been successfully updated!")
            })</script>');
    }
    public function getsubjects(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        if($_SESSION['role']->id > 1){
            $data['classes'] = DB::table('class_people')
                ->leftJoin('classes', 'classes.id', '=', 'class_people.id_class')
                ->leftJoin('categories as a', 'a.id', '=', 'classes.id_section')
                ->leftJoin('categories as b', 'b.id', '=', 'classes.id_room')
                ->leftJoin('categories as c', 'c.id', '=', 'classes.id_subject')
                ->leftJoin('categories as d', 'd.id', '=', 'classes.id_day')
                ->leftJoin('categories as e', 'e.id', '=', 'classes.id_time')
                ->where('class_people.status', 1)
                ->select('class_people.id_user as user_id', 'classes.class_name', 'classes.del_status',  'classes.id as class_id', 'classes.description', 'a.category as section', 'b.category as room', 'c.category as subject', 'd.category as day', 'e.category as time')
                ->get();
        }
        else{
            $data['classes'] = DB::table('classes')
                ->leftJoin('categories as a', 'a.id', '=', 'classes.id_section')
                ->leftJoin('categories as b', 'b.id', '=', 'classes.id_room')
                ->leftJoin('categories as c', 'c.id', '=', 'classes.id_subject')
                ->leftJoin('categories as d', 'd.id', '=', 'classes.id_day')
                ->leftJoin('categories as e', 'e.id', '=', 'classes.id_time')
                ->select('classes.class_name', 'classes.del_status', 'classes.id as class_id', 'classes.description', 'a.category as section', 'b.category as room', 'c.category as subject', 'd.category as day', 'e.category as time')
                ->get();
            $data['sections'] = DB::table('categories')->where('id_category_type', 6)->get();
            $data['rooms'] = DB::table('categories')->where('id_category_type', 7)->get();
            $data['subjects'] = DB::table('categories')->where('id_category_type', 8)->get();
            $data['days_management'] = DB::table('categories')->where('id_category_type', 11)->get();
            $data['time_management'] = DB::table('categories')->where('id_category_type', 10)->get();
        }
        return view('student.class.classes', $data);
    }
    public function addsubjects(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['class_name'] = $request->class_name;
        $data['description'] = $request->description;
        $data['id_section'] = $request->id_section;
        $data['id_room'] = $request->id_room;
        $data['id_subject'] = $request->id_subject;
        $data['created_by'] = Auth::user()->id_user;
        $data['id_day'] = $request->id_day;
        $data['id_time'] = $request->id_time;
        DB::table('classes')->insert($data);
        return redirect()->back()->with('message', '<script>
            $(document).ready(function(){
                toastr.success("Class succesfully created!");
            })</script>');
    }
    public function updatesubjects(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['class_name'] = $request->class_name;
        $data['description'] = $request->description;
        $data['id_section'] = $request->id_section;
        $data['id_room'] = $request->id_room;
        $data['id_subject'] = $request->id_subject;
        $data['id_day'] = $request->id_day;
        $data['id_time'] = $request->id_time;
        DB::table('classes')
            ->where('id', $request->id)
            ->update($data);
        return redirect()->back()->with('message', '<script>
            $(document).ready(function(){
                toastr.success("Class succesfully updated!");
            })</script>');
    }
    public function disableclass(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        DB::table('classes')
            ->where('id', $request->id)
            ->update(['del_status' => 0]);
    }
    public function enableclass(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        DB::table('classes')
            ->where('id', $request->id)
            ->update(['del_status' => 1]);
    }
    public function viewsubject_dashboard(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['count_students'] = DB::table('class_people')
        ->leftJoin('users', 'class_people.id_user', '=', 'users.id_user')
            ->where('users.id_user_role', 4)
            ->where('users.account_status', 1)
            ->where('users.del_status', 1)
            ->where('class_people.id_class', $request->id)
            ->count();
        $data['count_teachers'] = DB::table('class_people')
            ->leftJoin('users', 'class_people.id_user', '=', 'users.id_user')
            ->where('id_user_role', 3)
            ->where('account_status', 1)
            ->where('users.del_status', 1)
            ->where('class_people.id_class', $request->id)
            ->count();
        $data['count_assignments'] = DB::table('assignments')
            ->where('id_class', $request->id)
            ->count();
        $data['count_materials'] = DB::table('learning_materials')
            ->where('id_class', $request->id)
            ->count();
        $data['count_quizzes'] = DB::table('quizzes')
            ->where('id_class', $request->id)
            ->count();
        $data['class'] = DB::table('classes')
            ->where('id', $request->id)
            ->first();
        $data['feed'] = DB::table('feed')
            ->leftJoin('user_profile', 'user_profile.id', '=', 'feed.id_user')
            ->where('feed.del_status', 1)
            ->where('feed.feed_category', $request->id)
            ->select('feed.*', 'user_profile.first_name', 'user_profile.middle_name', 'user_profile.last_name', 'user_profile.picture')
            ->orderBy('feed.created_at', 'desc')
            ->get();
        return view('student.class.viewclass_dashboard', $data);
    }
    public function viewsubject_classpeople(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['class'] = DB::table('classes')
            ->where('id', $request->id)
            ->first();
        $data['users'] = DB::table('user_profile')
            ->leftJoin('class_people', 'class_people.id_user', '=', 'user_profile.id')
            ->leftJoin('users', 'users.id_user', '=', 'user_profile.id')
            ->leftJoin('user_role', 'users.id_user_role', '=', 'user_role.id')
            ->where('class_people.id_class', $request->id)
            ->where('class_people.del_status', 1)
            ->select('user_profile.*', 'user_role.role')
            ->get();
        return view('student.class.viewclass_classpeople', $data);
    }
    public function postclasspeople(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $user = DB::table('user_profile')
            ->where('account_id', $request->account_id)
            ->first();
        $check = DB::table('class_people')
            ->where('id_user', $user->id)
            ->where('id_class', $request->id_class)
            ->count();
        if($check == 0){
            $class_people['id_class'] = $request->id_class;
            $class_people['id_user'] = $user->id;
            $class_people['status'] = 0;
            DB::table('class_people')
                ->insert($class_people);
        }
    }
    public function removeuserfromclass(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        DB::table('class_people')
            ->where('id_class', $request->id_class)
            ->where('id_user', $request->id_student)
            ->update(['del_status' => 0]);
    }
    public function viewsubject_assignment(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['class'] = DB::table('classes')
            ->where('id', $request->id)
            ->first();
        if($request->bin == null){
            $bin = 1;
            $data['view_type'] = "";
        }
        else{
            $bin = 0;
            $data['view_type'] = "bin";
        }
        $data['assignments'] = DB::table('assignments')
            ->where('id_class', $request->id)
            ->where('del_status', $bin)
            ->select('id', 'title', 'points', 'start_date', 'end_date')
            ->get();
        return view('student.class.viewclass_assignments', $data);
    }
    public function viewsubject_assignmentviewresponses(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['class'] = DB::table('classes')
            ->where('id', $request->id)
            ->first();
        $data['assignment'] = DB::table('assignments')
            ->where('id', $request->assignment)
            ->where('id_class', $request->id)
            ->first();
        $data['responses'] = DB::table('assignment_response')
            ->leftJoin('user_profile', 'user_profile.id', '=', 'assignment_response.id_student')
            ->where('assignment_response.id_assignment', $request->assignment)
            ->select('user_profile.first_name', 'user_profile.last_name', 'assignment_response.response', 'assignment_response.attached_file', 'assignment_response.teacher_remarks', 'assignment_response.grade', 'assignment_response.id_assignment', 'assignment_response.id', 'user_profile.id as id_student')
            ->get();
        return view('student.class.viewclass_viewassignmentresponse', $data);
    }
    public function viewsubject_assignmentpostremark(Request $request){
        DB::table('assignment_response')
            ->where('id_assignment', $request->id_response)
            ->where('id_student', $request->id_student)
            ->update(['teacher_remarks' => $request->remarks, 'grade' => $request->grade]);
            return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Remark successfully submitted!");
                })</script>');
    }
    public function postAssignment(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $file = $request->userfile;
        $response['response'] = $request->response;
        $response['attached_file'] = "";
        if($request->ass_response_action == "update"){
            if($file != null){
                $extname = $file->extension();
                $filename = Auth::user()->id_user;
                $response['attached_file'] = $filename . '.' . $extname;
                $file->storeAs('/assignments/response/', $request->id. '/' . $filename .'.' . $extname,['disk' => 'public_uploads']);
            }
            DB::table('assignment_response')
                ->where('id', $request->id_assignment)
                ->where('id_student', Auth::user()->id_user)
                ->update($response);
            return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Response successfully updated!");
                })</script>');
        }
        else{
            if($file != null){
                $extname = $file->extension();
                $filename = Auth::user()->id_user;
                $response['attached_file'] = $filename . '.' . $extname;
                $file->storeAs('/assignments/response/', $request->id_assignment. '/' . $filename .'.' . $extname,['disk' => 'public_uploads']);
            }
            $response['teacher_remarks'] = "";
            $response['id_assignment'] = $request->id_assignment;
            $response['id_student'] = Auth::user()->id_user;
            $response['grade'] = "0.00";
            DB::table('assignment_response')
                ->where('id_assignment', $request->id_assignment)
                ->where('id_student', Auth::user()->id_user)
                ->insert($response);
            return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Response successfully submitted!");
                })</script>');
        }
    }
    public function newAssignment(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $assignment['id_class'] = $request->id_class;
        $assignment['created_by'] = Auth::user()->id_user;
        $assignment['title'] = $request->title;
        $assignment['instruction'] = $request->instruction;
        $assignment['attached_file'] = "";
        $assignment['points'] = $request->points;
        $assignment['start_date'] = $request->start_date;
        $assignment['end_date'] = $request->end_date;
        $assignment['is_assign_to_class'] = 0;
        $assignment['is_assign_to_specific_student'] = 0;

        $file = $request->userfile;
        DB::table('assignments')
            ->insert($assignment);
        $assignment = DB::table('assignments')->orderBy('id', 'desc')->first();
        if($file != null){
            $extname = $file->extension();
            $filename = bin2hex(random_bytes(16));
            $attached_file = $filename . '.' . $extname;
            $file->storeAs('/assignments/', $assignment->id. '/' . $filename .'.' . $extname,['disk' => 'public_uploads']);
            DB::table('assignments')
                ->where('id', $assignment->id)
                ->update(['attached_file'=> $attached_file]);
        }
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Assignment successfully created!");
                })</script>');
    }
    public function updateAssignment(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $assignment['title'] = $request->title;
        $assignment['instruction'] = $request->instruction;
        $assignment['points'] = $request->points;
        $assignment['start_date'] = $request->start_date;
        $assignment['end_date'] = $request->end_date;

        $file = $request->userfile;
        DB::table('assignments')
            ->where('id', $request->id)
            ->update($assignment);
        if($file != null){
            $extname = $file->extension();
            $filename = bin2hex(random_bytes(16));
            $attached_file = $filename . '.' . $extname;
            $file->storeAs('/assignments/', $request->id. '/' . $filename .'.' . $extname,['disk' => 'public_uploads']);
            DB::table('assignments')
                ->where('id', $request->id)
                ->update(['attached_file'=> $attached_file]);
        }
        return redirect()->back()->with('message', '<script>
                $(document).ready(function(){
                    toastr.success("Assignment successfully updated!");
                })</script>');
    }
    public function deleteAssignment(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        DB::table('assignments')
            ->where('id', $request->id)
            ->update(['del_status' => 0]);
    }
    public function permdeleteAssignment(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $record = DB::table('assignments')
            ->where('id', $request->id)
            ->first();
        \File::delete(public_path('uploads/assignments/'.$record->id));
        DB::table('assignment_response')
            ->where('id_assignment', $request->id)
            ->delete();
        DB::table('assignments')
            ->where('id', $request->id)
            ->delete();
    }
    public function restoreassignment(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        DB::table('assignments')
            ->where('id', $request->id)
            ->update(['del_status' => 1]);
    }
    public function viewsubject_quizzes(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['class'] = DB::table('classes')
            ->where('id', $request->id)
            ->first();
        $data['quizzes'] = DB::table('quizzes')
            ->where('id_class', $request->id)
            ->select('id', 'title', 'points', 'start_date', 'end_date', 'passing_points')
            ->get();
        return view('student.class.viewclass_quizzes', $data);
        //type_number([(=)])what[(=)])answer[(=)])points((end[]line))
    }
    public function viewquizresponse(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['class'] = DB::table('classes')
            ->where('id', $request->id_class)
            ->first();
        $data['quizzes'] = DB::table('quizzes')
            ->where('id', $request->id)
            ->where('id_class', $request->id_class)
            ->first();
        $data['responses'] = DB::table('quizzes_response')
            ->leftJoin('user_profile', 'user_profile.id', '=', 'quizzes_response.id_student')
            ->where('quizzes_response.id_quizzes', $request->id)
            ->select('user_profile.first_name', 'user_profile.last_name', 'quizzes_response.response', 'quizzes_response.teacher_remarks', 'quizzes_response.grade', 'quizzes_response.id_quizzes', 'quizzes_response.id', 'user_profile.id as id_student')
            ->get();
        return view('student.class.viewclass_viewquizzesresponse', $data);
    }
    public function addquiz(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['id_class'] = $request->id_class;
        $data['title'] = $request->title;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['passing_points'] = $request->passingpoints;
        $data['question'] = $request->question;
        $data['instruction'] = $request->instruction;
        DB::table('quizzes')->insert($data);
        return redirect()->back()->with('message', '<script>
            $(document).ready(function(){
                toastr.success("Quiz succesfully added!");
            })</script>');
        //type_number([(=)])what[(=)])answer[(=)])points((end[]line))
    }
    public function submitquizresponse(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $check = DB::table('quizzes_response')
            ->where('id_student', Auth::user()->id_user)
            ->where('id_quizzes', $request->id)
            ->count();
        if($check < 1){
            $data['id_quizzes'] = $request->id;
            $data['id_student'] = Auth::user()->id_user;
            $data['response'] = $request->compiledanswers;
            $data['teacher_remarks'] = '';
            $data['grade'] = 0;
            DB::table('quizzes_response')->insert($data);
            $result['title'] = 'Answer Submitted!';
            $result['msg'] = 'Quiz answer has been successfully submitted';
            $result['icon'] = 'success';
            return $result;
        }
        else{
            $result['title'] = 'Failed to submit answer!';
            $result['msg'] = 'You already have an existing response for this quiz.';
            $result['icon'] = 'error';
            return $result;
        }
        //type_number([(=)])what[(=)])answer[(=)])points((end[]line))
    }
    public function submitquizremarks(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['teacher_remarks'] = $request->remarks;
        $data['grade'] = $request->grade;
        DB::table('quizzes_response')
            ->where('id', $request->id)
            ->update($data);
    }
    public function viewsubject_materials(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['class'] = DB::table('classes')
            ->where('id', $request->id)
            ->first();
        if($request->bin == null){
            $bin = 1;
            $data['view_type'] = "";
        }
        else{
            $bin = 0;
            $data['view_type'] = "bin";
        }
        $data['materials'] = DB::table('learning_materials')
            ->leftJoin('categories', 'categories.id', '=', 'learning_materials.id_category')
            ->leftJoin('user_profile', 'user_profile.id', '=', 'learning_materials.created_by')
            ->where('learning_materials.id_class', $request->id)
            ->where('learning_materials.del_status', $bin)
            ->select('learning_materials.id', 'categories.category', 'learning_materials.title', 'learning_materials.description', 'learning_materials.attached_file', 'user_profile.last_name', 'user_profile.first_name')
            ->get();
        $data['lms_categories'] = DB::table('categories')->where('id_category_type', 9)->get();
        return view('student.class.viewclass_materials', $data);
    }
    public function addmaterials(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['id_class'] = $request->id_class;
        $data['id_category'] = $request->id_category;
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['attached_file'] = "";
        $data['created_by'] = Auth::user()->id_user;
        DB::table('learning_materials')->insert($data);

        $material = DB::table('learning_materials')->orderBy('id', 'desc')->first();

        $file = $request->userfile;
        if($file != null){
            $extname = $file->extension();
            $filename = bin2hex(random_bytes(16));
            $attached_file = $filename . '.' . $extname;
            $file->storeAs('/learning-materials/', $material->id. '/' . $filename .'.' . $extname,['disk' => 'public_uploads']);
            DB::table('learning_materials')
                ->where('id', $material->id)
                ->update(['attached_file'=> $attached_file]);
        }
        return redirect()->back()->with('message', '<script>
            $(document).ready(function(){
                toastr.success("Learning material succesfully added!");
            })</script>');
    }
    public function updatematerials(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        $data['id_category'] = $request->id_category;
        $data['title'] = $request->title;
        $data['description'] = $request->description;

        $file = $request->userfile;
        if($file != null){
            $extname = $file->extension();
            $filename = bin2hex(random_bytes(16));
            $data['attached_file'] = $filename . '.' . $extname;
            $file->storeAs('/learning-materials/', $request->id. '/' . $filename .'.' . $extname,['disk' => 'public_uploads']);
        }
        DB::table('learning_materials')
            ->where('id', $request->id)
            ->update($data);
        return redirect()->back()->with('message', '<script>
            $(document).ready(function(){
                toastr.success("Learning material succesfully updated!");
            })</script>');
    }
    public function deletematerials(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        DB::table('learning_materials')
            ->where('id', $request->id)
            ->update(['del_status' => 0]);
    }
    public function restorematerials(Request $request){
        if(app(\App\Http\Controllers\globalController::class)->checkauth()){
            return redirect('/login');
        }
        DB::table('learning_materials')
            ->where('id', $request->id)
            ->update(['del_status' => 1]);
    }
}
