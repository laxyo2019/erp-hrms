<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Route::get('login/{username}/{pass}', 'LoginController@login');
Route::post('/logout', 'LoginController@logout')->name('logout');
//Auth::routes(['register' => false]);


Route::resource('/information', 'InformationController');

Route::resource('/employee/leaves','Employee\LeavesController');


Route::group(['middleware' => ['role:hrms_teamlead']], function() {

	Route::get('leave-request/teamlead', 'HRD\LeavesController@indexTeamlead')->name('request.teamlead');

	route::post('leave-request/teamlead/{req_id}', 'HRD\LeavesController@tl_approval');

	Route::post('/reverse/teamlead/{req_id}', 'HRD\LeavesController@tl_reverse');

});

Route::group(['middleware' => ['role:hrms_hr']], function() {

	Route::get('leave-request/hr', 'HRD\LeavesController@indexHr')->name('request.hr');

	route::post('leave-request/hr/{req_id}', 'HRD\LeavesController@hr_approval');

	Route::post('/reverse/hr/{req_id}', 'HRD\LeavesController@hr_reverse');

});

Route::group(['middleware' => ['role:hrms_admin']], function() {

	Route::get('leave-request/admin', 'HRD\LeavesController@indexAdmin')->name('request.admin');

	route::post('leave-request/admin/{req_id}', 'HRD\LeavesController@admin_approval');

	Route::post('/reverse/admin/{req_id}', 'HRD\LeavesController@admin_reverse');
});

Route::resource('/birthday_wish','BirthdayWish');
Route::post('/import_birthday','BirthdayWish@import')->name('Birthday_user');
Route::get('/export_birthday','BirthdayWish@export')->name('Birthday_export_user');
Route::get('/birth_delete/{id}','BirthdayWish@destroy')->name('Birthday_destroy');
Route::get('/get_message','BirthdayWish@getMessage')->name('get_message');
Route::get('/create_message','BirthdayWish@create_message')->name('create_message');
Route::post('/save_message','BirthdayWish@save_message')->name('save_message');
Route::get('/edit_message/{id}','BirthdayWish@edit_message')->name('edit_message');
Route::post('/update_message/{id}','BirthdayWish@update_message')->name('update_message');

// Leave Requests

Route::resource('/hrd/leaves', 'HRD\LeavesController');

