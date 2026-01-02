<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

    {{-- Navbar header --}}
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="{{ route('admin.post.index') }}">
            <i class="fa fa-cogs"></i> TechBlog Admin
        </a>
    </div>

    {{-- Top right menu --}}
    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user-circle"></i>
                <span class="hidden-xs">
                    {{ auth()->user()->name ?? 'Admin' }}
                </span>
                <i class="fa fa-caret-down"></i>
            </a>

            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="{{ route('admin.profile.index') }}">
                        <i class="fa fa-user fa-fw"></i> Profile
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ route('admin.logout') }}">
                        <i class="fa fa-sign-out fa-fw"></i> Logout
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    {{-- Sidebar --}}
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            @include('admin.layout.menu')
        </div>
    </div>

</nav>
