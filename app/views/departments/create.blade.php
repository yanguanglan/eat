@extends('_layouts.default')

@section('main')

	<h2>新增 班次</h2>

	@include('_partials.notifications')

	{{ Form::open(array('route' => 'departments.store')) }}

		<div class="control-group">
			{{ Form::label('name', '班次') }}
			<div class="controls">
				{{ Form::text('name') }}
			</div>
		</div>


		<div class="control-group">
			{{ Form::label('starttime', '上班时间') }}
			<div class="controls">
				{{ Form::input('time', 'starttime', null, ['class' => 'form-control', 'placeholder' => 'Time']) }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('endtime', '下班时间') }}
			<div class="controls">
				{{ Form::input('time', 'endtime', null, ['class' => 'form-control', 'placeholder' => 'Time']) }}			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('保存', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('departments.index') }}" class="btn btn-large">取消</a>
		</div>

	{{ Form::close() }}

@stop