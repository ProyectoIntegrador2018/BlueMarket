<?php

namespace App\Http\Controllers;

use App\Project;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
	public function __construct() {
		$this->middleware('auth')->except('index');
	}

	public function index() {
		$projects = Project::with('tags:name')->get();
		$tags = Tag::all();
		return view('projects', ['tags' => $tags, 'projects' => $projects]);
	}

	public function show($id) {
		return view('projects.details', ['project' => Project::findOrFail($id)]);
	}

	public function create() {
		return view(
			'projects.create', [
				'courses' => Auth::user()->EnrolledIn,
				'labels' => Tag::where('type', 2)->get(),
				'skillsets' => Tag::where('type', 1)->get()
			]
		);
	}

	public function store(Request $request) {
		$attributes = request()->validate([
			'projectName' => ['required'],
			'videoPitch' => ['required'],
			'longDescription' => ['required'],
			'shortDescription' => ['required'],
			'course' => ['required'],
			'projectImage' => ['required'],
			'labels' => 'required|array|min:1',
			// verify each elm in labels[] to exist as a labels tag record
			'labels.*' => [
				'integer',
				Rule::in(Tag::where('type', 2)->pluck('id')),
			],
			'skillsets' => 'required|array|min:1',
			// verify each elm in skillsets[] to exist as a skill tag record
			'skillsets.*' => [
				'integer',
				Rule::in(Tag::where('type', 1)->pluck('id')),
			]
		]);

		$project = $this->saveRecord($attributes);
		if (!$project->exists) {
			abort(500);
		}

		$project->tags()->attach($attributes['skillsets']);
		$project->tags()->attach($attributes['labels']);

		return view('projects', ['project' => $project]);
	}

	private function saveRecord(array $attributes) {
		return Project::create([
			'name' => $attributes['projectName'],
			'video' => $this->formatYouTubeUrl($attributes['videoPitch']),
			'long_description' => $attributes['longDescription'],
			'short_description' => $attributes['shortDescription'],
			'course_id' => $attributes['course'],
			'photo' => $attributes['projectImage']
		]);
	}

	// Possible inputUrl => https://www.youtube.com/watch?v=VzzwnsLX_5o
	// Possible inputUrl => https://youtu.be/VzzwnsLX_5o
	// Return embedUrl => https://www.youtube.com/embed/VzzwnsLX_5o
	private function formatYouTubeUrl($inputUrl) {
		//Regex that selects all url except id and replaces it with an empty string. Returns only the ID.
		$id = preg_replace('/((http(s)?:\/\/)?)(www\.)?((youtube\.com\/watch\?v=)|(youtu.be\/)|(youtube\.com\/embed\/))/', '', $inputUrl);
		$embedUrl = "https://www.youtube.com/embed/".$id;
		return $embedUrl;
	}
}
