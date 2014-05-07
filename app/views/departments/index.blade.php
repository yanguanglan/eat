@extends('_layouts.default')

@section('main')

	<h1>
		班次列表 <a href="{{ URL::route('departments.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> 新增班次</a>
	</h1>

	<hr>

	{{ Notification::showAll() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>班次</th>
				<th>上班时间</th>
				<th>下班时间</th>
				<th>添加时间</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($departments as $department)
				<tr>
					<td>{{ $department->id }}</td>
					<td><a href="{{ URL::route('departments.show', $department->id) }}">{{ $department->name }}</a></td>
					<td>{{ $department->starttime }}</td>
					<td>{{ $department->endtime }}</td>
					<td>{{ $department->created_at }}</td>
					<td>
						<a href="{{ URL::route('departments.edit', $department->id) }}" class="btn btn-success btn-mini pull-left">编辑</a>

						{{ Form::open(array('route' => array('departments.destroy', $department->id), 'method' => 'delete', 'data-confirm' => '确定操作？')) }}
							<button type="submit" href="{{ URL::route('departments.destroy', $department->id) }}" class="btn btn-danger btn-mini">删除</button>
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{ $departments->links() }}
@stop