<?php

class NewsController extends \BaseController {

	public function newsList($co_id)
	{
		$list = News::where('co_id', $co_id)->get();
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
		return View::make('news.index')->with('news', News::where('co_id', Auth::user()->id)->paginate(10));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('news.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$attributes = array('title' => '标题',
			'content' => '内容',
		 );
		$validation = Validator::make(
			Input::all(),
			array(
					'title' => 'required',
					'content' => 'required',				),
					array(),
					$attributes		
			);

		if ($validation->passes())
		{
			$new = new News;
			$new->title   = Input::get('title');
			$new->content = Input::get('content');
			if (Input::get('expirationdate')) {
				$new->expirationdate = Input::get('expirationdate');
			}
			$new->co_id = Auth::user()->id;
			$new->user_id = 0;
			$new->save();

			#新增通知
			logs(Auth::user()->id, 'news', 'I', $new->id);

			Notification::success('保存成功！');

			return Redirect::route('news.edit', $new->id);
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
		return View::make('news.show')->with('new', News::find($id));
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
		return View::make('news.edit')->with('new', News::find($id));
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
		$attributes = array('title' => '标题',
			'content' => '内容',
		 );
		$validation = Validator::make(
			Input::all(),
			array(
					'title' => 'required',
					'content' => 'required',
				),
			array(),
			$attributes
			);

		if ($validation->passes())
		{
			$new = News::find($id);
			$new->title   = Input::get('title');
			$new->content    = Input::get('content');
			if (Input::get('expirationdate')) {
				$new->expirationdate = Input::get('expirationdate');
			}

			$new->save();

			#修改通知
			logs(Auth::user()->id, 'news', 'U', $id);

			Notification::success('保存成功！');

			return Redirect::route('news.edit', $new->id);
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
		$new = News::find($id);
		$new->delete();

		#删除通知
		logs(Auth::user()->id, 'news', 'D', $id);

		Notification::success('删除成功！');

		return Redirect::route('news.index');
	}

}