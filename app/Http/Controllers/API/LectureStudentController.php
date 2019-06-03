<?php

namespace app\Http\Controllers\API;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use Session;
use app\student;
use app\lecture;



class LectureStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lectureID = session('userID');
        return $lectureID;
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
        $students=student::where('lecture_id_FK',$id)->get();
        return $students->toJson();

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
     * @param  int  $idE
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
