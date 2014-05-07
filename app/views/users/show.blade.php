@extends('_layouts.default')

@section('main')
  	<div class="well clearfix">
	    <div class="col-md-8">
		    <p><strong>工号:</strong> {{ $user->sn }} </p>
		    <p><strong>姓名:</strong> {{ $user->name }} </p>
		    <p><strong>手机号码:</strong> {{ $user->phone }} </p>		    
		    <p><strong>在职:</strong> @if($user->iswork) 是 @else 否 @endif </p>
		</div>
		<div class="col-md-4">
			<p><em>创建时间: {{ $user->created_at }}</em></p>
			<p><em>更新时间: {{ $user->updated_at }}</em></p>
			<button class="btn btn-primary" onClick="location.href='{{ URL::route('users.edit', array('id'=>$user->id)) }}'">编辑</button>
		</div>
	</div>
@stop