<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('policy_no');
            $table->unique('policy_no');
            $table->integer('customer_id');
            $table->date('effective_date');
            $table->date('expiry_date');
            $table->string('carrier');
            $table->integer('total_premium');
            $table->string('status');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policies');
    }
}
