<?php

namespace App\Http\Controllers\ClientSide;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Project\IndexResource;
use App\Http\Resources\Project\ShowResource;

class ProjectController extends Controller
{
    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $limit=7)
    {
        return new IndexResource(Project::orderBy(Project::DATE, 'desc')->paginate($limit));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return new ShowResource(Project::find($id));
    }
}
