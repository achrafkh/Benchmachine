@extends('layouts.master')
@section('content')

<div class="benchmark-page">
@include('layouts.partials.header')
<style type="text/css">
  .contain {
    width: 200px;
    height: 200px;
    position: fixed;
    top:50%;
    bottom: 50%;
    right: 50%;
    margin: auto;
}

svg {
  position: absolute;
}
svg ellipse {
  -webkit-transform-origin: center;
          transform-origin: center;
}
svg:nth-of-type(1) ellipse {
  stroke: #F1725D;
  cx: 25px;
  stroke-width: 3px;
  -webkit-animation: jump 600ms infinite ease-in-out;
          animation: jump 600ms infinite ease-in-out;
  opacity: .7;
  -webkit-animation-delay: 0ms;
          animation-delay: 0ms;
}
svg:nth-of-type(2) ellipse {
  stroke: #38BDAB;
  cx: 65px;
  stroke-width: 3px;
  -webkit-animation: jump 600ms infinite ease-in-out;
          animation: jump 600ms infinite ease-in-out;
  opacity: .7;
  -webkit-animation-delay: 75ms;
          animation-delay: 75ms;
}
svg:nth-of-type(3) ellipse {
  stroke: #9D30A5;
  cx: 105px;
  stroke-width: 3px;
  -webkit-animation: jump 600ms infinite ease-in-out;
          animation: jump 600ms infinite ease-in-out;
  opacity: .7;
  -webkit-animation-delay: 150ms;
          animation-delay: 150ms;
}
svg:nth-of-type(4) ellipse {
  stroke: #B779E2;
  cx: 145px;
  stroke-width: 3px;
  -webkit-animation: jump 600ms infinite ease-in-out;
          animation: jump 600ms infinite ease-in-out;
  opacity: .7;
  -webkit-animation-delay: 225ms;
          animation-delay: 225ms;
}
svg:nth-of-type(5) ellipse {
  stroke: #683893;
  cx: 185px;
  stroke-width: 3px;
  -webkit-animation: jump 600ms infinite ease-in-out;
          animation: jump 600ms infinite ease-in-out;
  opacity: .7;
  -webkit-animation-delay: 300ms;
          animation-delay: 300ms;
}
svg:nth-of-type(6) ellipse {
  fill: #333333;
  opacity: .05;
  rx: 0;
  ry: 0;
  cx: 25px;
  cy: 48px;
  -webkit-animation: shadow 600ms infinite ease-in-out;
          animation: shadow 600ms infinite ease-in-out;
  -webkit-animation-delay: 0ms;
          animation-delay: 0ms;
}
svg:nth-of-type(7) ellipse {
  fill: #333333;
  opacity: .05;
  rx: 0;
  ry: 0;
  cx: 65px;
  cy: 48px;
  -webkit-animation: shadow 600ms infinite ease-in-out;
          animation: shadow 600ms infinite ease-in-out;
  -webkit-animation-delay: 75ms;
          animation-delay: 75ms;
}
svg:nth-of-type(8) ellipse {
  fill: #333333;
  opacity: .05;
  rx: 0;
  ry: 0;
  cx: 105px;
  cy: 48px;
  -webkit-animation: shadow 600ms infinite ease-in-out;
          animation: shadow 600ms infinite ease-in-out;
  -webkit-animation-delay: 150ms;
          animation-delay: 150ms;
}
svg:nth-of-type(9) ellipse {
  fill: #333333;
  opacity: .05;
  rx: 0;
  ry: 0;
  cx: 145px;
  cy: 48px;
  -webkit-animation: shadow 600ms infinite ease-in-out;
          animation: shadow 600ms infinite ease-in-out;
  -webkit-animation-delay: 225ms;
          animation-delay: 225ms;
}
svg:nth-of-type(10) ellipse {
  fill: #333333;
  opacity: .05;
  rx: 0;
  ry: 0;
  cx: 185px;
  cy: 48px;
  -webkit-animation: shadow 600ms infinite ease-in-out;
          animation: shadow 600ms infinite ease-in-out;
  -webkit-animation-delay: 300ms;
          animation-delay: 300ms;
}

@-webkit-keyframes jump {
  40% {
    -webkit-transform: translateY(20px) scale(1.3);
            transform: translateY(20px) scale(1.3);
    opacity: .9;
  }
  40% {
    rx: 10px;
    ry: 10px;
    stroke-width: 3px;
  }
  45% {
    rx: 15px;
    ry: 7px;
    stroke-width: 4px;
  }
  55% {
    rx: 10px;
    ry: 10px;
  }
}

