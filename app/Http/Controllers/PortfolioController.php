<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Skill;
use App\Models\Project;

class PortfolioController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderBy('id','desc')->get();
        $skills      = Skill::orderBy('category')->get()->groupBy('category');
        $projects    = Project::orderBy('id','desc')->get();

        return view('about', compact('experiences', 'skills', 'projects'));
    }
}
