
@include('header')
@php
    $user = auth()->user(); // ✅ đảm bảo luôn có biến $user
@endphp
<div class="container my-5">
    <div class="row">
        <!-- SIDEBAR -->
<div class="col-md-3 px-3">
    <div class="card shadow-sm mb-4 text-center py-4">
        <img src="{{ asset('images/nguoidung/' . ($user->avatar ?? 'macdinh.png')) }}" 
             class="rounded-circle mb-3 shadow-sm border avatar-img" width="100" height="100" style="object-fit: cover;position:center"> 
        <h3 class="fw-semibold mb-0">{{ $user->tenND }}</h3>
        <small class="text-muted">Thành viên</small>
    </div>

    <ul class="list-group shadow-sm mb-4">
        <li class="list-group-item {{ request()->routeIs('profile.edit') ? 'active text-white bg-dark' : '' }}">
            <a href="{{ route('profile.edit') }}" class="text-decoration-none d-flex align-items-center">
                <i class="fas fa-user me-2"></i> Thông tin tài khoản
            </a>
        </li>
        <li class="list-group-item {{ request()->routeIs('donhang.index') ? 'active text-white bg-dark' : '' }}">
            <a href="{{ route('donhang.index') }}" class="text-decoration-none d-flex align-items-center">
                <i class="fas fa-box me-2"></i> Đơn hàng của tôi
            </a>
        </li>
        <li class="list-group-item {{ request()->routeIs('nhanxet.index') ? 'active text-white bg-dark' : '' }}">
            <a href="{{ route('nhanxet.index') }}" class="text-decoration-none d-flex align-items-center">
                <i class="fas fa-pen me-2"></i> Nhận xét sản phẩm
            </a>
        </li>
    </ul>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
            <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
        </button>
    </form>
</div>
<!-- NỘI DUNG CHÍNH -->
<div class="col-md-9">
            @yield('content')
        </div>

    </div>
</div>
<style>
    .account-sidebar {
        padding-left: 30px;
    }

    .account-content {
        padding-left: 30px;
    }

    .account-content h2 {
        margin-bottom: 30px;
    }

    table.table td, table.table th {
        padding: 14px 16px;
    }

    .list-group-item a {
        padding-left: 10px;
    }
    .list-group-item {
        transition: background 0.3s, color 0.3s;
        font-weight: 500;
        font-size: 15px;
        border: none;
        padding: 12px 18px;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .list-group-item.active {
        background-color: #343a40 !important;
        color: #fff !important;
    }

    .list-group-item a {
        color: inherit;
        width: 100%;
    }

    .btn-outline-danger {
        font-weight: 500;
        padding: 10px;
    }
    .avatar-img {
    width: 110px;
    height: 110px;
    object-fit: cover;
    border: 3px solid #ccc;
    display: block;
    margin: 0 auto;
}
</style>
