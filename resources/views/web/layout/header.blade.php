{{-- ================= BOOTSTRAP + FONT AWESOME ================= --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

{{-- ================= HEADER CSS (UPDATED) ================= --}}
<style>
/* Header tổng */
.tech-header {
    height: 84px; /* tăng chiều cao */
    z-index: 999;
}

/* Navbar */
.tech-navbar {
    background: rgba(15, 23, 42, 0.96);
    backdrop-filter: blur(10px);
    box-shadow: 0 6px 28px rgba(0,0,0,.45);
    padding: 14px 36px; /* tăng chiều rộng */
}

/* Logo */
.tech-navbar .logo {
    height: 40px; /* logo to hơn */
}

/* Menu */
.tech-menu .nav-link {
    color: #e5e7eb !important;
    margin: 0 18px;
    font-weight: 500;
    font-size: 15px;
    position: relative;
    transition: 0.3s;
}

.tech-menu .nav-link:hover {
    color: #38bdf8 !important;
}

/* Search */
.tech-search {
    display: flex;
    align-items: center;
    background: #020617;
    border-radius: 999px;
    padding: 7px 14px;
    margin-right: 20px;
}

.tech-search input {
    background: transparent;
    border: none;
    color: #fff;
    outline: none;
    width: 180px;
    font-size: 14px;
}

.tech-search input::placeholder {
    color: #94a3b8;
}

.tech-search button {
    background: none;
    border: none;
    color: #38bdf8;
    font-size: 14px;
}

/* Icons */
.tech-icons .nav-link {
    color: #e5e7eb !important;
    font-size: 18px;
    margin-left: 14px;
    transition: 0.3s;
}

.tech-icons .nav-link:hover {
    color: #38bdf8 !important;
}

/* Dropdown */
.dropdown-menu {
    background: #020617;
    border-radius: 12px;
    border: none;
}

.dropdown-item {
    color: #e5e7eb;
}

.dropdown-item:hover {
    background: #38bdf8;
    color: #020617;
}

/* Mobile */
@media (max-width: 768px) {
    .tech-search {
        width: 100%;
        margin: 12px 0;
    }

    .tech-search input {
        width: 100%;
    }
}
</style>

<header class="tech-header">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top tech-navbar">
        <div class="container-fluid">

            <!-- LOGO ONLY (đã bỏ title TechBlog) -->
            <a class="navbar-brand" href="/">
                <img src="/web/images/version/tech-logo.png" class="logo" alt="Tech Blog">
            </a>

            <!-- Toggle -->
            <button class="navbar-toggler" type="button"
                data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">

                <!-- Menu -->
                <ul class="navbar-nav mx-auto tech-menu">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/category">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                </ul>

                <!-- Search -->
                <form action="{{ route('web.search') }}" method="GET" class="tech-search">
                    <input type="search" name="keyword" placeholder="Search articles...">
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                <!-- Icons + User -->
                <ul class="navbar-nav tech-icons">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-rss"></i></a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user-circle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @auth
                                <a class="dropdown-item" href="{{ route('web.auth.logout') }}">
                                    Logout
                                </a>
                            @endauth

                            @guest
                                <a class="dropdown-item" href="{{ route('web.auth.login') }}">
                                    Login
                                </a>
                            @endguest
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</header>

{{-- ================= BOOTSTRAP JS ================= --}}
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
