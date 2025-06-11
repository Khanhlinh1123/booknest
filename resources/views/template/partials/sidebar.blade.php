<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <div class="peers ai-c fxw-nw">
                <div class="peer peer-greed">
                    <a class="sidebar-link td-n" href="/">
                        <div class="peers ai-c fxw-nw">
                            <div class="peer">
                                <div class="logo"><img src="assets/static/images/logo.png" alt=""></div>
                            </div>
                            <div class="peer peer-greed">
                                <h5 class="lh-1 mB-0 logo-text">BookNest</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="peer">
                    <div class="mobile-toggle sidebar-toggle">
                        <a href="" class="td-n"><i class="fas fa-arrow-circle-left"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <ul class="sidebar-menu scrollable pos-r">
        <li class="nav-item mT-30 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                <span class="icon-holder"><i class="fas fa-tachometer-alt c-blue-500"></i></span>
                <span class="title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="sidebar-link" href="{{ route('admin.danhmuc.index') }}">
                <span class="icon-holder"><i class="fas fa-list-alt c-brown-500"></i></span>
                <span class="title">Quản lý danh mục</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="sidebar-link" href="{{ route('admin.sach.index') }}">
                <span class="icon-holder"><i class="fas fa-book c-blue-500"></i></span>
                <span class="title">Quản lý sách</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="sidebar-link" href="{{ route('admin.baiviet.index') }}">
                <span class="icon-holder"><i class="fas fa-newspaper c-deep-orange-500"></i></span>
                <span class="title">Quản lý bài viết</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="sidebar-link" href="{{ route('admin.khuyenmai.index') }}">
                <span class="icon-holder"><i class="fas fa-tags c-deep-purple-500"></i></span>
                <span class="title">Quản lý khuyến mại</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="sidebar-link" href="/charts">
                <span class="icon-holder"><i class="fas fa-user-shield c-indigo-500"></i></span>
                <span class="title">Quản lý tài khoản</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="sidebar-link" href="{{ route('admin.donhang.index') }}">
                <span class="icon-holder"><i class="fas fa-shopping-cart c-light-blue-500"></i></span>
                <span class="title">Quản lý đơn hàng</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="sidebar-link" href="{{ route('admin.tacgia.index') }}">
                <span class="icon-holder"><i class="fas fa-user-edit c-indigo-500"></i></span>
                <span class="title">Quản lý tác giả</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="sidebar-link" href="{{ route('admin.nhaxuatban.index') }}">
                <span class="icon-holder"><i class="fas fa-building c-amber-500"></i></span>
                <span class="title">Quản lý NXB</span>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.phieunhap.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.phieunhap.create') }}">
                <span class="icon-holder"><i class="fas fa-file-import c-green-500"></i></span>
                <span class="title">Nhập hàng</span>
            </a>
            </li>

 
        </ul>
    </div>
</div>
