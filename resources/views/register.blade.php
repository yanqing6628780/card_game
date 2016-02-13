@extends('_layouts.default')

@section('content')
@if($player == null)
<div>   
    <h4 class="title">填写资料,申请集色卡</h4>
    <form method="post">
        <div class="form-group">
            <label for="name">姓名</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="姓名"/>
        </div>
        <div class="form-group">
            <label for="phone">电话</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="电话"/>
        </div>
        <button type="submit" class="btn btn-danger btn-block">提交</button>
        <input type="hidden" name="_token" class="form-control" value="{{ csrf_token() }}" />
    </form>
</div>
@else
<a href="{{url('/game/'.$player->id)}}" class="btn btn-danger btn-block">我的色卡</a>
@endif
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@stop
