<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>在线订餐</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@include('_partials.assets')
</head>
<body>
<div class="container">
	<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="@if(Session::has('user_id')) {{ URL::route('user.order', Session::get('co_id')) }} @endif">在线订餐</a>

@if(Session::has('user_id'))
	<ul class="nav">
		<li class="">
		<a href="#" data-toggle="dropdown" class="dropdown-toggle">
			<i class="icon-user"></i>
			{{ Session::get('name') }}
		</a>
		<ul class="dropdown-menu pull-right">
			<li>
				<a href="{{ URL::route('user.profile') }}">修改密码</a>
			</li>
			<li>
				<a href="{{ URL::to('auth/logout') }}">退出</a>
			</li>		
		</ul>
	    </li>
	</ul>
@endif
		</div>
	</div>
</div>

<hr>
	@yield('main')
</div>
</body>
</html>