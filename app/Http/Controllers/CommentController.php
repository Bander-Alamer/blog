<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Post;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        public function store(Request $request,$id){
            $post = Post::where('id', '=', $id)->first();
            if(!$post){
                  return back();
            }
            $comment = new Comment();
            $comment->comment = $request->input("comment");
            $comment->user_id = $request->input("user_id");
            $comment->post_id = $post->id;
            if($comment->save()){
                return response()->json(["message" => 'Comment created!',"status" => 200]);
            }
            return response()->json(["message" => "FAILED","status" => 502]);
        }



        public function comments($id){
            $post = Post::where('id','=',$id)->first();
            if(!$post){
                return back();
            }

            foreach ($post->comments as $comment){
                $user = User::find($comment->user_id);
                $user->password = null;
                $user->email = null;
                $comment->user = $user;
            }
            return $post->comments;
        }
    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
