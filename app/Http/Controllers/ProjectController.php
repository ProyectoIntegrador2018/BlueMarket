<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
		$projects = Project::all();
		return view('projects.index', compact('projects'));
    }

    public function show($id)
    {
        return view('projects.show', ['project' => Project::findOrFail($id)]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
		$attributes = request()->validate([
	        'name' => ['required'],
	        'video' => ['present'],
	        'long_description' => ['present'],
	        'short_description'=> ['present'],
	        'photo'=> ['present']
	      ]);

	      $project = Project::create($attributes);
	      return view('projects.show', ['project' => $project]);
    }
}