<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;
use Illuminate\Http\Request;


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
        $allPosts = Post::all();
        $posts = array();

        foreach ($allPosts as $post){
            $post_user = User::where('id', $post->user_id)->first(); // post owner
            $myuser = Auth::user(); // logged in user 
            if(strcmp("$myuser->gender","$post_user->gender") == 0){
                $post->user = $post_user;
                $post->user->password = null;
                array_push($posts,$post);
            }
        }

        return view('home',['posts'=>$posts]);
    }


    public function genderIndex()
    {
        return view('fillGender');
    }

    public function genderUpdate(Request $request)
    {
        $user = Auth::user();
        if($request->has('gender')){
            if($request->gender == 'male' || $request->gender == 'female'){
                $user->gender = $request->gender;
            }
        }else{
            return back()->withErrors(['gender' => ['Please select a gender!']]);
        }

        if($user->save()){
            return redirect('home');
        }else{
            return back()->withErrors(['gender' => ['Something went wrong!! ']]);
        }
    }

}
