<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeparationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrms_separations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emp_name');
            $table->string('emp_code');
            $table->string('requested_on');
            $table->string('separation_date');
            $table->string('reason');
            $string->string('short_description');
            $table->string('status');
            $table->smallInteger('hr_approval')->default(0);
            $table->smallInteger('subadmin_approval')->default(0);
            $table->smallInteger('admin_approval')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('hrms_staff_settlement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emp_name');
            $table->string('emp_code');
            $table->string('requested_on');
            $table->string('reason');
            $string->string('short_description');
            $table->string('status');
            $table->smallInteger('hr_approval')->default(0);
            $table->smallInteger('subadmin_approval')->default(0);
            $table->smallInteger('admin_approval')->default(0);
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
        Schema::dropIfExists('hrms_separations');
        Schema::dropIfExists('hrms_staff_settlement');
    }
}
