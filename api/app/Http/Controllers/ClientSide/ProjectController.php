<?php

namespace App\Http\Controllers\ClientSide;

use App\Models\User;
use App\Models\Project;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * getProjects
     *
     * @return void
     */
    public function getProjects()
    {
        return Project::orderBy(Project::DATE, 'desc')->paginate(7);
    }
}
