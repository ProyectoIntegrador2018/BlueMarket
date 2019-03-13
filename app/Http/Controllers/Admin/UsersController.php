<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

/**
 * Admin UsersController
 */
class UsersController extends AdminController {

	public function __construct() {
		// Add the auth
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the users.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$users = User::all();
		return view('admin.users.index', compact('users'));
	}
}
