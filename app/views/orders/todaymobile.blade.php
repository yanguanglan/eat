@extends('_layouts.mobile')
@section('main')
<script type="text/javascript">
		$(function(){
			var winHeight=$(window).height();
			var _height=winHeight / 2;
			$(".inquire").height(_height);
		})
	</script>
<div class="login">
		<div class="header ">
		<a class="confirm" href="{{ URL::route('mobile.order.todaylist', Route::input('co_id'))}}">更多</a>
		<div class="til">今日订餐</div>
	    </div>
		<div class="inquire">
			<div class="inpuireCont">
				<p class="time">{{ date('Y-m-d') }}  {{$week[date('N')]}}</p>
				<h2 class="type">中午吃饭</h2>
				<p class="num">{{ $lunch }}<span>人</span></p>
			</div>
		</div>
		<div class="inquire inquire02">
			<div class="inpuireCont">
				<p class="time">{{ date('Y-m-d') }}  {{$week[date('N')]}}</p>
				<h2 class="type">晚上吃饭</h2>
				<p class="num">{{ $dinner }}<span>人</span></p>
			</div>
		</div>
	</div>
@stop