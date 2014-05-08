@extends('_layouts.front')

@section('main')

	<h2>新增 订餐</h2>

	@include('_partials.notifications')

	{{ Form::open(array('route' => 'user.order.post')) }}

		<div class="control-group">
			{{ Form::label('user_id', '用户') }}
			<div class="controls">
				{{ Form::text('user_id', Session::get('name'), array('readonly'=>true)) }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('breakfast', '早餐') }}
			<div class="controls">
				{{ Form::text('breakfast', 0) }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('lunch', '中餐') }}
			<div class="controls">
				{{ Form::text('lunch', 0) }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('dinner', '晚餐') }}
			<div class="controls">
				{{ Form::text('dinner', 0) }}
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
			{{ Form::reset('重置', array('class' => 'btn btn-success btn-save btn-large')) }}
		</div>

	{{ Form::close() }}

@stop