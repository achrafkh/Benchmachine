<header class="header">
	<div class="container">
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
					<a href="/home">
						<i class="b-clipboard"></i>
						<span>My Benchmarks</span>
					</a>
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
		<a class="logo" href="/home">
			<svg class="svg" role="img" title="logo">
        		<use xlink:href="/assets/images/svg-icons.svg#logo"/>
        	</svg>
		</a>
		<button class="sidebar-trigger" onclick="updateBenchmarks()">
			<i class="b-menu"></i>
		</button>
	</div>
</header>
