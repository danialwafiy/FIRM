<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Logbook Controller
Route::post('/logbook/svVerifyLog/{id}', 'API\LogbookController@svVerifyLog')->name('logbook.svVerifyLog');
Route::post('/logbook/verifyLog/{id}', 'API\LogbookController@verifyLog')->name('logbook.verifyLog');
Route::get('/logbook/getStudentLogbook/{id}', 'API\LogbookController@getStudentLogbook')->name('logbook.getStudentLogbook');
Route::put('/api/logbook/{id}', 'API\LogbookController@update');
Route::delete('/api/logbook/{id}', 'API\LogbookController@destroy');
Route::apiResources(['logbook' => 'API\LogbookController']);


Route::apiResources(['user' => 'API\UserController']);

//LectureStudent Controller
Route::apiResources(['studentlecture' => 'API\LectureStudentController']);
Route::get('/studentlecture','API\LectureStudentController@index');
 
Route::put('change-password/{user}','API\UserController@changePassword');

//StudentProfile Controller
Route::get('profile/getUserType', 'API\StudentProfileController@getUserType')->name('profile.getUserType');
Route::get('profile/showWithSessionStudent', 'API\StudentProfileController@showWithSessionStudent')->name('profile.showWithSessionStudent');
Route::get('profile/showButton', 'API\StudentProfileController@showButton')->name('profile.showButton');
Route::get('profile/showStudentProfile', 'API\StudentProfileController@showStudentProfile')->name('profile.showStudentProfile');
Route::get('profile/getAllStudentList', 'API\StudentProfileController@getAllStudentList')->name('profile.getAllStudentList');
Route::get('profile/getLecture/{id}', 'API\StudentProfileController@getLecture')->name('profile.getLecture');
Route::apiResources(['profile' => 'API\StudentProfileController']);

//News Controller
Route::apiResources(['news' => 'API\NewsController']);

//Internship Controller
Route::post('internship/setNoStudent/{id}', 'API\InternshipController@setNoStudent')->name('internship.setNoStudent');
Route::post('internship/removeLecture/{student}', 'API\InternshipController@removeLecture')->name('internship.removeLecture');
Route::post('internship/setLecture/{lecture}/{student}', 'API\InternshipController@setLecture')->name('internship.setLecture');
Route::get('internship/assignedStudents/{id}', 'API\InternshipController@assignedStudents')->name('internship.assignedStudents');
Route::get('internship/unassignedStudents/{id}', 'API\InternshipController@unassignedStudents')->name('internship.unassignedStudents');
Route::post('internship/statusActive/{id}', 'API\InternshipController@statusActive')->name('logbook.statusActive');
Route::post('internship/statusInactive/{id}', 'API\InternshipController@statusInactive')->name('logbook.statusInactive');
Route::get('internship/activeLectures', 'API\InternshipController@activeLectures')->name('internship.activeLectures');
Route::get('internship/inactiveLectures', 'API\InternshipController@inactiveLectures')->name('internship.inactiveLectures');
Route::apiResources(['internship' => 'API\InternshipController']);

//Lecture Controller
Route::get('lecture/dashboardAdminData', 'API\LectureController@dashboardAdminData')->name('lecture.dashboardAdminData');
Route::get('lecture/showWithSessionLecture', 'API\LectureController@showWithSessionLecture')->name('lecture.showWithSessionLecture');
Route::get('lecture/getMyStudents/{id}', 'API\LectureController@getMyStudents')->name('lecture.getMyStudents');
Route::get('lecture/getLectureProfile/{id}', 'API\LectureController@getLectureProfile')->name('lecture.getLectureProfile');
Route::get('lecture/getAllLectureList', 'API\LectureController@getAllLectureList')->name('lecture.getAllLectureList');
Route::apiResources(['lecture' => 'API\LectureController']);

//Meeting 
Route::get('meeting/getLectureStudentList', 'API\MeetingController@getLectureStudentList')->name('meeting.getLectureStudentList');
Route::post('meeting/requestChange', 'API\MeetingController@requestChange')->name('meeting.requestChange');
Route::get('meeting/getUserType', 'API\MeetingController@getUserType')->name('meeting.getUserType');
Route::post('meeting/studentConfirmDate', 'API\MeetingController@studentConfirmDate')->name('meeting.studentConfirmDate');
Route::post('meeting/changeDate', 'API\MeetingController@changeDate')->name('meeting.changeDate');
Route::get('meeting/showForm/{id}', 'API\MeetingController@showForm')->name('meeting.showForm');
Route::get('meeting/getCurrentDate/{id}', 'API\MeetingController@getCurrentDate')->name('meeting.getCurrentDate');
Route::apiResources(['meeting' => 'API\MeetingController']);