Route::group(['middleware' => ['role:hrms_admin|hrms_hr']], function() {

	Route::resource('/hrd/employees','HRD\EmployeesController');

	Route::resource('/leave-management/types', 'Leave\LeaveTypeController');
	Route::resource('/leave-management/allotments', 'Leave\AllotmentController');
	Route::resource('/leave-management/holidays', 'Leave\HolidayController');
	Route::resource('/settings/categories','Settings\CategoryController');
	Route::resource('/settings/designations','Settings\DesignationController');
	Route::resource('/settings/statuses','Settings\StatusController');
	Route::resource('/settings/grades','Settings\GradesController');

	/***Birthdays***/

	//Delete Employees Info

	Route::get('/hrd/employees/delete_row/{db_table}/{id}', 'HRD\EmployeesController@delete_row')->name('employee.delete_row');



	//Employee Save or Update Methods
	Route::prefix('hrd')->namespace('HRD')->group(function () {
		Route::post('/employees/{type}', 'EmployeesController@getForm');
		Route::post('/employees/insert_employee','EmployeesController@insert_employee');
		Route::post('/employee/save_main/{user_id}', 'EmployeesController@save_main')->name('employees.main');
		Route::post('/employee/save_personal/{user_id}', 'EmployeesController@save_personal')->name('employees.personal');
		Route::post('/employee/save_official/{user_id}', 'EmployeesController@save_official')->name('employees.official');
		Route::post('/employee/save_academics/{user_id}', 'EmployeesController@save_academics')->name('employees.academics');
		Route::post('/employee/save_experience/{user_id}', 'EmployeesController@save_experience')->name('employees.experience');
		Route::post('/employee/save_documents/{user_id}', 'EmployeesController@save_documents')->name('employees.documents');
		Route::post('/employee/save_nominee/{user_id}', 'EmployeesController@save_nominee')->name('employees.nominee');
		Route::post('/employees/save_bankdetails/{user_id}', 'EmployeesController@save_bankdetails')->name('employees.bankdetails');
		Route::post('/employees/save_familydetails/{user_id}', 'EmployeesController@save_familydetails')->name('employees.familydetails');
		
		
});
	Route::get('/familydetails/{id}/edit', 'HRD\EmployeesController@edit_familydetails')->name('edit.familydetails');
	Route::post('/familydetails/{id}/update', 'HRD\EmployeesController@update_family')->name('update.familydetails');

//Add Branches
	Route::resource('/branches', 'Settings\CompBranchController');

//Location > Branches
	Route::post('/location/branches', 'HRD\EmployeesController@showBranches')->name('company.branches');

//Employee Active/Inactive

	Route::post('employee/active/{user_id}', 'acl\UserController@active')->name('active');

// HRD > Employees Module
Route::get('employees/export/', 'HRD\EmployeesController@export')->name('employees.export');

//Download documents

Route::get('hrd/employees/download/{db_table}/{user_id}', 'HRD\EmployeesController@downloadDocs')->name('employees.download');

//Import Export

Route::post('import', 'HRD\EmployeesController@import')->name('employees.import');


// Master CRUD
Route::get('settings/mast_entity/{db_table}', 'MasterController@index')->name('mast_entity.all');
Route::get('settings/mast_entity', 'MasterController@start_page')->name('mast_entity.home');
Route::get('settings/mast_entity/{method}/{db_table}/{id?}', 'MasterController@createOrEditOrShow')->name('mast_entity.get');
Route::post('settings/mast_entity/{method}/{db_table}/{id?}', 'MasterController@storeOrUpdate')->name('mast_entity.post');
Route::delete('settings/mast_entity/{db_table}/{id}', 'MasterController@destroy')->name('mast_entity.delete');



/************Leave Management**************/

//Hold leaves or Reset
Route::get('leave-management/hold/{id}', 'Leave\AllotmentController@hold')->name('hold.leave');
Route::get('leave-management/reallot/{id}', 'Leave\AllotmentController@reallot')->name('reallot.leave');



//Export Import holidays

Route::post('holidays/import', 'Leave\HolidayController@import')->name('import.holidays');
Route::get('holidays/export', 'Leave\HolidayController@export')->name('export.holidays');

Route::get('/hrd/employees/show_page/{id}/{tab}','HRD\EmployeesController@show_page')->name('employee.show_page');


/*******ACL********/
 
Route::group(['middleware' => ['role:hrms_admin|hrms_hr']], function() {

	Route::resource('acl/permissions', 'acl\PermissionController');
	Route::resource('acl/roles', 'acl\RoleController');
	Route::resource('acl/users', 'acl\UserController');
	Route::post('user/assign/', 'acl\UserController@assign')->name('assign.role');

});

});

/*************************************/

/*******Leave Request**********/

Route::get('/leave-show/{id}', 'Employee\LeavesController@showrequest')->name('show.leave');

//Holidays



/*	create by kishan for export data using checkbox or unchecheked and view  enployee details*/

Route::get('/hrd/employees/view-details/{id}/{view}','HRD\EmployeesController@viewDetails')->name('employee.view-details');
Route::post('/hrd/employee/save_session','HRD\EmployeesController@save_session')->name('employee.save_session');
Route::post('/hrd/employees/activeInactive','HRD\EmployeesController@activeInactive')->name('employee.active-inactive');

//...................................//

Route::get('/exp_table','HRD\EmployeesController@exp_table')->name('exp_table');

//HRD LEAVES


Route::post('/approve_leave/{leave_id}', 'HRD\LeavesController@approve_leave');


Route::post('employee/holidaycheck', 'Employee\LeavesController@holidayCheck')->name('holiday.check');

Route::get('leave-request/{id}/download', 'Employee\LeavesController@download')->name('request.document');
Route::get('balance', 'Employee\LeavesController@balance');


Route::post('/hrd/employees/fetch_designation','HRD\EmployeesController@fetch_designation')->name('employees.fetch_designation');

/*****************************************/
	//	Recruitement Requests

Route::resource('recruitment', 'recruitment\RequestController');




/** SubAdmin ***/
Route::get('recruit-posting/subadmin', 'recruitment\RecruitPostingController@indexSubAdmin')->name('recruit.subadmin');

Route::post('recruit-posting/subadmin/{id}', 'recruitment\RecruitPostingController@SubAdminApproval')->name('recruit.subadmin.approved');

