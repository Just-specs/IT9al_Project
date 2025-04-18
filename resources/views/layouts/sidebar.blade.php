<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-light fa-computer"></i>
        </div>
        <div class="sidebar-brand-text mx-3">DayTech <sup>computer parts</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('products') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Product</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('suppliers') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Supplier</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/profile">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Profile</span></a>
    </li>

    <!-- Nav Item - Purchase Orders -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('purchase-orders') }}">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Purchase Orders</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>