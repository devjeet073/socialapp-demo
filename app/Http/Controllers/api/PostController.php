<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\ResponseController;
use App\Http\Requests\api\PostUpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Posttag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends ResponseController
{
    public function lists($id=null){
        $post = Post::orderBy('created_at','desc')->select('id','title','created_at')->paginate(10);
        return $this->_sendResponse("Post retrieved successfully.",$post);
    }
    public function show($id=null){
        if(!$id){
            return response()->json([
                'success' => false,
                'message' => 'Post not found '
            ], 400);
        }
        $post = Post::where('id',$id)
        ->with(['comments'=>function($q){
            $q->select('id','comment','post_id','created_at');
        },'tags'=>function($q){
            $q->select('tags.id','tags.tag','tags.created_at');
        }])
        ->first();

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found '
            ], 400);
        }
        $post_data = [
            'title' => $post->title,
            'comments' => $post->comments,
            'tags' => $post->tags
        ];

        return $this->_sendResponse("Single Post retrieved successfully.",$post_data);
    }
    public function add_comment_tags(PostUpdateRequest $request){

        $comment =  !empty($request->comment) ? $request->comment : null;
        $tag =  !empty($request->tag) ? $request->tag : null;
        $post_id =  $request->post_id;
        $user_id = Auth::user()->id;
        $post = Post::with(['comments','tags'])->find($post_id);
        if(!$post){
            return $this->_sendErrorResponse("Please enter valid post");
        }
        if($comment){
            Comment::insert([
                'post_id' => $post_id,
                'user_id' => $user_id,
                'comment' => $comment
            ]);
        }
        if($tag){
            $tag_ids=Tag::create(['tag'=>$tag]);
            $posttag=new Posttag;
            $posttag->tag_id = $tag_ids->id;
            $posttag->post_id = $post->id;
            $posttag->save();
        }
        if($comment || $tag){
            $post = Post::with(['comments','tags'])->find($post_id);
        }
        return $this->_sendResponse("Post updated successfully.",$post);
    }
}
