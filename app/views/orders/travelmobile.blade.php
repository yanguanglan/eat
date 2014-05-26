@extends('_layouts.default')

@section('main')

	<h2>事务申请</h2>

	@include('_partials.notifications')
	@if (Session::has('success'))
			<p class="warning">
				{{ Session::get('success') }}
			</p>
	@endif
	{{ Form::open(array('route' => 'mobile.order.travel.post')) }}
 
		<label class="checkbox inline">
			{{ Form::radio('type', 0, true) }} 请假
		</label>
		<label class="checkbox inline">
		  {{ Form::radio('type', 1) }} 公干
		</label>

	    <div class="control-group">
			{{ Form::label('reason', '事由') }}
			<div class="controls">
				{{ Form::textarea('reason') }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('保存', array('class' => 'btn btn-success btn-save btn-large')) }}
			{{ Form::reset('重置', array('class' => 'btn btn-success btn-save btn-large')) }}
		</div>

	{{ Form::close() }}

@stop