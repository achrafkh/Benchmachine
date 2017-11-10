@extends('layouts.master')
@section('content')
<div class="home-page">
    <div class="landing">
        <div class="landing-wrap">
            <div class="landing-inner">
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
                    Add the facebook pages you want to compare, wait for a moment and let the magic happen.
                </p>
               @if(auth()->check())
                <a style="color:white" href="{{ url('/auth/facebook') }}" class="landing-btn" waves-hover>
                My Reports
                </a>
               @else
                <a style="color:white" href="{{ url('/auth/facebook') }}" class="landing-btn" waves-hover>
                Get a glance
                </a>
               @endif
                <div class="video">
                    <div class="video-inner">
                        <video autoplay="" loop="" muted="" playsinline="" poster="https://sbks-www.s3.amazonaws.com/www/storage/www/video/video-posters/dashboard-poster.png">
                            <source src="https://sbks-www.s3.amazonaws.com/www/storage/www/video/suite-measurement/dashboard-video.mp4" type="video/mp4">
                            <source src="https://sbks-www.s3.amazonaws.com/www/storage/www/video/suite-measurement/dashboard-video.webm" type="video/webm">
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
                    Copy paste the url of the facebook pages you want to compare. It only takes a few seconds.
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
                <div  class="media-body mail-wrap">
                @if(auth()->guest())
                    <h4 class="mail-cap">E-mail</h4>
                    <input id="email" class="mail-input" type="text" name="email" placeholder="Add your e-mail" >
                @else
                    <input id="email" class="mail-input" type="hidden" name="email" value="{{ auth()->user()->getValidEmail() }}" >
                @endif
                </div>
                <div class="media-right mail-submit">
                    <button id="trigger" type="button" waves-hover>
                    Generate
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
