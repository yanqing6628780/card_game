<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>好运自然来</title>
<link rel="stylesheet" type="text/css" href="{{ elixir('assets/css/all.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('assets/css/app.css') }}">
@yield('head_css')
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <img class="img-responsive center-block" src="{{url('assets/images/header.jpg')}}">
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="jumbotron my-jumbotron">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="row rule">
        <div class="col-xs-12">
            <h4>活动规则</h4>
            <p>1、每个用户只能抽取一次礼品：中山（三乡）樱花旅游文化节门票两张或缅甸水果3个；</p>
            <p>2、成功集齐6个色块，即可赢取礼品一份，份数多多；</p>
            <p>3、每个用户只能抽取一次礼品：中山（三乡）樱花旅游文化节门票两张或缅甸水果3个；</p>
        </div>
    </div>
    @yield('winner')
    <div class="row">
        <div class="col-xs-12">
            <img class="img-responsive center-block" src="{{url('assets/images/qrcode.jpg')}}">
            <p class="text-center">微信号：三乡发布</p>
        </div>
    </div>
</div>
<div class="mask">
    <h3 class="text-center">请点击右上角分享到朋友圈</h3>
</div>

<script src="{{ elixir('assets/js/all.js') }}"></script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
@yield('foot_js')
</body>
</html>