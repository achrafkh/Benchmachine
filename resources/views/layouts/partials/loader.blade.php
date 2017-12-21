<div class="pending-wrapper">
	<div class="container">
		<div class="pending-content">
			<svg class="svg" role="img" title="logo-animated">
				<use xlink:href="/assets/images/svg-icons.svg#logo-animated"/>
			</svg>
			<h1>Benchmark generating...</h1>
			<p>
				{!! config('diver.msgs')[array_rand(config('diver.msgs'))]  !!}
			</p>
		</div>
		<form class="pending-notif">
			<div class="pending-checkbox">
				<input id="mail_notif" type="checkbox" name="mail_notif">
				<label for="mail_notif">
					Get notified when benchmark is ready
				</label>
			</div>

			<input required disabled id="email" class="notif-input form-control" type="email" placeholder="E-Mail...">

			<div id="emailError" class="alert" style="margin-top: 15px;display: none">

			</div>
			<button disabled id="saveEmail" class="mbtn notif-sub" waves-hover>
				<span>Save</span>
			</button>
		</form>
	</div>
</div>
@if(Session::has('payed'))
<script type="text/javascript">
ga('send', 'event', 'Purchase', 'Purchased', 'Payment completed and waiting for benchmark');
fbq('track', 'Purchase','{value:"5", currency:"USD",content_ids:"'+benchId+'",content_type:"benchmark"}');
</script>
@endif
