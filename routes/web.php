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
//Ajax Query 
Route::get('/ajax-query-course-enrolled','QueriesController@getCourse');
Route::get('/ajax-query-account-balance','QueriesController@getBalance');
//End of Ajax queries

//Ajax Report
Route::get('/ajax-query-collection-monthly','CollectionReportController@getMonthly');
Route::get('/ajax-query-collection-yearly','CollectionReportController@getYearly');
Route::get('/ajax-query-collection-dateRange','CollectionReportController@getDateRange');

//Ajax
Route::get('/ajax-building','FloorController@getbuilding');
Route::get('/ajax-enrollee','HomeController@getEnrollee');
Route::get('/ajax-groupenrollee','EnrolleeController@getGroupenrollee');
Route::get('/ajax-manageclass-getAttendance','ManageClassController@getAttendance');
Route::get('/ajax-getOrg','EnrolleeController@getOrg');
Route::get('/ajax-floor','TrainingRoomController@getFloor');
Route::get('/ajax-floor-and-room','TrainingRoomController@getFAR');
Route::get('/ajax-room','TrainingRoomController@getRoom');
Route::get('ajax-type','RateController@ajaxType');

Route::get('/employee/update-firstname','EmployeeController@updateFirstName');
Route::get('/employee/update-address','EmployeeController@updateAddress');
Route::get('/employee/update-email','EmployeeController@updateEmail');
Route::get('/employee/update-dob','EmployeeController@updateDob');
Route::get('/employee/update-contact','EmployeeController@updateContact');

Route::post('/update-class','TrainingOfficerController@updateClass');

Route::get('/ajax-enrollee-schedule-fill','EnrollmentController@fillSchedule');

//home page
Route::get('/','HomeController@home');
Route::get('/facilities','HomeController@facilities');
Route::get('/programs','HomeController@programs');
Route::get('/courses','HomeController@courses');
Route::get('/iEnroll','HomeController@iApply');
Route::get('/registercourse','HomeController@courseRegister');
Route::post('/iApply/insert','HomeController@insertiApply');
Route::get('/next','HomeController@next');
Route::get('/thankyou','HomeController@thankyou');

//Login
Route::get('/login','LoginController@home');
Route::post('/login/prelogin','LoginController@validateUsers');
Route::get('/login/postlogin','LoginController@postLogin');
Route::get('/logout','LoginController@logout');
Route::post('/login/validateUsers','LoginController@validateUsers');
Route::get('/tlogin','LoginController@thome');
Route::post('/login/tvalidateUsers','LoginController@tvalidateUsers');

Route::get('receipt',function(){
	return view('pdf.receipt');	
});

Route::get('receipt/print/single','CollectionController@printReceiptS');
Route::get('receipt/print/group','CollectionController@printReceiptG');

//Queries
Route::get('queries','QueriesController@viewQueries');

//Reports

Route::get('reports/collectionreport','CollectionReportController@viewReport');

//Utilities

//Business Information
Route::get('/utilities/companyinfo', 'UtilitiesController@viewUtilities' );

//Configuration
Route::get('/maintenance/employee', 'EmployeeController@viewEmployee' );

//Printable
Route::get('/voucher','PrintController@voucher');
Route::get('/regicard','PrintController@regicard');
Route::post('/enrollmentreport','PrintController@setEnrollmentReport');
Route::get('/certificate/{id}','PrintController@certificate');

//Issuance of Certificate
Route::get('/issuance','IssuanceController@viewClass');
Route::get('/issuance/class','IssuanceController@viewDetailClass');
Route::post('/certificate/individual','IssuanceController@certificate');

