@extends('layouts.master')
@section('content')
<div class="home-page">
    <div class="landing">
        <div class="landing-wrap">
            <div class="landing-inner">
                <a class="landing-logo" href=".">
                    <img class="hidden-xs" alt="Benchmarks.digital logo" src="assets/images/logo.png">
                    <svg class="svg visible-xs" role="img" title="logo">
                        <use xlink:href="/assets/images/svg-icons.svg#logo"/>
                    </svg>
                </a>
                @if(auth()->check())
                <a class="landing-login" href="{{ url('/home') }}" waves-hover>
                    Dashboard
                </a>
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
                <a onclick="smoothScroll(document.getElementById('submit_pages'))" style="color:white" href="#" id="glance" class="landing-btn" waves-hover>
                Get A Glance
                </a>
                <div class="video">
                    <div class="video-inner">
                        <video alt="video on screen" autoplay="" loop="" muted="" playsinline="" poster="{{url('/images/background2.png')}}">
                            <source src="{{ url('/front.mp4') }}" type="video/mp4">
                            <source src="{{ url('/front.mp4') }}">
                            Your browser does not support the video tag.
                        </video>
                        <img alt="page background" class="video-screen" src="/assets/images/md-christmas-screen.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <img alt="cloud picture" class="cloud cloud-1" src="/assets/images/cloud_1.png" alt="">
        <img alt="cloud picture" class="cloud cloud-2" src="/assets/images/cloud_2.png" alt="">
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
                        <i class="icon-ok"></i>
                        <i class="icon-cancel"></i>
                        <i class="icon-spin5 animate-spin"></i>
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
                        <i class="icon-ok"></i>
                        <i class="icon-cancel"></i>
                        <i class="icon-spin5 animate-spin"></i>
                    </div>
                    <div id="f_1" class="media-body fb-inner error_c">
                        <h4 class="fb-nb">Second page</h4>
                        <input id="fb_page_1" class="fb-input" type="text" name="accounts[]"
                        placeholder="https://www.facebook.com/exemple">
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button id="trigger" class="hf-sub track_click" type="submit" waves-hover>
                    <span class="hf-sub-txt1">Generate Benchmark</span>
                    <span class="hf-sub-txt2">Benchmark Generating</span>
                    <i class="icon-spin5 animate-spin"></i>
                </button>
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
@if(Session::has('CompleteRegistration'))
    <script type="text/javascript">
        ga('send', 'event', 'CompleteRegistration', 'NewUser', 'New User Completed Registration');
        fbq('track', 'CompleteRegistration');
    </script>
@endif
<script type="text/javascript">
$("#glance").unbind('click').bind("click", function (event) {
    ga('send', 'event', 'CTA', 'CTA button', 'CTA button clicked');
    fbq('trackCustom', 'CTA Clicked','{status: "completed"}');
});
var auth = {!! json_encode(auth()->check()) !!}
var mainButton = $("#trigger");
        $("#trigger").unbind('click').bind("click", function (event) {

        mainButton.addClass('loading');
        $('.fb-box').removeClass('error');
        $('.fb-box').removeClass('success');
        $('.fb-box').removeClass('loading');

        $('.fb-box').addClass('loading');


        $('#min').css('display', 'none');

        event.preventDefault();
        var form = $('#submit_pages');
        var pages = $('#submit_pages').serializeArray();
        $.ajax({
            url: '/api/pages/validate',
            type: 'post',
            statusCode: {
                422: function (response) {
                    $('.fb-box').removeClass('loading');
                    $('.fb-box').addClass('success');
                    $.each(response.responseJSON.errors, function (key, value) {
                        var index = key.split(".");
                        $('#f_' + index[1]).closest( "div.fb-box" ).removeClass('success').addClass('error');
                    });
                    $('.fb-box').last().removeClass('error').removeClass('success').removeClass('loading');
                    mainButton.removeClass('loading');
                }
            },
            data: pages,
            success: function (data) {
                $('.fb-box').removeClass('loading');
                $('.fb-box').addClass('success');
                $('.fb-box').last().removeClass('error').removeClass('success').removeClass('loading');

                if (data.hasOwnProperty('min')) {

                    $('#min').css('display', 'block');
                    mainButton.removeClass('loading');
                    return false;
                }
                if (data.hasOwnProperty('pages')) {

                    $.each(data.pages, function (index, value) {
                        $('#f_' + index).closest( "div.fb-box" ).removeClass('success').addClass('error');
                    });
                    mainButton.removeClass('loading');
                    return false;
                }
                if (data.hasOwnProperty('success')) {

                    ga('send', 'event', 'GeneratingFreeBenchmark', 'AddedFreeBenchmark', 'Free benchmark generating started');
                    fbq('trackCustom', 'FreeBenchmark','Freebenchmark added');

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
                        console.log(data.responseJSON)
                    }
                });
            });
</script>

@endsection
