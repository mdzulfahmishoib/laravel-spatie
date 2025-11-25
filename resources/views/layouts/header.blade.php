<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark bg-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item mt-1">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="{{ auth()->user()->foto
                    ? asset('storage/management_user/foto_profil/' . auth()->user()->foto)
                    : asset('img/default_user.jpg') }}"
                    alt="User Avatar" class="img-size-32 img-circle elevation-1" style="object-fit: cover;">
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right bg-dark text-white">
                <div class="px-3 py-2 text-center">
                    <img src="{{ auth()->user()->foto
                        ? asset('storage/management_user/foto_profil/' . auth()->user()->foto)
                        : asset('img/default_user.jpg') }}"
                        alt="User Image" class="img-circle elevation-1" width="80" height="80"
                        style="object-fit: cover;">
                    <p class="mt-2 mb-0 font-weight-bold text-white">{{ auth()->user()->name }}</p>
                    <p class="mb-0 text-white">{{ auth()->user()->email }}</p>
                    <small class="text-white">Terdaftar sejak :
                        {{ tanggal_indonesia(auth()->user()->created_at) }}</small>
                </div>
                <div class="dropdown-divider border-secondary"></div>
                <div class="px-3 py-2 text-center bg-white">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('layouts.profil') }}" class="btn btn-primary btn-sm mr-2">
                            <i class="fas fa-user"></i> Profil
                        </a>
                        <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="btn btn-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->


<form action="{{ route('logout') }}" method="POST" style="display: none;" id="logout-form">
    @csrf
</form>
