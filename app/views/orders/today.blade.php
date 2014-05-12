@extends('_layouts.default')

@section('main')
  	<div class="well clearfix">
  		<h1>今日订餐统计</h1>
	    <div class="col-md-8">
		    <p><strong>早餐:</strong> {{ $breakfast }} 人</p>	
		    <p><strong>中餐:</strong> {{ $lunch }} 人</p>	
		    <p><strong>晚餐:</strong> {{ $dinner }} 人</p>		
		</div>
		<div class="col-md-4">
			<button class="btn btn-primary" onClick="location.href='{{ URL::route('order.todaylist') }}'">查看详情</button>
		</div>
	</div>
@stop