<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">UPLOAD PB IDM BUAH<sup>VB</sup></div>
    </a>
    @php
        $sub_url = Request::segment(1);
    @endphp

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <li class="nav-item @if($sub_url == 'home') active @endif">
        <a class="nav-link" href="{{ url('/home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Home</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <div class="sidebar-heading">
        Proses Buah
    </div>
    <li class="nav-item @if($sub_url == 'master-timbangan') active @endif">
        <a class="nav-link" href="{{ url('/master-timbangan') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Master Timbangan</span></a>
    </li>
    <li class="nav-item @if($sub_url == 'jadwal-kirim') active @endif">
        <a class="nav-link" href="{{ url('/jadwal-kirim') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Jadwal Kirim Buah</span></a>
    </li>
    <li class="nav-item @if($sub_url == 'cluster-buah') active @endif">
        <a class="nav-link" href="{{ url('/cluster-buah') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Cluster Buah</span></a>
    </li>
    <li class="nav-item @if($sub_url == 'plu-hadiah') active @endif">
        <a class="nav-link" href="{{ url('/plu-hadiah') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>PLU HADIAH</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <!-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->
</ul>
