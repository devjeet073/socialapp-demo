<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index() {
        $posts = Post::leftJoin('users','users.id','posts.user_id')
        ->select('posts.id','posts.title','users.name as author_name')
        ->withCount('comments')
        ->with('tags')
        ->orderBy('posts.created_at','desc')
        ->paginate(10);
        return view("posts",compact('posts'));
    }
}
