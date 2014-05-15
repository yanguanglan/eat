@extends('_layouts.mobile')
@section('main')
<script type="text/javascript">
$(function(){
	$(".confirm").click(function(){
		$("#form").submit();
	})
})
</script>
<div class="header ">
<a class="back" href="{{ URL::route('user.admin.logout') }}">退出</a>
<div class="confirm">查询</div>
<div class="til">考勤</div>
</div>
{{ Form::open(array('route' => 'mobile.order.search.post', 'name'=>'form', 'id'=>'form', 'method'=>'post')) }}
<div class="header search">
	<div class="searchBox">
{{ Form::input('date', 'keyword', $today, array('class' => 'input01', 'placeholder' => 'Date')) }}
	</div>
	</div>
{{ Form::close() }}
	<div class="header table">
		<div class="tableList">工号 姓名</div>
		<div class="tableList"><b class="b1"></b>上午<b class="b2"></b></div>
		<div class="tableList">下午</div>
	</div>
	<div class="contTab">
		@foreach ($users as $user)
		<div class="table">
			<div class="tableList">{{ $user->sn }} {{ $user->name }}</div>
			<div class="tableList"><b class="b1"></b>@if (isset($morning[$user->id])) @if (punch($morning[$user->id]->worked_at, $department)) <span class="cd">{{ $morning[$user->id]->worked_at }}</span> @else {{ $morning[$user->id]->worked_at }} @endif @else <span class="lack">未打卡</span> @endif<b class="b2"></b></div>
			<div class="tableList">@if (isset($afternoon[$user->id])) @if (punch($afternoon[$user->id]->worked_at, $department)) <span class="cd">{{ $afternoon[$user->id]->worked_at }}</span> @else {{ $afternoon[$user->id]->worked_at }} @endif @else <span class="lack">未打卡</span> @endif</div>
		</div>
		@endforeach
	</div>
@stop