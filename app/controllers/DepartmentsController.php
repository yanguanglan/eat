<?php

class DepartmentsController extends \BaseController {

	public function departmentList($co_id)
	{
		$list = Department::where('co_id', $co_id)->get();
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
		return View::make('departments.index')->with('departments', Department::where('co_id', Auth::user()->id)->paginate(10));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('departments.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$attributes = array('name' => '班次名称',
			'starttime' => '上班时间',
			'endtime' => '下班时间',
		 );
		$validation = Validator::make(
			Input::all(),
			array(
					'name' => 'required',
					'starttime' => 'required',
					'endtime' => 'required',				),
					array(),
					$attributes	
			);

		if ($validation->passes())
		{
			$department = new Department;
			$department->name   = Input::get('name');
			$department->starttime = Input::get('starttime');
			$department->endtime = Input::get('endtime');
			$department->co_id = Auth::user()->id;
			$department->save();

			#新增班次
			logs(Auth::user()->id, 'department', 'I', $department->id);

			Notification::success('保存成功！');

			return Redirect::route('departments.edit', $department->id);
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
		return View::make('departments.show')->with('department', Department::find($id));
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
		return View::make('departments.edit')->with('department', Department::find($id));
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
		$attributes = array('name' => '班次名称',
			'starttime' => '上班时间',
			'endtime' => '下班时间',
		 );
		$validation = Validator::make(
			Input::all(),
			array(
					'name' => 'required',
					'starttime' => 'required',
					'endtime' => 'required',				),
					array(),
					$attributes		
			);

		if ($validation->passes())
		{
			$department = Department::find($id);
			$department->name   = Input::get('name');
			$department->starttime = Input::get('starttime');
			$department->endtime = Input::get('endtime');
			$department->save();

			#修改班次
			logs(Auth::user()->id, 'department', 'U', $id);

			Notification::success('保存成功！');

			return Redirect::route('departments.edit', $department->id);
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
		$department = Department::find($id);
		$department->delete();
		#删除班次
		logs(Auth::user()->id, 'department', 'D', $id);

		Notification::success('删除成功！');

		return Redirect::route('departments.index');
	}

}