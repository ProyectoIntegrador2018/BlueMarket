<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;

class NotificationController extends Controller
{
	const INVITES = 'enum.invite_status';
	const TYPE = 'enum.invite_type';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$teamInvites = Auth::user()->teamInvites;
		$projectInvites = Auth::user()->projectInvites;
		return view('notifications.index', compact('teamInvites', 'projectInvites'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Accept an invite to join a team or a project.
	 *
	 * @param  int $inviteId
	 * @return \Illuminate\Http\Response
	 */
	public function acceptInvite(Request $request) {
		$inviteId = $request->id;
		$inviteType = $request->invite_type;

		switch ($inviteType) {
			case config(self::TYPE)['team']:
				Auth::user()->teamInvites()->updateExistingPivot($inviteId, ['accepted' => config(self::INVITES)['accepted']]);
				break;

			case config(self::TYPE)['project']:
				Auth::user()->projectInvites()->updateExistingPivot($inviteId, ['accepted' => config(self::INVITES)['accepted']]);
				break;

			default:
				abort(400);
				break;
		}

		return ['success' => 'success'];
	}

	/**
	 * Decline an invite to join a team or a project.
	 *
	 * @param  int $inviteId
	 * @return \Illuminate\Http\Response
	 */
	public function declineInvite(Request $request) {
		$inviteId = $request->id;
		$inviteType = $request->invite_type;

		switch ($inviteType) {
			case config(self::TYPE)['team']:
				Auth::user()->teamInvites()->detach($inviteId);
				break;

			case config(self::TYPE)['project']:
				Auth::user()->projectInvites()->detach($inviteId);
				break;

			default:
				abort(400);
				break;
		}

		return ['success' => 'success'];
	}
}
