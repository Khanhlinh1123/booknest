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
	
	.menu-item.has-sub {
    position: relative;
}

.menu-item.has-sub > .dropdown-danhmuc-grid {
    display: none;
    position: absolute;
    top: calc(100% + 5px); /* Đẩy menu xuống 5px dưới mục "Danh mục" */
    left: 0;
    background-color: #f5f5f5;
    z-index: 9999;
    min-width: 550px;
    grid-template-columns: repeat(2, minmax(180px, 1fr));
    column-gap: 40px;
    row-gap: 10px;
    padding: 12px 20px;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    transition: opacity 0.2s ease;
}

.menu-item.has-sub:hover > .dropdown-danhmuc-grid {
    display: grid;
}


/* Bố cục danh mục con */
ul.dropdown-danhmuc-grid li {
    list-style: none;
    margin: 0;
}

ul.dropdown-danhmuc-grid li a {
    display: block;
    padding: 6px 8px;
    font-size: 14px;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
}

ul.dropdown-danhmuc-grid li a:hover {
    background-color: rgb(209, 126, 48); /* nâu nhạt */
    color: #fff;
}

/* Form tìm kiếm */
.custom-search-form {
    margin-bottom: 0 !important;
    max-width: 600px;
    margin: 0 auto;
}

.custom-input {
    height: 46px;
    border-radius: 999px;
    font-size: 15px;
}

.custom-button {
    height: 36px;
    width: 40px;
    border-radius: 999px;
    background-color: rgb(209, 126, 48);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
}
.danhmuc-hover-wrap {
    position: relative;
    display: inline-block;
}

/* Hiển thị menu khi hover */
.danhmuc-hover-wrap {
    position: relative;
    display: inline-block;
}

.dropdown-danhmuc-grid {
    display: none;
    position: absolute;
    top: calc(100% + 5px);
    left: 0;
    background-color: #f5f5f5;
    z-index: 9999;
    min-width: 550px;
    padding: 20px 20px;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    transition: opacity 0.2s ease;

    /* Giữ layout chia cột dù đang ẩn */
    grid-template-columns: repeat(2, minmax(180px, 1fr));
    column-gap: 40px;
    row-gap: 10px;
    display: none; /* quan trọng: không set grid ở đây */
}

/* Khi hover vào wrap thì menu hiển thị + dùng layout grid */
.danhmuc-hover-wrap:hover .dropdown-danhmuc-grid {
    display: grid;
}


</style>


<!-- Tìm kiếm trên đầu -->
<div class="bg-light border-bottom py-3">
    <div class="container">
        <form method="GET" action="{{ route('timkiem') }}" class="d-flex justify-content-center position-relative custom-search-form">
            <input type="text" name="tuKhoa" id="searchInput"
                class="form-control rounded-pill custom-input ps-4 pe-5"
                placeholder="Tìm kiếm sách..."
                autocomplete="off">

            <button type="submit" class="custom-button position-absolute end-0 me-2"style="top: -10px;">
                <i class="fa fa-search"></i>
            </button>

            <!-- Box gợi ý -->
            <div id="suggestionsBox"
                class="bg-white border rounded shadow-sm position-absolute w-100 mt-2"
                style="display:none; max-height: 300px; overflow-y: auto; z-index:999; top: 100%;">
            </div>
        </form>
    </div>
</div>



<div id="header-wrap">
		<header id="header">
			<div class="container-fluid">
				<div class="row ">

					<div class="col-md-2">
						<div class="main-logo">
							<a href="/"><img src="{{ asset('assets/bnhome/images/logo.png') }}" alt="logo"></a>
						</div>

					</div>

					<div class="col-md-8">

						<nav id="navbar">
							<div class="main-menu stellarnav">
								<ul class="menu-list">
									<li class="menu-item active"><a href="{{ route('home') }}">Trang chủ</a></li>
									<li class="menu-item has-sub">
  <div class="danhmuc-hover-wrap">
    <a href="#" class="nav-link">Danh mục <i class="fa-solid fa-angle-down" style="font-size: 0.6rem; margin-left: 6px;"></i>
	</a>
    <ul class="dropdown-danhmuc-grid">
      @foreach ($danhmucs as $dm)
        <li><a href="{{ route('danhmuc.show', $dm->maDM) }}">{{ $dm->tenDM }}</a></li>
      @endforeach
    </ul>
  </div>
</li>

									<li class="menu-item"><a href="{{ route('tacgia.index') }}" class="nav-link">Tác giả</a></li>
									<li class="menu-item"><a href="{{ route('baiviet.index') }}" class="nav-link">Bài viết</a></li>
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




					<div class="col-md-2 position-relative d-flex  gap-3">
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

	</div><!--header-wrap-->

	<script src="{{ asset('assets/bnhome/js/jquery-1.11.0.min.js') }}"></script>	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
		crossorigin="anonymous"></script>
    <script src="{{ asset('assets/bnhome/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/bnhome/js/script.js') }}"></script>
	<script>
document.addEventListener('DOMContentLoaded', function () {
	// Ẩn menu khi click vào bất kỳ mục nào trong danh mục
	document.querySelectorAll('.dropdown-danhmuc-grid a').forEach(link => {
		link.addEventListener('click', function () {
			const submenu = document.querySelector('.dropdown-danhmuc-grid');
			if (submenu) submenu.style.display = 'none';
		});
	});
});
</script>
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
