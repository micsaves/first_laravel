<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('test',function(){
    return Auth ::user();
});

//Companies
Route::get('company', 'CompanyController@get_data')->middleware("auth");
Route::post('company', 'CompanyController@insert_data')->middleware("auth");


//Departments
Route::get('department', 'DepartmentController@get_data')->middleware("auth");
Route::post('department', 'DepartmentController@insert_data')->middleware("auth");

//Sections
Route::get('section', 'SectionController@get_data')->middleware("auth");
Route::post('section', 'SectionController@insert_data')->middleware("auth");

//Employees
Route::get('employee', 'EmployeeController@get_data')->middleware("auth");
Route::post('employee', 'EmployeeController@insert_data')->middleware("auth");



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
