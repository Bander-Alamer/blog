<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Comment;
class CommentController extends Controller
{

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
    public function showPost($id){
        $post = Post::where('id','=',$id)->first();
        if($post){
            return $post;
        }
    }

    public function updatePost(Request $request, $id) {
        $post = Post::where('id','=',$id)->first();
        $post->title = $request->title;
        $post->body = $request->body;

        $post->save();

        return redirect('/posts')->with('status', 'Post was updated !');

    }

}
