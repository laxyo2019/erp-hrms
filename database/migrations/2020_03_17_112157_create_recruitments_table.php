<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecruitmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruitments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('requested_by');
            $table->string('job_title_id');
            $table->string('comp_id');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('job_description')->nullable();
            $table->string('requirements')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('depart_id')->nullable();
            $table->string('employement_type_id')->nullable();
            $table->string('experience_level_id')->nullable();
            $table->string('education_level_id')->nullable();
            $table->string('hr_actions')->default(0);
            $table->string('subadmin_approval')->default(0);
            $table->string('admin_approval')->default(0);
            $table->timestamps();
        });

        Schema::create('recruit_candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('job_title_id');
            $table->string('candidate_name')->nullable();
            $table->string('education_level')->nullable();
            $table->string('contact')->nullable();
            $table->string('alt_contact')->nullable();
            $table->string('resume')->nullable();
            $table->string('candidate_details')->nullable();
            $table->integer('recruiter_approval')->default(0);
            $table->integer('hr_approval')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('recruitments');
        Schema::dropIfExists('recruit_candidates');
    }
}
