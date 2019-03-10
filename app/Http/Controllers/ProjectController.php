<?php

namespace App\Http\Controllers;

use App\Project;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
	const PROJECTS = 'projects';
	const SKILLSETS = 'skillsets';
	const PRESENT = 'present';
	const CATEGORY = 'category';

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$projects = Project::all();
		return view(self::PROJECTS, compact(self::PROJECTS));
	}

	public function show($id) {
		return view('projects.show', ['project' => Project::findOrFail($id)]);
	}

	public function create() {
		return view(
			'registerProject', [
				'courses' => Auth::user()->EnrolledIn,
				'categories' => Tag::where('type', 2)->get(),
				self::SKILLSETS => Tag::where('type', 1)->get()
			]
		);
	}

	public function store(Request $request) {
		$attributes = request()->validate([
			'projectName' => ['required'],
			'videoPitch' => [self::PRESENT],
			'longDescription' => [self::PRESENT],
			'shortDescription' => [self::PRESENT],
			'projectImage' => [self::PRESENT],
			self::CATEGORY => [
				self::PRESENT,
				Rule::in(Tag::where('type', 2)->pluck('id'))
			],
			self::SKILLSETS => 'present|array|min:1',
			'skillsets.*' => [
				'integer',
				Rule::in(Tag::where('type', 1)->pluck('id')),
			]
		]);

		$project = $this->saveRecord($attributes);
		if (!isset($project)) {
			abort(500);
		}

		if (isset($attributes[self::SKILLSETS])) {
			$project->tags()->attach($attributes[self::SKILLSETS]);
		}

		if (isset($attributes[self::CATEGORY])) {
			$project->tags()->attach($attributes[self::CATEGORY]);
		}

		return view(self::PROJECTS, ['project' => $project]);
	}

	private function saveRecord(array $attributes) {
		return Project::create([
			'name' => $attributes['projectName'],
			'video' => $attributes['videoPitch'],
			'long_description' => $attributes['longDescription'],
			'short_description' => $attributes['shortDescription'],
			'photo' => $attributes['projectImage']
		]);
	}
}
