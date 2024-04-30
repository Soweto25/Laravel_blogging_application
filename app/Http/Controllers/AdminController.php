<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Admin;
use App\Models\Post;

use App\Models\Category;
use App\Models\Comment;
use App\Models\User;


class AdminController extends Controller
{
    function add_admin(Request $request)
    {
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);
        
        $admin = new Admin();
        $admin->username = $request->username;
        $admin->password = $request->password;

        $admin->save();

        return redirect('admin/login');
    }

    function register()
    {
        return view('backend.register');
    }


    //Login view
    function login()
    {
    	return view('backend.login');
    }

    //submit login
    function submit_login(Request $request)
    {
    	$request->validate([
    		'username'=>'required',
    		'password'=>'required'
    	]);

    	$userCheck=Admin::where(['username'=>$request->username,'password'=>$request->password])->count();
    	if($userCheck>0){
            $adminData=Admin::where(['username'=>$request->username,'password'=>$request->password])->first();
            session(['adminData'=>$adminData]);
    		return redirect('admin/dashboard');
    	}else{
    		return redirect('admin/login')->with('error','Invalid username/password!!');
    	}

    }

    // Dashboard
    function dashboard()
    {
        // $posts = Post::with('category')->orderBy('id', 'desc')->get();
        $posts=Post::orderBy('id','desc')->get();
        $categories = category::all();
    	return view('backend.dashboard',['posts'=>$posts, 'categories'=>$categories]);
    }

    // Show all users
    function users()
    {
        $data=User::orderBy('id','desc')->get();
        return view('backend.user.index',['data'=>$data]);
    }

    public function delete_user($id)
    {
        User::where('id',$id)->delete();
        return redirect('admin/user');
    }

    // Show all comments
    function comments()
    {
        $data=Comment::orderBy('id','desc')->get();
        $users=User::all();

        return view('backend.comment.index',['data'=>$data, 'users'=>$users]);

    }

    public function delete_comment($id)
    {
        Comment::where('id',$id)->delete();
        return redirect('admin/comment');
    }

    // Logout
    function logout()
    {
        session()->forget(['adminData']);
        return redirect('admin/login');
    }

}
