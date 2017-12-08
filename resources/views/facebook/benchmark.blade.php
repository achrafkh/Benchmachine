@extends('layouts.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.css">
<div class="benchmark-page">
	@if(!isset($static))
	 @include('layouts.partials.header',['id' => $benchmark->details->id])
	@endif
	<div class="benchmark-name" data-aos="fade-up" data-aos-once="true">
		<div class="container">
		@if(Session::has('flash'))
		<div class="alert alert-{{ Session::get('flash')['class'] }}">
		  {!! Session::get('flash')['msg'] !!}
		</div>
		@endif
			<h2>
				<i class="icon-pencil-alt"></i>
				<span>Title</span>
			</h2>
			<input id="original" type="hidden" name="o_title" value="{{ $benchmark->details->title }}">
			<input class="animated bounceInDown" data-id="1" id="title" type="text" name="title" placeholder="Benchmark" value="{{ isset($benchmark->details->title) ? $benchmark->details->title : '' }}">
		</div>
	</div>

	@include('facebook.sections.summary',['averages' => $benchmark->averages,'variations' => $benchmark->variations])
	@include('facebook.sections.table', ['accounts' => $benchmark->accounts])

	@include('facebook.sections.charts')

 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'likes' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'comments' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'shares' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'engagement_rate' ])
 	@include('facebook.sections.posts',['posts' => $benchmark->posts,'sort'=> 'total_interactions' ])

@if(!Session::has('email-'. $benchmark->details->id ))
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
          Get notified
          </h4>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
          <form role="form" id="change_email" method="POST" action="{{ route('editEmail') }}">
            {{ csrf_field() }}
            <div class="form-group">
            <input type="hidden" name="id" value="{{ $benchmark->details->id }}">
              <label for="exampleInputEmail1" style="margin-bottom: 10px">Email address</label>
              <input required="" type="email" class="form-control" name="email"
              id="email" value="{{ auth()->user()->getValidEmail() }}" placeholder="Enter email"/>
            </div>
            <button type="submit" class="btn btn-warning">save</button>
          </form>
        </div>
        <!-- Modal Footer -->
       <!--  <div class="modal-footer">
    <button type="button" class="btn btn-default"
          data-dismiss="modal">
          Close
          </button>
          <button type="button" class="btn btn-primary">
          Save changes
          </button>
        </div> -->
      </div>
    </div>
  </div>
@endif

@if(!isset($print))
@include('payment.'.getPaymentProvider())
@endif
@endsection
@section('custom-js')
@if(!isset($print))
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.js"></script>
<script type="text/javascript" src="/js/animate.js"></script>
<script type="text/javascript">

var bench_id = {!! json_encode($benchmark->details->id) !!};
$( document ).ready(function() {
$.get( "/api/show-modal/"+bench_id, function( data ) {
	if(data == 1){
		$('#myModalNorm').modal('show');
	}
});
    AOS.init({
      offset: 100,
      duration: 1000,
      easing: 'ease-in-sine',
      delay: 100,
      disable: 'mobile',
    });
});
</script>

@include('payment.'.getPaymentProvider().'_js')
@endif
@foreach(collect($benchmark->charts)->collapse() as $chart)
	@include('facebook.charts.'.$chart['type'], $chart)
@endforeach
@endsection
