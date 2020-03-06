<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    	Schema::create('hrms_comp_mast', function (Blueprint $table) {
			$table->increments('id');
			$table->string('account_code', 5)->default(10001);
			$table->string('name', 100);
			$table->string('description')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('hrms_nominee_type', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 100);
			$table->string('description')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('hrms_dept_mast', function (Blueprint $table) {
			$table->increments('id');
			$table->string('account_code', 5)->default(10001);
			$table->string('name', 100);
			$table->string('description')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

  		Schema::create('hrms_desg_mast', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('account_code', 5)->default(10001);
	        $table->string('name', 100);
	        $table->text('description')->nullable();
	        $table->timestamps();
	        $table->softDeletes();
    	});

    	Schema::create('hrms_marital_status', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('account_code', 5)->default(10001);
	        $table->string('name', 100);
	        $table->text('description')->nullable();
	        $table->timestamps();
	        $table->softDeletes();
    	});
		  
		Schema::create('hrms_emp_grade_mast',function(Blueprint $table){
			$table->increments('id');
			$table->string('account_code', 5)->default(10001);
			$table->string('name', 100);
			$table->decimal('entitled_amt', 8,2)->nullable();
			$table->text('description')->nullable();
			$table->timestamps();
			$table->softDeletes();  
		});
		Schema::create('hrms_emp_status_mast',function(Blueprint $table){
			$table->increments('id');
			$table->string('account_code', 5)->default(10001);
			$table->string('name', 100);
			$table->text('description')->nullable();
			$table->timestamps();
			$table->softDeletes();  
		});
		Schema::create('hrms_emp_type_mast',function(Blueprint $table){
			$table->increments('id');
			$table->string('account_code', 5)->default(10001);
			$table->string('name', 100);
			$table->text('description')->nullable();
			$table->timestamps();
			$table->softDeletes();  
		});

		
		Schema::create('hrms_approval_template', function (Blueprint $table) {
			$table->increments('id');
			$table->string('account_code', 5)->default(10001);
			$table->unsignedInteger('appr_id');
			$table->string('title', 100);
			$table->text('description')->nullable();
			$table->string('permits', 255);
			$table->integer('is_mandatory')->default(0);
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

    	Schema::dropIfExists('hrms_nominee_type');
    	Schema::dropIfExists('hrms_comp_mast');
    	Schema::dropIfExists('hrms_dept_mast');
    	Schema::dropIfExists('hrms_desg_mast');
        Schema::dropIfExists('hrms_approval_template');
        Schema::dropIfExists('hrms_emp_status_mast');
        Schema::dropIfExists('hrms_emp_grade_mast');
        Schema::dropIfExists('hrms_emp_type_mast');
        Schema::dropIfExists('hrms_marital_status');
    }
}
