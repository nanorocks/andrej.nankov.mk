<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function getPosts()
    {
        return Post::orderBy(Post::DATE, 'desc')->paginate(4);
    }
}
