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
    <script type="text/javascript"></script>
    @yield('js')

    @yield('custom-js')

</body>
</html>
