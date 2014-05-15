<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::route('admin.login');
});

Route::filter('auth.mobile', function()
{
	if (Auth::guest()) return Redirect::route('user.admin.login');
});

Route::filter('auth.admin', function()
{
	if (Auth::check() && Auth::user()->id != 1) return Redirect::route('users.index');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('auth.user', function()
{
	if (!Session::has('user_id')) return Redirect::to('auth/login/'.Route::input('co_id'));
});

function logs($co_id, $target, $action, $object_id)
{

	Logs::create(
		array(
			'co_id' => $co_id,
			'target' => $target,
			'action' => $action,
			'object_id' => $object_id,
		)
	);
}

function upload($file, $dir = null)
{
		if ($file)
		{
			// Generate random dir
			if ( ! $dir) $dir = str_random(8);

			// Get file info and try to move
			$destination = public_path() .  '/uploads/' . $dir;
			$filename    = $file->getClientOriginalName();
			$path        = '/uploads/' . $dir . '/' . $filename;
			$uploaded    = $file->move($destination, $filename);

			if ($uploaded) return $path;
		}
}

function punch($today, $department)
{	
	$re = 0;
   /* $now = date('H:i:s', strtotime($today));
    foreach ($department as $value) {
    	if ($now > $value->starttime and $now < $value->endtime) {
    		$re = 1;
    		break;
    	}
    }*/
    return $re;
}
