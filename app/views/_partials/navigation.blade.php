@if(Auth::check())
	<ul class="nav">
		@if(Auth::user()->id == 1)<li class="{{ Request::is('companies*') ? 'active' : null }}"><a href="{{ URL::route('companies.index') }}"><i class="icon-home"></i> 单位管理</a></li>@endif
		<li class="{{ Request::is('users*') ? 'active' : null }}"><a href="{{ URL::route('users.index') }}"><i class="icon-user"></i> 员工管理</a></li>
		<li class="{{ Request::is('departments*') ? 'active' : null }}"><a href="{{ URL::route('departments.index') }}"><i class="icon-bell"></i> 班次管理</a></li>
		<li class="{{ Request::is('order.today*') ? 'active' : null }}"><a href="{{ URL::route('order.today') }}"><i class="icon-glass"></i> 今日订餐</a></li>
		<li class="{{ Request::is('news*') ? 'active' : null }}"><a href="{{ URL::route('news.index') }}"><i class="icon-signal"></i> 通知管理</a></li>
		<li>
		<li class="{{ Request::is('order.search') ? 'active' : null }}"><a href="{{ URL::route('order.search') }}"><i class="icon-search"></i> 考勤查询</a></li>
		<li>
		<li class="">
		<a href="#" data-toggle="dropdown" class="dropdown-toggle">
			<i class="icon-wrench"></i>
			{{ Auth::user()->name }}
		</a>
		<ul class="dropdown-menu pull-right">
			<li>
				<a href="{{ URL::route('admin.profile') }}">修改密码</a>
			</li>
			<li>
				<a href="{{ URL::route('admin.logout') }}">退出</a>
			</li>		</ul>
	</li>
	</ul>
@endif