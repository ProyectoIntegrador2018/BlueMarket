<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index(Request $request) {
		$keyword = $request->get('search');
		$perPage = 25;

		if (!empty($keyword)) {
			$users = User::latest()->paginate($perPage);
		} else {
			$users = User::latest()->paginate($perPage);
		}

		return view('test.users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create() {
		return view('test.users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {

		$requestData = $request->all();

		User::create($requestData);

		return redirect('users')->with('flash_message', 'User added!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 *
	 * @return \Illuminate\View\View
	 */
	public function show($id) {
		$user = User::findOrFail($id);

		return view('test.users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 *
	 * @return \Illuminate\View\View
	 */
	public function edit($id) {
		$user = User::findOrFail($id);

		return view('test.users.edit', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param  int  $id
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(Request $request, $id) {

		$requestData = $request->all();

		$user = User::findOrFail($id);
		$user->update($requestData);

		return redirect('users')->with('flash_message', 'User updated!');
	}
}
