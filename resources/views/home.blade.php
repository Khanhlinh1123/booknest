
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
<style>
	.star-rating {
		position: relative;
		display: inline-block;
		font-size: 16px;
		line-height: 1;
		}

		.stars {
		letter-spacing: 2px;
		font-family: Arial, sans-serif;
		color: #ccc;
		}

		.stars.overlay {
		color: #ffc107;
		position: absolute;
		top: 0;
		left: 0;
		overflow: hidden;
		width: var(--percent);
		white-space: nowrap;
		pointer-events: none;
		}
		.discount-badge {
		position: absolute;
		top: 10px;
		right: 10px;
		background-color: #dc3545;
		color: white;
		font-size: 14px;
		font-weight: bold;
		border-radius: 50%;
		width: 45px;
		height: 45px;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0 2px 6px rgba(0,0,0,0.15);
		z-index: 10;
		}

</style>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">

@include('header')

	<section id="billboard" style="margin-top: 0; padding-top: 0;">
	<div class="main-slider slick-slider">
		<div class="slider-item">
			<img src="{{ asset('assets/bnhome/images/ms_banner_img3.webp') }}" alt="Banner 1" class="banner-image img-fluid w-100">
		</div>
		<div class="slider-item">
			<img src="{{ asset('assets/bnhome/images/ms_banner_img4.webp') }}" alt="Banner 2" class="banner-image img-fluid w-100">
		</div>
		<div class="slider-item">
			<img src="{{ asset('assets/bnhome/images/ms_banner_img5.webp') }}" alt="Banner 3" class="banner-image img-fluid w-100">
		</div>
	</div>

	<!-- Nút điều hướng -->
	<button class="prev slick-arrow"><i class="icon icon-arrow-left"></i></button>
	<button class="next slick-arrow"><i class="icon icon-arrow-right"></i></button>
</section>


