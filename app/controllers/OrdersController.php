<?php

class OrdersController extends \BaseController {

	public function getToday()
	{
		$today = date('Y-m-d 00:00:00', time());

		$order = Order::where('co_id', Auth::user()->id)->where('created_at', '>', $today)->get();

		$breakfast = $order->sum('breakfast');
		$lunch = $order->sum('lunch');
        $dinner = $order->sum('dinner');

		return View::make('orders.today')->with('breakfast', $breakfast)->with('lunch', $lunch)->with('dinner', $dinner);
	}

	public function getTodayList()
	{
		$today = date('Y-m-d 00:00:00', time());

		$orders = Order::where('co_id', Auth::user()->id)->where('created_at', '>', $today)->paginate(10);

		return View::make('orders.todaylist')->with('orders', $orders);
	}

	public function getTodayMobile($co_id)
	{
		$today = date('Y-m-d 00:00:00', time());

		$order = Order::where('co_id', $co_id)->where('created_at', '>', $today)->get();

		$breakfast = $order->sum('breakfast');
		$lunch = $order->sum('lunch');
        $dinner = $order->sum('dinner');
        $week = array(
			'0' => '周日',
			'1' => '周一',
			'2' => '周二',
			'3' => '周三',
			'4' => '周四',
			'5' => '周五',
			'6' => '周六',
		);
		return View::make('orders.todaymobile')->with('breakfast', $breakfast)->with('lunch', $lunch)->with('dinner', $dinner)->with('week', $week);
	}

	public function getTodayListMobile($co_id)
	{
		$today = date('Y-m-d 00:00:00', time());

		$orders = Order::where('co_id', $co_id)->where('created_at', '>', $today)->get();

		return View::make('orders.todaylistmobile')->with('orders', $orders);
	}

	public function searchList()
	{
		if(Input::get('keyword')) {
			$today_start = date(Input::get('keyword')." 00:00:00", strtotime(Input::get('keyword')));
			$today_end = date(Input::get('keyword')." 23:59:59", strtotime(Input::get('keyword')));
			$today = Input::get('keyword');
		} else {
			$today_start = date('Y-m-d 00:00:00', time());
			$today_end = date('Y-m-d 23:59:59', time());
			$today = date('Y-m-d', time());
		}

		$morning = $afternoon = array();
		
		$order = Order::where('co_id', Auth::user()->id)->where('worked_at', '>', $today_start)->where('worked_at', '<', $today_end)->orderBy('worked_at', 'desc')->get();
		foreach ($order as $value) {
			if (date('H:i:s', strtotime($value->created_at)) < '12:00:00') {
				$morning[$value->user->id] = $value;
		    }
		}
		$order = Order::where('co_id', Auth::user()->id)->where('worked_at', '>', $today_start)->where('worked_at', '>', $today_end)->orderBy('worked_at', 'asc')->get();
		foreach ($order as $value) {
			if (date('H:i:s', strtotime($value->created_at)) >= '12:00:00') {
				$afternoon[$value->user->id] = $value;
		    }
		}

		//用户
		$user = User::where('co_id', Auth::user()->id)->get();

		//班次
		$department = Department::where('co_id', Auth::user()->id)->get();

		return View::make('orders.search')->with('today', $today)->with('users', $user)->with('department', $department)->with('morning', $morning)->with('afternoon', $afternoon);
	}

	public function searchListMobile()
	{
		if(Input::get('keyword')) {
			$today_start = date(Input::get('keyword')." 00:00:00", strtotime(Input::get('keyword')));
			$today_end = date(Input::get('keyword')." 23:59:59", strtotime(Input::get('keyword')));
			$today = Input::get('keyword');
		} else {
			$today_start = date('Y-m-d 00:00:00', time());
			$today_end = date('Y-m-d 23:59:59', time());
			$today = date('Y-m-d', time());
		}

		$morning = $afternoon = array();
		
		$order = Order::where('co_id', Auth::user()->id)->where('worked_at', '>', $today_start)->where('worked_at', '<', $today_end)->orderBy('worked_at', 'desc')->get();
		foreach ($order as $value) {
			if (date('H:i:s', strtotime($value->created_at)) < '12:00:00') {
				$morning[$value->user->id] = $value;
		    }
		}
		$order = Order::where('co_id', Auth::user()->id)->where('worked_at', '>', $today_start)->where('worked_at', '>', $today_end)->orderBy('worked_at', 'asc')->get();
		foreach ($order as $value) {
			if (date('H:i:s', strtotime($value->created_at)) >= '12:00:00') {
				$afternoon[$value->user->id] = $value;
		    }
		}

		//用户
		$user = User::where('co_id', Auth::user()->id)->get();

		//班次
		$department = Department::where('co_id', Auth::user()->id)->get();

		return View::make('orders.searchmobile')->with('today', $today)->with('users', $user)->with('department', $department)->with('morning', $morning)->with('afternoon', $afternoon);
	}

	public function orderList($co_id)
	{
		$list = Order::where('co_id', $co_id)->get();
		return Response::json(array(
	        'data' => $list->toArray(),
	        'totalCount'=> $list->count()
		));
	}

