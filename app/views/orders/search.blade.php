@extends('_layouts.default')

@section('main')

<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="{{ URL::route('order.search') }}">考勤查询</a></li>
  <li role="presentation"><a href="{{ URL::route('order.count') }}">考勤统计</a></li>
  <li role="presentation"><a href="{{ URL::route('order.setdate') }}">日期设置</a></li>
</ul>

	{{ Notification::showAll() }}
{{ Form::open(array('route' => 'order.search.post', 'method'=>'post', 'class'=>'form-search')) }}
{{ Form::input('date', 'keyword', $today, array('class' => 'input-medium', 'placeholder' => 'Date')) }}
{{ Form::submit('查询', array('class' => 'btn btn-success btn-save btn-medium')) }}
{{ Form::close() }}
	<div class="alert alert-info count_text"></div>
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
			<?php $morning_late = $morning_leave_early = 0;?>
			<?php $afternoon_late = $afternoon_leave_early = 0;?>
			@foreach ($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->sn }}</td>
					<td>{{ $user->name }}</td>
					<td>
						@if (isset($morning[$user->id]))
							@if (punch($morning[$user->id]->worked_at, $department))
								<?php $morning_late++;?>
								<span class="label label-warning">{{ $morning[$user->id]->worked_at }}</span>
							@else
								<span class="label label-success">{{ $morning[$user->id]->worked_at }}</span>
							@endif
						@else
							<?php $morning_leave_early++;?>
							<span class="label label-important">未打卡</span>
						@endif
					</td>
					<td>
						 @if (isset($afternoon[$user->id]))
							 @if (punch($afternoon[$user->id]->worked_at, $department))
							 	<?php $afternoon_late++;?>
								 <span class="label label-warning">{{ $afternoon[$user->id]->worked_at }}</span>
							 @else
							 	<span class="label label-success">{{ $afternoon[$user->id]->worked_at }}</span>
							 @endif
						 @else
						 	 <?php $afternoon_leave_early++;?>
							 <span class="label label-important">未打卡</span>
						 @endif
					 </td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{--- $users->links() ---}}
	<script>
	    J(function(){
		    J('.input-medium').calendar({ btnBar:true,format:'yyyy-MM-dd' });
		});
		$(function(){
			$('.count_text').html(' 上午迟到'+{{$morning_late}}+'人，未打卡'+{{$morning_leave_early}}+'<br/> 下午早退'+{{$afternoon_late}}+'人，未打卡'+{{$afternoon_leave_early}})
		});
	</script>
@stop