<div class="row bg-title">
   <!-- .page title -->
   <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">{{ $page['title'] or '' }}</h4>
   </div>
   <!-- /.page title -->
   <!-- .breadcrumb -->
   <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
         <li><a href="/dashboard">Dashboard</a></li>
         @if(isset($page))
          <li class="active"><a href="/{{ $page['url'] or ''}}">{{ $page['title'] or '' }}</a></li>
         @endif
      </ol>
   </div>
   <!-- /.breadcrumb -->
</div>
