@extends('layouts.master')
@section('content')
<div class="home-page">
    <div class="landing">
        <div class="landing-wrap">
            <div class="landing-inner">
                @if(auth()->check())

                @else
                <a class="landing-login" href="{{ url('/auth/facebook') }}" waves-hover>
                    <i class="icon-facebook"></i>
                    Connect
                </a>
                @endif
                <h1 class="landing-title">
                Get a Free Market Overview Now
                </h1>
                <p class="landing-txt">
                   Discover your key performances indicators, Learn  from social leaders and Set goals and baselines for performance and growth based on your direct competitors.
                </p>
               @if(auth()->check())
                <a style="color:white" href="{{ url('/home') }}" class="landing-btn" waves-hover>
                My Benchmarks
                </a>
               @else
                <a style="color:white" href="{{ url('/default/no') }}" class="landing-btn" waves-hover>
                Download a default example
                </a>
               @endif
                <div class="video">
                    <div class="video-inner">
                        <video autoplay="" loop="" muted="" playsinline="" poster="{{url('/images/background.png')}}">
                            <source src="{{ url('/front.mp4') }}" type="video/mp4">
                            <source src="{{ url('/front.mp4') }}">
                            Your browser does not support the video tag.
                        </video>
                        <img class="video-screen" src="/assets/images/md-screen.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <img class="cloud cloud-1" src="/assets/images/cloud_1.png" alt="">
        <img class="cloud cloud-2" src="/assets/images/cloud_2.png" alt="">
    </div>
    <div class="home-form">
        <form id="submit_pages" action="{{ route('newDemoBench') }}" method="POST" >
         {{ csrf_field() }}
            <div class="hf-header">
                <h2>
                Add facebook pages
                </h2>
                <p>
                    Discover your key performances indicators, Learn from social leaders and Set goals and baselines for performance and growth based on your direct competitors.
                </p>
                <div id="min" class="alert alert-danger" style="display: none">
                  <strong>Danger!</strong> Minimum : 2 pages.
                </div>
            </div>
            <div class="fb-wrap">
                <div class="media fb-box focused">
                    <div class="media-left fb-icon">
                        <i class="icon-facebook"></i>
                    </div>
                    <div id="f_0" class="media-body fb-inner error_c">
                        <h4 class="fb-nb">First page</h4>
                        <input id="fb_page_0" class="fb-input" type="text" name="accounts[]"
                        placeholder="https://www.facebook.com/exemple">
                    </div>
                </div>
                <div class="media fb-box">
                    <div class="media-left fb-icon">
                        <i class="icon-facebook"></i>
                    </div>
                    <div id="f_1" class="media-body fb-inner error_c">
                        <h4 class="fb-nb">Second page</h4>
                        <input id="fb_page_1" class="fb-input" type="text" name="accounts[]"
                        placeholder="https://www.facebook.com/exemple">
                    </div>
                </div>
            </div>
            <div class="media mail">
                <div class="media-right mail-submit">
                    <button id="trigger" type="button" waves-hover>
                    Generate
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<input type="hidden" id="refreshed" value="no">
<script type="text/javascript">
onload=function(){
    var e=document.getElementById("refreshed");
    if(e.value=="no")e.value="yes";
    else{e.value="no";location.reload();}
}
</script>
@endsection


@section('js')
<!-- Global site tag (gtag.js) - Google AdWords: 825013547 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-825013547"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());
 gtag('config', 'AW-825013547');
</script>
<script type="text/javascript">
var auth = {!! json_encode(auth()->check()) !!}

        $("#trigger").unbind('click').bind("click", function (event) {
        startLoader();
        $('#min').css('display', 'none');
        $('.error_c').css('border-style', 'none');
        event.preventDefault();
        var form = $('#submit_pages');
        var pages = $('#submit_pages').serializeArray();
        $.ajax({
            url: '/api/pages/validate',
            type: 'post',
            statusCode: {
                422: function (response) {
                    removeLoader();
                    $.each(response.responseJSON.errors, function (key, value) {
                        var index = key.split(".");
                        $('#f_' + index[1]).css('border-color', '#ffc1c1').css('border-style', 'solid');
                    });
                }
            },
            data: pages,
            success: function (data) {

                if (data.hasOwnProperty('min')) {
                    $('#min').css('display', 'block');
                    removeLoader();
                    return false;
                }
                if (data.hasOwnProperty('pages')) {
                    $.each(data.pages, function (index, value) {
                        $('#f_' + index).css('border-color', '#ffc1c1').css('border-style', 'solid');
                    });
                    removeLoader();
                    return false;
                }
                if (data.hasOwnProperty('email')) {
                    $('#email').css('border-color', '#ffc1c1').css('border-style', 'solid');
                    removeLoader();
                    return false;
                }
                if (data.hasOwnProperty('success')) {
                         $.each(data.ids, function (key, value) {

                            $('<input />').attr('type', 'hidden')
                                    .attr('name', "account_ids[]")
                                        .attr('value', value)
                                        .appendTo(form);
                            });
                           $.post( {!! json_encode(route('newDemoBench')) !!}, pages ).done(function( data ) {
                                if(auth){
                                    window.location.href = {!! json_encode(url('/benchmarks/') ) !!}+'/'+data;
                                    return false;

                                } else {
                                     window.location.href = {!! json_encode(url('/auth/facebook')) !!};
                                }
                            });
                            event.preventDefault();
                        }
                    },
                    error: function (data) {
                        removeLoader();
                        console.log(data.responseJSON)
                    }
                });
            });
</script>

@endsection
