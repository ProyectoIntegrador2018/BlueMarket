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
			'projectName' => ['required'],
			'videoPitch' => ['present'],
			'longDescription' => ['present'],
			'shortDescription'=> ['present'],
			'projectImage'=> ['present']
		]);

		$project = $this->saveRecord($attributes);
		if (!isset($project)) {
			abort(500);
		}

		return view('projects', ['project' => $project]);
	}

	private function saveRecord(array $attributes)
	{
		return Project::create([
			'name' => $attributes['projectName'],
			'video' => $attributes['videoPitch'],
			'long_description' => $attributes['longDescription'],
			'short_description' => $attributes['shortDescription'],
			'photo' => $attributes['projectImage']
		]);
	}
}
