<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('amount');
            $table->string('type',10);
            $table->string('description',100);
            $table->date('transaction_date');
            $table->string('place',10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_transactions');
    }
}
