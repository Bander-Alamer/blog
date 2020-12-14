<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createPost');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = Auth::user();
        $post = new Post();
        $post->title=$request->input('title');
        $post->body= urldecode($request->input('body'));
        $post->user_id = $user->id;
        if($post->save()){
            return redirect('home');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id){
            $post = Post::find($id);
            foreach($post->comments as $comment){
                $user = User::find($comment->user_id);
                $comment->user = $user;
            }
            return view('showPost', ['post' => $post,'comments' => $post->comments]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $post = Post::where('id','=',$id);
        $post->delete();
        return redirect('/posts')->with('status', 'Post was deleted !');
    }


}
