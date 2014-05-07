@extends('_layouts.default')

@section('main')

	<h1>
		员工列表 <a href="{{ URL::route('users.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> 新增员工</a>
	</h1>

	<hr>

	{{ Notification::showAll() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>工号</th>
				<th>姓名</th>
				<th>手机号码</th>
				<th>添加时间</th>
				<th>在职</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->sn }}</td>
					<td><a href="{{ URL::route('users.show', $user->id) }}">{{ $user->name }}</a></td>
					<td>{{ $user->phone }}</td>
					<td>{{ $user->created_at }}</td>
					<td>@if ($user->iswork) 是 @else 否 @endif</td>
					<td>
						<a href="{{ URL::route('users.edit', $user->id) }}" class="btn btn-success btn-mini pull-left">编辑</a>

						{{ Form::open(array('route' => array('users.destroy', $user->id), 'method' => 'delete', 'data-confirm' => '确定操作？')) }}
							<button type="submit" href="{{ URL::route('users.destroy', $user->id) }}" class="btn btn-danger btn-mini">删除</button>
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{ $users->links() }}
@stop