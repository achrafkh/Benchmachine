<div class="breadcrumb-wrapper">
	<div class="container">
		<ol class="breadcrumb">
		  <li><a href="{{ url()->previous() }}">Back</a></li>
		  @if(isset($page))
		  	<li class="active">{{ $page }}</li>
		  @endif
		</ol>
	</div>
</div>
