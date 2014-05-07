@extends('_layouts.default')

@section('main')

	<h2>编辑 单位信息</h2>

	@include('_partials.notifications')

	{{ Form::model($company, array('method' => 'post', 'route' => array('admin.profile.post'))) }}
		<div class="control-group">
			{{ Form::label('name', '单位') }}
			<div class="controls">
				{{ Form::text('name', $company->name, array('readonly'=>true)) }}
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

		<div class="control-group">
			{{ Form::label('issms', '发送短信') }}
			<div class="controls">
				{{ Form::checkbox('issms') }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('保存', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('users.index') }}" class="btn btn-large">取消</a>
		</div>

	{{ Form::close() }}

@stop