<div id="paymentStripe" class="fb-wrapper" data-aos="fade-up" data-aos-once="true" data-aos-duration="800" data-aos-delay="0" data-aos-offset="0">
	<div class="fb-form">
		<div class="fb-header">
			<h1>
			Extend your <b>benchmark.</b>
			</h1>
		</div>
		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane period-tab active">
				<div class="fb-header">
					<p>Choose the time periods for your benchmark report.</p>
				</div>
				<div class="fb-inner">
					<div class="row">
						<div class="col-md-6">
							<label for="date-from">
								From
							</label>
							<div class="input-container">
								<input class="form-control datepicker" id="date-from" type="text" name="since" placeholder="{{$benchmark->details->since->toDateString()}}">
								<i class="b-calendar"></i>
							</div>
						</div>
						<div class="col-md-6">
							<label for="date-to">
								To
							</label>
							<div class="input-container">
								<input class="form-control datepicker" id="date-to" type="text" name="until" placeholder="{{$benchmark->details->until->toDateString()}}">
								<i class="b-calendar"></i>
							</div>
						</div>
						<div class="col-md-6" id="difTime">
							<span>Benchmark {{ $benchmark->details->since->diffInDays($benchmark->details->until) }} Days</span>
						</div>
						<div class="col-md-6">
							<div class="text-right">
								<strong>0 USD</strong>
							</div>
						</div>
						<div class="col-md-6">
							VAT
						</div>
						<div class="col-md-6">
							<div class="text-right">
								<strong>0 USD</strong>
							</div>
						</div>
						<hr>
						<div class="col-md-6">
							<strong>TOTAL</strong>
						</div>
						<div class="col-md-6">
							<div class="text-right">
								<strong class="price">5 USD</strong>
							</div>
						</div>
					</div>
				</div>
				<div class="fb-footer">
					<form id="stripeForm" action="{{ route('stripeCheckout') }}" method="POST">
						{{ csrf_field() }}
						<input type="hidden" name="benchmark_id" value="{{$benchmark->details->id}}">
						<input type="hidden" name="since" id="since" value="{{ $benchmark->details->since->todateString() }}">
						<input type="hidden" name="until" id="until" value="{{ $benchmark->details->until->todateString() }}">
						<script
							src="https://checkout.stripe.com/checkout.js" class="stripe-button"
							data-key="{{ env('STRIPE_KEY') }}"
							data-amount="500"
							data-name="Benchmarks.digital"
							data-panel-label="PAY"
							data-label="Generate"
							data-email="{{ auth()->user()->getValidEmail() }}"
							data-image="{{ url('/images/logo.jpg') }}"
							data-locale="auto"
							data-zip-code="false"
							data-currency="usd">
						</script>
						<button disabled="" type="submit" id="hideme" class="mbtn">
							<span>Purchase</span>
						</button>
						<script>
						document.getElementsByClassName("stripe-button-el")[0].style.display = 'none';
						</script>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var Orisince = {!! json_encode($benchmark->details->since->toDateString()) !!};
	var Oriuntil = {!! json_encode($benchmark->details->until->toDateString()) !!};
</script>
