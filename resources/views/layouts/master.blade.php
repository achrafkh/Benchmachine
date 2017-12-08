<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#0363c5" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Benchmark Machine</title>
    <link rel="stylesheet" href="/assets/css/theme.css">
    <link type="text/css" rel="stylesheet" href="/css/loader.css">
</head>
<body class="">
    <div class="page-wrap">
     @yield('content')

    @include('layouts.partials.footer')
    </div>
    <script src="/assets/js/vendors.min.js"></script>
    <script src="/assets/js/theme.js"></script>
    <script type="text/javascript">jQuery.fn.load = function(callback){ $(window).on("load", callback) };</script>
    @yield('js')

    @yield('custom-js')
    <script type="text/javascript">
        $(".print-btn").unbind().click(function() {
          startLoader();
          setTimeout(removeLoader, 10000)
        });
    </script>
</body>
</html>
