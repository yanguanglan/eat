@extends('_layouts.default')

@section('main')
  	<div class="well clearfix">
	    <div class="col-md-8">
		    <p><strong>班次:</strong> {{ $department->name }} </p>
		    <p><strong>上班时间:</strong> {{ $department->starttime }} </p>		    
		    <p><strong>下班时间:</strong> {{ $department->endtime }} </p>
		</div>
		<div class="col-md-4">
			<p><em>创建时间: {{ $department->created_at }}</em></p>
			<p><em>更新时间: {{ $department->updated_at }}</em></p>
			<button class="btn btn-primary" onClick="location.href='{{ URL::route('departments.edit', array('id'=>$department->id)) }}'">编辑</button>
		</div>
	</div>
@stop