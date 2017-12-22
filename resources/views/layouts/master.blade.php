<!doctype html>
<html lang="en">
<head>
    <title>Social Media Benchmarks</title>
    @include('layouts.partials.metadata')
    <link rel="stylesheet" href="/assets/css/theme.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link type="text/css" rel="stylesheet" href="/css/loader.css">
    <script type="text/javascript" src="/js/pixels.js"></script>
</head>

<body class="">
    <div class="page-wrap {{ $class or '' }}">
        <div id="alertsParent" class="alerts-container">

        </div>
    @yield('content')
    @include('layouts.partials.footer')
    </div>

    <script src="/assets/js/vendors.min.js"></script>
    <script src="/assets/js/theme.js"></script>
    <script type="text/javascript"></script>
    @yield('js')
    @yield('custom-js')
    <noscript>Your browser does not support JavaScript!</noscript>
</body>
</html>
