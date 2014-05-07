@extends('_layouts.default')

@section('main')

	<h2>编辑 订餐</h2>

	@include('_partials.notifications')

	{{ Form::model($order, array('method' => 'put', 'route' => array('orders.update', $order->id))) }}
		<div class="control-group">
			{{ Form::label('user', '用户') }}
			<div class="controls">
				{{ Form::text('user', $order->user->name, array('readonly'=>true)) }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('breakfast', '早餐') }}
			<div class="controls">
				{{ Form::text('breakfast') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('lunch', '中餐') }}
			<div class="controls">
				{{ Form::text('lunch') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('dinner', '晚餐') }}
			<div class="controls">
				{{ Form::text('dinner') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('issms', '发送短信') }}
			<div class="controls">
				{{ Form::checkbox('issms') }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('保存', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('orders.index') }}" class="btn btn-large">取消</a>
		</div>

	{{ Form::close() }}

@stop