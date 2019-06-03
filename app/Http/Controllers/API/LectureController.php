<?php

namespace app\Http\Controllers\API;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\lecture;
use app\student;
use app\Http\Resources\lectures as LecturesResource;
use app\Http\Resources\students as StudentsResource;


class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function dashboardAdminData()
    {
        $totalStudent = student::count();
        $totalLecture = lecture::count();
        $activeStudent = student::where('status','1')->count();
        $activeLecture = lecture::where('status','1')->count();
        $data = [
            'totalStudent'=>$totalStudent,
            'totalLecture'=>$totalLecture,
            'activeStudent' =>$activeStudent,
            'activeLecture'=>$activeLecture
        ];
        return $data;
    }

    public function showWithSessionLecture()
    {
        $lecture=lecture::where('lecture_id',session('userID'))->first();
        return $lecture;
    }

    public function getMyStudents($id)
    {
        $students = student::where('lecture_id_FK', $id)->get();
        return StudentsResource::collection($students);
    }

    public function getAllLectureList()
    {
        $lecture = lecture::all();
        return LecturesResource::collection($lecture);
    }

    public function getLectureProfile($id)
    {
        $lecture=lecture::where('lecture_id',$id)->first();
        return $lecture;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lecture = lecture::where(['lecture_id' => $id])
        ->first();
        return json_encode($lecture);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
