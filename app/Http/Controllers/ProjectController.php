<?php

namespace App\Http\Controllers;

use App\Project;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$projects = Project::all();
		return view('projects', compact('projects'));
	}

	public function show($id) {
		return view('projects.show', ['project' => Project::findOrFail($id)]);
	}

	public function create()
	{
		return view('registerProject', [
			'courses' => Auth::user()->EnrolledIn,
			'categories' => Tag::where('type', 2)->get(),
			'skillsets' => Tag::where('type', 1)->get()
		]);
	}

	public function store(Request $request) {
		$attributes = request()->validate([
			'name' => ['required'],
			'video' => ['present'],
			'long_description' => ['present'],
			'short_description' => ['present'],
			'photo' => ['present']
		]);

		$project = Project::create($attributes);
		return view('projects.show', ['project' => $project]);
	}
}