<section id="featured-books" class="py-3 my-3">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<div class="section-header align-center">
					<div class="title">
						<span></span>
					</div>
					<h2 class="section-title">Sách mới</h2>
				</div>

				<div class="product-list" data-aos="fade-up">
					<div class="row">

						@foreach($sachMoi as $sach)
						<div class="col-md-2-4">
							<div class="product-item">
								<figure class="product-style position-relative">
									{{-- Vòng tròn giảm giá --}}
									@if($sach->giaDaGiam < $sach->giaGoc)
										@php
											$phanTram = round(100 * ($sach->giaGoc - $sach->giaDaGiam) / $sach->giaGoc);
										@endphp
										<div class="discount-badge">
											- {{ $phanTram }}%
										</div>
									@endif
									<a href="{{ route('sach.show', $sach->slug) }}">
										<img src="{{ asset('images/sach/' . $sach->hinhanh) }}"
											alt="{{ $sach->tenSach }}"
											style="width: 100%; height: 280px; object-fit: cover; border-radius: 6px;">
									</a>
									<form action="{{ route('giohang.them') }}" method="POST" style="display: inline;">
										@csrf
										<input type="hidden" name="maSach" value="{{ $sach->maSach }}">
										<input type="hidden" name="soLuong" value="1">
										<button type="submit" class="add-to-cart" data-product-tile="add-to-cart">Thêm vào giỏ</button>
									</form>
								</figure>

								<figcaption class="pt-2">
									<h4 class="mb-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 48px;">
										<a href="{{ route('sach.show', $sach->slug) }}" class="text-decoration-none text-dark">
										{{ $sach->tenSach }}
										</a>
									</h4>

									<span class="text-muted small">{{ $sach->tacGia->tenTG ?? 'Không rõ' }}</span>

									{{-- Giá --}}
									<div class="mt-1">
										<span class="fw-bold text-danger" style="font-size: 18px;">
										{{ number_format($sach->giaDaGiam) }}₫
										</span>

										@if($sach->giaDaGiam < $sach->giaGoc)
										<span class="text-muted text-decoration-line-through ms-2">
											{{ number_format($sach->giaGoc) }}₫
										</span>
										@endif
									</div>

									{{-- Đánh giá + đã bán --}}
									<div style="font-size: 14px; color: #666;" class="mt-2">
										@if($sach->soDanhGia > 0)
									@php
										$rating = round($sach->trungBinhSao * 10) / 10; // ví dụ 4.2
										$percentage = min(100, $rating / 5 * 100); // % tô vàng
									@endphp

									<div class="star-rating" style="--percent: {{ $percentage }}%">
										<div class="stars base">★★★★★</div>
										<div class="stars overlay">★★★★★</div>
									</div>
									<span class="ms-1 text-muted">({{ $sach->soDanhGia }})</span>
									@endif
										<span class="ms-2">| Đã bán {{ number_format($sach->soLuongDaBan) }}</span>
									</div>

								</figcaption>

							</div>
						</div>
						@endforeach

					</div>
				</div>

			</div>
		</div>

		<section id="featured-books" class="py-3 my-3">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<div class="section-header align-center">
					<div class="title">
						<span></span>
					</div>
					<h2 class="section-title">Sách được mua nhiều nhất</h2>
				</div>

				<div class="product-list" data-aos="fade-up">
					<div class="row">

						@foreach($top5Sach as $sach)
						<div class="col-md-2-4">
							<div class="product-item" style="min-height: 320px;">
								<figure class="product-style position-relative">
									{{-- Vòng tròn giảm giá --}}
									@if($sach->giaDaGiam < $sach->giaGoc)
										@php
											$phanTram = round(100 * ($sach->giaGoc - $sach->giaDaGiam) / $sach->giaGoc);
										@endphp
										<div class="discount-badge">
											- {{ $phanTram }}%
										</div>
									@endif
									<a href="{{ route('sach.show', $sach->slug) }}">
										<img src="{{ asset('images/sach/' . $sach->hinhanh) }}"
											alt="{{ $sach->tenSach }}"
											style="width: 100%; height: 280px; object-fit: cover; border-radius: 6px;">
									</a>
									<form action="{{ route('giohang.them') }}" method="POST" style="display: inline;">
										@csrf
										<input type="hidden" name="maSach" value="{{ $sach->maSach }}">
										<input type="hidden" name="soLuong" value="1">
										<button type="submit" class="add-to-cart" data-product-tile="add-to-cart">Thêm vào giỏ</button>
									</form>
								</figure>
								<figcaption class="pt-2">
									<h4 class="mb-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 48px;">
										<a href="{{ route('sach.show', $sach->slug) }}" class="text-decoration-none text-dark">
										{{ $sach->tenSach }}
										</a>
									</h4>
								  <span class="text-muted small">{{ $sach->tacGia->tenTG ?? 'Không rõ' }}</span>

									{{-- Giá --}}
									<div class="mt-1">
										<span class="fw-bold text-danger" style="font-size: 18px;">
										{{ number_format($sach->giaDaGiam) }}₫
										</span>

										@if($sach->giaDaGiam < $sach->giaGoc)
										<span class="text-muted text-decoration-line-through ms-2">
											{{ number_format($sach->giaGoc) }}₫
										</span>

										
										@endif
									</div>

									{{-- Đánh giá + đã bán --}}
									<div style="font-size: 14px; color: #666;" class="mt-2">
									@if($sach->soDanhGia > 0)
									@php
										$rating = round($sach->trungBinhSao * 10) / 10; // ví dụ 4.2
										$percentage = min(100, $rating / 5 * 100); // % tô vàng
									@endphp

									<div class="star-rating" style="--percent: {{ $percentage }}%">
										<div class="stars base">★★★★★</div>
										<div class="stars overlay">★★★★★</div>
									</div>
									<span class="ms-1 text-muted">({{ $sach->soDanhGia }})</span>
									@endif
									<span class="ms-2">| Đã bán {{ number_format($sach->soLuongDaBan) }}</span>
									
								</div>
							</figcaption>

							</div>
						</div>
						@endforeach

					</div>
				</div>

			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="btn-wrap align-right">
					<a href="{{ route('sach.new') }}" class="btn-accent-arrow">Xem tất cả sách <i class="icon icon-ns-arrow-right"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>


