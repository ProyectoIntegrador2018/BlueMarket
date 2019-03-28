<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\View
	 */
	public function index(Request $request) {
		$searchQuery = $request->get('search');
		$paginationSize = $request->get('paginationSize');

		if (!isset($paginationSize)) {
			$paginationSize = 25;
		}

		if (isset($searchQuery) && !empty($searchQuery)) {
			$users = User::where('name', 'like', "%{$searchQuery}%")->orWhere('email', 'like', "%{$searchQuery}%")->latest()->simplePaginate(paginationSize);
		} else {
			$users = User::all()->latest()->simplePaginate(paginationSize);
		}

		return view('admin.users.index', ['users' => $users]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\View
	 */
	public function create() {
		return view('admin.users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {
		$validatedAttributes = request()->validate([
			'name' => 'required|string',
			'email' => 'required|string',
			'role' => 'required|integer'
		]);

		$user = User::create($validatedAttributes);
		if (!isset($user)) {
			abort(500);
		}

		return redirect('users')->with('flash_message', 'User added!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View
	 */
	public function show(int $id) {
		$user = User::find($id);
		return view('admin.users.show', ['user' => $user]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View
	 */
	public function edit(int $id) {
		$user = User::find($id);
		return view('admin.users.edit', ['user' => $user]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(Request $request, int $id) {
		$user = User::findOrFail($id);
		$user->update($request->all());

		return redirect('users')->with('flash_message', 'User updated!');
	}
}