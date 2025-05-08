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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>

<style>
	
    .search-bar {
    position: relative;
    width: 250px; /* hoặc điều chỉnh theo ý */
}

.search-bar input[type="search"] {
    width: 100%;
    height: 40px;
    padding: 0 45px 0 15px; /* chừa phải 40px cho nút */
    font-size: 14px;
    border-radius: 20px;
    border: 1px solid #ccc;
    outline: none;
    box-sizing: border-box;
}

.search-bar button {
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    margin: 0;
    font-size: 18px;
    color: #6c757d;
    line-height: 1;
}


</style>


<div id="header-wrap">

		<div class="top-content">
			<div class="container-fluid">
				<div class="row ">
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
				<div class="row ">

					<div class="col-md-2">
						<div class="main-logo">
							<a href="/"><img src="{{ asset('assets/bnhome/images/logo.png') }}" alt="logo"></a>
						</div>

					</div>

					<div class="col-md-7">

						<nav id="navbar">
							<div class="main-menu stellarnav">
								<ul class="menu-list">
									<li class="menu-item active"><a href="{{ route('home') }}">Trang chủ</a></li>
									<li class="menu-item has-sub">
									<a href="#" class="nav-link">Danh mục</a>
										<ul>
										@foreach ($danhmucs as $dm)
										<li><a href="{{ route('danhmuc.show', $dm->maDM) }}">{{ $dm->tenDM }}</a></li>
										@endforeach
										</ul>

									</li>
									<li class="menu-item"><a href="{{ route('tacgia.show') }}" class="nav-link">Tác giả</a></li>
									<li class="menu-item"><a href="#latest-blog" class="nav-link">Bài viết</a></li>
									<li class="menu-item"><a href="#best-selling" class="nav-link">Về BookNest</a></li>
									
								</ul>

								<div class="hamburger">
									<span class="bar"></span>
									<span class="bar"></span>
									<span class="bar"></span>
								</div>

							</div>
						</nav>

					</div>

					<!-- Tìm kiếm -->
					<div class="col-md-2 position-relative ">
						<div class="search-bar position-relative" style="max-width: 220px;">
							<form id="searchForm" method="GET" action="{{ route('timkiem') }}">
								<input type="text" name="tuKhoa" id="searchInput" class="form-control rounded-pill px-3 py-1"
									placeholder="Tìm kiếm sách..." autocomplete="off" style="font-size: 14px;">
									<button type="submit"
										class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent p-0"
										style="height: 100%; display: flex; align-items: center; justify-content: center; padding-right: 10px;">
										<i class="fa-solid fa-magnifying-glass text-muted"></i>
									</button>
							</form>
							<div id="suggestionsBox" class="bg-white border rounded shadow position-absolute w-100 mt-1"
								style="display:none; max-height: 320px; overflow-y: auto; z-index:999;"></div>
						</div>
					</div>





					<div class="col-md-1 position-relative d-flex  gap-3">
						<!-- Icon người dùng -->
						<div class="dropdown">
							<a href="#" class="user-account for-buy" data-bs-toggle="dropdown">
							<i class="fa-solid fa-user fa-xl" style="color: #5c452b;"></i>

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

							<a href="{{ route('giohang.hienthi') }}" class="cart for-buy position-relative">
							<i class="fa-solid fa-cart-shopping fa-xl" style="color: #5c452b;"></i>
							@if(isset($soLuongTrongGio) && $soLuongTrongGio > 0)
								<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
									{{ $soLuongTrongGio }}
								</span>
							@endif
						</a>

							</div>
					
				</div>
			</div>
		</header>
		<div class="container mt-4" id="searchResults"></div>

	</div><!--header-wrap-->

	<script src="{{ asset('assets/bnhome/js/jquery-1.11.0.min.js') }}"></script>	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
		crossorigin="anonymous"></script>
    <script src="{{ asset('assets/bnhome/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/bnhome/js/script.js') }}"></script>
	<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('searchInput');
    const box = document.getElementById('suggestionsBox');
    const form = document.getElementById('searchForm');

    input.addEventListener('input', function () {
        const keyword = this.value.trim();
        if (!keyword) {
            box.style.display = 'none';
            return;
        }

        fetch(`/api/sach-search?q=${encodeURIComponent(keyword)}`)
            .then(res => res.json())
            .then(data => {
                box.innerHTML = '';

                if (data.length === 0) {
                    box.innerHTML = '<div class="p-2 text-muted">Không tìm thấy kết quả.</div>';
                } else {
                    data.forEach(item => {
                        const html = `
                            <a href="${item.url}" class="d-flex align-items-center p-2 text-dark text-decoration-none border-bottom">
                                <img src="${item.hinhanh}" style="width:40px;height:50px;object-fit:cover;margin-right:10px;">
                                <div class="flex-grow-1">
                                    <div class="fw-bold" style="font-size:13px">${item.tenSach}</div>
                                    <div class="text-danger" style="font-size:12px">${item.giaDaGiam.toLocaleString()}₫
                                        <span class="text-muted text-decoration-line-through ms-1">${item.giaGoc.toLocaleString()}₫</span>
                                    </div>
                                </div>
                            </a>`;
                        box.innerHTML += html;
                    });
                }

                box.style.display = 'block';
            });
    });

    // Enter key redirect
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            form.submit();
        }
    });

    // Hide suggestion when click outside
    document.addEventListener('click', function (e) {
        if (!input.contains(e.target) && !box.contains(e.target)) {
            box.style.display = 'none';
        }
    });
});
</script>
