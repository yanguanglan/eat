@extends('_layouts.default')

@section('main')
  	<div class="well clearfix">
	    <div class="col-md-8">
		    <p><strong>单位名称:</strong> {{ $company->name }} </p>
		    <p><strong>手机号码:</strong> {{ $company->phone }} </p>	
		    <p><strong>管理员电话:</strong> {{ $company->adminphone }} </p>	    
		    <p><strong>短信发送:</strong> @if($company->issms) 是 @else 否 @endif </p>
		    <p><strong>版本号:</strong> {{ $company->version }} </p>
		</div>
		<div class="col-md-4">
			<p><em>创建时间: {{ $company->created_at }}</em></p>
			<p><em>更新时间: {{ $company->updated_at }}</em></p>
			<button class="btn btn-primary" onClick="location.href='{{ URL::route('companies.edit', array('id'=>$company->id)) }}'">编辑</button>
		</div>
	</div>
@stop