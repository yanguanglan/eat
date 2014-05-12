@extends('_layouts.default')

@section('main')

	<h1>考勤查询</h1>

	<hr>

	{{ Notification::showAll() }}
{{ Form::open(array('route' => 'order.search.post', 'method'=>'post', 'class'=>'form-search')) }}
{{ Form::input('date', 'keyword', $today, array('class' => 'input-medium', 'placeholder' => 'Date')) }}
{{ Form::submit('查询', array('class' => 'btn btn-success btn-save btn-medium')) }}
{{ Form::close() }}
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>工号</th>
				<th>姓名</th>
				<th>上午</th>
				<th>下午</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->sn }}</td>
					<td>{{ $user->name }}</td>
					<td>@if (isset($morning[$user->id])) @if (punch($morning[$user->id]->created_at, $department)) <span class="label label-warning">{{ $morning[$user->id]->created_at }}</span> @else {{ $morning[$user->id]->created_at }} @endif @else 未打卡 @endif</td>
					<td>@if (isset($afternoon[$user->id])) @if (punch($afternoon[$user->id]->created_at, $department)) <span class="label label-warning">{{ $afternoon[$user->id]->created_at }}</span> @else {{ $afternoon[$user->id]->created_at }} @endif @else 未打卡 @endif</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{--- $orders->links() ---}}
@stop