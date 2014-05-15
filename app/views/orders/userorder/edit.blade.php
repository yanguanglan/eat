@extends('_layouts.mobile')

@section('main')
	{{ Form::model($order, array('method' => 'post', 'name'=>'form', 'id'=>'form', 'route' => array('user.order.post'))) }}
	<div class="header ">
		<a class="back" href="{{ URL::to('auth/logout') }}">退出</a>
		<a class="confirm">确认</a>
		<div class="til">订餐</div>
	</div>
		<div class="contTab">
		@if (Session::has('success'))
			<p class="warning">
				{{ Session::get('success') }}
			</p>
		@endif
		@if ($errors->any())
			<p class="warning">
				{{ implode(',', $errors->all()) }}
			</p>
		@endif
		<div class="table">
			<div class="person">
				<span class="name">{{ Session::get('name') }}</span>
			</div>
		</div>
		<div class="table perList">
			<div class="person">
				<h2><span class="title">早上食堂就餐</span><a class="btn @if($order->breakfast == 0) no @else yes @endif"></a></h2>
				<p><a class="lower"></a>招待<span class="num">@if($order->breakfast > 1) {{ $order->breakfast - 1}} @else 0 @endif</span>人<a class="add"></a></p>
			<input name="breakfast" id="breakfast" type="hidden" value="{{ $order->breakfast }}" />
			</div>
		</div>
		<div class="table perList">
			<div class="person">
				<h2><span class="title">中午食堂就餐</span><a class="btn @if($order->lunch == 0) no @else yes @endif"></a></h2>
				<p><a class="lower"></a>招待<span class="num">@if($order->lunch > 1) {{ $order->lunch - 1}} @else 0 @endif</span>人<a class="add"></a></p>
				<input name="lunch" id="lunch" type="hidden" value="{{ $order->lunch }}" />
			</div>
		</div>
		<div class="table perList">
			<div class="person">
				<h2><span class="title">晚上食堂就餐</span><a class="btn @if($order->dinner == 0) no @else yes @endif"></a></h2>
				<p><a class="lower"></a>招待<span class="num">@if($order->dinner > 1) {{ $order->dinner - 1}} @else 0 @endif</span>人<a class="add"></a></p>
				<input name="dinner" id="dinner" type="hidden" value="{{ $order->dinner }}" />
			</div>
		</div>
	</div>
	{{ Form::close() }}

	{{ Form::model($user, array('method' => 'post', 'route' => array('user.profile.post'))) }}
	<div class="pwd">
		<h1>修改资料</h1>
		    <p><lable for="phone">手机号码</label></p>
		    {{ Form::text('phone', $user->phone, array('class'=>'input01')) }}
		    <p><lable for="password">密码</label></p>
		    {{ Form::password('password', '', array('class'=>'input01')) }}
		<input type="submit" value="确定修改"  class="btn"/>
	</div>
	{{ Form::close() }}

<script type="text/javascript">
		$(function(){
			//yes or no
			$("h2.btn").click(function(){
				if($(this).hasClass("yes")){
					$(this).removeClass("yes")
					$(this).addClass("no");
					$(this).parent().parent().find(".num").text("0");
					$(this).parent().parent().find("input").val(0);
				}else{
					$(this).removeClass("no")
					$(this).addClass("yes");
					$(this).parent().parent().find("input").val(1);
				}
			})
			
			$(".confirm").click(function(){
				$("#form").submit();
			})
			
			//add or lower
			$(".lower").click(function(){
				if ($(this).parent().parent().find(".btn").hasClass("no"))
				{
					return;
				}
				var _num=parseInt($(this).parent("p").find(".num").text());
				var _val = parseInt($(this).parent().parent().find("input").val());
				_num=_num-1;
				_val = _val - 1;
				if(_num < 1){
					$(this).css('display','none');
					$(this).parent("p").find(".num").text("0");
					$(this).parent().parent().find("input").val(_val);
				}else{
					$(this).parent("p").find(".num").text(_num);
					$(this).parent().parent().find("input").val(_val);
				}
			})
			$(".add").click(function(){
				if ($(this).parent().parent().find(".btn").hasClass("no"))
				{
					return;
				}
				var _num=parseInt($(this).parent("p").find(".num").text());
				var _val = parseInt($(this).parent().parent().find("input").val());
				_num=_num+1;
				_val = _val + 1;
				$(this).parent("p").find(".num").text(_num);
				$(this).parent().parent().find("input").val(_val);
				if(_num > 0){
					$(this).siblings(".lower").css('display','block');
				}
			})
			
			
			//加减号的判断
			var ln=$('.perList').length;
			for(var i=0;i<ln;i++){
				if($('.perList').eq(i).find('.num').html()==0){
					$('.perList').eq(i).find('.lower').hide();
					}
				}
			
		})
	</script>
@stop