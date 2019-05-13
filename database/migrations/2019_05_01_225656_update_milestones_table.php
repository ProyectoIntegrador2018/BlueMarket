<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('milestones', function (Blueprint $table) {
			$table->dropColumn('status');
			$table->dropForeign(['previous_milestone_id']);
			$table->foreign('previous_milestone_id')->references('id')->on('milestones')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('milestones', function (Blueprint $table) {
			$table->integer('status')->nullable();
			$table->dropForeign(['previous_milestone_id']);
			$table->foreign('previous_milestone_id')->references('id')->on('milestones');
        });
    }
}
