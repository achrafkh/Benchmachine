<hr>
<div class="container" style="width: 50%;"  data-aos="fade-up" data-aos-duration="1600" data-aos-delay="600" data-aos-offset="600">
	<div class="row">
		<div class="text-center">
			<h2 style="font-size: 32px;color: #4d4d4d;">Buy another <strong>BENCHMARK</strong></h2>
		</div>
		<hr>
	</div>
	<div class="row">
		<div class="">
			<h2 style="font-size: 30px;color: #4d4d4d;margin-bottom: 10px">Select periode</h2>
			<p style="color: #a6a6a1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
		</div>
		<hr>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div id="datepicker-inline-since" class="pull-right">
				<div class="datepicker datepicker-inline">
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div id="datepicker-inline-until" class="pull-left">
				<div class="datepicker datepicker-inline">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<h2 style="font-size: 30px;color: #4d4d4d;margin-bottom: 10px;margin-top: 20px;padding-left: 15px;">Checkout</h2>
		<br>
		<div class="col-md-6" id="difTime">
			<span>Benchmark {{ $benchmark->details->since->diffInDays($benchmark->details->until) }} Days</span>
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<strong class="price">5 USD</strong>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			VAT
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<strong>0 USD</strong>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-6">
			<strong>TOTAL</strong>
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<strong class="price">5 USD</strong>
			</div>
		</div>
		<p style="font-size: 13px;color: #a6a6a1;margin-top: 20px;padding-left: 15px;">*Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
	</div>
	<style type="text/css">
.btn-sunny {
color: #fff;
background-color: #f4ad49;
border-bottom:2px solid #c38a3a;
}

.btn-sunny:hover, .btn-sky.active:focus, .btn-sunny:focus, .open>.dropdown-toggle.btn-sunny {
color: #fff;
background-color: #f5b75f;
border-bottom:2px solid #c4924c;
outline: none;
}
.btn-sunny:active, .btn-sunny.active {
color: #fff;
background-color: #d69840;
border-top:2px solid #ab7a33;
margin-top: 2px;
}
.btn:focus,
.btn:active:focus,
.btn.active:focus {
    outline: none;
    outline-offset: 0px;
}

a {color:#fff;}
a:hover {text-decoration:none; color:#fff;}
.btn{
    margin: 4px;
    box-shadow: 1px 1px 5px #888888;
}

.btn-xs{
    font-weight: 300;
}
	</style>
	<div class="row">
	<form   action="{{ route('stripeCheckout') }}" method="POST" style="padding :10px 10px 10px 10px" class="pull-right">
		{{ csrf_field() }}
		<input type="hidden" name="benchmark_id" value="{{$benchmark->details->id}}">
		<input type="hidden" name="since" id="since">
		<input type="hidden" name="until" id="until">
		<script
		  src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		  data-key="pk_test_NwBR00CRQsOdtzDqa20ztBYl"
		  data-amount="{{config('price.usd').'00'}}"
		  data-name="Benchmark Machine"
		  data-panel-label="PAY"
		  data-label="Generate"
		  data-email="{{ auth()->user()->getValidEmail() }}"
		  data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
		  data-locale="auto"
		  data-zip-code="false"
		  data-currency="usd">
		</script>
		 <script>
        document.getElementsByClassName("stripe-button-el")[0].style.display = 'none';
	    </script>
	    <button type="submit"  style="display:none" id="hideme" class="btn btn-sunny text-uppercase btn-md">Proceed</button>
	</form>
	</div>
	<br>
</div>
