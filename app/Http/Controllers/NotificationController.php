<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$teamInvites = Auth::user()->teamInvites;
		// projectInvites pending
		return view('notifications.index', compact('teamInvites'));
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
	 * Accept an invite to join a team.
	 *
	 * @param  int $inviteId
	 * @return \Illuminate\Http\Response
	 */
	public function acceptInviteToJoinTeam(int $inviteId) {
		DB::table('team_user')->where('id', $inviteId)->update(['has_accepted' => config(self::INVITES)['accepted']]);
	}

	/**
	 * Refuse an invite to join a team.
	 *
	 * @param  int $inviteId
	 * @return \Illuminate\Http\Response
	 */
	public function refuseInviteToJoinTeam(int $inviteId) {
		DB::table('team_user')->where('id', $inviteId)->delete();
	}

	/**
	 * Accept an invite to join a project.
	 *
	 * @param  int $inviteId
	 * @return \Illuminate\Http\Response
	 */
	public function acceptInviteToJoinProject(int $inviteId) {
		DB::table('project_user')->where('id', $inviteId)->update(['has_accepted' => config(self::INVITES)['accepted']]);
	}

	/**
	 * Refuse an invite to join a project.
	 *
	 * @param  int $inviteId
	 * @return \Illuminate\Http\Response
	 */
	public function refuseInviteToJoinProject(int $inviteId) {
		DB::table('project_user')->where('id', $inviteId)->delete();
	}
}
