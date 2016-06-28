<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Stocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('securityID', 30);
            $table->string('ISIN', 12);
            $table->string('CUSIP', 9);
            $table->string('symbol', 10);
            $table->string('exchange', 50);
            $table->string('securityName', 300);
            $table->string('securityType', 100);
            $table->string('issuerID', 30);
            $table->string('issuerName', 200)->nullable();
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
        Schema::drop('stocks');
    }
}
