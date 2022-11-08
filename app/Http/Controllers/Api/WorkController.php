<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkResource;
use App\Models\Image;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }

    public function index()
    {
        $works = Work::included()
                        ->filter()
                        ->sort()
                        ->getOrPaginate();
        return WorkResource::collection($works);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->image){
            $data = $request->validate([
                'name'=>'required|max:255',
                'image'=>'image'
            ]);
        }else{
            $data = $request->validate([
                'name'=>'required|max:255',
                
            ]);
        }
        
        $user=auth()->user();

        $data['user_id']= $user->id;
        $work=Work::create($data);
        if($request->image){
            $path = $request->image->store('works'); 
            $work->image()->create([
                'url' => $path
            ]);
            $data = [$work];
            return WorkResource::make($work);
        }
        return WorkResource::make($work);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $work=Work::included()->findOrFail($id);

        return WorkResource::make($work);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Work $work)
    {
        
        if($request->image){
            
            $data = $request->validate([
                'name'=>'required|max:255',
                'status'=>'required',
                'image'=>'image'
            ]);
        }else{
            $data = $request->validate([
                'name'=>'required|max:255',
                'status'=>'required'
            ]);
        }
        
        $user=$work->user;

        $data['user_id']= $user->id;
        $work->update($data);
        
        if($request->image){
            $path = $request->image->store('works');
            if($work->image){
                Storage::delete($work->image->url);
                $work->image->update([
                    'url' => $path
                ]);
            }else{
                $work->image()->create([
                    'url' => $path
                ]);
            }
            $data = [$work];
            return WorkResource::make($work);
        }
        if($work->image){
            $data = [$work];
            return WorkResource::make($work);
        }else{
            return WorkResource::make($work);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        $work->delete();
        return $work;
    }
}
