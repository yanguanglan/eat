@extends('_layouts.default')

@section('main')
  	<div class="well clearfix">
	    <div class="col-md-8">
		    <p><strong>用户:</strong> {{ $order->user->name }} </p>
		    <p><strong>早餐:</strong> {{ $order->breakfast }} </p>	
		    <p><strong>中餐:</strong> {{ $order->lunch }} </p>	
		    <p><strong>晚餐:</strong> {{ $order->dinner }} </p>	
		    <p><strong>发送短信:</strong> @if($order->issms) 是 @else 否 @endif</p>	
		</div>
		<div class="col-md-4">
			<p><em>创建时间: {{ $order->created_at }}</em></p>
			<p><em>更新时间: {{ $order->updated_at }}</em></p>
			<button class="btn btn-primary" onClick="location.href='{{ URL::route('orders.edit', array('id'=>$order->id)) }}'">编辑</button>
		</div>
	</div>
@stop