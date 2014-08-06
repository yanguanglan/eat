@extends('_layouts.default')

@section('main')

<ul class="nav nav-tabs" role="tablist">
  <li role="presentation"><a href="{{ URL::route('order.search') }}">考勤查询</a></li>
  <li role="presentation" class="active"><a href="{{ URL::route('order.count') }}">考勤统计</a></li>
  <li role="presentation"><a href="{{ URL::route('order.setdate') }}">日期设置</a></li>
</ul>

	{{ Notification::showAll() }}
{{ Form::open(array('route' => 'order.count.post', 'method'=>'post', 'class'=>'form-search')) }}
{{ Form::input('date', 'keyword', $today, array('class' => 'input-medium', 'placeholder' => 'Date')) }}
{{ Form::submit('查询', array('class' => 'btn btn-success btn-save btn-medium')) }}
{{ Form::close() }}
	<div class="alert alert-info count_text"></div>
	<table class="table table-striped count-table">
		<thead>
			<tr>
				<th>#</th>
				<th>工号</th>
				<th>姓名</th>
				<th>电话</th>
				<th>正常打卡(次)</th>
				<th>迟到或早退(次)</th>
				<th>未打卡(次)</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<?php $user['no_records'] = $num_count-$user['normal']-$user['late'];?>
				<tr>
					<td>{{ $user['user_id'] }}</td>
					<td>{{ $user['sn'] }}</td>
					<td>{{ $user['name'] }}</td>
					<td>{{ $user['phone'] }}</td>
					<td class="normal" data-count="{{ $user['normal'] }}">
						<span class="label label-success">{{ $user['normal'] }}</span>
					</td>
					<td class="late" data-count="{{ $user['late'] }}">
						<span class="label <?php echo $user['late']>0 ? 'label-warning' : 'label-success'?>">{{ $user['late'] }}</span>
					</td>
					<td class="no_records" data-count="{{ $user['no_records'] }}">
						<span class="label <?php echo $user['no_records']>0 ? 'label-important' : 'label-success'?>">{{ $user['no_records'] }}</span>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<script>
		J(function(){
		    J('.input-medium').calendar({ btnBar:true,format:'yyyy-MM' });
		});
		$(function(){
			var late_count=0,normal_count=0;
			$.each($('.count-table tbody tr'),function(i,n){
				var late=$(this).find('td.late').attr('data-count');
				var no_records=$(this).find('td.no_records').attr('data-count');
				if(late == '0' && no_records == '0'){
					normal_count++;
				}else{
					late_count++;
				}
			});
			$('.count_text').html(' 当前月份，迟到、早退或未打卡'+late_count+'人<br/> 全勤'+normal_count+'人');
		});
	</script>
@stop