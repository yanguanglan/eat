@extends('_layouts.front')

@section('main')

	<h2>编辑 个人信息</h2>

	@include('_partials.notifications')

	{{ Form::model($user, array('method' => 'post', 'route' => array('user.profile.post'))) }}
		<div class="control-group">
			{{ Form::label('name', '姓名') }}
			<div class="controls">
				{{ Form::text('name', $user->name, array('readonly'=>true)) }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('phone', '手机号码') }}
			<div class="controls">
				{{ Form::text('phone') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('password', '密码') }}
			<div class="controls">
				{{ Form::password('password') }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('保存', array('class' => 'btn btn-success btn-save btn-large')) }}
			{{ Form::reset('重置', array('class' => 'btn btn-success btn-save btn-large')) }}
		</div>

	{{ Form::close() }}

@stop