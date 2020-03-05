<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_mast', function (Blueprint $table) {
          
          //single row
          $table->increments('id');
          $table->integer('user_id');
          $table->integer('role_id')->nullable();
          $table->integer('branch_id')->nullable();
          $table->integer('status')->default(0);
          $table->unsignedInteger('reports_to')->nullable();
          $table->string('emp_code', 15)->nullable();
          $table->integer('active')->default(1);
          $table->unsignedInteger('comp_id')->nullable();
          $table->unsignedInteger('dept_id')->nullable();
          $table->unsignedInteger('desg_id')->nullable();
          $table->unsignedInteger('grade_id')->nullable();
          $table->string('emp_name', 50);
          $table->string('emp_img', 200)->default('emp_default_image.png');
          $table->enum('emp_gender', ['M', 'F', 'O'])->nullable();
          $table->string('emp_father', 5O)->nullable();
          $table->date('emp_dob')->nullable();
          $table->text('curr_addr')->nullable();
          $table->text('perm_addr')->nullable();
          $table->string('blood_grp',3)->nullable();
          $table->string('contact', 50)->nullable();
          $table->string('alt_contact', 50)->nullable();
          $table->string('email', 50)->nullable();
          $table->string('alt_email', 50)->nullable();
          $table->string('driv_lic', 20)->nullable();
          $table->string('aadhar_no', 20)->nullable();
          $table->string('voter_id', 20)->nullable();
          $table->string('pan_no', 20)->nullable();
          $table->string('passport_id')->nullable();
          $table->string('file_path')->nullable();
          $table->unsignedInteger('emp_type')->nullable();
          $table->unsignedInteger('emp_status')->nullable();
          $table->string('old_uan', 20)->nullable();
          $table->string('curr_uan', 20)->nullable();
          $table->string('old_pf', 20)->nullable();
          $table->string('curr_pf', 20)->nullable();
          $table->string('old_esi', 20)->nullable();
          $table->string('curr_esi', 20)->nullable();
          $table->string('passport_doc')->nullable();
          $table->date('join_dt')->nullable();
          $table->date('leave_dt')->nullable();
          $table->integer('leave_allotted')->nullable();
          $table->timestamps();
          $table->softDeletes();			
        });

        Schema::create('hrms_birthdays', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('user_id');
          $table->string('emp_name');
          $table->string('birth_date');
          $table->timestamps()
          $table->softDeletes();
        });

        Schema::create('hrms_emp_nominee', function (Blueprint $table) { //multiple rows
          $table->increments('id');
          $table->unsignedInteger('user_id');
          $table->integer('nominee_type_id');
          $table->string('name', 100);
          $table->string('email', 100)->nullable();
          $table->text('address')->nullable();
          $table->string('aadhar_no', 20)->nullable();
          $table->string('contact', 20)->nullable();
          $table->text('addr')->nullable();
          $table->string('file_path',200)->nullable(); // aadhar
          $table->string('relation', 20)->nullable();
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('hrms_emp_bank_details', function (Blueprint $table) { //mul rows
          $table->increments('id');
          $table->unsignedInteger('user_id');
          $table->string('acc_holder', 50)->nullable();
          $table->string('acc_no', 50)->nullable();
          $table->string('bank_name', 50)->nullable();
          $table->string('ifsc', 50)->nullable();
          $table->string('branch_name', 50)->nullable();
          $table->string('file_path',200)->nullable();
          $table->text('note')->nullbale();
          $table->boolean('is_primary')->default(0);
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('hrms_emp_academics', function (Blueprint $table) { //mul rows
          $table->increments('id');
          $table->unsignedInteger('user_id');
          $table->string('domain_of_study',90)->nullable();
          $table->string('name_of_unversity', 90)->nullable();
          $table->string('completed_in_year', 4)->nullable();
          $table->string('grade_or_pct', 10)->nullable();
          $table->string('file_path',200)->nullable();
          $table->text('note')->nullable();
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('hrms_emp_exp', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('user_id');
          $table->string('comp_name', 100);
          $table->string('job_type', 50)->nullable(); // Part-time, contract, full-time, etc
          $table->decimal('monthly_ctc', 8, 2)->nullable();
          $table->string('desg', 50)->nullable();
          $table->string('total_exp')->nullable();
          $table->string('comp_loc', 50)->nullable();
          $table->string('comp_email', 100)->nullable();
          $table->string('comp_website', 100)->nullable();
         	$table->date('start_dt')->nullable();
          $table->date('end_dt')->nullable();
          $table->text('reason_of_leaving')->nullable();
          $table->string('file_path',200)->nullable();
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('hrms_family_details', function (Blueprint $table ){
          $table->increments('id');
          $table->unsignedInteger('user_id');
          $table->string('father_name')->nullable();
          $table->string('mother_name')->nullable();
          $table->string('husband_name')->nullable();
          $table->string('wife_name')->nullable();
          $table->string('brother_name')->nullable();
          $table->string('sister_name')->nullable();
          $table->timestamps();
          $table->softDeletes();

        });

        Schema::create('hrms_emp_docs', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('user_id');
          $table->string('doc_type_id');
          $table->text('file_path')->nullable();
          $table->string('remarks')->nullable();
          $table->date('date');
          $table->char('doc_status', 10);  //Submitted, Pendng
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('hrms_comp_branch', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('comp_id')->nullable();
          $table->integer('city')->nullable();
          $table->text('address')->nullable();
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
      Schema::dropIfExists('hrms_emp_mast');
      Schema::dropIfExists('hrms_emp_nominee');
      Schema::dropIfExists('hrms_emp_bank_details');
      Schema::dropIfExists('hrms_emp_academics');
      Schema::dropIfExists('hrms_emp_exp');
      Schema::dropIfExists('hrms_emp_docs');
    }
}
