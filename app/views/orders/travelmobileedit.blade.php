@extends('_layouts.mobile')
@section('main')
{{ Form::model($order, array('method' => 'post', 'route' => array('mobile.order.travel.post'))) }}
    <div class="header ">
		<a class="back" href="{{ URL::to('auth/logout', 1) }}">退出</a>
		<div class="confirm"></div>
		<div class="til"></div>
	</div>
	@if (Session::has('success'))
			<p class="warning">
				{{ Session::get('success') }}
			</p>
	@endif
	@if ($errors->any())
			<p class="warning">
				{{ implode(',', $errors->all()) }}
			</p>
		@endif
	<div class="header table leaveTab">
		<div class="tableList active">
			{{ Form::radio('type', 0, iif(0, $order->type)) }}请假</div>
		<div class="tableList"><b class="b1"></b>
			 {{ Form::radio('type', 1, iif(1, $order->type)) }}公干</div>
	</div>
	<div class="leaveCont">
		<div class="time">
			<h2>起始时间</h2>
			{{ Form::input('datetime-local', 'timestart', $timestart, array('class' => 'input01', 'placeholder' => 'Time')) }}
			<span>至</span>
			{{ Form::input('datetime-local', 'timeend', $timeend, array('class' => 'input01', 'placeholder' => 'Time')) }}
		</div>
		<div class="reason">
			<h2>{{ Form::label('reason', '事由') }}</h2>
			{{ Form::textarea('reason') }}
		</div>
		{{ Form::submit('提  交', array('class' => 'btn')) }}
	</div>
{{ Form::close() }}
@stop