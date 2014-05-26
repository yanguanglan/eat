@extends('_layouts.mobile')
@section('main')
		<div class="header ">
		<a class="back" href="{{ URL::route('mobile.todayorder') }}">返回</a>
		<div class="confirm">&nbsp;</div>
		<div class="til">考勤统计</div>
	    </div>

	<div class="header table">
		<div class="tableList">工号 姓名</div>
		<div class="tableList">考勤</div>
		<div class="tableList">备注</div>
	</div>
	<div class="contTab">
		@foreach ($orders as $order)
		<div class="table">
			<div class="tableList">
			@if (Route::input('type') == 'nowork')
				{{ $order->sn }} {{ $order->name }}
			@else
				{{ $order->user->sn }} {{ $order->user->name }}
			@endif
			</div>
			<div class="tableList">
			@if (Route::input('type') == 'work')
				{{ $order->worked_at }}
			@elseif (Route::input('type') == 'leave')
				请假
			@elseif (Route::input('type') == 'travel')
				公干
			@else
				未打卡
			@endif
			</div>
			<div class="tableList">
			@if (Route::input('type') == 'leave')
				{{ $order->reason }}
			@elseif (Route::input('type') == 'travel')
				{{ $order->reason }}
			@else
				
			@endif
			</div>
		</div>
		@endforeach
	</div>
@stop