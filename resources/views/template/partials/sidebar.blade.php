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
        <li class="nav-item mT-30 actived">
            <a class="sidebar-link" href="/">
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
            <a class="sidebar-link" href="/calendar">
                <span class="icon-holder"><i class="fas fa-newspaper c-deep-orange-500"></i></span>
                <span class="title">Quản lý bài viết</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="sidebar-link" href="/chat">
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
            <a class="sidebar-link" href="/forms">
                <span class="icon-holder"><i class="fas fa-shopping-cart c-light-blue-500"></i></span>
                <span class="title">Quản lý đơn hàng</span>
            </a>
        </li>

            <li class="nav-item dropdown"><a class="sidebar-link" href="/ui"><span class="icon-holder"><i class="fas fa-palette c-pink-500"></i></span><span class="title">UI Elements</span></a></li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder"><i class="fas fa-table c-orange-500"></i></span>
                    <span class="title">Tables</span>
                    <span class="arrow"><i class="fas fa-angle-right"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="sidebar-link" href="/basic-table">Basic Table</a></li>
                    <li><a class="sidebar-link" href="/datatable">Data Table</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder"><i class="fas fa-map c-purple-500"></i></span>
                    <span class="title">Maps</span>
                    <span class="arrow"><i class="fas fa-angle-right"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="/google-maps">Google Map</a></li>
                    <li><a href="/vector-maps">Vector Map</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder"><i class="fas fa-file-alt c-red-500"></i></span>
                    <span class="title">Pages</span>
                    <span class="arrow"><i class="fas fa-angle-right"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="sidebar-link" href="/blank">Blank</a></li>
                    <li><a class="sidebar-link" href="/404">404</a></li>
                    <li><a class="sidebar-link" href="/500">500</a></li>
                    <li><a class="sidebar-link" href="/signin">Sign In</a></li>
                    <li><a class="sidebar-link" href="/signup">Sign Up</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder"><i class="fas fa-layer-group c-teal-500"></i></span>
                    <span class="title">Multiple Levels</span>
                    <span class="arrow"><i class="fas fa-angle-right"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="nav-item dropdown"><a href="javascript:void(0);"><span>Menu Item</span></a></li>
                    <li class="nav-item dropdown">
                        <a href="javascript:void(0);"><span>Menu Item</span>
                            <span class="arrow"><i class="fas fa-angle-right"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0);">Menu Item</a></li>
                            <li><a href="javascript:void(0);">Menu Item</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
