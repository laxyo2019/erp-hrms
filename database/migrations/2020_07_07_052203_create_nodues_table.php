<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoduesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrms_nodues_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->int('user_id');
            $table->int('department_id');
            $table->string('date_join');
            $table->string('date_leave');
            $table->string('reason_of_leaving');
            $table->string('assets_description');
            $table->json('hod_sale_depart');
            $table->json('hod_it_depart');
            $table->json('hod_accounts_depart');
            $table->string('posted');
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
        Schema::dropIfExists('hrms_nodues_request');
    }
}
