<?php

namespace App\Http\Controllers;

use App\Project;
use App\Milestone;
use Illuminate\Http\Request;

class MilestoneController extends Controller {
	const MILESTONE_STATUS = 'enum.milestone_status';

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$projectId = $request->get('projectId');
		$milestones = Project::findOrFail($projectId)->milestones;

		return view('projects.milestones.index', compact('milestones'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$validatedAttributes = request()->validate([
			'name' => 'required|string',
			'project_id' => 'required|int',
			'previous_milestone_id' => 'required|int',
		]);

		$validatedAttributes['status'] = $request->get('status');

		$date = $request->get('done_date');
		if($date != null) {
			$date = $this->parseReqDate($date);
			$validatedAttributes['done_date'] = $date;
		}

		$milestone = Milestone::create($validatedAttributes);
		abort_if(!$milestone->exists, 500);

		Project::findOrFail($validatedAttributes['project_id'])->next_milestone($validatedAttributes['previous_milestone_id'])->update(array('previous_milestone_id' => $milestone->id));

		return $milestone;
	}


	private function parseReqDate($date) {
		$isodate = strtotime($date);
		$isodate = date("Y-m-d H:i:s", $isodate);
		return $isodate;
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $milestoneId
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, int $milestoneId) {
		// TODO: add validation here
		$milestone = Milestone::findOrFail($milestoneId);
		$attrs = $request->all();

		if($request['previous_milestone_id'] != $milestone->previous_milestone_id)
		{
			$old_next_milestone = Project::findOrFail($request['project_id'])->next_milestone($milestone->id);

			$old_prev_milestone = Milestone::find($milestone->previous_milestone_id);

			// get the updated milestone's new previous milestone
			$new_prev_milestone = Milestone::findOrFail($request['previous_milestone_id']);

			// update the milestone that comes after the new prev milestone
			$milestone_after_new_prev = Project::find($request['project_id'])->next_milestone($new_prev_milestone->id);

			if($milestone_after_new_prev)
			{
				$milestone_after_new_prev->update(array('previous_milestone_id' => $milestone->id));
			}

			if($old_next_milestone)
			{
				if($old_prev_milestone)
				{
					$old_next_milestone->update(array('previous_milestone_id' => $old_prev_milestone->id));
				}
				else
				{
					$old_next_milestone->update(array('previous_milestone_id' => null));
				}
			}
		}

		$date = $attrs['done_date'];
		if($date != null) {
			$attrs['done_date'] = $this->parseReqDate($date);
		}

		$milestone->update($attrs);

		return $milestone;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $milestoneId
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(int $milestoneId) {
		$milestone = Milestone::findOrFail($milestoneId);
		$milestone->destroy();
	}

	/**
	 * Create the default 5 milestones for a project.
	 *
	 * @param  int  $projectId
	 */
	public static function createDefaultMilestones(int $projectId) {
		$milestoneIdeation = new Milestone(['name' => 'Ideation',
			'status' => config(self::MILESTONE_STATUS)['current'],
			'done_date' => null,
			'project_id' => $projectId,
			'previous_milestone_id' => null]);
		$milestoneIdeation->save();

		$milestoneDesign = new Milestone(['name' => 'Design',
			'status' => null,
			'done_date' => null,
			'project_id' => $projectId,
			'previous_milestone_id' => $milestoneIdeation->id]);
		$milestoneDesign->save();

		$milestonePlanning = new Milestone(['name' => 'Planning',
			'status' => null,
			'done_date' => null,
			'project_id' => $projectId,
			'previous_milestone_id' => $milestoneDesign->id]);
		$milestonePlanning->save();

		$milestoneExecution = new Milestone(['name' => 'Execution',
			'status' => null,
			'done_date' => null,
			'project_id' => $projectId,
			'previous_milestone_id' => $milestonePlanning->id]);
		$milestoneExecution->save();

		$milestoneTest = new Milestone(['name' => 'Test',
			'status' => null,
			'done_date' => null,
			'project_id' => $projectId,
			'previous_milestone_id' => $milestoneExecution->id]);
		$milestoneTest->save();
	}
}
