<?php

namespace app\Http\Controllers;
use app\User;
use app\student;
use app\lecture;
use app\supervisor;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use Auth;
use Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        if(Auth::user()->type=="1" || Auth::user()->type=="2" ||  Auth::user()->type=="3"  )
        {
            $user = User::where('user_id', Auth::user()->user_id)->first();

            session(['userID'=>Auth::user()->user_id]);
            session(['userTYPE'=>Auth::user()->type]);

            return view('layouts/master',compact('user'));
        }
        else
        {
            $user = User::where('user_id', Auth::user()->user_id)->first();
            $sv = supervisor::where('supervisor_id',Auth::user()->user_id)->first();

            session(['userID'=>Auth::user()->user_id]);
            session(['userTYPE'=>Auth::user()->type]);
            session(['studentID'=>$sv->student_id_FK]);

            return view('layouts/master',compact('user'));
        }
    }
    
}