//Enrollee//
//Single
Route::group(['middleware' => ['admin']],function(){
	Route::get('/manage_app/enrollee','EnrolleeController@viewTrainingclass');
	Route::get('/manage_app/enrollee/view/{id}','EnrolleeController@viewEnrollee');
	Route::post('/manage_app/enrollee/insert','EnrolleeController@insertEnrollee');
	Route::post('/manage_app/enrollee/application', 'EnrolleeController@application');
	Route::post('/manage_app/cancel','EnrolleeController@cancelEnrollee');

	//Group Enroll
	Route::get('/manage_app/genrollee','EnrolleeController@viewGEnrollee');
	Route::post('/manage_app/genrollee/insert','EnrolleeController@insertGEnrollee');
	Route::post('/manage_app/genrollee/update','EnrolleeController@updateGEnrollee');
	Route::get('/manage_app/genrollee/view/{id}','EnrolleeController@viewGroupEnrollee');
	Route::post('/manage_app/genrollee/view/set','EnrolleeController@markGroupEnrollee');
	Route::post('/manage_app/genrollee/application','EnrolleeController@viewGApplication');
	Route::post('/manage_app/genrollee/application/insert','EnrolleeController@insertGApplication');

	//Collection
	//Single
	Route::get('/view_accounts/next','CollectionController@viewNext');
	Route::get('/collection/single','CollectionController@viewSCollection');
	Route::get('/collection/single/account','CollectionController@viewAccount');
	Route::post('/collection/single/incash/insert','CollectionController@insertSCollection');

	//Group
	Route::get('/collection/group','CollectionController@viewCollection');
	Route::post('/collection/group/incash/insert','CollectionController@insertInCashCollection');
	Route::post('/collection/group/check/insert','CollectionController@insertCheckCollection');

	//Payment History
	Route::get('/collection/paymenthistory','CollectionController@viewHistory');

	//calendar
	Route::get('/calendar','EnrollmentController@viewCalendar');
	//Manage Enrollment
	Route::get('/manage_enrollment','EnrollmentController@viewEnrollment');
	Route::get('/manage_enrollment/set','EnrollmentController@setEnrollment');
	Route::post('/manage_enrollment/insert','EnrollmentController@insertEnrollment');
	Route::post('/manage_enrollment/update','EnrollmentController@updateEnrollment');
	Route::post('/manage_enrollment/updateDateStart','EnrollmentController@updateDateStart');
	Route::post('/manage_enrollment/enrollee','EnrollmentController@viewEnrollee');
	Route::post('/manage_enrollment/cancel','EnrollmentController@cancelEnrollment');
	Route::post('/manage_enrollment/cancelEnrollment','EnrollmentController@cancelEnrollee');
	Route::post('/manage_enrollment/nosession','EnrollmentController@nosession');


	//Manage Class
	Route::get('/manage_class','ManageClassController@viewClass');
	Route::post('/manage_class/setgrade','ManageClassController@setGrade');
	Route::get('/manage_class/grade','ManageClassController@viewGrade');
	Route::post('/manage_class/setattendance','ManageClassController@setAttendance');
	Route::get('/manage_class/attendance','ManageClassController@viewAttendance');
	Route::post('/attendance/insert','ManageClassController@insertAttendance');
	Route::post('/manage_class/grade/insert','ManageClassController@insertGrade');
	//Students
	//Route::get('/students','StudentController@viewStudents');

	//admin page
	Route::get('/admin', 'AdminController@home');
	Route::get('/manage_app/gapplication', 'AdminController@gapplication');

	//Maintenance//

	//Holiday
	Route::get('/maintenance/holiday','HolidayController@viewHoliday');
	Route::post('holiday/insert','HolidayController@insertHoliday');
	Route::post('holiday/update','HolidayController@updateHoliday');
	Route::post('holiday/delete','HolidayController@deleteHoliday');
	Route::get('/maintenance/holiday/archive','HolidayController@viewArchive');
	Route::post('holiday/activate','HolidayController@activateHoliday');
	//Employee
	Route::get('/maintenance/employee', 'EmployeeController@viewEmployee' );
	Route::post('/employee/insert', 'EmployeeController@createEmployee' );
	Route::post('/employee/update', 'EmployeeController@updateEmployee' );
	Route::post('/employee/delete', 'EmployeeController@deleteEmployee' );

	//Position
	Route::get('/maintenance/position','PositionController@viewPosition');
	Route::post('/position/insert','PositionController@createPosition');
	Route::post('/position/update','PositionController@updatePosition');
	Route::post('/position/delete','PositionController@deletePosition');

	//Training Officer
	Route::get('maintenance/tofficer','TOfficerController@viewTOfficer');
	Route::post('tofficer/insert','TOfficerController@insertTOfficer');
	Route::post('tofficer/update','TOfficerController@updateTOfficer');
	Route::post('tofficer/delete','TOfficerController@deleteTOfficer');
	Route::get('maintenance/tofficer/archive','TOfficerController@viewArchive');
	Route::post('tofficer/activate','TOfficerController@activateTOfficer');


	//Training Room
	Route::get('/maintenance/room','TrainingRoomController@viewRoom');
	Route::post('/room/insert','TrainingRoomController@createRoom');
	Route::post('/room/update','TrainingRoomController@updateRoom');
	Route::post('/room/delete','TrainingRoomController@deleteRoom');
	Route::get('/maintenance/room/archive','TrainingRoomController@viewArchive');
	Route::post('/room/activate','TrainingRoomController@activateRoom');

	//Building
	Route::get('/maintenance/building','BuildingController@viewBuilding');
	Route::post('/building/insert','BuildingController@insertBuilding');
	Route::post('/building/update','BuildingController@updateBuilding');
	Route::post('/building/delete','BuildingController@deleteBuilding');
	Route::get('/maintenance/building/archive','BuildingController@viewArchive');
	Route::post('/building/activate','BuildingController@activateBuilding');

	//Floor
	Route::get('/maintenance/floor','FloorController@viewFloor');
	Route::post('/floor/insert','FloorController@insertFloor');
	Route::post('/floor/update','FloorController@updateFloor');
	Route::post('/floor/delete','FloorController@deleteFloor');
	Route::get('/maintenance/floor/archive','FloorController@viewArchive');
	Route::post('/floor/activate','FloorController@activateFloor');

	//Vessel
	Route::get('/maintenance/vessel','VesselController@viewVessel');
	Route::post('/vessel/insert','VesselController@insertVessel');
	Route::post('/vessel/update','VesselController@updateVessel');
	Route::post('/vessel/delete','VesselController@deleteVessel');
	Route::get('/maintenance/vessel/archive','VesselController@viewArchive');
	Route::post('/vessel/activate','VesselController@activateVessel');


	//ProgramType
	Route::get('/maintenance/ptype','ProgramTypeController@viewType');
	Route::post('/type/insert','ProgramTypeController@insertType');
	Route::post('/type/update','ProgramTypeController@updateType');
	Route::post('/type/delete','ProgramTypeController@deleteType');
	Route::post('/type/activate','ProgramTypeController@activateType');
	Route::get('/maintenance/ptype/archive','ProgramTypeController@viewArchive');

	//Program
	Route::get('/maintenance/program','ProgramController@viewProgram');
	Route::post('program/insert','ProgramController@insertProgram');
	Route::post('program/update','ProgramController@updateProgram');
	Route::post('program/delete','ProgramController@deleteProgram');
	Route::get('/maintenance/program/archive','ProgramController@viewArchive');
	Route::post('program/activate','ProgramController@activateProgram');

	//Rate
	Route::get('/maintenance/rate','RateController@viewRate');
	Route::post('/rate/insert','RateController@insertRate');
	Route::post('/rate/update','RateController@updateRate');
	Route::post('/rate/delete','RateController@deleteRate');
	Route::get('/maintenance/rate/archive','RateController@viewArchive');
	Route::post('/rate/activate','RateController@activateRate');

	//Maintenance End//

	//Account Setting
	Route::get('/admin/accountsetting','AdminController@viewAccount');
	Route::post('/admin/update-image','AdminController@updateImage');
});

