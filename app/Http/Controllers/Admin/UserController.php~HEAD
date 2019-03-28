<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

/**
 * Admin UsersController
 */
class UserController extends AdminController {

	public function __construct() {
		// Add the auth
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the users.
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
			$users = User::where('name', 'like', "%{$searchQuery}%")->orWhere('email', 'like', "%{$searchQuery}%")->simplePaginate($paginationSize);
		}
		else {
			$users = User::simplePaginate($paginationSize);
		}

		return view('admin.users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new user.
	 *
	 * @return \Illuminate\View
	 */
	public function create() {
		return view('admin.users.create');
	}

	/**
	 * Store a newly created user in storage.
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
		abort_if(!$user->exists, 500);

		return redirect('users')->with('flash_message', 'User added!');
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View
	 */
	public function show(int $id) {
		$user = User::find($id);
		return view('admin.users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View
	 */
	public function edit(int $id) {
		$user = User::find($id);
		return view('admin.users.edit', compact('user'));
	}

	/**
	 * Update the specified user in storage.
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
