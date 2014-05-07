@extends('_layouts.default')

@section('main')

	<h1>
		通知列表 <a href="{{ URL::route('news.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> 新增通知</a>
	</h1>

	<hr>

	{{ Notification::showAll() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>标题</th>
				<th>添加时间</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($news as $new)
				<tr>
					<td>{{ $new->id }}</td>
					<td><a href="{{ URL::route('news.show', $new->id) }}">{{ $new->title }}</a></td>					
					<td>{{ $new->created_at }}</td>
					<td>
						<a href="{{ URL::route('news.edit', $new->id) }}" class="btn btn-success btn-mini pull-left">编辑</a>

						{{ Form::open(array('route' => array('news.destroy', $new->id), 'method' => 'delete', 'data-confirm' => '确定操作？')) }}
							<button type="submit" href="{{ URL::route('news.destroy', $new->id) }}" class="btn btn-danger btn-mini">删除</button>
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{ $news->links() }}
@stop