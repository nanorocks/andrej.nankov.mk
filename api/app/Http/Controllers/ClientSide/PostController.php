<?php

namespace App\Http\Controllers\ClientSide;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post\IndexResource;
use App\Http\Resources\Post\ShowResource;

class PostController extends Controller
{
    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $limit=7)
    {
        return new IndexResource(Post::orderBy(Post::DATE, 'desc')->paginate($limit));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return new ShowResource(Post::find($id));
    }


    public function showByUuid(string $id)
    {
        return new ShowResource(Post::where(Post::UNIQUE_ID, $id)->first());
    }
}
