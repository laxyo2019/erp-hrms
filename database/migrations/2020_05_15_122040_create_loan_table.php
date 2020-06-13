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
        Schema::create('hrms_loan_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('requested_amt', 10, 2);
            $table->string('interest_rate', 8, 2);
            $table->string('loan_type_id');
            $table->string('tenure');
            $table->string('emi');
            $table->integer('monthly_deduction', 10, 2);
            $table->string('reason');
            $table->string('sanctioned_date');
            $table->string('sanctioned_amt', 10, 2);
            $table->string('total_interest', 10, 2);
            $table->string('account_no');
            $table->smallinteger('posted');
            $table->smallinteger('hr_approval');
            $table->smallinteger('subadmin_approval');
            $table->smallinteger('admin_approval');
            $table->string('accountant_approval');
            $table->string('disburse_date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('hrms_loan_monthly_deduction', function (Blueprint, $table){
            $table->bigIncrements('id');
            $table->integer('loan_request_id');
            $table->integer('user_id');
            $table->integer('balance', 10, 2);
            $table->integer('deduction', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        })
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrms_loan_request');
        Schema::dropIfExists('hrms_loan_monthly_deduction');
    }
}
