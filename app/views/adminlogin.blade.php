@extends('_layouts.mobile')
@section('main')
<div class="login">
	{{ Form::open() }}
		<div class="loginCont">
			<p>考勤订餐系统</p>
			<h1>登录</h1>
			@if ($errors->has('login'))
				<div class="alert alert-error">{{ $errors->first('login', ':message') }}</div>
			@endif
			<input type="text" name="name" placeholder="请输入单位名称"  class="input01"/>
			<input type="password" name="password" placeholder="请输入密码"  class="input01"/>
			<input type="submit" value="立即登录"  class="btn"/>
		</div>
		{{ Form::close() }}
</div>
@stop