<section id="author-section" class="py-3 my-3" data-aos="fade-up">
    <div class="container">
        <div class="section-header align-center mb-4">
            <div class="title">
                <span></span>
            </div>
            <h2 class="section-title">Các tác giả</h2>
        </div>

        <div class="row justify-content-center text-center">
            @foreach ($tacgias as $tacgia)
                <div class="col-6 col-sm-4 col-md-2 mb-4">
                    <a href="{{ route('tacgia.show', $tacgia->slug) }}" class="text-decoration-none text-dark">
                        <div class="author-item">
                            <img src="{{ asset('images/tacgia/' . $tacgia->hinhanh) }}"
                                 alt="{{ $tacgia->tenTG }}"
                                 class="rounded-circle img-fluid"
                                 style="width: 150px; height: 150px; object-fit: cover; margin-bottom: 10px;">
                            <p class="fw-semibold">{{ $tacgia->tenTG }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="btn-wrap align-right">
                    <a href="{{ route('tacgia.index') }}" class="btn-accent-arrow">
                        Xem tất cả tác giả <i class="icon icon-ns-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>



	
	

	<section id="quotation" class="align-center pb-3 mb-3">
		<div class="inner-content">
			<h2 class="section-title divider">Quote trong ngày</h2>
			<blockquote data-aos="fade-up">
				<q>“Một cuốn sách thực sự hay nên đọc khi tuổi trẻ, rồi đọc lại khi đã trưởng thành, và một nửa lúc tuổi già, giống như một tòa nhà đẹp nên được chiêm ngưỡng trong ánh bình minh, nắng trưa và ánh trăng.”</q>
				<div class="author-name">Robertson Davies</div>
			</blockquote>
		</div>
	</section>

	<!-- <section id="special-offer" class="bookshelf pb-5 mb-5">

		<div class="section-header align-center">
			<div class="title">
				<span>Grab your opportunity</span>
			</div>
			<h2 class="section-title">Books with offer</h2>
		</div>

		<div class="container">
			<div class="row">
				<div class="inner-content">
					<div class="product-list" data-aos="fade-up">
						<div class="grid product-grid">
							<div class="product-item">
								<figure class="product-style">
									<img src="images/product-item5.jpg" alt="Books" class="product-item">
									<button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to
										Cart</button>
								</figure>
								<figcaption>
									<h3>Simple way of piece life</h3>
									<span>Armor Ramsey</span>
									<div class="item-price">
										<span class="prev-price">$ 50.00</span>$ 40.00
									</div>
								</div>
							</figcaption>

							<div class="product-item">
								<figure class="product-style">
									<img src="images/product-item6.jpg" alt="Books" class="product-item">
									<button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to
										Cart</button>
								</figure>
								<figcaption>
									<h3>Great travel at desert</h3>
									<span>Sanchit Howdy</span>
									<div class="item-price">
										<span class="prev-price">$ 30.00</span>$ 38.00
									</div>
								</div>
							</figcaption>

							<div class="product-item">
								<figure class="product-style">
									<img src="images/product-item7.jpg" alt="Books" class="product-item">
									<button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to
										Cart</button>
								</figure>
								<figcaption>
									<h3>The lady beauty Scarlett</h3>
									<span>Arthur Doyle</span>
									<div class="item-price">
										<span class="prev-price">$ 35.00</span>$ 45.00
									</div>
								</div>
							</figcaption>

							<div class="product-item">
								<figure class="product-style">
									<img src="images/product-item8.jpg" alt="Books" class="product-item">
									<button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to
										Cart</button>
								</figure>
								<figcaption>
									<h3>Once upon a time</h3>
									<span>Klien Marry</span>
									<div class="item-price">
										<span class="prev-price">$ 25.00</span>$ 35.00
									</div>
								</div>
							</figcaption>

							<div class="product-item">
								<figure class="product-style">
									<img src="images/product-item2.jpg" alt="Books" class="product-item">
									<button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to
										Cart</button>
								</figure>
								<figcaption>
									<h3>Simple way of piece life</h3>
									<span>Armor Ramsey</span>
									<div class="item-price">$ 40.00</div>
								</figcaption>
							</div>
						</div><!--grid-->
					</div>
				</div><!--inner-content-->
			</div>
		</div>
	</section> -->

	<section id="latest-blog" class="py-3 my-3">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<div class="section-header align-center">
						<div class="title">
							<span>Xem bài viết</span>
						</div>
						<h2 class="section-title">Bài viết gần đây</h2>
					</div>

					<div class="row">
					@foreach ($top3BaiViet as $bv)
						<div class="col-md-4">
							<article class="column" data-aos="fade-up">
								<figure>
									<a href="#" class="image-hvr-effect">
									<img src="{{ asset($bv->anhBia ?? 'images/default.jpg') }}" alt="post" class="post-image">
									</a>
								</figure>
								<div class="post-item">
									<div class="meta-date">{{ \Carbon\Carbon::parse($bv->created_at)->format('M d, Y') }}</div>
									<h3>
									<a href="{{ route('baiviet.show', $bv->slug) }}">
										{{ \Str::limit(strip_tags($bv->tieuDe), 50) }}
									</a>
									</h3>

									<div class="links-element">
										<div class="categories">{{ $bv->nguoiDung->tenND ?? 'Ẩn danh' }}</div>
										<div class="social-links">
											<ul>
												<li><a href="#"><i class="icon icon-facebook"></i></a></li>
												<li><a href="#"><i class="icon icon-twitter"></i></a></li>
												<li><a href="#"><i class="icon icon-behance-square"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</article>
						</div>
						@endforeach

						

					</div>


					<div class="row">

						<div class="btn-wrap align-center">
						<a href="{{ route('baiviet.index') }}" class="btn btn-outline-accent btn-accent-arrow" tabindex="0">
						Xem tất cả bài viết<i class="icon icon-ns-arrow-right"></i></a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>


	<section id="best-selling" class="leaf-pattern-overlay">
		<div class="corner-pattern-overlay"></div>
		<div class="container">
			<div class="row justify-content-center">

				<div class="col-md-8">

					<div class="row">

						<div class="col-md-6">
							<figure class="products-thumb">
								<img src="{{ asset('images/booknest.jpg')  }}" alt="book" class="single-image">
							</figure>
						</div>

						<div class="col-md-6">
							<div class="product-entry">
								<h2 class="section-title divider">Về BookNest</h2>

								<div class="products-content">
									<div class="author-name">By BookNest</div>
									<h3 class="item-title">Nơi những trang sách tìm về tổ ấm.</h3>
									<p>Booknest là không gian của những người yêu sách chân thành.
Tại đây, mỗi cuốn sách không chỉ là món quà tri thức mà còn là nhịp cầu kết nối tâm hồn, cảm xúc và câu chuyện đời thường. Chúng tôi chọn lọc kỹ lưỡng từng tựa sách, nâng niu từng bìa sách như nâng niu một người bạn đồng hành.
Dù bạn là người mê văn học, say mê triết lý hay đang kiếm tìm một chút dịu dàng giữa dòng đời – Booknest luôn có một góc dành riêng cho bạn.</p>
									<div class="btn-wrap">
										<a href="#" class="btn-accent-arrow">Xem thêm <i
												class="icon icon-ns-arrow-right"></i></a>
									</div>
								</div>

							</div>
						</div>

					</div>
					<!-- / row -->

				</div>

			</div>
		</div>
	</section>

	<section id="subscribe">
		<div class="container">
			<div class="row justify-content-center">

				<div class="col-md-8">
					<div class="row">

						<div class="col-md-6">

							<div class="title-element">
								<h2 class="section-title divider">Nhận thông tin khuyến mãi từ chúng tôi</h2>
							</div>

						</div>
						<div class="col-md-6">

							<div class="subscribe-content" data-aos="fade-up">
								<p>Sed eu feugiat amet, libero ipsum enim pharetra hac dolor sit amet, consectetur. Elit
									adipiscing enim pharetra hac.</p>
								<form id="form">
									<input type="text" name="email" placeholder="Nhận email ưu đãi">
									<button class="btn-subscribe">
										<span>Đăng ký</span>
										<i class="icon icon-send"></i>
									</button>
								</form>
							</div>

						</div>

					</div>
				</div>

			</div>
		</div>
	</section>

	



	
@include( 'footer');
@include('components.chat-bubble')


	<!-- JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-7+Q2j6g4v
	

</body>

</html>