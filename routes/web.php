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

Route::get('/', function () {
 return view('auth.login');
});

Route::post('/setting/set-page', 'settingController@setting_set_page');


Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/attendance', 'attendanceController@index');
Route::post('/attendance/get', 'attendanceController@attendance_get');
Route::post('/attendance/update-data', 'attendanceController@attendance_update_data');


//usermaster
Route::get('/users', 'userController@index');
Route::get('/users/add', 'userController@user_add');
Route::get('/users/edit/{id?}', 'userController@user_edit');
Route::post('/users/get', 'userController@user_get');
Route::post('/users/save', 'userController@user_save');
Route::post('/users/update', 'userController@user_update');
Route::post('/users/delete', 'userController@user_delete');
Route::post('/users/check_language', 'userController@user_language');
Route::post('/users/save_language', 'userController@save_language');



//employee
Route::get('/employee', 'employeeController@index');
Route::get('/employee/add', 'employeeController@employee_add');
Route::get('/employee/edit/{id?}', 'employeeController@employee_edit');
Route::post('/employee/get', 'employeeController@employee_get');
Route::post('/employee/get-raw', 'employeeController@employee_get_raw');
Route::post('/employee/save', 'employeeController@employee_save');
Route::post('/employee/update', 'employeeController@employee_update');
Route::post('/employee/delete', 'employeeController@employee_delete');

//fingerptiny
Route::get('/finger-print/upload-user', 'fingerPrintController@finger_print_upload_user');
Route::get('/finger-print/export-absen', 'fingerPrintController@finger_print_export_absen');
Route::post('/master-fingerprint/get-list', 'fingerPrintController@finger_print_get_all_mesin');
Route::get('/finger-print', 'fingerPrintController@index');
Route::get('/finger-print/add', 'fingerPrintController@finger_print_add');
Route::get('/finger-print/edit/{id?}', 'fingerPrintController@finger_print_edit');
Route::post('/finger-print/get', 'fingerPrintController@finger_print_get');
Route::post('/finger-print/get-raw', 'fingerPrintController@finger_print_get_raw');
Route::post('/finger-print/save', 'fingerPrintController@finger_print_save');
Route::post('/finger-print/update', 'fingerPrintController@finger_print_update');
Route::post('/finger-print/delete', 'fingerPrintController@finger_print_delete');




//division
Route::get('/division', 'divisionController@index');
Route::get('/division/add', 'divisionController@division_add');
Route::get('/division/edit/{id?}', 'divisionController@division_edit');
Route::post('/division/get', 'divisionController@division_get');
Route::post('/division/get-raw', 'divisionController@division_get_raw');
Route::post('/division/save', 'divisionController@division_save');
Route::post('/division/update', 'divisionController@division_update');
Route::post('/division/delete', 'divisionController@division_delete');


//employee
Route::get('/position', 'positionController@index');
Route::get('/position/add', 'positionController@position_add');
Route::get('/position/edit/{id?}', 'positionController@position_edit');
Route::post('/position/get', 'positionController@position_get');
Route::post('/position/get-raw', 'positionController@position_get_raw');
Route::post('/position/save', 'positionController@position_save');
Route::post('/position/update', 'positionController@position_update');
Route::post('/position/delete', 'positionController@position_delete');


//shift
Route::get('/shift', 'shiftController@index');
Route::get('/shift/add', 'shiftController@shift_add');
Route::get('/shift/edit/{id?}', 'shiftController@shift_edit');
Route::post('/shift/get', 'shiftController@shift_get');
Route::post('/shift/save', 'shiftController@shift_save');
Route::post('/shift/update', 'shiftController@shift_update');
Route::post('/shift/delete', 'shiftController@shift_delete');
Route::post('/shift/print', 'shiftController@shift_print');

//shift module
Route::get('/shift-setting', 'shiftSettingController@index');
Route::post('/shift-setting/get', 'shiftSettingController@shift_setting_get');
Route::post('/shift-setting/update', 'shiftSettingController@shift_setting_update');
Route::post('/shift-setting/get-by-id', 'shiftSettingController@shift_setting_get_by_id');
Route::post('/shift-setting/get-by-id', 'shiftSettingController@shift_setting_get_by_id');






//loan
Route::get('/loan', 'loanController@index');
Route::get('/loan/add', 'loanController@loan_add');
Route::get('/loan/edit/{id?}', 'loanController@loan_edit');
Route::post('/loan/get', 'loanController@loan_get');
Route::post('/loan/save', 'loanController@loan_save');
Route::post('/loan/update', 'loanController@loan_update');
Route::post('/loan/delete', 'loanController@loan_delete');


//permission
Route::get('/permission', 'permissionController@index');
Route::get('/permission/add', 'permissionController@permission_add');
Route::get('/permission/edit/{id?}', 'permissionController@permission_edit');
Route::post('/permission/get', 'permissionController@permission_get');
Route::post('/permission/save', 'permissionController@permission_save');
Route::post('/permission/update', 'permissionController@permission_update');
Route::post('/permission/delete', 'permissionController@permission_delete');

//application letter
Route::get('/application-letter', 'applicationLetterController@index');
Route::get('/application-letter/add', 'applicationLetterController@application_letter_add');
Route::get('/application-letter/edit/{id?}', 'applicationLetterController@application_letter_edit');
Route::post('/application-letter/get', 'applicationLetterController@application_letter_get');
Route::post('/application-letter/save', 'applicationLetterController@application_letter_save');
Route::post('/application-letter/update', 'applicationLetterController@application_letter_update');
Route::post('/application-letter/delete', 'applicationLetterController@application_letter_delete');

