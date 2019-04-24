<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tasks', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
			$table->text('description');
			$table->dateTime('deadline')->nullable(false);
			$table->unsignedInteger('task_status'); // Enum [open, overdue, closed]
			$table->dateTime('completed_date')->nullable();

			// Foreign keys
			$table->unsignedInteger('closed_by')->nullable();
			$table->unsignedInteger('created_by')->nullable(false);
			$table->unsignedInteger('project_id')->nullable(false);

			$table->foreign('closed_by')->references('id')->on('users');
			$table->foreign('created_by')->references('id')->on('users');
			$table->foreign('project_id')->references('id')->on('projects');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('tasks');
	}
}
