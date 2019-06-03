<?php

namespace app\Http\Controllers\API;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use Session;
use app\news;
use app\Http\Resources\news as NewsResource;


class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = news::all();
        return NewsResource::collection($news);

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
            'title' => 'required|string|max:191',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);   
        
        if($request->filename){
            $name=time().'.'.explode('/',explode(':',substr($request->filename,0,strpos($request->filename,';')))[1])[1];

            \Image::make($request->filename)->save(public_path('files/').$name);

            return news::create([
                'title'=>$request['title'],
                'description'=>$request['description'],
                'date'=>$request['date'],
                'filename'=>$name,
            ]);
        }
        else{
            return news::create([
                'title'=>$request['title'],
                'description'=>$request['description'],
                'date'=>$request['date'],
            ]); 
        }
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $news = news::findOrFail($id);
 
        if($request->newFile){
            $name=time().'.'.explode('/',explode(':',substr($request->newFile,0,strpos($request->newFile,';')))[1])[1];

            \Image::make($request->newFile)->save(public_path('files/').$name);

                $news->title = $request['title'];
                $news->description = $request['description'];
                $news->filename = $name;
                $news->date = $request['date'];
                $news->save();
        }
        else{
                $news->title = $request['title'];
                $news->description = $request['description'];
                $news->date = $request['date'];
                $news->save();
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
        $news = news::findOrFail($id);
        //delete user
        $news->delete();
    }
}
