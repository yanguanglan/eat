@extends('_layouts.default')

@section('main')

	<h1>
		今日订餐列表
	</h1>

	<hr>

	{{ Notification::showAll() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>用户</th>
				<th>早餐</th>
				<th>中餐</th>
				<th>晚餐</th>
				<th>添加时间</th>
				<th>发送短信</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($orders as $order)
				<tr>
					<td>{{ $order->id }}</td>
					<td>{{ $order->user->name }}</a></td>
					<td>{{ $order->breakfast }}</td>
					<td>{{ $order->lunch }}</td>
					<td>{{ $order->dinner }}</td>					
					<td>{{ $order->created_at }}</td>
					<td>@if($order->issms) 是 @else 否 @endif</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{ $orders->links() }}
@stop