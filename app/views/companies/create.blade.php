@extends('_layouts.default')

@section('main')

	<h2>新增 单位</h2>

	@include('_partials.notifications')

	{{ Form::open(array('route' => 'companies.store')) }}

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


		<div class="control-group">
			{{ Form::label('phone', '联系电话') }}
			<div class="controls">
				{{ Form::text('phone') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('adminphone', '管理员电话') }}
			<div class="controls">
				{{ Form::text('adminphone') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('issms', '发送短信') }}
			<div class="controls">
				{{ Form::checkbox('issms', 1, true) }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('version', '版本号') }}
			<div class="controls">
				{{ Form::text('version') }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('保存', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('companies.index') }}" class="btn btn-large">取消</a>
		</div>

	{{ Form::close() }}

@stop