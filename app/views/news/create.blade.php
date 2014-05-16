@extends('_layouts.default')

@section('main')

	<h2>新增 通知</h2>

	@include('_partials.notifications')

	{{ Form::open(array('route' => 'news.store')) }}

		<div class="control-group">
			{{ Form::label('title', '标题') }}
			<div class="controls">
				{{ Form::text('title') }}
			</div>
		</div>


		<div class="control-group">
			{{ Form::label('content', '内容') }}
			<div class="controls">
				{{ Form::textarea('content') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('expirationdate', '有效期') }}
			<div class="controls">
				{{ Form::input('date', 'expirationdate', date('Y-m-d', time()+604800), array('class' => 'form-control', 'placeholder' => 'Date')) }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('保存', array('class' => 'btn btn-success btn-save btn-large')) }}
			<a href="{{ URL::route('news.index') }}" class="btn btn-large">取消</a>
		</div>

	{{ Form::close() }}

@stop