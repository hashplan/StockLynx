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
        Schema::create('valuation_trees', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->length(20)->unsigned();
            $table->bigInteger('tree_id')->length(20)->unsigned();
            $table->bigInteger('scenario_id')->length(20)->unsigned();
            $table->bigInteger('identifier')->length(20)->unsigned();
            $table->enum('class', array('Equity','Credit','Option'))->index();
            $table->enum('framework', array('Fundamental','Merger Arbitrage','Volatility Arbitrage','Distressed','Catalyst'))->index();
            $table->integer('level')->length(3)->unsigned();
            $table->string('scenario_name', 35);
            $table->string('scenario_comment', 300)->nullable();
            $table->enum('valuation_method', array('custom', 'multiple', 'yield'))->index();
            $table->string('valuation_date', 30)->nullable();
            $table->enum('metric', array('NULL','Net Income','EPS','EBITDA','Revenue','Levered FCF','Levered FCF per Share','Unlevered FCF','Dividend per Share'))->index();
            $table->double('metric_value',15,2)->nullable();
            $table->string('metric_comment', 300)->nullable();
            //$table->enum('modifier', array('NULL','multiple','yield'))->index();
            $table->float('modifier')->length(30)->index();
            $table->string('modifier_comment', 300)->nullable();
            //$table->bigInteger('cash')->length(20)->unsigned()->nullable();
            $table->double('percentage',5,2)->nullable();
            $table->double('cash',15,2)->nullable();
            $table->string('cash_comment', 300)->nullable();
            //$table->enum('debt', array('Current Portion', 'Long-term Portion', 'Minority Interest'))->index();
            $table->double('debt',15,2)->nullable();
            $table->string('debt_comment', 300)->nullable();
            $table->double('ev',15,2)->nullable();
            $table->double('mkt_cap',15,2)->nullable();
            $table->integer('diluted_shares')->length(5)->nullable();
            $table->float('discount_rate')->length(3)->nullable();
            $table->string('discount_rate_comment', 300)->nullable();
            $table->integer('discount_days')->length(1)->nullable();
            $table->double('value_per_share_raw',15,2)->nullable();
            $table->bigInteger('value_per_share_current')->length(11)->nullable();
            $table->string('valuation_comment', 300)->nullable();
        });

        $table_prefix = DB::getTablePrefix();
        DB::statement("ALTER TABLE `" . $table_prefix . "valuation_trees` CHANGE `class` `class` ENUM('Equity','Credit','Option');");
        DB::statement("ALTER TABLE `" . $table_prefix . "valuation_trees` CHANGE `framework` `framework` ENUM('Fundamental','Merger Arbitrage','Volatility Arbitrage','Distressed','Catalyst');");
        DB::statement("ALTER TABLE `" . $table_prefix . "valuation_trees` CHANGE `valuation_method` `valuation_method` ENUM('custom', 'multiple', 'yield');");
        DB::statement("ALTER TABLE `" . $table_prefix . "valuation_trees` CHANGE `metric` `metric` ENUM('NULL','Net Income','EPS','EBITDA','Revenue','Levered FCF','Levered FCF per Share','Unlevered FCF','Dividend per Share');");
//        DB::statement("ALTER TABLE `" . $table_prefix . "valuation_trees` CHANGE `modifier` `modifier` ENUM('NULL','multiple','yield');");
        DB::statement("ALTER TABLE `" . $table_prefix . "valuation_trees` CHANGE `debt` `debt` ENUM('Current Portion', 'Long-term Portion', 'Minority Interest');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('valuation_trees');
    }
}
