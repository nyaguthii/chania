<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('daily_payment_id');
            $table->integer('amount');
            $table->string('receipt_no',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_receipts');
    }
}
