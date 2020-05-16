<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('requested_amt');
            $table->string('sanctioned_amt')
            $table->string('sanctioned_on');
            $table->string('reason');
            $table->string('disbursed_amt');
            $table->string('disbursed_amt');
            $table->string('disbursed_amt');
            $table->string('disbursed_amt');
            $table->string('disbursed_amt');
            $table->string('disbursed_amt');
            $table->string('disbursed_amt');
            $table->string('disbursed_amt');
            $table->string('disbursed_amt');
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
        Schema::dropIfExists('loan');
    }
}
