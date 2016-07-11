<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RosettaTrees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rosetta_trees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->length(10)->unsigned();
            $table->integer('stock_id')->length(10)->unsigned();
            $table->bigInteger('parent_id')->length(20)->unsigned()->nullable()->default(0);
            $table->string('name');
            $table->string('comment');
            $table->enum('status', array('ACTIVE','DELETED'))->index();
            $table->bigInteger('lft')->length(20)->unsigned();
            $table->bigInteger('rgt')->length(20)->unsigned();
            $table->smallInteger('depth')->length(7)->unsigned();
        });

        $table_prefix = DB::getTablePrefix();
        DB::statement("ALTER TABLE `" . $table_prefix . "rosetta_trees` CHANGE `status` `status` ENUM('ACTIVE','DELETED');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rosetta_trees');
    }
}
