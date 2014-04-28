<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::group(array('prefix' => 'api'), function()
{
	//
	Route::resource('users', 'UsersController');
	Route::resource('companies', 'CompaniesController');
	Route::resource('departments', 'DepartmentsController');
	Route::resource('news', 'NewsController');
	Route::resource('orders', 'OrdersController');

	Route::get('userlist/{co_id}', array('as' => 'userlist', 'uses' => 'UsersController@userlist'));
	Route::get('departmentlist/{co_id}', array('as' => 'departmentlist', 'uses' => 'DepartmentsController@departmentlist'));
	Route::get('newslist/{co_id}', array('as' => 'newslist', 'uses' => 'NewsController@newslist'));
	Route::get('orderlist/{co_id}', array('as' => 'orderlist', 'uses' => 'OrdersController@orderlist'));

});

