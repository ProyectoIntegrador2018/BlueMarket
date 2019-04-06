<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEnumNameToTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement("ALTER TABLE `tags` CHANGE `type` `type`
			ENUM('label','skill', 'category') CHARACTER SET utf8
			COLLATE utf8_general_ci NOT NULL;");

		DB::statement("UPDATE `tags` set `type` = 'label' where
			`type` = 'category';");

		DB::statement("ALTER TABLE `tags` CHANGE `type` `type`
			ENUM('label','skill') CHARACTER SET utf8 COLLATE
			utf8_general_ci NOT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement("ALTER TABLE `tags` CHANGE `type` `type`
		  ENUM('category','skill', 'label') CHARACTER SET utf8
		  COLLATE utf8_general_ci NOT NULL;");

		DB::statement("UPDATE `tags` set `type` = 'category' where
		  `type` = 'label';");

		DB::statement("ALTER TABLE `tags` CHANGE `type` `type`
		  ENUM('category','skill') CHARACTER SET utf8 COLLATE
		  utf8_general_ci NOT NULL;");
    }
}
