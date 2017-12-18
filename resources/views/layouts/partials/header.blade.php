<header class="header">
	<div class="container">

		<a class="logo" href="/">
			<svg class="svg" role="img" title="logo">
        		<use xlink:href="/assets/images/svg-icons.svg#logo"/>
        	</svg>
		</a>

	@if(isset($id))
		<form id="printpdf" action="{{url('/benchmarks/wkdownload/' . $id)}}" method="POST">
		{{ csrf_field() }}
			<input type="hidden" id="type" name="type" value="desc">
			<input type="hidden" id="col" name="col" value="1">
			<input type="hidden" id="chartdate_en" name="chartdate_en" value="1">
			<input type="hidden" id="chartdate_in" name="chartdate_in" value="1">
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
				{{-- <span class="profile-type">Premium</span> --}}
			@else
				<span class="profile-name">Guest</span>
			@endif
			</div>
			<div class="media-right media-middle">
				<i class="icon-down-open-1"></i>
			</div>
			</button>
			<ul class="dropdown-menu dropdown-menu-right">
				@if(!isset($hidden_sidebar))
					<li>
						<button class="sidebar-trigger" type="button">
							<svg class="svg" role="img" title="report" width="20" height="20">
				        		<use xlink:href="/assets/images/svg-icons.svg#icon-report"/>
				        	</svg>
							<span>My Benchmarks</span>
						</button>
					</li>
				@endif
				<!-- <li>
					<a href="">
						<svg class="svg" role="img" title="settings" width="20" height="20">
			        		<use xlink:href="assets/images/svg-icons.svg#icon-settings"/>
			        	</svg>
						<span>Settings</span>
					</a>
				</li> -->
				<li>
					<a href="/logout"
						onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">
						<svg class="svg" role="img" title="power-button" width="20" height="20">
			        		<use xlink:href="/assets/images/svg-icons.svg#icon-power-button"/>
			        	</svg>
						<span>Log out</span>
					</a>
				</li>
					<form id="logout-form" action="/logout" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
			</ul>
		</div>
	</div>
</header>
