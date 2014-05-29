<?php

class UsersController extends \BaseController {

	public function getLogin()
	{
		return View::make('login');
	}

	public function getUserLogin($co_id)
	{
		if (Company::find($co_id)) {
			return View::make('users.login');
		}
	}

	public function getAdminLogin()
	{
		return View::make('adminlogin');
	}

	public function postAdminLogin()
	{
		$user = array(
			'adminphone'    => Input::get('name'),
			'password' => Input::get('password')
		);

			if (Auth::attempt($user)) 
			{	
			    return Redirect::route('mobile.todayorder');
			}
			else
			{   
				return Redirect::route('user.admin.login')->withErrors(array('login' => '登录失败，请检查你填写的信息是否正确！'));
		    }
	}

	public function getAdminLogout()
	{
		Auth::logout();
		return Redirect::route('user.admin.login');
	}

	public function postUserLogin($co_id, $type = 0)
	{
		$user = User::where('co_id', $co_id)->where('sn', Input::get('sn'))->first();
		if(isset($user->id)) {

			if (Hash::check(Input::get('password'), $user->password))
			{
			    //写session
			    Session::put('user_id', $user->id);
			    Session::put('name', $user->name);
			    Session::put('co_id', $co_id);
			    if ($type == 1) 
			    {
			    	return Redirect::route('mobile.order.travel');
			    }
			    return Redirect::route('user.order', $co_id); 
			}
		}

		return Redirect::back()->withInput()->withErrors(array('login' => '登录失败，请检查你填写的信息是否正确！'));
	}

	public function getProfile()
	{
		return View::make('profile')->with('company', Company::find(Auth::user()->id));
	}

	public function postProfile()
	{
		$attributes = array('name' => '员工姓名',
			'phone' => '手机号码',
		 );
		$validation = Validator::make(
			Input::all(),
			array(
				    'name' => 'required',
				    'phone' => 'required',
				   ),
				array(),
				$attributes	
			);

		if ($validation->passes())
		{

			$company = Company::find(Auth::user()->id);
			$company->name = Input::get('name');
			$company->phone = Input::get('phone');
			$company->issms = Input::get('issms') ? Input::get('issms') : 0;
			if (Input::get('password'))
			{
				$company->password = Hash::make(Input::get('password'));
			}
			$company->save();

			#更新管理员信息
			logs($company->id, 'company', 'U', $company->id);

			Notification::success('保存成功！');

			return Redirect::route('admin.profile');

	    } 

	    return Redirect::back()->withInput()->withErrors($validation->messages());

	}

	public function getUserProfile()
	{
		return View::make('users.profile')->with('user', User::find(Session::get('user_id')));
	}

	public function postUserProfile()
	{
		$attributes = array(
			'phone' => '手机号码',
		 );

		$validation = Validator::make(
			Input::all(),
			array(
				    'phone' => 'required',
				   ),
				   array(),
				   $attributes	
			);

		if ($validation->passes())
		{

			$user = User::find(Session::get('user_id'));
			$user->phone = Input::get('phone');
			if (Input::get('password'))
			{
				$user->password = Hash::make(Input::get('password'));
			}
			$user->save();

			Session::flash('success', '修改资料成功!');

			#更新管理员信息
			logs(Session::get('co_id'), 'user', 'U', $user->id);

			
			return Redirect::route('user.order', Session::get('co_id')); 
			#return Redirect::route('user.profile');
	    } 

	    return Redirect::back()->withInput()->withErrors($validation->messages());

	}

	public function postLogin()
	{
		$user = array(
			'name'    => Input::get('name'),
			'password' => Input::get('password')
		);

			if (Auth::attempt($user)) 
			{	
				if(Auth::user()->id == 1) {
					return Redirect::route('companies.index');
			    } else {
			    	return Redirect::route('users.index');
			    }
			}
			else
			{   
				return Redirect::route('admin.login')->withErrors(array('login' => '登录失败，请检查你填写的信息是否正确！'));
		    }
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::route('admin.login');
	}

	public function userList($co_id)
	{
		$list = User::where('co_id', $co_id)->get();
		return Response::json(array(
	        'data' => $list->toArray(),
	        'totalCount'=> $list->count()
		));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return View::make('users.index')->with('users', User::where('co_id', Auth::user()->id)->paginate(10));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//

		$attributes = array(
			'sn' => '员工工号',
			'name' => '员工姓名',
			'phone' => '手机号码',
		 );

		$validation = Validator::make(
			Input::all(),
			array(
				    'sn' => 'required',
					'name' => 'required',
					'phone' => 'required',				),
					array(),
					$attributes		
			);
        
        $count = User::where('co_id', Auth::user()->id)->count();

		if ($validation->passes())
		{
			$user = new User;
			$user->co_id   = Auth::user()->id;
			$user->sn   = Input::get('sn');
			$user->name   = Input::get('name');
			$user->password = Hash::make('111111');
			$user->phone = Input::get('phone');
			$user->iswork    = Input::get('iswork') ? Input::get('iswork') : 0;
			$user->fingerprint1 = $count + 1;
			$user->save();

			#新增员工
			logs(Auth::user()->id, 'user', 'I', $user->id);

			Notification::success('保存成功！');

			return Redirect::route('users.edit', $user->id);
		}

		return Redirect::back()->withInput()->withErrors($validation->messages());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		return View::make('users.show')->with('user',User::find($id));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		return View::make('users.edit')->with('user', User::find($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$attributes = array(
			'sn' => '员工工号',
			'name' => '员工姓名',
			'phone' => '手机号码',
		 );
		$validation = Validator::make(
			Input::all(),
			array(  
				    'sn' => 'required',
					'name' => 'required',
					'phone' => 'required',	
				),
				array(),
				$attributes		
			);

		if ($validation->passes())
		{
			$user = User::find($id);
			$user->sn   = Input::get('sn');
			$user->name   = Input::get('name');
			$user->phone    = Input::get('phone');
			$user->password = Input::get('password') ? Hash::make(Input::get('password')) : $user->password;
			$user->iswork    = Input::get('iswork') ? Input::get('iswork') : 0;
			$user->save();

			#修改员工
			logs(Auth::user()->id, 'user', 'U', $id);

			Notification::success('保存成功！');

			return Redirect::route('users.edit', $user->id);
		}

		return Redirect::back()->withInput()->withErrors($validation->messages());
	}


	public function postFingerprint($user_id)
	{
			$user = User::find($user_id);

			if (Input::hasFile('fingerprint1') && Input::hasFile('fingerprint2'))
			{
				$user->fingerprint1 = Input::get('fingerprint1');
				$user->fingerprint2 = Input::get('fingerprint2');
				//$user->fingerprint1 = Image::upload(Input::file('fingerprint1'), 'fingerprint1/' . $user->id);
				//$user->fingerprint2 = Image::upload(Input::file('fingerprint2'), 'fingerprint2/' . $user->id);
				$user->save();
			}

			$list = User::find($user_id);
			return Response::json(array(
		        'data' => array($list->toArray()),
		        'totalCount'=> count($list)
			));	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$user = User::find($id);
		$user->delete();

		#删除员工
		logs(Auth::user()->id, 'user', 'D', $id);

		Notification::success('删除成功！');

		return Redirect::route('users.index');
	}

}