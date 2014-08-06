<?php

use Illuminate\Support\Facades\Input;
class OrdersController extends \BaseController {

	public function getTodayOrder($co_id)
	{
		#统计当天在岗，请假，公干人数
		$today = date('Y-m-d 00:00:00', time());
		#1
		$order = Order::where('co_id', $co_id)->where('worked_at', '>', $today)->get();
		$work = count($order);
		#2
		$order = Order::where('co_id', $co_id)->where('timestart', '>', $today)->where('timeend', '>', $today)->where('type', 0)->get();
		$leave = count($order);
		#3
		$order = Order::where('co_id', $co_id)->where('timestart', '>', $today)->where('timeend', '>', $today)->where('type', 1)->get();
		$travel = count($order);
		#4
		$user = User::where('co_id', $co_id)->get();
		$nowork = count($user);
		$nowork = $nowork - $work - $leave - $travel;


		return Response::json(array(
		        'data' => array('work'=>$work, 'leave'=>$leave, 'travel'=>$travel, 'nowork'=>$nowork),
		        'totalCount'=> 1
		));

	}

	public function getTodayOrderList($co_id, $type)
	{
		#统计当天在岗，请假，公干明细
		$today = date('Y-m-d 00:00:00', time());
		$order = array();
		if ($type == 'work')
		{
			$order = Order::where('co_id', $co_id)->where('worked_at', '>', $today)->get();
		}
		elseif ($type == 'leave')
		{
			$order = Order::where('co_id', $co_id)->where('timestart', '>', $today)->where('timeend', '>', $today)->where('type', 0)->get();
		}
		elseif ($type == 'travel')
		{
			$order = Order::where('co_id', $co_id)->where('timestart', '>', $today)->where('timeend', '>', $today)->where('type', 1)->get();
		}
		else
		{
			$order = Order::where('co_id', $co_id)->where('worked_at', '>', $today)->get();
			$user_id = array();
			foreach ($order as $value) {
				$user_id[] = $value->user_id;
			}

			if (!empty($user_id)) {
				$order = User::where('co_id', $co_id)->whereNotIn('id', $user_id)->get();
			}
			else
			{
				$order = User::where('co_id', $co_id)->get();
			}
		}

		return Response::json(array(
		        'data' => $order->toArray(),
		        'totalCount'=> $order->count()
		));

	}

	public function getTodayOrderMobile()
	{
		#统计当天在岗，请假，公干人数/	手机端
		$today = date('Y-m-d 00:00:00', time());
		#1
		$order = Order::where('co_id', Auth::user()->id)->where('worked_at', '>', $today)->get();
		$work = count($order);
		#2
		$order = Order::where('co_id', Auth::user()->id)->where('timestart', '>', $today)->where('timeend', '>', $today)->where('type', 0)->get();
		$leave = count($order);
		#3
		$order = Order::where('co_id', Auth::user()->id)->where('timestart', '>', $today)->where('timeend', '>', $today)->where('type', 1)->get();
		$travel = count($order);
		#4
		$user = User::where('co_id', Auth::user()->id)->get();
		$nowork = count($user);
		$nowork = $nowork - $work - $leave - $travel;

		return View::make('orders.todayordermobile')->with('work', $work)->with('leave', $leave)->with('travel', $travel)->with('nowork', $nowork);
	}

	public function getTodayOrderListMobile($type)
	{
		#统计当天在岗，请假，公干明细/	手机端
		$today = date('Y-m-d 00:00:00', time());
		if ($type == 'work')
		{
			$orders = Order::where('co_id', Auth::user()->id)->where('worked_at', '>', $today)->get();
		}
		elseif ($type == 'leave')
		{
			$orders = Order::where('co_id', Auth::user()->id)->where('timestart', '>', $today)->where('timeend', '>', $today)->where('type', 0)->get();
		}
		elseif ($type == 'travel')
		{
			$orders = Order::where('co_id', Auth::user()->id)->where('timestart', '>', $today)->where('timeend', '>', $today)->where('type', 1)->get();
		}
		else
		{
			$orders = Order::where('co_id', Auth::user()->id)->where('worked_at', '>', $today)->get();
			$user_id = array();
			foreach ($orders as $value) {
				$user_id[] = $value->user_id;
			}

			if (!empty($user_id)) {
				$orders = User::where('co_id', Auth::user()->id)->whereNotIn('id', $user_id)->get();
			}
			else
			{
				$orders = User::where('co_id', Auth::user()->id)->get();
			}

		}

		return View::make('orders.todayorderlistmobile')->with('orders', $orders);
	}

