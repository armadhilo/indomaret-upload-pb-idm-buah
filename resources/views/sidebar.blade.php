<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">UPLOAD PB IDM BUAH<sup>VB</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Home</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <div class="sidebar-heading">
        Proses Buah
    </div>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/master-timbangan') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Master Timbangan</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/jadwal-kirim') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Jadwal Kirim Buah</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/cluster-buah') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Cluster Buah</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <!-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->
</ul>
