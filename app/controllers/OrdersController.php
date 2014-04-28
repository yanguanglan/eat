<?php

class OrdersController extends \BaseController {

	public function orderlist($co_id)
	{
		$list = Order::where('co_id', $co_id)->get();
		return Response::json(array(
	        'data' => $list->toJson(),
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
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$order = new Order();
		$order->co_id = Input::get('co_id');
		$order->user_id = Input::get('user_id');
		$order->breakfast = Input::get('breakfast');
		$order->lunch = Input::get('lunch');
		$order->dinner = Input::get('dinner');
		$order->issms = Input::get('issms');
		$order->save();

		return Response::json(array(
	        'data' => $order->toJson(),
	        'totalCount'=> count($order)
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
	}

}