@keyframes jump {
  40% {
    -webkit-transform: translateY(20px) scale(1.3);
            transform: translateY(20px) scale(1.3);
    opacity: .9;
  }
  40% {
    rx: 10px;
    ry: 10px;
    stroke-width: 3px;
  }
  45% {
    rx: 15px;
    ry: 7px;
    stroke-width: 4px;
  }
  55% {
    rx: 10px;
    ry: 10px;
  }
}
@-webkit-keyframes shadow {
  45% {
    opacity: .15;
    rx: 10px;
    ry: 3px;
    -webkit-transform: translateY(5px) scale(1.3);
            transform: translateY(5px) scale(1.3);
  }
}
@keyframes shadow {
  45% {
    opacity: .15;
    rx: 10px;
    ry: 3px;
    -webkit-transform: translateY(5px) scale(1.3);
            transform: translateY(5px) scale(1.3);
  }
}

footer{
  position: fixed;
    bottom: 0;
    width: 100%;
}
.btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
.btn-labeled {padding-top: 0;padding-bottom: 0;}
.btn { margin-bottom:10px; }
</style>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="benchmark-page">
  <div class="container">
    <div class="row">
      <div class='contain'>
      <div class="row text-center" style="margin-bottom: 40px">
      @if(Session::has('flash'))
    <div class="alert alert-{{ Session::get('flash')['class'] }}">
      {!! Session::get('flash')['msg'] !!}
    </div>
    @endif
         <button type="button" class="btn btn-labeled btn-warning"  data-toggle="modal" data-target="#myModalNorm">
     <span class="btn-label">
      <i class="fa fa-envelope-o" aria-hidden="true"></i>
     </span>
      Email
    </button>
      </div>
        <svg height='80' width='210'>
          <ellipse cx='25' cy='20' fill='none' rx='10' ry='10'></ellipse>
        </svg>
        <svg height='80' width='210'>
          <ellipse cx='25' cy='20' fill='none' rx='10' ry='10'></ellipse>
        </svg>
        <svg height='80' width='210'>
          <ellipse cx='25' cy='20' fill='none' rx='10' ry='10'></ellipse>
        </svg>
        <svg height='80' width='210'>
          <ellipse cx='25' cy='20' fill='none' rx='10' ry='10'></ellipse>
        </svg>
        <svg height='80' width='210'>
          <ellipse cx='25' cy='20' fill='none' rx='10' ry='10'></ellipse>
        </svg>
        <svg height='80' width='210'>
          <ellipse cx='25' cy='20' fill='none' rx='10' ry='10'></ellipse>
        </svg>
        <svg height='80' width='210'>
          <ellipse cx='25' cy='20' fill='none' rx='10' ry='10'></ellipse>
        </svg>
        <svg height='80' width='210'>
          <ellipse cx='25' cy='20' fill='none' rx='10' ry='10'></ellipse>
        </svg>
        <svg height='80' width='210'>
          <ellipse cx='25' cy='20' fill='none' rx='10' ry='10'></ellipse>
        </svg>
        <svg height='80' width='210'>
          <ellipse cx='25' cy='20' fill='none' rx='10' ry='10'></ellipse>
        </svg>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Modal title
                </h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form role="form" id="change_email" method="POST" action="{{ route('editEmail') }}">
                {{ csrf_field() }}
                  <div class="form-group">
                    <label for="exampleInputEmail1" style="margin-bottom: 10px">Email address</label>
                      <input required="" type="email" class="form-control" name="email"
                      id="email" value="{{ auth()->user()->getValidEmail() }}" placeholder="Enter email"/>
                  </div>
                  <button type="submit" class="btn btn-warning">Submit</button>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
               <!--  <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary">
                    Save changes
                </button> -->
            </div>
        </div>
    </div>
</div>

@endsection
@section('custom-js')
<!-- <script type="text/javascript">
$( document ).ready(function() {
	function recursive_ajax(){
	    console.log("begin");
	    $.ajax({
	        type:"POST",
	        data: {pages_ids: {!! json_encode($benchmark_ids) !!} },
	        url: {!! json_encode(env('CORE').'/platform/check-pages') !!},
	        success: function(data){
	            console.log(data);
	            if(data.status == 0){
	            	setTimeout(recursive_ajax, 5000);
	            } else {
	            	window.location.reload();
	            }
	        }
	    });
	}
	recursive_ajax();
});
</script> -->
@endsection
