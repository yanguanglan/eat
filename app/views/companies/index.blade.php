@extends('_layouts.default')

@section('main')

	<h1>
		单位列表 <a href="{{ URL::route('companies.create') }}" class="btn btn-success"><i class="icon-plus-sign"></i> 新增单位</a>
	</h1>

	<hr>

	{{ Notification::showAll() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>单位名称</th>
				<th>手机号码</th>
				<th>管理员电话</th>
				<th>添加时间</th>
				<th>发送短信</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($companies as $company)
				<tr>
					<td>{{ $company->id }}</td>
					<td><a href="{{ URL::route('companies.show', $company->id) }}">{{ $company->name }}</a></td>
					<td>{{ $company->phone }}</td>
					<td>{{ $company->adminphone }}</td>
					<td>{{ $company->created_at }}</td>
					<td>@if($company->issms) 是 @else 否 @endif</td>
					<td>
						<a href="{{ URL::route('companies.edit', $company->id) }}" class="btn btn-success btn-mini pull-left">编辑</a>

						{{ Form::open(array('route' => array('companies.destroy', $company->id), 'method' => 'delete', 'data-confirm' => '确定操作？')) }}
							<button type="submit" href="{{ URL::route('companies.destroy', $company->id) }}" class="btn btn-danger btn-mini">删除</button>
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{ $companies->links() }}
@stop