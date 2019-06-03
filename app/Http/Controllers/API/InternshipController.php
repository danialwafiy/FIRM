<?php

namespace app\Http\Controllers\API;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use Session;
use app\lecture;
use app\student;


class InternshipController extends Controller
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
        //
    }

    public function activeLectures()
    {
        $lectures=lecture::where('status','1')->get();
        return $lectures->toJson();
    }

    public function inactiveLectures()
    {   
        $lectures=lecture::where('status','0')->get();
        return $lectures->toJson();        
    }

    public function statusActive($id)
    {
        $lecture = lecture::findOrFail($id);
        $lecture->status = "1";
        $lecture->save();       
    }
    
    public function statusInactive($id)
    {
        $lecture = lecture::findOrFail($id);
        $lecture->status = "0";
        $lecture->save();  

        student::where('lecture_id_FK', '=',$id)->update(['lecture_id_FK' => null]);
    }

    public function unassignedStudents()
    {
        $ustudents=student::whereNull('lecture_id_FK')->get();  
        return $ustudents->toJson();
    }

    public function assignedStudents($id)
    {   
        $astudents=student::where('lecture_id_FK',strtoupper($id))->get();
        return $astudents->toJson();
    }

    public function setLecture($lecture,$student)
    {
        $studentIds = explode(',', $student);
        return $students = student::whereIn('student_id', $studentIds)
            ->update(['lecture_id_FK' => $lecture]);
    }

    public function setNoStudent($lecture)
    {
        $studentCount = student::where('lecture_id_FK', '<=', $lecture)->count();

        $lectureID = lecture::findOrFail($lecture);
        $lectureID->no_student = $studentCount;
        $lectureID->save();
    }

    public function removeLecture($student)
    {
        $student = student::findOrFail($student);
        $student->lecture_id_FK =null;
        $student->save();
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
