<?php

namespace App\Http\Controllers;
use App\Models\Settings;

use Illuminate\Http\Request;
// use App\Models\Settings;

class SettingController extends Controller
{
    //
    function index(){
    	$setting=Settings::first();
    	return view('backend.setting.index',['setting'=>$setting]);
    }
    // Store
    function save_settings(Request $request){
    	$countData=Settings::count();
    	if($countData==0){
	    	$data=new Setting;
	        $data->comment_auto=$request->comment_auto;
	        $data->user_auto=$request->user_auto;
	        $data->recent_limit=$request->recent_limit;
	        $data->popular_limit=$request->popular_limit;
	        $data->recent_comment_limit=$request->recent_comment_limit;
	        $data->save();
	    }else{
	    	$firstData=Settings::first();
	    	$data=Settings::find($firstData->id);
	        $data->comment_auto=$request->comment_auto;
	        $data->user_auto=$request->user_auto;
	        $data->recent_limit=$request->recent_limit;
	        $data->popular_limit=$request->popular_limit;
	        $data->recent_comment_limit=$request->recent_comment_limit;
	        $data->save();
	    }

        return redirect('admin/setting')->with('success','Data has been updated.');
    }
}
