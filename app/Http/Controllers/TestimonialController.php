<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Testimonial;
use Validator;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $pagedata = Testimonial::all();
        return view('Testimonial/testimonial', compact('pagedata'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Testimonial/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'user_name' => 'required|unique:testimonials|max:255',
            'description' => 'required',
            'user_image' => 'mimes:jpeg,jpg,png',
            'created_by' => 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }
        // $request->validate([
        //     'title' => 'required|max:255',
        //     'description' => 'required',
        // ]);
        $testimonial = new Testimonial();
        $testimonial->user_name = $request->user_name;
        $testimonial->description = $request->description;
        $testimonial->user_designation = $request->designation;
        //$testimonial->user_image = $request->user_image;
        $testimonial->created_by = $request->created_by;
        
        if(!empty(request()->user_image)){
            $imageName = time().'.'.request()->user_image->getClientOriginalExtension();
            $imagearray = request()->user_image->move(public_path('uploads/Testimonials'), $imageName);
            $testimonial->user_image = $imageName;
        }
        $testimonial->save();
        return redirect('/testimonial')->with('success', 'Testimonial Added successfully.');
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
        $editData = Testimonial::where('id',$id)->first();
        return view('Testimonial/edit',compact('editData'));
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
        // dd($request);
        $v = Validator::make($request->all(), [
            'user_name' => 'required|max:255|unique:testimonials,user_name,'.$id,
            'description' => 'required',
            'user_image' => 'mimes:jpeg,jpg,png',
            'created_by' => 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $testimonial = Testimonial::find($id);
        $testimonial->user_name = $request->user_name;
        $testimonial->description = $request->description;
        $testimonial->user_designation = $request->designation;
        //$testimonial->user_image = $request->user_image;
        $testimonial->created_by = $request->created_by;
        
        if(!empty(request()->user_image)){
            $imageName = time().'.'.request()->user_image->getClientOriginalExtension();
            $imagearray = request()->user_image->move(public_path('uploads/Testimonials'), $imageName);
            $testimonial->user_image = $imageName;
            if(!empty(request()->user_image_hidden)){
                $old_image=$request->user_image_hidden;
                if(file_exists(public_path('uploads').'/Testimonials/'.$old_image)){
                    unlink(public_path('uploads').'/Testimonials/'.$old_image);
                }
            }
        }elseif(empty(request()->user_image_hidden)){
            $old_image=$testimonial->user_image;
            
            if($old_image && file_exists(public_path('uploads').'/Testimonials/'.$old_image)){
                unlink(public_path('uploads').'/Testimonials/'.$old_image);
            }
            $testimonial->user_image = '';
        }

        // dd($testimonial);
        $testimonial->save();

        // Testimonial::find($id)->update($validatedData);
        return redirect('/testimonial')->with('success', 'Page is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return redirect('/testimonial')->with('success', 'Page is successfully deleted');
    }

    /**
     * Remove the image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_user_image($id)
    {
        $testimonial = Testimonial::find($id);
        $image_name = $testimonial->user_image;
        $path = public_path() . '/uploads/Testimonials/' . $image_name[0];
        if (file_exists($path) && !empty($image_name[0])) {
            unlink($path);
        }
        $testimonial->user_image = '';
        $testimonial->save();
        // CustomPage::find($id)->delete();
    	return redirect('/testimonial')->with('success','Image removed successfully.');
    }
}