	public function getTravelOrder()
	{
		$today = date('Y-m-d 00:00:00', time());
		$timestart = $timeend = strftime('%Y-%m-%dT%H:%M:%S', time());
		$order = Order::where('user_id', Session::get('user_id'))->where('timestart', '>', $today)->where('timeend', '>', $today)->first();
		if(isset($order->id)) {
			$timestart = strftime('%Y-%m-%dT%H:%M:%S', strtotime($order->timestart));
			$timeend = strftime('%Y-%m-%dT%H:%M:%S', strtotime($order->timeend));
			return View::make('orders.travelmobileedit')->with('order', $order)->with('user', User::find(Session::get('user_id')))->with('timestart', $timestart)->with('timeend', $timeend);
		}
		return View::make('orders.travelmobile')->with('user', User::find(Session::get('user_id')))->with('timestart', $timestart)->with('timeend', $timeend);
		#请假/公干
	}

	public function postTravelOrder()
	{
		#请假/公干
		#return View::make('orders.travelmobile');
		$today = date('Y-m-d 00:00:00', time());
		$timestart = date('Y-m-d H:i:s', strtotime(Input::get('timestart')));
		$order = Order::where('user_id', Session::get('user_id'))->where('timestart', '>', $today)->where('timeend', '>', $today)->first();
		$attributes	= array(
			'type' => '类型',
			'reason' => '事由',
			'timestart' => '请假时间',
			'timeend' => '到岗时间'
		);
		if($order) {
			#edit
			$validation = Validator::make(
			Input::all(),
			array(
					'type' => 'required',
					'reason' => 'required',
					'timestart' => "required|after:$today",
					'timeend' => "required|after:$timestart",
				),
			array(),
			$attributes
			);

		if ($validation->passes())
		{

			$order->type = Input::get('type');
			$order->reason = Input::get('reason');
			$order->timestart = Input::get('timestart');
			$order->timeend = Input::get('timeend');
			$order->save();

			#修改订餐
			logs(Session::get('co_id'), 'order', 'U', $order->id);

			Session::flash('success', '提交申请成功!');

			return Redirect::route('mobile.order.travel');
		}

		    return Redirect::back()->withInput()->withErrors($validation->messages());

		}

		$order = new Order;
		#add
				$validation = Validator::make(
			Input::all(),
			array(
					'type' => 'required',
					'reason' => 'required',
					'timestart' => "required|after:$today",
					'timeend' => "required|after:$timestart",
				),
				array(),
				$attributes
			);

		if ($validation->passes())
		{
			$order->co_id = Session::get('co_id');
			$order->user_id = Session::get('user_id');
			$order->breakfast = 0;
			$order->lunch = 0;
			$order->dinner = 0;
			$order->issms = 0;
			$order->reason = Input::get('reason');
			$order->type = Input::get('type');
			$order->timestart = Input::get('timestart');
			$order->timeend = Input::get('timeend');
			$order->save();

			#修改订餐
			logs(Session::get('co_id'), 'order', 'I', $order->id);

			Session::flash('success', '提交申请成功!');

			return Redirect::route('mobile.order.travel');
		}

		    return Redirect::back()->withInput()->withErrors($validation->messages());

	}

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
		//用户
		$user = User::where('co_id', Auth::user()->id)->get();
		//班次
		$department = Department::where('co_id', Auth::user()->id)->get();

