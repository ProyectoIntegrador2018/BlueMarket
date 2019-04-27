<?php

namespace App\Http\Controllers;

use App\Project;
use App\Milestone;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
	const MILESTONE_STATUS = 'enum.milestone_status';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$projectId = $request->get('projectId');
		$milestones = Project::findOrFail($projectId)->milestones;

		return view('projects.milestones.index', compact('milestones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.milestones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedAttributes = request()->validate([
			'name' => 'required|string',
			'project_id' => 'required|int',
		]);

		$milestone = Milestone::create($validatedAttributes);
		abort_if(!$milestone->exists, 500);

		return $milestone;
    }

    /**
     * Display the specified resource.
     *
	 * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
		$milestone = Milestone::findOrFail($id);
		return view('projects.milestones.details', compact('milestone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
	 * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
		$milestone = Milestone::findOrFail($id);
		return view('projects.milestones.edit', compact('milestone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
		$milestone = Milestone::findOrFail($id);
		$milestone->update($request->all());

		return $milestone;
    }

    /**
     * Remove the specified resource from storage.
     *
	 * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
		$milestone = Milestone::findOrFail($id);
        $milestone->destroy();
    }

    /**
     * Create the default 5 milestones for a project.
     *
	 * @param  int  $projectId
     */
    public static function createDefaultMilestones(int $projectId)
    {
		$milestoneIdeation = new Milestone(['name' => 'Ideation',
			'status' => config(self::MILESTONE_STATUS)['current'],
			'done_date' => null,
			'project_id' => $projectId,
			'previous_milestone_id' => null]);
		$milestoneIdeation->save();

		$milestonertDesign = new Milestone(['name' => 'Design',
			'status' => null,
			'done_date' => null,
			'project_id' => $projectId,
			'previous_milestone_id' => $milestonIdeation]);
		$milestonertDesign->save();

		$milestonePlanning = new Milestone(['name' => 'Planning',
			'status' => null,
			'done_date' => null,
			'project_id' => $projectId,
			'previous_milestone_id' => $milestonDesign]);
		$milestonePlanning->save();

		$milestonExecution = new Milestone(['name' => 'Execution',
			'status' => null,
			'done_date' => null,
			'project_id' => $projectId,
			'previous_milestone_id' => $milestonPlanning]);
		$milestonExecution->save();

		$milestonesertTest = new Milestone(['name' => 'Test',
			'status' => null,
			'done_date' => null,
			'project_id' => $projectId,
			'previous_milestone_id' => $milestonExecution]);
		$milestonesertTest->save();
    }
}