	public function getUserOrder($co_id)
	{	
		$today = date('Y-m-d 00:00:00', time());
		$order = Order::where('user_id', Session::get('user_id'))->where('created_at', '>', $today)->first();
		if(isset($order->id)) {
			return View::make('orders.userorder.edit')->with('order', $order)->with('user', User::find(Session::get('user_id')));
		}
		return View::make('orders.userorder.create')->with('user', User::find(Session::get('user_id')));
	}

	public function postUserOrder()
	{
		$today = date('Y-m-d 00:00:00', time());
		$order = Order::where('user_id', Session::get('user_id'))->where('created_at', '>', $today)->first();
		if($order) {
			#edit
			$validation = Validator::make(
			Input::all(),
			array(
					'breakfast' => 'required|numeric',
					'lunch' => 'required|numeric',	
					'dinner' => 'required|numeric',			)		
			);

		if ($validation->passes())
		{
			$order->breakfast = Input::get('breakfast');
			$order->lunch = Input::get('lunch');
			$order->dinner = Input::get('dinner');
			$order->issms = Input::get('issms') ? Input::get('issms') : 0;
			$order->save();

			#修改订餐
			logs(Session::get('co_id'), 'order', 'U', $order->id);

			Session::flash('success', '订餐提交成功!');

			return Redirect::route('user.order', Session::get('co_id'));
		}

		    return Redirect::back()->withInput()->withErrors($validation->messages());

		}

		$order = new Order;
		#add
				$validation = Validator::make(
			Input::all(),
			array(
					'breakfast' => 'required|numeric',
					'lunch' => 'required|numeric',	
					'dinner' => 'required|numeric',			)		
			);

		if ($validation->passes())
		{
			$order->co_id = Session::get('co_id');
			$order->user_id = Session::get('user_id');
			$order->breakfast = Input::get('breakfast');
			$order->lunch = Input::get('lunch');
			$order->dinner = Input::get('dinner');
			$order->issms = Input::get('issms') ? Input::get('issms') : 0;
			$order->save();

			#修改订餐
			logs(Session::get('co_id'), 'order', 'I', $order->id);

			Session::flash('success', '订餐提交成功!');

			return Redirect::route('user.order', Session::get('co_id'));
		}

		    return Redirect::back()->withInput()->withErrors($validation->messages());

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return View::make('orders.index')->with('orders', Order::where('co_id', Auth::user()->id)->paginate(10));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('orders.create');
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
					'breakfast' => 'required',
					'lunch' => 'required',	
					'dinner' => 'required',			)		
			);

		if ($validation->passes())
		{
			$order = new Order();
			$order->co_id = Auth::user()->id;
			$order->user_id = Input::get('user_id');
			$order->breakfast = Input::get('breakfast');
			$order->lunch = Input::get('lunch');
			$order->dinner = Input::get('dinner');
			$order->issms = Input::get('issms') ? Input::get('issms') : 0;
			$order->save();

			#新增订餐
			logs(Auth::user()->id, 'order', 'I', $order->id);

			Notification::success('保存成功！');

			return Redirect::route('orders.edit', $order->id);
		}

		return Redirect::back()->withInput()->withErrors($validation->messages());

		//
		/*$order = new Order();
		$order->co_id = Input::get('co_id');
		$order->user_id = Input::get('user_id');
		$order->breakfast = Input::get('breakfast');
		$order->lunch = Input::get('lunch');
		$order->dinner = Input::get('dinner');
		$order->issms = Input::get('issms');
		$order->save();

		return Response::json(array(
	        'data' => $order->toArray(),
	        'totalCount'=> count($order)
		));*/
	}

	public function postOrder($co_id, $order_id)
	{
			if ($order_id) {
				$order = Order::find($order_id);
			} else {
				$order = new Order();
			}
			$order->co_id = $co_id;
			$order->user_id = Input::get('user_id');
			$order->breakfast = Input::get('breakfast');
			$order->lunch = Input::get('lunch');
			$order->dinner = Input::get('dinner');
			$order->issms = Input::get('issms');
			$order->worked_at = Input::get('worked_at');
			$order->save();

			$list = Order::find($order->id);
			return Response::json(array(
		        'data' => array($list->toArray()),
		        'totalCount'=> count($list)
			));	
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
		return View::make('orders.show')->with('order', Order::find($id));
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
		return View::make('orders.edit')->with('order', Order::find($id));
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
					'breakfast' => 'required',
					'lunch' => 'required',	
					'dinner' => 'required',			)		
			);

		if ($validation->passes())
		{
			$order = Order::find($id);
			$order->breakfast = Input::get('breakfast');
			$order->lunch = Input::get('lunch');
			$order->dinner = Input::get('dinner');
			$order->issms = Input::get('issms') ? Input::get('issms') : 0;
			$order->save();

			#修改订餐
			logs(Auth::user()->id, 'order', 'U', $id);

			Notification::success('保存成功！');

			return Redirect::route('orders.edit', $order->id);
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
		$order = Order::find($id);
		$order->delete();

		#删除订餐
		logs(Auth::user()->id, 'order', 'D', $id);

		Notification::success('删除成功！');

		return Redirect::route('orders.index');
	}

}