<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;

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