		$morning = $afternoon = array();

		$order = Order::where('co_id', Auth::user()->id)->where('worked_at', '>', $today_start)->where('worked_at', '<', $today_end)->orderBy('worked_at', 'desc')->get();
		foreach ($order as $value) {
			if (date('H:i:s', strtotime($value->worked_at)) < '12:00:00') {
				$morning[$value->user->id] = $value;
		    }
		}
		$order = Order::where('co_id', Auth::user()->id)->where('worked_at', '>', $today_start)->where('worked_at', '<', $today_end)->orderBy('worked_at', 'asc')->get();
		foreach ($order as $value) {
			if (date('H:i:s', strtotime($value->worked_at)) >= '12:00:00') {
				$afternoon[$value->user->id] = $value;
		    }
		}

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
			if (date('H:i:s', strtotime($value->worked_at)) < '12:00:00') {
				$morning[$value->user->id] = $value;
		    }
		}
		$order = Order::where('co_id', Auth::user()->id)->where('worked_at', '>', $today_start)->where('worked_at', '<', $today_end)->orderBy('worked_at', 'asc')->get();
		foreach ($order as $value) {
			if (date('H:i:s', strtotime($value->worked_at)) >= '12:00:00') {
				$afternoon[$value->user->id] = $value;
		    }
		}

		//用户
		$user = User::where('co_id', Auth::user()->id)->get();

		//班次
		$department = Department::where('co_id', Auth::user()->id)->get();

		return View::make('orders.searchmobile')->with('today', $today)->with('users', $user)->with('department', $department)->with('morning', $morning)->with('afternoon', $afternoon);
	}

	public function setdateList()
	{
		if(!isset($_POST['savedate'])){
			$time = isset($_POST['keyword']) && strtotime($_POST['keyword']) ? strtotime($_POST['keyword']): time();
			$list=array();
			$day_num = date('t',$time);
			$today = date('Y-m',$time);
			$res = Workdate::where('co_id', Auth::user()->id)->where('ymd','like',$today.'-%')->orderBy('ymd','asc')->get();
			if($res){
				foreach ($res as $key => $val){
					$list[$val->ymd]=$val;
				}
			}
			return View::make('orders.setdate')->with('list',$list)->with('day_num', $day_num)->with('today',$today);
		}else{
			Workdate::where('co_id', Auth::user()->id)->where('ymd','like',$_POST['ym'].'%')->delete();
			if(is_array($_POST['name']) && count($_POST['name'])>0){
				$datas=array();
				foreach ($_POST['name'] as $key => $val){
					if(!$val) continue;
					$datas[]=array('ymd'=>$key,'co_id'=>Auth::user()->id,'is_work'=>1);
				}
				if(!empty($datas)){
					DB::table('work_date')->insert($datas);
				}
			}
			Notification::success('保存成功！');
			return Redirect::route('order.setdate');
		}
	}

	public function countList()
	{
		$user=array();
		$user_temp=$workdate=array();
		if(Input::get('keyword')) {
			$today = Input::get('keyword');
		} else {
			$today = date('Y-m', time());
		}
		$day_num = date('t',strtotime($today));
		//用户
		$user_res = User::where('co_id', Auth::user()->id)->get();
		foreach ($user_res as $key => $val){
			$user[$val->id]=array(
					'user_id'=>$val->id,
					'sn'=>$val->sn,
					'name'=>$val->name,
					'phone'=>$val->phone,
					'normal'=>0,			//正常打卡次数
					'late'=>0,				//迟到次数
					'no_records'=>0,		//没打卡次数
			);
		}
		//班次
		$department = Department::where('co_id', Auth::user()->id)->get();
		//考勤日
		$workdate_res = Workdate::where('co_id', Auth::user()->id)->where('ymd','like',$today.'-%')->orderBy('ymd','asc')->get();
		if(count($workdate_res)>0){
			foreach ($workdate_res as $key => $val){
				$workdate[$val->ymd]=array(
					'ymd'=>$val->ymd,
					'is_work'=>$val->is_work
				);
			}
		}else{
			//如果管理员没设置考勤日，就默认使用工作日
			for ($i=1;$i<=$day_num;$i++){
				$i=$i<10?'0'.$i:$i;
				$w=date("w",strtotime($today.'-'.$i));
				if(!in_array($w, array(6,0))){
					$workdate[$today.'-'.$i]=array(
							'ymd'=>$today.'-'.$i,
							'is_work'=>1
					);
				}
			}
		}

		$order = Order::where('co_id', Auth::user()->id)->where('worked_at', 'like', $today.'-%')->orderBy('worked_at', 'asc')->get();
		//上班
		foreach ($order as $value) {
			$ymd = date('Y-m-d', strtotime($value->worked_at));
			$his = date('H:i:s', strtotime($value->worked_at));
			if(!isset($workdate[$ymd])) continue;
			if ($his < '12:00:00') {
				if(isset($user_temp[$value->user_id][$ymd.'_am'])){
					continue;
				}
				if(punch($his, $department)){
					$user[$value->user_id]['late']++;
				}else{
					$user[$value->user_id]['normal']++;
				}
				$user_temp[$value->user_id][$ymd.'_am']=1;
			}
		}
		//下班
		$order = Order::where('co_id', Auth::user()->id)->where('worked_at', 'like', $today.'-%')->orderBy('worked_at', 'desc')->get();
		foreach ($order as $value) {
			$ymd = date('Y-m-d', strtotime($value->worked_at));
			$his = date('H:i:s', strtotime($value->worked_at));
			if(!isset($workdate[$ymd])) continue;
			if($his >= '12:00:00'){
		    	if(isset($user_temp[$value->user_id][$ymd.'_pm'])){
		    		continue;
		    	}
				if(punch($his, $department)){
					$user[$value->user_id]['late']++;
				}else{
					$user[$value->user_id]['normal']++;
				}
		    	$user_temp[$value->user_id][$ymd.'_pm']=1;
		    }
		}
		//var_dump($user);exit;
		return View::make('orders.count')->with('today', $today)->with('users', $user)->with('num_count', count($workdate)*2);
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
		$attributes = array('breakfast' => '早餐',
			'lunch' => '中餐',
			'dinner' => '晚餐',
		 );
		if($order) {
			#edit
			$validation = Validator::make(
			Input::all(),
			array(
					'breakfast' => 'required|numeric',
					'lunch' => 'required|numeric',
					'dinner' => 'required|numeric',			),
					array(),
					$attributes
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
					'dinner' => 'required|numeric',			),
					array(),
					$attributes
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
		$attributes = array('breakfast' => '早餐',
			'lunch' => '中餐',
			'dinner' => '晚餐',
		 );

		$validation = Validator::make(
			Input::all(),
			array(
					'breakfast' => 'required',
					'lunch' => 'required',
					'dinner' => 'required',			),
					array(),
					$attributes
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

	public function postOrder($co_id, $order_id = null)
	{
			if ($order_id) {
				$order = Order::find($order_id);
				$order->breakfast = Input::get('breakfast');
				$order->lunch = Input::get('lunch');
				$order->dinner = Input::get('dinner');
				$order->issms = Input::get('issms');
			} else {
				$order = new Order();
				$order->co_id = $co_id;
				$order->user_id = Input::get('user_id');
				$order->breakfast = Input::get('breakfast');
				$order->lunch = Input::get('lunch');
				$order->dinner = Input::get('dinner');
				$order->issms = Input::get('issms');
				$order->worked_at = Input::get('worked_at');
			}
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
		$attributes = array('breakfast' => '早餐',
			'lunch' => '中餐',
			'dinner' => '晚餐',
		 );
		$validation = Validator::make(
			Input::all(),
			array(
					'breakfast' => 'required',
					'lunch' => 'required',
					'dinner' => 'required',			),
					array(),
					$attributes
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