//rekruitmen
Route::get('/rekruitmens', 'rekruitmenController@index');
Route::get('/rekruitmen/add', 'rekruitmenController@rekruitmen_add');
Route::get('/rekruitmen/edit/{id?}', 'rekruitmenController@rekruitmen_edit');
Route::post('/rekruitmen/get', 'rekruitmenController@rekruitmen_get');
Route::post('/rekruitmen/save', 'rekruitmenController@rekruitmen_save');
Route::post('/rekruitmen/update', 'rekruitmenController@rekruitmen_update');
Route::post('/rekruitmen/delete', 'rekruitmenController@rekruitmen_delete');


//multiple Documents
Route::get('/multiple-documents', 'multipleDocumentController@index');
Route::get('/multiple-documents/add', 'multipleDocumentController@multiple_document_add');
Route::get('/multiple-documents/edit/{id?}', 'multipleDocumentController@multiple_document_edit');
Route::post('/multiple-documents/get', 'multipleDocumentController@multiple_document_get');
Route::post('/multiple-documents/save', 'multipleDocumentController@multiple_document_save');
Route::post('/multiple-documents/update', 'multipleDocumentController@multiple_document_update');
Route::post('/multiple-documents/delete', 'multipleDocumentController@multiple_document_delete');


//payroll setting attribute
Route::get('/payroll/salary-attribute', 'payrollController@payroll_salary_attribute');
Route::get('/payroll-setting/edit/{id?}', 'payrollController@payroll_setting_edit');
Route::get('/payroll-setting/add', 'payrollController@payroll_setting_add');
Route::post('/payroll-setting/save', 'payrollController@payroll_setting_save');
Route::post('/payroll-setting/update', 'payrollController@payroll_setting_update');
Route::post('/payroll-setting/delete', 'payrollController@payroll_setting_delete');
Route::post('/payroll-setting/get', 'payrollController@payroll_setting_get');
Route::post('/payroll/salary-attribute-get', 'payrollController@payroll_salary_attribute_get');

//payroll add modul
//Route::post('/payroll-setting/save', 'payrollController@payroll_setting_save');

//pengaturan
Route::get('/setting', 'settingController@index');
Route::get('/setting/add', 'settingController@setting_add');
Route::get('/setting/edit/{id?}', 'settingController@setting_edit');
Route::post('/setting/get', 'settingController@setting_get');
Route::post('/setting/get-raw', 'settingController@setting_get_raw');
Route::post('/setting/save', 'settingController@setting_save');
Route::post('/setting/update', 'settingController@setting_update');
Route::post('/setting/delete', 'settingController@setting_delete');
Route::post('/setting/modul-save', 'settingController@setting_modul_save');



//role
Route::get('/role', 'roleController@index');
Route::get('/role/add', 'roleController@role_add');
Route::get('/role/edit/{id?}', 'roleController@role_edit');
Route::post('/role/get', 'roleController@role_get');
Route::get('/role/get-raw', 'roleController@role_get_raw');
Route::post('/role/save', 'roleController@role_save');
Route::post('/role/update', 'roleController@role_update');
Route::post('/role/delete', 'roleController@role_delete');

//group role
Route::get('/group-role', 'groupRoleController@index');
Route::get('/group-role/add', 'groupRoleController@group_role_add');
Route::get('/group-role/edit/{id?}', 'groupRoleController@group_role_edit');
Route::post('/group-role/get', 'groupRoleController@group_role_get');
Route::post('/group-role/get-raw', 'groupRoleController@group_role_get_raw');
Route::post('/group-role/save', 'groupRoleController@group_role_save');
Route::post('/group-role/update', 'groupRoleController@group_role_update');
Route::post('/group-role/delete', 'groupRoleController@group_role_delete');
Route::post('/group-role-detail/get-id', 'groupRoleController@group_role_detail_get_by_id');




Route::get('/payroll/print', 'payrollController@index');
Route::post('/payroll/get-data', 'payrollController@payroll_get_data');
Route::get('/payroll', 'payrollController@payroll');
Route::post('/payroll/get-payroll-list', 'payrollController@get_list_payroll');
Route::get('/payroll/sync', 'payrollController@payroll_sync');


//Route::get('/payroll/module', 'payrollController@payroll');

//salary module
Route::get('/salary-module', 'salaryModuleController@index');
Route::post('/salary-module/get', 'salaryModuleController@salary_module_get');
Route::get('/salary-module/{view?}/{id?}', 'salaryModuleController@salary_module_edit');


///extension
Route::post('/extension/attendance-late/save','extensionAttendanceController@extension_attendance_save');
Route::post('/extension/bpjs-ketenaga-kerjaan/save','extensionBPJSKetenagaKerjaanController@extension_bpjs_ketenaga_kerjaan_save');
Route::post('/extension/bpjs-kesehatan/save','extensionBPJSKesehatanController@extension_bpjs_kesehatan_save');












//modul
Route::post('/select2/get-raw', 'modul2Controller@select2_get_raw');
Route::get('/select2-group/get-like/{query?}', 'modul2Controller@select2_get_like');




Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

/*Route::get('/home', function (Post $post) {
   Route::get('/home', 'HomeController@index')->name('home');
})->middleware('can:update,post');
*/
