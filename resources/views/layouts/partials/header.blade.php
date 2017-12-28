<header class="header">
	<div class="container">

		<a class="logo" href="/home">
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
			<button  type="submit" class="mbtn mbtn-icon print-btn" waves-hover>
				<i class="b-printer"></i>
	        	<i class="icon-spin5 animate-spin"></i>
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
				@if(auth()->check())
					@if(auth()->user()->isSuperAdmin())
					<li>
						<a href="/dashboard"  type="button">
							<i class="fa fa-dashboard"></i>
							<span>Dashboard</span>
						</a>
					</li>
					@endif
				@endif
				<li>
					<button onclick="updateBenchmarks()" class="sidebar-trigger" type="button">
						<i class="b-clipboard"></i>
						<span>My Benchmarks</span>
					</button>
				</li>


				<!-- <li>
					<a href="">
						<i class="b-settings"></i>
						<span>Settings</span>
					</a>
				</li> -->
				<li>
					<a href="/logout"
						onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">
						<i class="b-power-button"></i>
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
