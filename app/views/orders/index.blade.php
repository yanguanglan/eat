@extends('_layouts.default')

@section('main')

	<h1>
		订餐列表 <a href="{{ URL::route('orders.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> 新增订餐</a>
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
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($orders as $order)
				<tr>
					<td>{{ $order->id }}</td>
					<td><a href="{{ URL::route('orders.show', $order->id) }}">{{ $order->user->name }}</a></td>
					<td>{{ $order->breakfast }}</td>
					<td>{{ $order->lunch }}</td>
					<td>{{ $order->dinner }}</td>					
					<td>{{ $order->created_at }}</td>
					<td>@if($order->issms) 是 @else 否 @endif</td>
					<td>
						<a href="{{ URL::route('orders.edit', $order->id) }}" class="btn btn-success btn-mini pull-left">编辑</a>

						{{ Form::open(array('route' => array('orders.destroy', $order->id), 'method' => 'delete', 'data-confirm' => '确定操作？')) }}
							<button type="submit" href="{{ URL::route('orders.destroy', $order->id) }}" class="btn btn-danger btn-mini">删除</button>
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{ $orders->links() }}
@stop