<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->increments('id');
			$table->string('name');
			$table->string('google_id')->unique()->nullable(); // required to implement several providers
			$table->string('email')->unique();
			$table->integer('role')->unsigned()->default(3); // default: student
			$table->string('picture_url')->nullable();
			$table->rememberToken();
			$table->timestamp('last_logon')->useCurrent();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
