@extends('_layouts.default')

@section('main')

	<h2>编辑 员工</h2>

	@include('_partials.notifications')

	{{ Form::model($user, array('method' => 'put', 'route' => array('users.update', $user->id))) }}

		<div class="control-group">
			{{ Form::label('sn', '工号') }}
			<div class="controls">
				{{ Form::text('sn') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('name', '姓名') }}
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


		<div class="control-group">
			{{ Form::label('phone', '联系电话') }}
			<div class="controls">
				{{ Form::text('phone') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('iswork', '在职') }}
			<div class="controls">
				{{ Form::checkbox('iswork') }}
			</div>
		</div>


		<div class="form-actions">
			{{ Form::submit('保存', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('users.index') }}" class="btn btn-large">取消</a>
		</div>

	{{ Form::close() }}

@stop