<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#0363c5" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
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
