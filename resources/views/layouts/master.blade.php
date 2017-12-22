<!doctype html>
<html lang="en">
<head>
    <title>Social Media Benchmarks</title>
    @include('layouts.partials.metadata')
    <link rel="stylesheet" href="/assets/css/theme.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="shortcut icon" href="/favicon.ico">
    <link type="text/css" rel="stylesheet" href="/css/loader.css">
    <link rel="canonical" href="{{ URL::current() }}">

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
