<ul class="navbar-nav  bg-primary  sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class=" d-flex align-items-center justify-content-center" href="#">
        <div class="row mt-4 mb-4 mx-auto">
            {{-- <div class=" col-sm-3 d-sm-block d-none"><img class="img-fluid" src="asset/img/logo.png" alt="">
            </div> --}}
            <div class=" my-auto col-sm-12 d-none d-sm-block text-center "><img class="img-fluid w-75"
                    src="{{ url('/asset/img/cbt.svg') }}" alt="">
            </div>

            <div class=" my-auto col-12 d-block d-sm-none text-center "><img class="img-fluid w-75"
                    src="{{ url('/asset/img/cbt.svg') }}" alt="">
            </div>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    {{-- ADMIN --}}

    {{-- User --}}

    <li class="nav-item {{ Request::is('index*') ? 'active' : '' }} animate-btn">
        <a class="nav-link" href="{{ route('index') }}"> <i class="fa-solid fa-check"></i>
            <span>Rekomendasi</span></a>
    </li>

    <li class="nav-item {{ Request::is('supplier*') ? 'active' : '' }} animate-btn">
        <a class="nav-link" href="{{ route('view-supplier') }}"><i class="fa-solid fa-boxes-packing"></i>
            <span>Supplier</span></a>
    </li>

    <li class="nav-item {{ Request::is('item*') ? 'active' : '' }} animate-btn">
        <a class="nav-link" href="{{ route('view-item') }}"><i class="fa-solid fa-box"></i>
            <span>Item</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
