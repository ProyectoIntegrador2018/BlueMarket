<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_user', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('team_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->boolean('has_accepted')->default(config('enum.invite_status')['pending']);

			$table->foreign('team_id')->references('id')->on('teams');
			$table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('project_user');
    }
}
