<div class="breadcrumb-wrapper">
	<div class="container">
		<ol class="breadcrumb">
		  <li><a href="{{ url()->previous() }}">Back</a></li>
		  @if(isset($title) && isset($date))
		  	<li class="active"><span id="benchTitle">{{ $title }}</span> {{ $date }}</li>
		  @endif
		</ol>
	</div>
</div>
