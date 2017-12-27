@extends('layouts.master')
@section('content')
<div class="home-page">
    <div class="landing">
        <div class="landing-wrap">
            <div class="landing-inner">
                <a class="landing-logo" href=".">
                    <img class="hidden-xs" alt="Benchmarks.digital logo" src="/assets/images/logo.png">
                    <svg class="svg visible-xs" role="img" title="logo">
                        <use xlink:href="/assets/images/svg-icons.svg#logo"/>
                    </svg>
                </a>
                @if(auth()->check())
                <a class="landing-login" href="{{ url('/home') }}" waves-hover>
                    <i class="icon-facebook"></i>
                    Connect
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
                <a onclick="smoothScroll(document.getElementById('submit_pages'))"  href="#" id="glance" class="landing-btn white-txt" waves-hover>
                Get A Glance
                </a>
                <div class="video">
                    <div class="video-inner">
                        <video alt="video on screen" autoplay="" loop="" muted="" playsinline="" poster="{{url('/images/background2.png')}}">
                            <source src="{{ url('/assets/videos/benchmark.mp4') }}" type="video/mp4">
                            <source src="{{ url('/assets/videos/benchmark.webm') }}">
                            Your browser does not support the video tag.
                        </video>
                        <img alt="page background" class="video-screen" src="/assets/images/md-christmas-screen.png">
                    </div>
                </div>
            </div>
        </div>
        <canvas id="snow" class="snow"></canvas>
        <img alt="cloud picture" class="cloud cloud-1" src="/assets/images/cloud_1.png">
        <img alt="cloud picture" class="cloud cloud-2" src="/assets/images/cloud_2.png" >
    </div>
     <div class="fb-wrapper">
        <div class="fb-inner">
        <div class="fb-header">
                <h1>Create a new <b>benchmark.</b></h1>
                <p>Copy paste the url of the facebook pages you want to compare. It only takes a few seconds.</p>
            </div>
        <form id="submit_pages" action="{{ route('newDemoBench') }}" method="POST" class="fb-form">
         {{ csrf_field() }}
            <div class="fb-form-inner">
                <div class="media fb-box focused">
                    <div class="media-left fb-icon">
                        <i class="icon-facebook"></i>
                        <i class="icon-ok"></i>
                        <i class="icon-cancel"></i>
                        <i class="icon-spin5 animate-spin"></i>
                    </div>
                    <div id="f_0" class="media-body fb-inner error_c">
                        <label for="fb_page_0" class="fb-nb">First page</label>
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
                        <label for="fb_page_1" class="fb-nb">Second page</label>
                        <input id="fb_page_1" class="fb-input" type="text" name="accounts[]"
                        placeholder="https://www.facebook.com/exemple">
                    </div>
                </div>
            </div>

            <div class="fb-footer text-center" style="margin-top: 15px">
                <button id="trigger" class="media fb-sub" waves-hover>
                    <div class="media-left media-middle">
                        <i class="icon-facebook"></i>
                        <i class="icon-spin5 animate-spin"></i>
                    </div>
                    <div class="media-body media-middle">
                        Generate Benchmark
                    </div>
                </button>
                <p class="fb-sub-cap">
                    One click, No password, Simple and practical
                </p>
            </div>
        </form>
        </div>
    </div>
</div>
<input type="hidden" id="refreshed" value="no">
<input type="hidden" id="auth" value="{{ auth()->check() }}">
@endsection


@section('js')
<script type="text/javascript">
ga('send', {
  hitType: 'pageview',
  title: 'Welcome Page',
  page: '/',
});
</script>
@if(Session::has('CompleteRegistration'))
    <script type="text/javascript">
        ga('send', 'event', 'CompleteRegistration', 'NewUser', 'New User Completed Registration');
        fbq('track', 'CompleteRegistration');
    </script>
@endif
<script type="text/javascript" src="/assets/js/canvas/snow.js"></script>
<script type="text/javascript" src="/js/welcome.js"></script>
@endsection
