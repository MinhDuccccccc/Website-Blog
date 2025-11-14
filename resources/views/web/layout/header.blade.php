<header class="tech-header header">
    <div class="container-fluid">
        <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="/">
                <img src="/web/images/version/tech-logo.png" alt="">
            </a>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                {{-- Main Menu --}}
                <ul class="navbar-nav mr-auto" style="margin-right: 30px;">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/category">Category</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contact">Contact Us</a></li>
                </ul>

                {{-- Search Bar --}}
                <form action="{{ route('web.search') }}" method="GET" 
                      class="form-inline my-2 my-lg-0" 
                      style="margin-left: -15px; margin-right: 15px;">
                    <input class="form-control mr-sm-2" 
                           type="search" 
                           name="keyword" 
                           placeholder="Search..." 
                           aria-label="Search" 
                           style="width: 200px; border-radius: 20px; padding-left: 15px;">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit"
                            style="border-radius: 20px; padding: 5px 10px;">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
                {{-- End Search Bar --}}

                {{-- Right Icons --}}
                <ul class="navbar-nav" style="margin-left: -5px;">
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-rss"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-android"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-apple"></i></a></li>

                    {{-- User Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @auth
                                <li>
                                    <a class="dropdown-item" href="{{ route('web.auth.logout') }}">
                                        <i class="fa fa-sign-in fa-fw"></i> Logout
                                    </a>
                                </li>
                            @endauth

                            @guest
                                <li>
                                    <a class="dropdown-item" href="{{ route('web.auth.login') }}">
                                        <i class="fa fa-sign-in fa-fw"></i> Login
                                    </a>
                                </li>
                            @endguest
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div><!-- end container-fluid -->
</header><!-- end market-header -->
