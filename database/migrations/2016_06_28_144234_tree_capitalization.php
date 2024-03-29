<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TreeCapitalization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tree_capitalizations', function (Blueprint $table) {
            $table->bigInteger('id')->length(20)->unsigned();
            $table->enum('type_capitalization', array('Outstanding','Option','ConvertibleBond','RSU (unvested)','Reduction (for Buyback)'))->index();
            $table->bigInteger('shares')->length(20)->unsigned();
            $table->bigInteger('debt_value')->length(20)->unsigned();
            $table->bigInteger('cash_value')->length(20)->unsigned();
            $table->bigInteger('exercise_price')->length(20)->unsigned();
        });

        $table_prefix = DB::getTablePrefix();
        DB::statement("ALTER TABLE `" . $table_prefix . "tree_capitalizations` CHANGE `type_capitalization` `type_capitalization` ENUM('Outstanding','Option','ConvertibleBond','RSU (unvested)','Reduction (for Buyback)');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tree_capitalizations');
    }
}
