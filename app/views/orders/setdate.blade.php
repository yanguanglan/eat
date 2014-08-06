@extends('_layouts.default')

@section('main')

<ul class="nav nav-tabs" role="tablist">
  <li role="presentation"><a href="{{ URL::route('order.search') }}">考勤查询</a></li>
  <li role="presentation"><a href="{{ URL::route('order.count') }}">考勤统计</a></li>
  <li role="presentation" class="active"><a href="{{ URL::route('order.setdate') }}">日期设置</a></li>
</ul>

	{{ Notification::showAll() }}
{{ Form::open(array('route' => 'order.setdate.post', 'method'=>'post', 'class'=>'form-search')) }}
{{ Form::input('date', 'keyword', $today, array('class' => 'input-medium', 'placeholder' => 'Date')) }}
{{ Form::submit('查询', array('class' => 'btn btn-success btn-save btn-medium')) }}
{{ Form::close() }}

<div class="alert alert-info count_text"></div>
{{ Form::open(array('route' => 'order.setdate.post', 'method'=>'post', 'class'=>'form-setdate')) }}
	<?php $today.='-';?>
	{{ Form::input('hidden', 'savedate', 1)}}
	{{ Form::input('hidden', 'ym', $today)}}
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>日期</th>
				<th>星期</th>
				<th>是否考勤</th>
			</tr>
		</thead>
		<tbody>
			<?php $weekarray=array("日","一","二","三","四","五","六");?>
			@for ($i=1;$i<=$day_num;$i++)
				<?php $i=$i<10?'0'.$i:$i;?>
				<?php $w=date("w",strtotime($today.$i));?>
				<tr class="<?php echo !in_array($w, array(6,0))?'success':'warning'?>">
					<td>{{ $i }}</td>
					<td>{{ '星期'.$weekarray[$w] }}</td>
					<td>{{ $today.$i }}</td>
					<td class="is_work" week="{{$w}}">
						<?php
							if(isset($list[$today.$i]->is_work)){
								if($list[$today.$i]->is_work == 1){
									echo Form::checkbox('name['.$today.$i.']', 1, true);
								}else{
									echo Form::checkbox('name['.$today.$i.']', 1, false);
								}
							}else{
								echo Form::checkbox('name['.$today.$i.']', 1, false);
							}
						?>
					</td>
				</tr>
			@endfor
		</tbody>
	</table>
	<div class="form-actions">
    	<button id="select_all" is_all="0" style="float: left;" class="btn btn-small">全&#12288;选</button>
    	<button id="select_work_day" style="float: left;" class="btn btn-small">选择工作日</button>
    	{{ Form::submit('保&#12288;存', array('class' => 'btn btn-large btn-primary','style'=>'float: right;margin: 0 5px;')) }}
    </div>
{{ Form::close() }}
    <script>
	    J(function(){
		    J('.input-medium').calendar({ btnBar:true,format:'yyyy-MM' });
		});
		$(function(){
			var workday=$('.is_work input[type="checkbox"]:checked').length;
			var restday=$('.is_work input[type="checkbox"]:not(:checked)').length;
			$('.count_text').html('当前月份，考勤日为'+workday+'天，休息日为'+restday+'天！');
			$('#select_all').click(function(){
				if($(this).attr('is_all') == '0'){
					$(this).attr('is_all',1);
					$('.is_work input[type="checkbox"]').prop("checked", true);
				}else{
					$(this).attr('is_all',0);
					$('.is_work input[type="checkbox"]').prop("checked", false);
				}
				return false;
			});
			$('#select_work_day').click(function(){
				$.each($('.is_work input[type="checkbox"]'), function(i, n){
					$(this).prop('checked',$.inArray($(this).parent('td').attr('week'),['0','6']) === -1);
				});
				return false;
			});
		});
    </script>
@stop