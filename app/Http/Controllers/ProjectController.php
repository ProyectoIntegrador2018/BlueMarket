<?php

namespace App\Http\Controllers;

use App\Project;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller {

	public function __construct() {
		$this->middleware('auth')->except(['index', 'show']);
	}

	public function index() {
		$projects = Project::with('tags:name')->get();
		$tags = Tag::all();
		return view('projects', compact('tags', 'projects'));
	}

	public function show($id) {
		return view('projects.details', ['project' => Project::findOrFail($id)]);
	}

	public function create() {
		return view(
			'projects.create', [
				'courses' => Auth::user()->enrolledIn,
				'teams' => Auth::user()->teamsLed()->get(),
				'labels' => Tag::where('type', 2)->get(),
				'skillsets' => Tag::where('type', 1)->get()
			]
		);
	}

	public function store(Request $request) {

		$attributes = request()->validate([
			'projectName' => ['required', 'min:3'],
			'videoPitch' => 'required',
			'longDescription' => 'required',
			'shortDescription' => 'required',
			'course' => 'required',
			'projectImage' => 'image',
			'newTeam' => 'required_without:existingTeam',
			'existingTeam' => 'required_without:newTeam',
			'labels' => 'required|array|min:1',
			// verify each elm in labels[] to exist as a label tag record
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

		// Save the team
		if(!empty($attributes['existingTeam']) && !empty($attributes['newTeam'])) {
			// You can't have both
			return redirect('projects/create')->withErrors([
				'bothTeams' => 'You can either create a new team, OR associate to an existing team, but not both.'
			])->withInput();
		}

		if(empty($attributes['existingTeam'])) {
			// Save a new team
			$team = new \App\Team();
			$team->name = $attributes['newTeam'];
			$team->leader_id = Auth::id();
			// TODO: should we add the team image here?
			abort_if(!$team->save(), 500);
			$team->members()->attach(Auth::id());
			$attributes['team_id'] = $team->id;
		}
		else {
			// Associate the team to the project
			$team_id = $attributes['existingTeam'];
			if(!$this->validateTeam($team_id, $attributes['course'])) {
				return redirect('projects/create')->withErrors([
					'teamMembership' => 'Some team members do not belong to the course you\'re trying to create this project in.'
				])->withInput();
			}

			$attributes['team_id'] = $team_id;
		}

		$project = $this->saveRecord($attributes);

		abort_if(!$project->exists, 500);

		$project->tags()->attach($attributes['skillsets']);
		$project->tags()->attach($attributes['labels']);

		return redirect()->action('ProjectController@show', ['id' => $project->id]);
	}

	private function validateTeam($team_id, $course_id) {
		// Check that all members in the team belong to the course that you're trying to create this project in
		$team = \App\Team::find($team_id);
		if(!$team->exists()) {
			return false;
		}

		foreach($team->members()->get() as $member) {
			if(!$member->enrolledIn()->where('course_id', $course_id)->exists()) {
				return false;
			}
		}

		return true;
	}

	private function saveRecord(array $attributes) {
		$path = isset($attributes['projectImage']) ? Storage::putFile('public', $attributes['projectImage']) : null;
		$path = $path != null ? Storage::url($path) : null;

		return Project::create([
			'name' => $attributes['projectName'],
			'video' => $this->formatYouTubeUrl($attributes['videoPitch']),
			'long_description' => $attributes['longDescription'],
			'short_description' => $attributes['shortDescription'],
			'course_id' => $attributes['course'],
			'team_id' => $attributes['team_id'],
			'photo' => $path
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
