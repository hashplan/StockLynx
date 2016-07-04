<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ValuationTree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valuation_tree', function (Blueprint $table) {
            $table->bigInteger('user_id', 20);
            $table->bigInteger('tree_id', 20);
            $table->bigInteger('scenario_id', 20);
            $table->bigInteger('identifier', 20);
            $table->string('class', 30);
            $table->string('framework', 20);
            $table->integer('level', 3);
            $table->string('scenario_name', 35);
            $table->string('scenario_comment', 300)->nullable();
            $table->string('valuation_method', 30);
            $table->string('valuation_date', 30)->nullable();
            $table->enum('metric', array('NULL','Net Income','EPS','EBITDA','Revenue','Levered FCF','Levered FCF per Share','Unlevered FCF','Dividend per Share'))->index();
            $table->string('metric_comment', 300)->nullable();
            $table->enum('modifier', array('NULL','multiple','yield'))->index();
            $table->string('modifier_comment', 300)->nullable();
            $table->bigInteger('cash', 20)->unsigned()->nullable();
            $table->string('cash_comment', 300)->nullable();
            $table->bigInteger('debt', 300)->unsigned()->nullable();
            $table->string('debt_comment', 300)->nullable();
            $table->bigInteger('ev', 20)->nullable();
            $table->bigInteger('mkt_cap', 20)->nullable();
            $table->integer('diluted_shares', 5)->nullable();
            $table->integer('discount_rate', 3)->nullable();
            $table->string('discount_rate_comment', 300)->nullable();
            $table->integer('discount_days', 1)->nullable();
            $table->bigInteger('value_per_share_raw', 11)->nullable();
            $table->bigInteger('value_per_share_current', 11)->nullable();
            $table->string('valuation_comment', 300)->nullable();
        });

        $table_prefix = DB::getTablePrefix();
        DB::statement("ALTER TABLE `" . $table_prefix . "valuation_tree` CHANGE `metric` `metric` SET('NULL','Net Income','EPS','EBITDA','Revenue','Levered FCF','Levered FCF per Share','Unlevered FCF','Dividend per Share');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('valuation_tree');
    }
}
