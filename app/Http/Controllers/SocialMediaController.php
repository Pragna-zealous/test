<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socialmedia;
use Validator;
use App;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socialmedias = Socialmedia::all();
        return view('socialmedia.index',compact('socialmedias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('socialmedia.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'icon' => 'mimes:jpeg,jpg,png',
            'title' => ['required','max:255'],
            'link' => ['required','max:255']
        ];

        $validator = Validator::make($data, $rules);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }

        $imageName = '';
        if(!empty(request()->icon)){
            $imageName = time().'.'.request()->icon->getClientOriginalExtension();
            $imagearray = request()->icon->move(public_path('uploads/'), $imageName);
        }

        $data = [
            'icon' => $imageName,
            'title' => $data['title'],
            'link' => $data['link']
        ];

        $check = Socialmedia::create($data);

        return redirect('/socialmedia')->with('success', 'Social Media has been saved.');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mediadata = Socialmedia::find($id);
        return view('socialmedia/edit',compact('mediadata'));
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
         $rules = array(
            'icon' => 'mimes:jpeg,jpg,png',
            'title' => 'required',
            'link' => 'required',
        );
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('socialmedia.edit',$id)->withErrors($validator)->withInput();
        } 

        $mediadata = Socialmedia::find($id);
        $icon = '';
        if(!empty(request()->icon)){
            $imageName = time().'.'.request()->icon->getClientOriginalExtension();
            $imagearray = request()->icon->move(public_path('uploads/'), $imageName);
            $mediadata->icon = $imageName;
            if(!empty(request()->profile_image_hidden)){
                $old_image=$request->profile_image_hidden;
                if(file_exists(public_path('uploads').'/'.$old_image)){
                    unlink(public_path('uploads').'/'.$old_image);
                }
            }
        }elseif(empty(request()->profile_image_hidden)){
            $old_image=$mediadata->user_profile;
            
            if($old_image && file_exists(public_path('uploads').'/'.$old_image)){
                unlink(public_path('uploads').'/'.$old_image);
            }
            $mediadata->user_profile = '';
        }

        $mediadata->title = $request->title;
        $mediadata->link = $request->link;
        $mediadata->save();

        \Session::flash('flash_success', 'Social Media updated successfully.');
        return redirect('socialmedia');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Socialmedia::find($id);    
        $user->delete();

        \Session::flash('flash_success', 'Social Media deleted successfully.');
        return redirect('socialmedia');
    }
}
