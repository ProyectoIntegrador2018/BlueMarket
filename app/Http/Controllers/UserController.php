<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
	const ROLES = 'enum.user_roles';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$users = User::where('role', config(self::ROLES)['sys_admin'])->get();
		return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$user = User::create($request->all());
		$user->role = config(self::ROLES)['sys_admin'];
		$id = $user->id;

		return view('admin.users.show', ['user' => User::findOrFail($id)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
		$id = $user->id;

		if ($user->role != config(self::ROLES)['sys_admin']) {
			abort(400);
		}

        return view('admin.users.show', ['user' => User::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $id = $user->id;
        return view('admin.users.edit', ['user' => User::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
		$user->update($request->all());
		$id = $user->id;
		return view('admin.users.show', ['user' => User::findOrFail($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort(401);
    }
}
