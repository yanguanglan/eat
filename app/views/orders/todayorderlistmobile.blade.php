@extends('_layouts.mobile')
@section('main')
<div class="header ">
		<a href="{{ URL::route('mobile.todayorder') }}" class="back">返回</a>
		<div class="til">
			@if (Route::input('type') == 'work')
				在岗
			@elseif (Route::input('type') == 'leave')
				请假
			@elseif (Route::input('type') == 'travel')
				公干
			@else
				未打卡
			@endif
			人数（{{ count($orders) }}人）</div>
</div>
<div class="contTab 
			@if (Route::input('type') == 'work')
				postTab
			@elseif (Route::input('type') == 'leave')
			@elseif (Route::input('type') == 'travel')
			@else
				postTab
			@endif
		">
		<div class="table tebleHead">
			<div class="tableList">工号姓名</div>
			<div class="tableList"><b class="b1"></b>到岗时间
			@if (Route::input('type') == 'leave')
				<b class="b2"></b>
			@elseif (Route::input('type') == 'travel')
				<b class="b2"></b>
			@endif
			</div>
			@if (Route::input('type') == 'leave')
				<div class="tableList">事由</div>
			@elseif (Route::input('type') == 'travel')
				<div class="tableList">事由</div>
			@endif

		</div>
		@foreach ($orders as $order)
		<div class="table">
		    <div class="tableList">
			@if (Route::input('type') == 'nowork')
				{{ $order->sn }} {{ $order->name }}
			@else
				{{ $order->user->sn }} {{ $order->user->name }}
			@endif
		    </div>
			<div class="tableList"><b class="b1"></b><span>
			@if (Route::input('type') == 'work')
				{{ date('m-d H:i', strtotime($order->worked_at)) }}
			@elseif (Route::input('type') == 'leave')
				{{ date('m-d H:i', strtotime($order->timeend)) }}
			@elseif (Route::input('type') == 'travel')
				{{ date('m-d H:i', strtotime($order->timeend)) }}
			@else
				未打卡
			@endif
			</span>
			@if (Route::input('type') == 'leave')
				<b class="b2"></b>
			@elseif (Route::input('type') == 'travel')
				<b class="b2"></b>
			@endif
			</div>
			
			@if (Route::input('type') == 'leave')
				<div class="tableList"><span>{{ $order->reason }}</span></div>
			@elseif (Route::input('type') == 'travel')
				<div class="tableList"><span>{{ $order->reason }}</span></div>
			@endif
		</div>
		@endforeach
	</div>
@stop