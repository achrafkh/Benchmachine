<!doctype html>
<html lang="en">
<head>
    <title>Social Media Benchmarks</title>
    @include('layouts.partials.metadata')
    <link rel="stylesheet" href="/assets/css/theme.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link type="text/css" rel="stylesheet" href="/css/loader.css">
    @if(Agent::isMobile() || Agent::isTablet())
        <link rel="stylesheet" href="/assets/css/picker/default.css">
    @else
        <link rel="stylesheet" href="/assets/css/picker/classic.css">
    @endif
    @if(auth()->guest())
    <script type="text/javascript" src="/js/pixels.js"></script>
    @elseif(auth()->user()->hasRole(['client']))
    <script type="text/javascript" src="/js/pixels.js"></script>
    @else
    <script type="text/javascript">
        function ga(){
            return null;
        }
        function fbq(){
            return null;
        }
    </script>

    @endif
</head>

<body class="@if(Agent::isMobile() || Agent::isTablet()) ismobile @endif">

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
    @if(Session::has('msg'))
        @if(isset(Session::get('msg')['class']))
        <script type="text/javascript">
            showAlert({!! json_encode(Session::get('msg')['class']) !!},{!! json_encode(Session::get('msg')['msg']) !!},10);
        </script>
        @endif
    @endif
    <noscript>Your browser does not support JavaScript!</noscript>

    @if(auth()->guest())
    <script type="text/javascript">
        window._mfq = window._mfq || [];
        (function() {
        var mf = document.createElement("script");
        mf.type = "text/javascript"; mf.async = true;
        mf.src = "//cdn.mouseflow.com/projects/b80d4089-8ab5-4741-be42-fc8110a57f84.js";
        document.getElementsByTagName("head")[0].appendChild(mf);
        })();
    </script>
    @elseif(auth()->user()->hasRole(['client']))
        <script type="text/javascript">
            window._mfq = window._mfq || [];
            (function() {
            var mf = document.createElement("script");
            mf.type = "text/javascript"; mf.async = true;
            mf.src = "//cdn.mouseflow.com/projects/b80d4089-8ab5-4741-be42-fc8110a57f84.js";
            document.getElementsByTagName("head")[0].appendChild(mf);
            })();
        </script>
    @endif
</body>
</html>
