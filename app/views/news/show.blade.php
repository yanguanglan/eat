@extends('_layouts.default')

@section('main')
  	<div class="well clearfix">
	    <div class="col-md-8">
		    <p><strong>标题:</strong> {{ $new->title }} </p>
		    <p><strong>内容:</strong> {{ $new->content }} </p>		 
		    @if ($new->expirationdate)
		    <p><strong>有效期:</strong> {{ $new->expirationdate }} </p>
		    @endif
		</div>
		<div class="col-md-4">
			<p><em>创建时间: {{ $new->created_at }}</em></p>
			<p><em>更新时间: {{ $new->updated_at }}</em></p>
			<button class="btn btn-primary" onClick="location.href='{{ URL::route('news.edit', array('id'=>$new->id)) }}'">编辑</button>
		</div>
	</div>
@stop