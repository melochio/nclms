<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\globalController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\adminController;

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

// AUTHENTICATION
Route::get('/login', [authController::class, 'getLogin'])->name('login');;
Route::post('/login', [authController::class, 'postLogin']);
Route::get('/logout', [authController::class, 'logout']);
Route::post('/forgotpassword', [authController::class, 'postlostpassword']);
Route::get('/resetpassword', [authController::class, 'getresetpassword']);
Route::post('/resetpassword', [authController::class, 'postresetpassword']);
Route::get('/', [globalController::class, 'index']);
Route::get('/hashcheck', [authController::class, 'hashcheck']);
Route::get('/account_disabled',[globalController::class, 'account_disabled']);
Route::post('/changepassword', [authController::class, 'changepassword']);

Route::get('/newsfeed', [adminController::class, 'publicfeed']);
Route::post('/newsfeed/post', [adminController::class, 'postpublicfeed']);
Route::post('/newsfeed/delete', [adminController::class, 'deletepublicfeed']);
Route::post('/newsfeed/postcomment', [adminController::class, 'postfeedcomment']);
Route::get('/dashboard', [studentController::class, 'index']);
Route::get('/profile', [studentController::class, 'getprofile']);
Route::post('/profile', [studentController::class, 'postprofile']);
Route::get('/usermanagement/students', [adminController::class, 'studentManagement']);
Route::post('/usermanagement/students', [adminController::class, 'poststudentManagement']);
Route::get('/usermanagement/teachers', [adminController::class, 'teacherManagement']);
Route::post('/usermanagement/teachers', [adminController::class, 'postteacherManagement']);
Route::post('/usermanagement/user/update', [adminController::class, 'updateuserinfo']);
Route::post('/usermanagement/enableuser', [adminController::class, 'enableuser']);
Route::post('/usermanagement/disableuser', [adminController::class, 'disableuser']);
Route::get('/roommanagement', [adminController::class, 'roommanagement']);
Route::get('/sectionmanagement', [adminController::class, 'sectionmanagement']);
Route::get('/subjectmanagement', [adminController::class, 'subjectmanagement']);
Route::get('/materialsmanagement', [adminController::class, 'materialsmanagement']);
Route::get('/timemanagement', [adminController::class, 'timemanagement']);
Route::get('/daysmanagement', [adminController::class, 'daysmanagement']);
Route::post('/categories/addcategory', [adminController::class, 'addcategory']);
Route::post('/categories/updatecategory', [adminController::class, 'updatecategory']);
Route::post('/categories/disablerecord', [adminController::class, 'disablecategory']);
Route::post('/categories/enablerecord', [adminController::class, 'enablecategory']);

//classes
Route::get('/subjects', [studentController::class, 'getsubjects']);
Route::post('/subjects/add', [studentController::class, 'addsubjects']);
Route::post('/subjects/update', [studentController::class, 'updatesubjects']);
Route::post('/subjects/disable', [studentController::class, 'disableclass']);
Route::post('/subjects/enable', [studentController::class, 'enableclass']);
Route::get('/subjects/view/dashboard/{id}', [studentController::class, 'viewsubject_dashboard']);
Route::get('/subjects/view/classpeople/{id}', [studentController::class, 'viewsubject_classpeople']);
Route::post('/subjects/view/classpeople', [studentController::class, 'postclasspeople']);
Route::post('/subjects/view/removeuserfromclass', [studentController::class, 'removeuserfromclass']);
Route::get('/subjects/view/assignments/{id}', [studentController::class, 'viewsubject_assignment']);
Route::get('/subjects/view/assignments/{id}/view', [studentController::class, 'viewsubject_assignmentviewresponses']);
Route::post('/subjects/view/assignments/postRemark', [studentController::class, 'viewsubject_assignmentpostremark']);
Route::post('/subjects/view/assignments/{id}', [studentController::class, 'postAssignment']);
Route::post('/subjects/view/assignments/new/assignment', [studentController::class, 'newAssignment']);
Route::post('/subjects/view/assignments/update/assignment', [studentController::class, 'updateAssignment']);
Route::post('/subjects/view/assignments/delete/assignment', [studentController::class, 'deleteAssignment']);
Route::post('/assignment/restore', [studentController::class, 'restoreassignment']);
Route::get('/subjects/view/quizzes/{id}', [studentController::class, 'viewsubject_quizzes']);
Route::get('/quizzes/viewresponse/{id}', [studentController::class, 'viewquizresponse']);
Route::post('/quizzes/add', [studentController::class, 'addquiz']);
Route::post('/quizzes/submitresponse', [studentController::class, 'submitquizresponse']);
Route::post('/quizzes/submitremarks', [studentController::class, 'submitquizremarks']);
Route::get('/subjects/view/materials/{id}', [studentController::class, 'viewsubject_materials']);
Route::get('/subjects/view/assignments/{bin}/{id}', [studentController::class, 'viewsubject_assignment']);
Route::get('/subjects/view/materials/{bin}/{id}', [studentController::class, 'viewsubject_materials']);
Route::post('/subjects/materials/add', [studentController::class, 'addmaterials']);
Route::post('/subjects/materials/update', [studentController::class, 'updatematerials']);
Route::post('/subjects/materials/delete', [studentController::class, 'deletematerials']);
Route::post('/subjects/materials/restore', [studentController::class, 'restorematerials']);

//classes fetch data
Route::get('/fetch/assessment_response/{id}', [globalController::class, 'fetch_assessmentresponse']);
Route::get('/fetch/assessment/{id}', [globalController::class, 'fetch_assessment']);
Route::get('/fetch/materials/{id}', [globalController::class, 'fetch_materials']);
Route::get('/fetch/quiz/{id}', [globalController::class, 'fetch_quiz']);
Route::get('/fetch/quiznresponse', [globalController::class, 'fetch_quiznresponse']);
Route::get('/fetch/quizresponse', [globalController::class, 'fetch_quizresponse']);
Route::get('/fetch/verifyuserbyid/{id}', [globalController::class, 'fetch_verifyuserbyid']);
Route::get('/fetch/checkclasspeople', [globalController::class, 'checkclasspeople']);
Route::get('/fetch/userprofile', [globalController::class, 'fetchuserprofile']);
Route::get('/fetch/category', [globalController::class, 'fetchcategory']);
Route::get('/fetch/class', [globalController::class, 'fetchclass']);
Route::post('/fetch/account_status', [authController::class, 'fetchaccountstatus']);
Route::post('/check/currentpassword', [authController::class, 'checkcurrentpassword']);
Route::get('/fetch/feed', [globalController::class, 'fetchfeedbyid']);
Route::get('/fetch/feedcomments', [globalController::class, 'fetchfeedcomments']);