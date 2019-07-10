<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\CustomPage;
use App\Models\Partner;
use App\Models\Programme;
use Validator;

class CustompageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('custompage');
        $pagedata = CustomPage::all();

        return view('custompage', compact('pagedata'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('Custom/create');
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
            'title' => 'required|unique:custom_pages|max:255',
            'description' => 'required',
            'banner_image' => 'mimes:jpeg,jpg,png',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }
        // $request->validate([
        //     'title' => 'required|max:255',
        //     'description' => 'required',
        // ]);
        $custompage = new CustomPage();
        $custompage->title = $request->title;
        $custompage->description = $request->description;
        $custompage->author_id = $request->author_id;
        $custompage->page_slug = str_slug($request->title, '-');
        if(!empty(request()->banner_image)){
            $imageName = time().'.'.request()->banner_image->getClientOriginalExtension();
            $imagearray = request()->banner_image->move(public_path('uploads/CMS/'), $imageName);
            $custompage->banner_image = $imageName;
        }
        $custompage->save();
        return redirect('/custompage')->with('success', 'Page is successfully Added');
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
        //return view('Custom/edit');
        $editData = CustomPage::where('id',$id)->first();
        return view('Custom/edit',compact('editData'));
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
        $v = Validator::make($request->all(), [
            'title' => 'required|unique:custom_pages,title,'.$id.'|max:255',
            'description' => 'required',
            'banner_image' => 'mimes:jpeg,jpg,png',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }
        $custompage = Custompage::find($id);
        $custompage->title = $request->title;
        $custompage->description = $request->description;
        $custompage->author_id = $request->author_id;
        $custompage->page_slug = str_slug($request->title, '-');
        
        if(!empty(request()->banner_image)){
            $imageName = time().'.'.request()->banner_image->getClientOriginalExtension();
            $imagearray = request()->banner_image->move(public_path('uploads/CMS/'), $imageName);
            $custompage->banner_image = $imageName;
            if(!empty(request()->banner_image_hidden)){
                $old_image=$request->banner_image_hidden;
                if(file_exists(public_path('uploads').'/CMS/'.$old_image)){
                    unlink(public_path('uploads').'/CMS/'.$old_image);
                }
            }
        }elseif(empty(request()->banner_image_hidden)){
            $old_image=$custompage->banner_image;
            
            if($old_image && file_exists(public_path('uploads').'/CMS/'.$old_image)){
                unlink(public_path('uploads').'/CMS/'.$old_image);
            }
            $custompage->banner_image = '';
        }
        
        $custompage->save();
        return redirect('/custompage')->with('success', 'Page is successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $custompost = CustomPage::findOrFail($id);
        $custompost->delete();

        return redirect('/custompage')->with('success', 'Page is successfully deleted');
    }

    /**
     * Remove the image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_banner_image($id)
    {
        $custompage = CustomPage::find($id);
        $image_name = $custompage->banner_image;
        $path = public_path() . '/uploads/CMS/' . $image_name[0];
        if (file_exists($path) && !empty($image_name[0])) {
            unlink($path);
        }
        $custompage->banner_image = '';
        $custompage->save();
        // CustomPage::find($id)->delete();
    	return redirect('/custompage')->with('success','Image removed successfully.');
    }

    /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function partner_images(){
        // $images = Partner::all();
        $images = Partner::orderBy('image_order', 'asc')->get();
        return view('partnerimage', compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_partner_images(Request $request)
    {
        for ($i=1; $i <= $request['total_count']; $i++) {
            if(is_numeric($request->input('stored_image_id_'.$i))){
                $partner = Partner::find($request->input('stored_image_id_'.$i));
                if ($partner->id == $request->input('stored_image_id_'.$i)) {
                    $partner->image_order = $i;
                }
                $partner->save();
            }else{
                $name=$request['stored_image_id_'.$i];
                foreach($request->file('files') as $image)
                {
                    if($name == $image->getClientOriginalName()){
                        $name=$image->getClientOriginalName();
                        $image->move(public_path().'/uploads/Partners/', $name);

                        $custompage_partner = new Partner();
                        $custompage_partner->image_name = $name;
                        $custompage_partner->image_order = $i;
                        $custompage_partner->save();
                    }
                }
            }
        }
        return redirect('/partner_images')->with('success', 'Images are successfully Added');
    }

    public function ajaxRequestPartner()
    {
        return view('ajaxRequestPartner');
    }
    
    public function ajaxRequestPartnerPost(Request $request)
    {
        $id = $request->all();
        Partner::where('id', $id)->delete();
        return response()->json(['success'=>'Partner Image Deleted']);
    }

    public function programme_images(Request $request)
    {
        $images = Programme::orderBy('image_order', 'asc')->get();
        return view('programme', compact('images'));
    }

    public function store_programme_images(Request $request)
    {
        // dd($request->all());
        for ($i=1; $i <= $request['total_count']; $i++) {
            //print_r('stored_image_id_'.$i.'---------'.$request['stored_image_id_'.$i].'<pre>');
            if(is_numeric($request->input('stored_image_id_'.$i))){
                $programme = Programme::find($request->input('stored_image_id_'.$i));
                if ($programme->id == $request->input('stored_image_id_'.$i)) {
                    $programme->image_order = $i;
                }
                $programme->save();
            }else{
                $name=$request['stored_image_id_'.$i];
                foreach($request->file('files') as $image)
                {
                    if($name == $image->getClientOriginalName()){
                        $name=$image->getClientOriginalName();
                        $image->move(public_path().'/uploads/Programme/', $name);

                        $custompage_programme = new Programme();
                        $custompage_programme->image_name = $name;
                        $custompage_programme->image_order = $i;
                        $custompage_programme->save();
                    }
                }
            }
        }
        return redirect('/programme_images')->with('success', 'Images are successfully Added');
    }

    public function ajaxRequestProgramme()
    {
        return view('ajaxRequestProgramme');
    }
    
    public function ajaxRequestProgrammePost(Request $request)
    {
        $id = $request->all();
        Programme::where('id', $id)->delete();
        return response()->json(['success'=>'Programme Image Deleted']);
    }
}
