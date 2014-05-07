<?php

class CompaniesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return View::make('companies.index')->with('companies', Company::paginate(10));
		/*return Response::json(array(
	        'data' => Company::all()->toArray(),
	        'totalCount'=> Company::count()
		));*/
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('companies.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validation = Validator::make(
			Input::all(),
			array(
					'name' => 'required',
					'phone' => 'required',
					'version' => 'required',
					'password' => 'required',
				)		
			);

		if ($validation->passes())
		{
			$company = new Company;
			$company->name   = Input::get('name');
			$company->password = Hash::make(Input::get('password'));
			$company->phone = Input::get('phone');
			$company->issms    = Input::get('issms') ? Input::get('issms') : 0;
			$company->version = Input::get('version');
			$company->save();

			Notification::success('保存成功！');

			return Redirect::route('companies.edit', $company->id);
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
		return View::make('companies.show')->with('company',Company::find($id));
		//$list = Company::find($id);
		// return Response::json(array(
	 //        'data' => array($list->toArray()),
	 //        'totalCount'=> count($list)
		// ));

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
		return View::make('companies.edit')->with('company', Company::find($id));
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
		$validation = Validator::make(
			Input::all(),
			array(
					'name' => 'required',
					'phone' => 'required',
					'version' => 'required',
				)		
			);

		if ($validation->passes())
		{
			$company = Company::find($id);
			$company->name   = Input::get('name');
			$company->phone    = Input::get('phone');
			$company->issms    = Input::get('issms') ? Input::get('issms') : 0;
			$company->version = Input::get('version');
			$company->save();

			#更新管理员信息
			logs($id, 'company', 'U', $id);

			Notification::success('保存成功！');

			return Redirect::route('companies.edit', $company->id);
		}

		return Redirect::back()->withInput()->withErrors($validation->messages());
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
		$company = Company::find($id);
		$company->delete();

		Notification::success('删除成功！');

		return Redirect::route('companies.index');
	}

}