<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('approval_actions_mast', function (Blueprint $table){
          $table->bigIncrements('id');
          $table->string('name');
          $table->text('description')->nullable();
          $table->smallInteger('reverse')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });

      Schema::create('leave_mast', function (Blueprint $table) {
        $table->bigIncrements('id');
    		$table->string('name');
    		$table->decimal('total',8,2)->default('0.0');
        $table->decimal('generate_days',8,2)->default('0.0');
    		$table->integer('generates_after')->nullable();  // (days count)
        $table->integer('carry')->nullable();
				$table->decimal('max_apply_once',8,2)->nullable();
				$table->decimal('min_apply_once',8,2)->nullable();
				$table->decimal('max_days_month',8,2)->nullable();
				$table->integer('max_apply_month')->nullable();// (how many times, user can apply)
				$table->integer('max_apply_year')->nullable();
				$table->boolean('carry_forward')->nullable();
        $table->integer('docs_required')->nullable();
        $table->integer('without_pay')->default(0.0);
        $table->integer('dont_show')->nullable();
        $table->timestamps();
        $table->softDeletes();
      });

      Schema::create('emp_leave_allotment', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('leave_mast_id');
          $table->integer('user_id');
          $table->integer('status')->default(1);
          $table->date('start');
          $table->date('end');
          $table->decimal('initial_bal',8,2)->default('0.0');
          $table->decimal('current_bal',8,2)->default('0.0');
          $table->date('generated_at')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });

      Schema::create('leave_allotment_detail', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('leave_mast_id');
          $table->integer('user_id');
          $table->smallInteger('status')->default(1);
          $table->date('start');
          $table->date('end');
          $table->decimal('initial_bal',8,2)->default('0.0');
          $table->decimal('current_bal',8,2)->default('0.0');
          $table->date('generated_at')->nullable();  // (days count)
          $table->timestamps();
          $table->softDeletes();
      });

      Schema::create('emp_leave_applies', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('user_id');
          $table->integer('reports_to');
          $table->integer('leave_type_id');
          $table->char('day_status', 1)->nullable();
          $table->date('from');
          $table->date('to')->nullable();
          $table->decimal('count',8,2);
          $table->text('reason')->nullable();
          $table->string('file_path', 200)->nullable();
          $table->text('addr_during_leave')->nullable();
          $table->string('contact_no',12)->nullable();
          $table->text('applicant_remark')->nullable();
          $table->decimal('paid_count', 8,2)->nullable();
          $table->decimal('unpaid_count', 8,2)->nullable();
          $table->integer('subadmin_approval')->default(0);
          $table->integer('admin_approval')->default(0);
          $table->text('approver_remark')->nullable();
          $table->text('hr_remark')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });

      Schema::create('holidays', function (Blueprint $table){
          $table->bigIncrements('id');
          $table->string('title');
          $table->date('date');
          $table->string('desc')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });

      Schema::create('leave_approval_detail', function (Blueprint $table){
          $table->bigIncrements('id');
          $table->integer('leave_apply_id');
          $table->integer('user_id');
          $table->integer('approver_id');
          $table->integer('actions');
          $table->decimal('paid_count', 8,2)->nullable();
          $table->decimal('unpaid_count', 8,2)->nullable();
          $table->decimal('carry', 8,2)->nullable();
          $table->string('approver_remark')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });

/*****

      Schema::create('activity', function (Blueprint $table){
          $table->bigIncrements('id');
          $table->string('title');
          $table->string('desc');
      });

      Schema::create('leave_period', function(Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name');
          $table->string('start');
          $table->string('end');
          $table->timestamps();
          $table->softDeletes();

      });

      Schema::create('leave_approval_mast', function (Blueprint $table){
          $table->bigIncrements('id');
          $table->integer('act_id');
          $table->string('title');
          $table->string('approve');
          $table->string('decline');
          $table->string('cancel');
          $table->string('hold');
          $table->string('skip');
          $table->string('desc');
      });

      Schema::create('approval_designation', function (Blueprint $table){
          $table->bigIncrements('id');
          $table->string('desig_id');
          $table->string('approval_id');
          $table->timestamps();
          $table->softDeletes();
      });

      

      Schema::create('approval_setup_mast', function (Blueprint $table){
          $table->bigIncrements('id');
          $table->integer('emp_id');
          $table->integer('dept_id');
          $table->integer('designations_id');
          $table->integer('activity_id');
          $table->text('actions_id');
          $table->integer('ordering')
      });

      Schema::create('permission_alias', function (Blueprint $table){
        $table->bigIncrements('id');
        $table->string('permission_id');
        $table->string('alias');
        $table->timestamps();
      })


      Schema::create('leave_type_mast', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name',100);
          $table->text('description')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });
******/

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      
      Schema::dropIfExists('approval_actions_mast');
      Schema::dropIfExists('leave_mast');
      Schema::dropIfExists('emp_leave_applies');
      Schema::dropIfExists('emp_leave_allotment');
      Schema::dropIfExists('holidays');
      Schema::dropIfExists('leave_approval_detail');


/***
      Schema::dropIfExists('approval_designation');
      Schema::dropIfExists('leave_approval_mast');
      Schema::dropIfExists('approval_setup_mast');
      Schema::dropIfExists('activity'); 
      Schema::dropIfExists('permission_alias');
      Schema::dropIfExists('leave_type_mast');
***/
    }
}