Route::group(['middleware' => ['TO']],function(){
	//Training Officer/tofficer/class/insertreport
	Route::get('/tofficer/','TrainingOfficerController@viewClass');
	Route::get('/tofficer/setclass','TrainingOfficerController@setClass');
	Route::get('/tofficer/class','TrainingOfficerController@Classes');
	Route::post('/tofficer/class/enrollee/update','TrainingOfficerController@updateEnrollee');
	Route::get('/tofficer/class/attendance','TrainingOfficerController@viewAttendance');
	Route::get('/tofficer/class/grade','TrainingOfficerController@viewGrade');
	Route::post('/tofficer/attendance/insert','TrainingOfficerController@insertAttendance');
	Route::post('/tofficer/grade/insert','TrainingOfficerController@insertGrade');

	//account
	Route::get('/tofficer/accountsetting','TrainingOfficerController@viewAccount');

	//ajax for training officer
	Route::post('/tofficer/update-image','TrainingOfficerController@updateImage');
	Route::get('/tofficer/update-firstname','TrainingOfficerController@updateFirstName');
	Route::get('/tofficer/update-address','TrainingOfficerController@updateAddress');
	Route::get('/tofficer/update-email','TrainingOfficerController@updateEmail');
	Route::get('/tofficer/update-dob','TrainingOfficerController@updateDob');
	Route::get('/tofficer/update-contact','TrainingOfficerController@updateContact');
});

Route::group(['middleware' => ['receptionist']],function(){
	//Receptionist
	Route::get('receptionist','ReceptionistController@home');
	Route::get('/receptionist/manage_enrollment/single/next','ReceptionistController@SNextStep');
	ROUTE::get('/receptionist/manage_enrollment/single/view','ReceptionistController@viewSingleClass');
	Route::get('/receptionist/manage_enrollment/sapplication/','ReceptionistController@SApplication');
	Route::post('/receptionist/manage_enrollment/sapplication/insert','ReceptionistController@insertSApplication');
	Route::get('/receptionist/manage_enrollment/group/view','ReceptionistController@viewGroupClass');
	Route::get('/receptionist/manage_enrollment/gapplication','ReceptionistController@GApplication');
	Route::post('/receptionist/manage_enrollment/gapplication/insert','ReceptionistController@insertGApplication');
	Route::post('/manage_enrollment/group/insert','ReceptionistController@insertGroup');
	Route::post('/manage_enrollment/group/finalize','ReceptionistController@finalizeGroup');

	//account settings
	Route::get('/receptionist/accountsetting','ReceptionistController@viewAccount');
	Route::post('/receptionist/update-image','ReceptionistController@updateImage');
});

Route::group(['middleware' => ['cashier']],function(){
	//Cashier
	Route::get('/cashier','CashierController@home');
	Route::get('/cashier/view_accounts/next','CashierController@viewNext');
	Route::get('/cashier/account','CashierController@viewAccount');
	Route::post('/cashier/insert','CashierController@insertPayment');
	//account settings
	Route::get('/cashier/accountsetting','CashierController@viewAccount');
	Route::post('/cashier/update-image','CashierController@updateImage');
});


?>