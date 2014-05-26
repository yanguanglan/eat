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
		<div class="header">
		<div class="confirm">更多</div>
		<div class="til">考勤统计</div>
	    </div>
		<div class="inquire">
			<div class="inpuireCont">
				<p class="time">{{ date('Y-m-d') }}  {{$week[date('N')]}}</p>
				<h2 class="type">在岗</h2>
				<p class="num"><a href="{{ URL::route('mobile.todayorderlist', 'work')}}">{{ $work }}</a><span>人</span></p>
			</div>
		</div>
		<div class="inquire inquire02">
			<div class="inpuireCont">
				<p class="time">{{ date('Y-m-d') }}  {{$week[date('N')]}}</p>
				<h2 class="type">请假</h2>
				<p class="num"><a href="{{ URL::route('mobile.todayorderlist', 'leave')}}">{{ $leave }}</a><span>人</span></p>
			</div>
		</div>
		<div class="inquire">
			<div class="inpuireCont">
				<p class="time">{{ date('Y-m-d') }}  {{$week[date('N')]}}</p>
				<h2 class="type">公干</h2>
				<p class="num"><a href="{{ URL::route('mobile.todayorderlist', 'travel')}}">{{ $travel }}</a><span>人</span></p>
			</div>
		</div>
		<div class="inquire inquire02">
			<div class="inpuireCont">
				<p class="time">{{ date('Y-m-d') }}  {{$week[date('N')]}}</p>
				<h2 class="type">未打卡</h2>
				<p class="num"><a href="{{ URL::route('mobile.todayorderlist', 'nowork')}}">{{ $nowork }}</a><span>人</span></p>
			</div>
		</div>
	</div>
@stop