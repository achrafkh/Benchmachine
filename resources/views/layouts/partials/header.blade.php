<header class="benchmark-header">
	<div class="container">
	@if(isset($id))
		<form action="{{url('/benchmarks/wkdownload/' . $id)}}" method="POST">
		{{ csrf_field() }}
			<button id="print_button" target="_blank"  class="print-btn" waves-hover>
			Print benchmark
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
				<li>
					<a href="/settings">Settings</a>
				</li>
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
