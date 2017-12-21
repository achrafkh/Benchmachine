<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#0363c5" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="keywords" content="Benchmarks, Facebook, KPI, Social benchmarking">
    <meta name="description" content="Discover your key performances indicators, Learn from social leaders and Set goals and baselines for performance and growth based on your direct competitors.">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

    <!-- Twitter Card data -->
    <meta name="twitter:card" value="Discover your key performances indicators, Learn from social leaders and Set goals and baselines for performance and growth based on your direct competitors.">




        <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="The Name or Title Here">
    <meta itemprop="description" content="This is the page description">
    <meta itemprop="image" content="http://www.example.com/image.jpg">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="{{ url('/images/logo.jpg') }}">
    <meta name="twitter:site" content="@Kpeiz_Digital">
    <meta name="twitter:title" content="Benchmarks inc">
    <meta name="twitter:description" content="Discover your key performances indicators, Learn from social leaders and Set goals and baselines for performance and growth based on your direct competitors.">
    <meta name="twitter:creator" content="@Kpeiz_Digital">

    <meta name="twitter:image:src" content="{{ url('/assets/images/christmas-bg.jpg') }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="Benchmarks.digital" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:image" content="{{ url('/images/logo.jpg') }}" />
    <meta property="og:description" content="Discover your key performances indicators, Learn from social leaders and Set goals and baselines for performance and growth based on your direct competitors." />
    <meta property="og:site_name" content="Benchmarks" />
    <meta property="fb:admins" content="10206916243304374" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_ID') }}" />


    <META NAME="geo.position" CONTENT="36.880750; 10.260194">
    <META NAME="geo.placename" CONTENT="KNSD">
    <META NAME="geo.region" CONTENT="Tunisia Tunis la Soukra 2036">



    <title>Benchmark</title>
    <link rel="stylesheet" href="/assets/css/theme.min.css">
    <link type="text/css" rel="stylesheet" href="/css/loader.css">
    @include('layouts.partials.pixels')
</head>

<body class="">
    <div class="page-wrap {{ $class or '' }}">
    @yield('content')
    @include('layouts.partials.footer')
    </div>
    <script src="/assets/js/vendors.min.js"></script>
    <script src="/assets/js/theme.js"></script>
    <script type="text/javascript">jQuery.fn.load = function(callback){ $(window).on("load", callback) };</script>
    @yield('js')

    @yield('custom-js')

    <script type="text/javascript">
        $( ".track_click" ).click(function() {
          ga('send', 'event', $(this).data('section'), $(this).data('name'), $(this).data('desc'));
          fbq('trackCustom', $(this).data('name'),$(this).data('fbq'));
        });
    </script>


</body>
</html>
