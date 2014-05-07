@extends('_layouts.default')

@section('main')

	<div id="login" class="login">
		{{ Form::open() }}

			@if ($errors->has('login'))
				<div class="alert alert-error">{{ $errors->first('login', ':message') }}</div>
			@endif

			<div class="control-group">
				{{ Form::label('name', '单位名称') }}
				<div class="controls">
					{{ Form::text('name') }}
				</div>
			</div>

			<div class="control-group">
				{{ Form::label('password', '密码') }}
				<div class="controls">
					{{ Form::password('password') }}
				</div>
			</div>

			<div class="form-actions">
				{{ Form::submit('登录', array('class' => 'btn btn-inverse btn-login')) }}
			</div>

		{{ Form::close() }}
	</div>

@stop