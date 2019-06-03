<?php

namespace app\Http\Controllers\API;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\meeting;
use app\student;
use session;
use Carbon\Carbon;


class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requestChange(Request $request)
    {
        $student = student::find(session('userID'));
        $student->meeting_msg=$request['msg'];
        $student->meeting_status='request';
        $student->save();       
    }
    public function studentConfirmDate()
    {
        $student = student::find(session('userID'));
        $student->meeting_status='confirmed';
        $student->save();        
    }

    public function getUserType()
    {
        if(session('userTYPE')=="3"){
            return '3';
        }else
        {
            return '2';           
        }        
    }
    public function showForm($id)
    {
        $student = student::where(['student_id' => $id])->first();
        if ($student->meeting_date == '')         
        {
            $data = [
                'showFormSet'=>'true',
                'showFormChange'=>'false',
            ];
            return $data;           
        }
        else{
            $data = [
                'showFormSet'=>'false',
                'showFormChange'=>'true',
            ];
            return $data;  
        }
    }



    public function changeDate(Request $request)
    {
        $student = student::where(['student_id' => $request['student_id']])->first();

        $this->validate($request,[
            'date' => 'required',
        ]);  
        $student->meeting_date=(new Carbon($request['date']))->format('d/m/y');
        $student->meeting_msg='';
        $student->meeting_status='unconfirmed';
        $student->save();
     
    }

    public function getCurrentDate($id)
    {
        $student = student::where(['student_id' => $id])->first();
        return $student;
    }

    public function getLectureStudentList()
    {
        $students = student::where(['lecture_id_FK'=>session('userID')])->get();
        return $students;
    }

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
        $student = student::where(['student_id' => $request['student_id']])->first();

        $this->validate($request,[
            'date' => 'required',
        ]);  
        $student->meeting_date=(new Carbon($request['date']))->format('d/m/y');
        $student->meeting_status='unconfirmed';
        $student->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
