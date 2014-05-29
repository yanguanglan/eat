@extends('_layouts.mobile')
@section('main')
<script type="text/javascript">
		$(function(){
			var winHeight=parseInt($(window).height()) - 40,
				mainH=winHeight - 30,
				contH=winHeight / 2;
			$(".main").height(mainH);
			$(".inquire").height(contH);
			//当改变窗口大小
			$(window).resize(function(){
				location.reload(); 
			});
		})
</script>
<div class="blueBg">
<div class="header ">
		<a class="back" href="{{ URL::route('user.admin.logout') }}">退出</a>
		<a href="" class="confirm"></a>
		<div class="til"></div>
	</div>
	<div class="main">
		<!--<hr class="hr01" />
		<hr class="hr02" />-->
		<div class="inquire inquire01">
			<div class="inpuireCont">
				<h2 class="type">在岗人数</h2>
				<p class="num"><a href="{{ URL::route('mobile.todayorderlist', 'work')}}">{{ $work }}</a><span>人</span></p>
			</div>
		</div>
		<div class="inquire inquire01">
			<div class="inpuireCont">
				<h2 class="type">公干人数</h2>
				<p class="num"><a href="{{ URL::route('mobile.todayorderlist', 'travel')}}">{{ $travel }}</a><span>人</span></p>
			</div>
		</div>
		<div class="inquire inquire01">
			<div class="inpuireCont">
				<h2 class="type">请假人数</h2>
				<p class="num"><a href="{{ URL::route('mobile.todayorderlist', 'leave')}}">{{ $leave }}</a><span>人</span></p>
			</div>
		</div>
		<div class="inquire inquire01">
			<div class="inpuireCont">
				<h2 class="type">未打卡人数</h2>
				<p class="num"><a href="{{ URL::route('mobile.todayorderlist', 'nowork')}}">{{ $nowork }}</a><span>人</span></p>
			</div>
		</div>
	</div>
</div>
@stop