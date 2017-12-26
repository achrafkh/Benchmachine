<div class="navbar-default sidebar" role="navigation">
	<div class="sidebar-nav navbar-collapse slimscrollsidebar">
		<!-- .User Profile -->
		<div class="user-profile">
			<div class="dropdown user-pro-body">
				<div><img src="{{ auth()->user()->image }}" alt="user-img" class="img-circle"></div>
				<a href="starter-page.html#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> {{ auth()->user()->name }} <span class="caret"></span></a>
				<ul class="dropdown-menu animated flipInY">
					<li><a href="starter-page.html#"><i class="ti-user"></i> My Profile</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="starter-page.html#"><i class="ti-settings"></i> Account Setting</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="/logout"
						onclick="event.preventDefault();
						document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout</a>
					</li>
					<form id="logout-form" action="/logout" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</ul>
			</div>
		</div>
		<!-- .User Profile -->
		<ul class="nav" id="side-menu">
			<li class="sidebar-search hidden-sm hidden-md hidden-lg">
				<!-- / Search input-group this is only view in mobile-->
				<div class="input-group custom-search-form">
					<input type="text" class="form-control" placeholder="Search...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
					</span>
				</div>
				<!-- /input-group -->
			</li>
			<li class="nav-small-cap m-t-10" style="margin-left: 10px">  <strong>Main Menu</strong></li>
			<li><a href="javascript:void(0)" class="waves-effect"><i data-icon="&#xe008;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Dashboard</span></a>
			</li>
			<li><a href="/dashboard/users" class="waves-effect"><i data-icon="&#xe008;" class="fa fa-users fa-fw"></i> <span class="hide-menu">Users</span></a>
			</li>
			<!-- <li>
				<a href="javascript:void(0)" class="waves-effect active"><i data-icon="&#xe008;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Ree<span class="fa arrow"></span><span class="label label-rouded label-purple pull-right">2</span></span></a>
				<ul class="nav nav-second-level">
					<li><a href="javascript:void(0)">Link one</a></li>
					<li><a href="javascript:void(0)">Link Two</a></li>
				</ul>
			</li> -->
		</ul>
	</div>
</div>
