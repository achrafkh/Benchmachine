<!DOCTYPE html>
<!--
   This is a starter template page. Use this page to start your new project from
   scratch. This page gets rid of all links and provides the needed markup only.
   -->
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- Favicon icon -->
      <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon/favicon-16x16.png">
      <title>Benchmarks Dashboard</title>
      <!-- Bootstrap Core CSS -->
      <link href="/admin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="/admin/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
      @yield('top-css')
      <!-- This is Sidebar menu CSS -->
      <link href="/admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
      <!-- This is a Animation CSS -->
      <link href="/admin/css/animate.css" rel="stylesheet">
      <!-- This is a Custom CSS -->
      <link href="/admin/css/style.css" rel="stylesheet">
      <!-- color CSS you can use different color css from css/colors folder -->

      <link href="/admin/css/colors/light-blue.css" id="theme"  rel="stylesheet">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->

      @yield('css')

</head>
   <body class="fix-sidebar">
      <!-- Preloader -->
      <div class="preloader">
         <div class="cssload-speeding-wheel"></div>
      </div>
      <div id="wrapper">
         <!-- Top Navigation -->
          @include('admin.layouts.partials.top-nav')
         <!-- End Top Navigation -->
         <!-- Left navbar-header -->
          @include('admin.layouts.partials.left-nav')
         <!-- Left navbar-header end -->
         <!-- Page Content -->
         <div id="page-wrapper">
            <div class="container-fluid">

                  @yield('breadcumbs')
               <!-- .row -->
                  @yield('content')
               <!-- .row -->

               <!-- .row -->
                  @yield('content2')
               <!-- .row -->

               <!-- .right-sidebar -->

               <!-- /.right-sidebar -->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2017 &copy; Market Gear SARL </footer>
         </div>
         <!-- /#page-wrapper -->
      </div>
      <!-- /#wrapper -->
      <!-- jQuery -->
      <script src="/admin/plugins/bower_components/jquery/dist/jquery.min.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="/admin/bootstrap/dist/js/tether.min.js"></script>
      <script src="/admin/bootstrap/dist/js/bootstrap.min.js"></script>
      <script src="/admin/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
      <!-- Sidebar menu plugin JavaScript -->
      <script src="/admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
      <!--Slimscroll JavaScript For custom scroll-->
      <script src="/admin/js/jquery.slimscroll.js"></script>
      <!--Wave Effects -->
      <script src="/admin/js/waves.js"></script>
      <!-- Custom Theme JavaScript -->
      <script src="/admin/js/custom.min.js"></script>

      @yield('js')

   </body>
</html>
