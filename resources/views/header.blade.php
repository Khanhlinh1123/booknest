<!DOCTYPE html>
<html lang="en">

<head>
	<title>Nơi những trang sách tìm về tổ ấm</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="author" content="">
	<meta name="keywords" content="">
	<meta name="description" content="">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="{{ asset('assets/bnhome/css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/bnhome/icomoon/icomoon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/bnhome/css/vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/bnhome/style.css') }}" rel="stylesheet">


</head>

<div id="header-wrap">

		<div class="top-content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<div class="social-links">
							<ul>
								<li>
									<a href="#"><i class="icon icon-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="icon icon-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="icon icon-youtube-play"></i></a>
								</li>
								<li>
									<a href="#"><i class="icon icon-behance-square"></i></a>
								</li>
							</ul>
						</div><!--social-links-->
					</div>
					

				</div>
			</div>
		</div><!--top-content-->

		<header id="header">
			<div class="container-fluid">
				<div class="row">

					<div class="col-md-2">
						<div class="main-logo">
							<a href="/"><img src="{{ asset('assets/bnhome/images/logo.png') }}" alt="logo"></a>
						</div>

					</div>

					<div class="col-md-7">

						<nav id="navbar">
							<div class="main-menu stellarnav">
								<ul class="menu-list">
									<li class="menu-item active"><a href="#home">Trang chủ</a></li>
									<li class="menu-item has-sub">
									<a href="#" class="nav-link">Danh mục</a>
										<ul>
										@foreach ($danhmucs as $dm)
										<li><a href="{{ route('danhmuc.show', $dm->maDM) }}">{{ $dm->tenDM }}</a></li>
										@endforeach
										</ul>

									</li>
									<li class="menu-item"><a href="#featured-books" class="nav-link">Tác giả</a></li>
									<li class="menu-item"><a href="#popular-books" class="nav-link">Bài viết</a></li>
									<li class="menu-item"><a href="#special-offer" class="nav-link">Về BookNest</a></li>
									
								</ul>

								<div class="hamburger">
									<span class="bar"></span>
									<span class="bar"></span>
									<span class="bar"></span>
								</div>

							</div>
						</nav>

					</div>
					<div class="col-md-2">
						<div class="right-element">
						<div class="action-menu">

						<div class="search-bar">
							<a href="#" class="search-button search-toggle" data-selector="#header-wrap">
								<i class="icon icon-search"></i>
							</a>
							<form role="search" method="get" class="search-box">
								<input class="search-field text search-input" placeholder="Search"
									type="search">
							</form>
						</div>
						</div>
						</div>

					</div>
					<div class="col-md-1 position-relative d-flex align-items-center">
    <!-- Icon người dùng -->
    <div class="dropdown">
        <a href="#" class="user-account for-buy" data-bs-toggle="dropdown">
            <i class="icon icon-user"> </i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 160px;">
            @guest
                <li><a class="dropdown-item" href="{{ route('login') }}">Đăng nhập</a></li>
                <li><a class="dropdown-item" href="{{ route('register') }}">Đăng ký</a></li>
            @else
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Tài khoản</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item">Đăng xuất</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>

    <!-- Giỏ hàng -->
    <a href="#" class="cart for-buy"><i class="icon icon-clipboard"></i></a>
</div>
					
				</div>
			</div>
		</header>

	</div><!--header-wrap-->