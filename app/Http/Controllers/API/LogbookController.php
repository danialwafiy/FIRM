<?php

namespace app\Http\Controllers\API;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\logbook;
use app\Http\Resources\logbook as LogbookResource;
use Session;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session('userTYPE')=="3"){
            $data = [
                'show'=>'true',
                'showVerify'=>'false',
                'showAddLogBtn' =>'true',
                'showVerifySV'=>'false'
            ];
            return $data;
        }
        else if(session('userTYPE')=="4")
        {
            $data = [
                'show'=>'false',
                'showVerify'=>'false',
                'showAddLogBtn' =>'false',
                'showVerifySV'=>'true'
            ];
            return $data;            
        }
        else{
            $data = [
                'show'=>'false',
                'showVerify'=>'true',
                'showAddLogBtn' =>'false',
                'showVerifySV'=>'false'
            ];
            return $data;
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
        $this->validate($request,[
            'title'=>'required|string|max:191',
            'description'=>'required|string',
            'date'=>'required'
        ]);
            
        if($request->filename){
            $name=time().'.'.explode('/',explode(':',substr($request->filename,0,strpos($request->filename,';')))[1])[1];

            \Image::make($request->filename)->save(public_path('files/').$name);

            return logbook::create([
                'title'=>$request['title'],
                'description'=>$request['description'],
                'date'=>$request['date'],
                'filename'=>$name,
                'student_id_FK'=>session('userID')
            ]);
        }
        else{
            return logbook::create([
                'title'=>$request['title'],
                'description'=>$request['description'],
                'date'=>$request['date'],
                'student_id_FK'=>session('userID')
            ]); 
        }
        


    }

    public function svVerifyLog($id)
    {
        $logbook = logbook::findOrFail($id);
        $logbook->supervisor_verify = "verified";
        $logbook->save();
    }

    public function verifyLog($id)
    {
        $logbook = logbook::findOrFail($id);
        $logbook->lecture_verify = "verified";
        $logbook->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $log = logbook::where(['logbook_id' => $id])
        ->first();
        return json_encode($log);
    }

    public function getStudentLogbook($id)
    {
            $logbooks = logbook::where('student_id_FK', $id)->orderBy('date','asc')->paginate(5);
            return LogbookResource::collection($logbooks);

    }

    /**
     * Update the specified resource in storage.
     *
     * @para m  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $logbook = logbook::findOrFail($id);
 
        if($request->newFile){
            $name=time().'.'.explode('/',explode(':',substr($request->newFile,0,strpos($request->newFile,';')))[1])[1];

            \Image::make($request->newFile)->save(public_path('files/').$name);

                $logbook->title = $request['title'];
                $logbook->description = $request['description'];
                $logbook->date = $request['date'];
                $logbook->filename = $name;
                $logbook->save();
        }
        else{
                $logbook->title = $request['title'];
                $logbook->description = $request['description'];
                $logbook->date = $request['date'];
                $logbook->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $logbook = logbook::findOrFail($id);
        //delete user
        $logbook->delete();
        return ['message'=>'Log Deleted'];
    }
}
