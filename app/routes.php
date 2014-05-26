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

Route::get('/', array('as'=>'home',function()
{
	return View::make('hello');
}));

Route::get('auth/login/{co_id}', array('as'=>'user.login', 'uses'=>'UsersController@getUserLogin'));
Route::post('auth/login/{co_id}', array('as'=>'user.login.post', 'uses'=>'UsersController@postUserLogin'));
Route::get('auth/logout', function(){
	$co_id = Session::get('co_id');
	Session::flush();
	return Redirect::route('user.login', $co_id);
});

Route::group(array('before' => 'auth.mobile'), function()
{
	Route::get('mobile/order/search', array('as'=>'mobile.order.search', 'uses'=>'OrdersController@searchListMobile'));
	Route::post('mobile/order/search', array('as'=>'mobile.order.search.post', 'uses'=>'OrdersController@searchListMobile'));
});

Route::get('mobile/order/today/{co_id}', array('as'=>'mobile.order.today', 'uses'=>'OrdersController@getTodayMobile'));
Route::get('mobile/order/todaylist/{co_id}', array('as'=>'mobile.order.todaylist', 'uses'=>'OrdersController@getTodayListMobile'));

Route::get('auth/admin/logout', array('as'=>'user.admin.logout', 'uses'=>'UsersController@getAdminLogout'));
Route::get('auth/admin/login', array('as'=>'user.admin.login', 'uses'=>'UsersController@getAdminLogin'));
Route::post('auth/admin/login', array('as'=>'user.admin.login.post', 'uses'=>'UsersController@postAdminLogin'));

Route::group(array('before'=>'auth.user'), function()
{
	Route::get('user/profile', array('as'=>'user.profile', 'uses'=>'UsersController@getUserProfile'));
	Route::post('user/profile', array('as'=>'user.profile.post', 'uses'=>'UsersController@postUserProfile'));

	Route::get('user/order/{co_id}', array('as'=>'user.order', 'uses'=>'OrdersController@getUserOrder'));
	Route::post('user/order', array('as'=>'user.order.post', 'uses'=>'OrdersController@postUserOrder'));
});

Route::get('admin/logout', array('as'=>'admin.logout', 'uses'=>'UsersController@getLogout'));
Route::get('admin/login', array('as'=>'admin.login', 'uses'=>'UsersController@getLogin'));
Route::post('admin/login', array('as'=>'admin.login.post', 'uses'=>'UsersController@postLogin'));
Route::group(array('before' => 'auth'), function()
{
	Route::resource('users', 'UsersController');
	Route::resource('departments', 'DepartmentsController');
	Route::resource('news', 'NewsController');
	Route::resource('orders', 'OrdersController');
	Route::get('admin/profile', array('as'=>'admin.profile', 'uses'=>'UsersController@getProfile'));
	Route::post('admin/profile', array('as'=>'admin.profile.post', 'uses'=>'UsersController@postProfile'));
	Route::get('order/search', array('as'=>'order.search', 'uses'=>'OrdersController@searchList'));
	Route::post('order/search', array('as'=>'order.search.post', 'uses'=>'OrdersController@searchList'));
	Route::get('order/today', array('as'=>'order.today', 'uses'=>'OrdersController@getToday'));
	Route::get('order/todaylist', array('as'=>'order.todaylist', 'uses'=>'OrdersController@getTodayList'));
});
Route::group(array('before' => 'auth.admin'), function()
{
	Route::resource('companies', 'CompaniesController');
});

Route::group(array('prefix' => 'api'), function()
{
	//
	Route::get('companies', function(){
		return Response::json(array(
	        'data' => Company::all()->toArray(),
	        'totalCount'=> Company::count()
		));
	});

	Route::get('companies/{co_id}', function($co_id){
		$list = Company::find($co_id);
		return Response::json(array(
	        'data' => array($list->toArray()),
	        'totalCount'=> count($list)
		));
	});

	Route::get('users/{user_id}', function($user_id){
		$list = User::find($user_id);
		return Response::json(array(
	        'data' => array($list->toArray()),
	        'totalCount'=> count($list)
		));
	});

	Route::get('news/{news_id}', function($news_id){
		$list = News::find($news_id);
		return Response::json(array(
	        'data' => array($list->toArray()),
	        'totalCount'=> count($list)
		));
	});

	Route::get('orders/{user_id}', function($user_id){
		$today = date('Y-m-d 00:00:00', time());
		$list = Order::where('user_id', $user_id)->where('created_at', '>', $today)->first();
		return Response::json(array(
	        'data' => array($list->toArray()),
	        'totalCount'=> count($list)
		));
	});

	Route::get('departments/{department_id}', function($department_id){
		$list = Department::find($department_id);
		return Response::json(array(
	        'data' => array($list->toArray()),
	        'totalCount'=> count($list)
		));
	});


	#当天统计
	Route::get('todayorder/{co_id}', array('as'=>'todayorder', 'uses'=>'OrdersController@getTodayOrder'));
	Route::get('todayorderlist/{co_id}/{type}', array('as'=>'todayorderlist', 'uses'=>'OrdersController@getTodayOrderList'));

	Route::get('userlist/{co_id}', array('as' => 'userlist', 'uses' => 'UsersController@userList'));
	Route::get('departmentlist/{co_id}', array('as' => 'departmentlist', 'uses' => 'DepartmentsController@departmentList'));
	Route::get('newslist/{co_id}', array('as' => 'newslist', 'uses' => 'NewsController@newsList'));
	Route::get('orderlist/{co_id}', array('as' => 'orderlist', 'uses' => 'OrdersController@orderList'));
	Route::get('loglist/{co_id}/{log_id}', array('as'=> 'loglist', 'uses'=>'LogsController@logList'));
	Route::post('postfingerprint/{user_id}', array('as'=>'postfingerprint', 'uses'=>'UsersController@postFingerprint'));
	Route::post('postorder/{co_id}/{order_id?}', array('as'=>'postorder', 'uses'=>'OrdersController@postOrder'));
});

