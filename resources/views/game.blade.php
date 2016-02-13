@extends('_layouts.default')

@section('content')
<h4 class="title">十八的色卡，帮TA领礼品</h4>
<div class="image-coloring clearfix">
    <div style="display: table;margin: 0 auto">
    @for ($i = 1; $i < 6; $i++)
    @if ($i <= $activated_card)
    <img src="{{url('assets/images/block-'.$i.'-active.jpg')}}" class="card active">
    @else
    <img src="{{url('assets/images/block-'.$i.'.jpg')}}" class="card">
    @endif
    @endfor
    </div>
</div>
<div class="image-coloring clearfix">
    <div style="display: table;margin: 0 auto">
    @for ($i = 6; $i < 11; $i++)
    @if ($i <= $activated_card)
    <img src="{{url('assets/images/block-'.$i.'-active.jpg')}}" class="card active">
    @else
    <img src="{{url('assets/images/block-'.$i.'.jpg')}}" class="card">
    @endif
    @endfor
    </div>
</div>
<p class="text-center">
    游戏时间: 1月25日-1月29日
    <br>
    活动参与人数: {{$real_players_num}}
</p>
@if($is_self == 0)
<button class="btn btn-danger btn-block" id="coloring_btn">帮TA填色</button>
<a href="{{action('homeController@getRegister')}}" class="btn btn-info btn-block">我也要填色拿礼品</a>
@endif
@stop

@section('winner')
<div class="jumbotron my-jumbotron">
    <table class="table table-striped table-condensed">
        <caption>中奖名单</caption>
        <thead>
            <tr>
                <th>姓名</th>
                <th>电话</th>
            </tr>
        </thead>
        <tbody>                
        @foreach ($winners as $item)
        <tr>
            <td>{{$item->user->name}}</td>
            <td>{{$item->user->phone}}</td>
        @endforeach
        </tr>
        </tbody>
    </table>
</div>
@stop

@section('foot_js')
<script type="text/javascript">
var is_self = {{$is_self}};
var hits = {{$player->card->hits}};
var is_winner = {{$player->card->is_winner}};
var activated_card = {{$activated_card}};

// wx.config({!! $wechat_js->config(array('onMenuShareTimeline'), false, true) !!} );

// wx.ready(function(){
//     
//     wx.onMenuShareTimeline({
//         title: '好运自然来',
//         link: '{{action("homeController@getGame", [$player->id])}}',
//         imgUrl: "{{url('assets/images/header.jpg')}}",
//         success: function () { 
            
//         },
//         cancel: function () { 
            
//         }
//     });
// 
// });

$(function() {
    if(is_self == 1) {
        $('.mask').show().on('click', function(event) {
            $(this).hide();
        });
        setTimeout(function(){
            $('.mask').hide();
        }, 3000);
    }
    $('#coloring_btn').on('click', function(event) {
        $.ajax({
            url: '{{action("homeController@postHits")}}',
            type: 'POST',
            dataType: 'json',
            data: { player_id: {{$player->id}} },
        })
        .done(function(data) {
            console.log("success");

            if(data.activated_card){            
                if(activated_card != data.activated_card){
                    alert('收集成功!');
                    activated_card = data.activated_card;
                    cardRefresh();
                }else{
                    data.msg || alert('很遗憾,请继续努力~');
                }
            }

            data.msg && alert(data.msg);
        })
        .fail(function() {
            alert("error");
        });
    });

    function cardRefresh () {
        $.each($('.card'), function (index, element) {
            if( $(element).hasClass("active") == false) {
                if( (index+1) <= activated_card ){
                    var old_src = $(element).attr('src');
                    var file_name = old_src.substr(0, (old_src.length-4));
                    var new_src = file_name + '-active.jpg';
                    $(element).attr('src', new_src);
                    console.log(new_src);
                }
            }
        })
    }
})
</script>
@stop