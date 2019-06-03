<?php

namespace app\Http\Controllers\API;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use Session;
use app\student;
use app\lecture;
use app\internship;
use app\Http\Resources\students as StudentsResource;


class StudentProfileController extends Controller
{
    
    public function index()
    {

    }

    public function getUserType()
    {
        return session('userTYPE');
    }

    public function showButton()
    {
        if(session('userTYPE')=="3"){
            return "false";
        }
        else{
            return "true";
        }
    }

    public function getAllStudentList()
    {
        $students = student::all();
        return StudentsResource::collection($students);
    }

    public function showStudentProfile()
    {
        if(session('userTYPE')=="1"){
            return "true";
        }
        else{
            return "false";
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student=student::where('student_id',$id)->first();
        return $student;
    }

    public function showWithSessionStudent()
    {
        $student=student::where('student_id',session('userID'))->first();
        return $student;
    }

    public function getLecture($id)
    {   
        $lectureID = student::select('lecture_id_FK')->where('student_id',$id)->first();
        $lectureDATA = lecture::where('lecture_id',$lectureID->lecture_id_FK)->first();
        return $lectureDATA;
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