/*** Admin ***/

Route::get('recruit-posting/admin', 'recruitment\RecruitPostingController@indexAdmin')->name('recruit.admin');

Route::post('recruit-posting/admin/{id}', 'recruitment\RecruitPostingController@AdminApproval')->name('recruit.admin.approved');

/*** HR ***/
Route::get('recruit-posting/hr', 'recruitment\RecruitPostingController@indexHr')->name('recruit.hr');

Route::post('recruit-posting/hr/{id}', 'recruitment\RecruitPostingController@HrApproval')->name('recruit.hr.approved');

Route::resource('recruit-posting', 'recruitment\RecruitPostingController', ['except' => 'index']);

/***Add Users with job posting respectivly***/

Route::get('/recruit/{job_id}/candidates', 'recruitment\CandidateController@index')->name('candidates.index');

Route::post('/recruit/candidates/store', 'recruitment\CandidateController@store')->name('candidates.store');

Route::get('/recruit/candidates/{id}', 'recruitment\CandidateController@show');

Route::delete('/recruit/candidate/{candidate_id}', 'recruitment\CandidateController@destroy')->name('candidates.destroy');

Route::get('candidate/{id}/download', 'recruitment\CandidateController@downloadResume')->name('download.resume');

// End of Recruitement Requests -----------


/******User Registration******/
//Route::get('auth/create', 'UserController@create');


Route::get('/home', 'HomeController@index')->name('home');


/*
 //Expanses

	Route::resource('/expenses/payments','Expenses\PaymentsController');

	Route::post('/expenses/accounts','Expenses\PaymentsController@account_mast')->name('account_mast');
	Route::post('/expenses/vendor_mast','Expenses\PaymentsController@vendor_mast')->name('vendor_mast');
	Route::get('payments/export/', 'Expenses\PaymentsController@export')->name('payments.export');
	Route::post('payments/imports/', 'Expenses\PaymentsController@import')->name('payments.imports');

	//Tours
	Route::get('expenses/tour/tour_stages/{id}','Expenses\ToursController@tour_stages')->name('tour.tour_stages');
	Route::get('expenses/tour/approve/{id}','Expenses\ToursController@approve')->name('tour.approve');
	Route::get('expenses/tour/start/{id}','Expenses\ToursController@start')->name('tour.start');
	Route::get('expenses/tour/end/{id}','Expenses\ToursController@end')->name('tour.end');
	Route::get('expenses/tour/decline/{id}','Expenses\ToursController@decline')->name('tour.decline');

	Route::resource('/expenses/vendors','Expenses\VendorsController');
	Route::resource('/expenses/tours','Expenses\ToursController');
	Route::resource('/settings/expense_in_user','Settings\ExpenseUserController');
	Route::resource('/settings/expense_permit_user','Settings\ExpensePermitUserController');

	//start Tendar section routing

	Route::resource('/tender_master', 'Tender\TenderController');
	Route::post('tender_master/{type}', 'Tender\TenderController@getForm');
	Route::post('tender_details/', 'Tender\TenderController@save_details');
	Route::post('delete_reco/', 'Tender\TenderController@delete_reco');
	Route::post('update_meeting/', 'Tender\TenderController@update_meeting');

	//Start Tender Type Controller  

	Route::resource('/tender_type', 'Tender\TenderTypeController');

	//End Tender Type Controller

	//Start Tender Categoty Controller

	Route::resource('/tender_category', 'Tender\TenderCategoryController');

	//End Tender Categoty Controller
	Route::group(['prefix' => 'tenders', 'namespace' => 'Tender'], function ()  {

	});
*/
//  Employee Leaves
/*
	Route::resource('/hrd/rules', 'HRD\LeavesController');
	Route::get('emp_leave','Employee\LeavesController@emp_leave')->name('emp_leave');
	Route::post('emp_leave_store','Employee\LeavesController@store')->name('emp_leave_store');
	Route::get('employee/leaves/{id}/create', 'Employee\LeavesController@applyform')->name('apply.leave');
	Route::get('/employee/apply_leaves/{id}','Employee\LeavesController@apply_leaves')->name('employee.apply_leaves');

	Route::post('/hrd/employees/leave-allotment/{id}', 'Leave\AllotmentController@store')->name('alloting.leave');

	
*/