<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuSetting;
use App\Models\CustomPage;
use Validator;
use App;

class MenuSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function headersetting()
    {
        //
        $menuData = MenuSetting::where('menu','header')->get();
        return view('menusettings.header_menu_setting',compact('menuData'));   
    }

    public function footersetting()
    {
        //
        $menuData = MenuSetting::where('menu','footer')->get();
        $cmss = CustomPage::select('title', 'id')->get();
        return view('menusettings.footer_menu_setting',compact('menuData','cmss'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
        $titles = $request->title;
        $names = $request->name;
        $ids = $request->id;

        if($request->menu == 'header')
        {
            $links = $request->link;

            $v = Validator::make($request->all(), [
                "title.*"  => "required|string|distinct",
            ],
            [
                'title.*.required' => 'Title is required'
            ]);

            if ($v->fails())
            {
                return redirect()->back()->withErrors($v->errors());
            }

            foreach($titles as $i => $title){
                $menuarray = array();
                $menuarray['name'] = $names[$i];
                $menuarray['title'] = $titles[$i];
                $menuarray['menu'] = $request->menu;
                $menuarray['link'] = $links[$i];
                $menuarray['cms_id'] = null;
                //$menuarray->save();
                $a = MenuSetting::where('id', $ids[$i])->update($menuarray);
                
            }
        }
        else
        {
            $cms_ids = $request->cms_id;

            $v = Validator::make($request->all(), [
                "title.*"  => "required|string",
                "cms_id.*"  => "required|string",
            ],
            [
                'title.*.required' => 'Title is required',
                'cms_id.*.required' => 'Cms Page is required'
            ]);

            if ($v->fails())
            {
                return redirect()->back()->withErrors($v->errors());
            }
            $app_url = env('APP_URL');
            
            foreach($titles as $i => $title){

                $cmsdata =  CustomPage::select('page_slug')->where('id',$cms_ids[$i])->first();
                $link = $app_url.'/custompage_load/'.$cmsdata->page_slug;
                
                $menuarray = array();
                $menuarray['name'] = $names[$i];
                $menuarray['title'] = $titles[$i];
                $menuarray['menu'] = $request->menu;
                $menuarray['cms_id'] = $cms_ids[$i];
                $menuarray['link'] = $link;

                $a = MenuSetting::where('id', $ids[$i])->update($menuarray);
                //$menuarray->save();
            }   
        }

        if( $request->menu == 'header') 
            return redirect('/headersetting')->with('success', 'Menu Setting has been saved.');
        else
            return redirect('/footersetting')->with('success', 'Menu Setting has been saved.');
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
