@extends('_layouts.mobile')
@section('main')
<script type="text/javascript">
		$(function(){
			var winHeight=$(window).height();
			$(".login").height(winHeight);
			//当改变窗口大小
			$(window).resize(function(){
				location.reload(); 
			});
		})
</script>
{{ Form::open() }}
<div class="login">
		<div class="loginCont">
			<p>考勤订餐系统</p>
			<h1>登录</h1>
			@if ($errors->has('login'))
				<div class="alert alert-error">{{ $errors->first('login', ':message') }}</div>
			@endif
			<input type="text" name="name" placeholder="请输入管理员电话"  class="input01"/>
			<input type="password" name="password" placeholder="请输入密码"  class="input01"/>
			<input type="submit" value="立即登录"  class="btn"/>
		</div>
</div>
{{ Form::close() }}
@stop