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
            $table->string('interest_rate');
            $table->string('loan_type_id');
            $table->string('tenure');
            $table->string('emi');
            $table->string('monthly_deduction');
            $table->string('reason');
            $table->string('sanctioned_on');
            $table->string('sanctioned_amt');
            $table->smallinteger('hr_approval');
            $table->smallinteger('subadmin_approval');
            $table->smallinteger('admin_approval');
            $table->string('accountant_approval');
            $table->string('account_no');
            $table->string('disburse_date');
            $table->timestamps();
            $table->softDeletes();
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
