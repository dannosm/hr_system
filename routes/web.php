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

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/attendance', 'attendanceController@index');
Route::post('/attendance/get', 'attendanceController@attendance_get');

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


//multiple Documents
Route::get('/multiple-documents', 'multipleDocumentController@index');
Route::get('/multiple-documents/add', 'multipleDocumentController@multiple_document_add');
Route::get('/multiple-documents/edit/{id?}', 'multipleDocumentController@multiple_document_edit');
Route::post('/multiple-documents/get', 'multipleDocumentController@multiple_document_get');
Route::post('/multiple-documents/save', 'multipleDocumentController@multiple_document_save');
Route::post('/multiple-documents/update', 'multipleDocumentController@multiple_document_update');
Route::post('/multiple-documents/delete', 'multipleDocumentController@multiple_document_delete');









Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

/*Route::get('/home', function (Post $post) {
   Route::get('/home', 'HomeController@index')->name('home');
})->middleware('can:update,post');
*/
