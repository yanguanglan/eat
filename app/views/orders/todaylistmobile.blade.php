@extends('_layouts.mobile')
@section('main')
		<div class="header ">
		<a class="back" href="{{ URL::route('mobile.order.today', Route::input('co_id')) }}">返回</a>
		<div class="confirm">&nbsp;</div>
		<div class="til">今日订餐</div>
	    </div>
	<div class="header table">
		<div class="tableList">工号 姓名</div>
		<div class="tableList">中餐</div>
		<div class="tableList">晚餐</div>
	</div>
	<div class="contTab">
		@foreach ($orders as $order)
		@if ($order->breakfast!=0 || $order->lunch!=0 || $order->dinner!=0)
		<div class="table">
			<div class="tableList">{{ $order->user->sn }} {{ $order->user->name }}</div>
			<div class="tableList">{{ $order->lunch }}</div>
			<div class="tableList">{{ $order->dinner }}</div>
		</div>
		@endif
		@endforeach
	</div>
@stop