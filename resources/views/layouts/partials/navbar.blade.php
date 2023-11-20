<nav class="navbar navbar-expand-lg main-navbar">

    <ul class="navbar-nav navbar-right ms-auto">

        <li class="dropdown dropdown-list-toggle">
            <a href="#"
               data-toggle="dropdown"
               class="nav-link notification-toggle nav-link-lg">
                <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">

            </div>
        </li>

        <li class="dropdown">
            <a href="#"
               data-bs-toggle="dropdown"
               class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="#"
                   class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>

                <div class="dropdown-divider"></div>

                <form action="{{ route('logout') }}"
                      method="post"
                      id="logout">
                    @csrf
                    <a onclick="document.getElementById('logout').requestSubmit()"
                       data-turbo-method="post"
                       class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>

            </div>
        </li>
    </ul>
</nav>
