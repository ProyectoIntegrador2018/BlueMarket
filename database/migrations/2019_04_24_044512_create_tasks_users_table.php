<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
 * Creates the Assignments (Task_User) pivot table
 *
 */
class CreateTasksUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('task_user', function (Blueprint $table) {
			$table->integer('task_id')->unsigned();
			$table->integer('user_id')->unsigned();

			$table->primary(['task_id', 'user_id']);

			$table->foreign('task_id')->references('id')->on('tasks');
			$table->foreign('user_id')->references('id')->on('users');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('task_user');
	}
}
