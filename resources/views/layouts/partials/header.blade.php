<header class="benchmark-header">
	<div class="container">
	@if(isset($id))
		<form id="printpdf" action="{{url('/benchmarks/wkdownload/' . $id)}}" method="POST">
		{{ csrf_field() }}
			<input type="hidden" id="type" name="type" value="desc">
			<input type="hidden" id="col" name="col" value="1">
			<input type="hidden" id="chartdate" name="chatdate" value="1">
			<button type="submit" class="print-btn" waves-hover>
				<svg role="img" title="printer" width="22" height="22">
	        		<use xlink:href="/assets/images/svg-icons.svg#icon-printer"/>
	        	</svg>
				<span class="hidden-xs">Print benchmark</span>
			</button>
		</form>
	@endif
		<div class="dropdown profile-dropdown">
			<button class="media profile-trigger" class="media" type="button" data-toggle="dropdown">
			<div class="media-left media-middle">
			@if(auth()->check())
				<span class="profile-img" style="background-image:url({{ auth()->user()->image  }})"></span>
			@else
				<span class="profile-img" style="background-image:url('')"></span>
			@endif
			</div>
			<div class="media-body media-middle hidden-xs">
			@if(auth()->check())
				<span class="profile-name">{{ auth()->user()->name }}</span>
				<span class="profile-type">Premium</span>
			@else
				<span class="profile-name">Guest</span>
			@endif
			</div>
			<div class="media-right media-middle">
				<i class="icon-down-open-1"></i>
			</div>
			</button>
			<ul class="dropdown-menu dropdown-menu-right">
				<li>
					<a href="/home">History</a>
				</li>
				<!-- <li>
					<a href="/settings">Settings</a>
				</li> -->
				<li role="separator" class="divider"></li>
				<li>
					<a href="{{ route('logout') }}"
						onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">
						Logout
					</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</li>
			</ul>
		</div>
	</div>
</header>
