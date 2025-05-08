@include('header')
<div class="banner-container mb-4">
    <img src="{{ asset('images/banner1.jpg') }}" alt="Banner Sách Mới" class="img-fluid w-100" style="max-height: 300px; object-fit: cover;">
</div>
<style>
    .book-detail-page {
        padding: 40px 0;
        font-family: 'Segoe UI', sans-serif;
    }

    .book-title {
        font-size: 30px;
        font-weight: 700;
        color: #5a3e2b;
    }

    .book-meta p {
        margin-bottom: 6px;
        font-size: 15px;
        color: #555;
    }

    .book-price .original-price {
        text-decoration: line-through;
        color: #a1a1a1;
        font-size: 16px;
        margin-right: 10px;
    }

    .book-price .discount-price {
        font-size: 24px;
        font-weight: bold;
        color: #d35400;
    }

    .rating-stars i {
        color: #f39c12;
        font-size: 18px;
        margin-right: 2px;
    }

    .btn-add-to-cart, .btn-buy-now {
        background-color: #a47148;
        border: none;
        padding: 10px 20px;
        font-size: 15px;
        color: white;
        border-radius: 4px;
        margin-top: 20px;
        margin-right: 10px;
    }

    .btn-buy-now {
        background-color: #e74c3c;
    }

    .btn-add-to-cart:hover {
        background-color: #8b5e34;
    }

    .btn-buy-now:hover {
        background-color: #c0392b;
    }

    .book-description h4 {
        border-left: 4px solid #a47148;
        padding-left: 10px;
        color: #333;
        font-size: 20px;
        margin-top: 50px;
    }

    .book-description p {
        margin-top: 10px;
        font-size: 15px;
        color: #444;
        line-height: 1.7;
    }
</style>

<div class="container book-detail-page">
    <div class="row">
        <!-- Hình ảnh sách -->
        <div class="col-md-4">
            <img src="{{ asset('images/sach/' . $sach->hinhanh) }}" alt="{{ $sach->tenSach }}" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-1">
        </div>
        <!-- Thông tin sách -->
        <div class="col-md-7">
            <h2 class="book-title">{{ $sach->tenSach }}</h2>

            <div class="rating-stars mt-2 mb-2">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                <i class="fa fa-star-o"></i>
                <span class="text-muted">(3.5/5)</span>
            </div>

            <div class="book-meta">
                <p><strong>Đã bán:</strong> {{ $sach->soLuongDaBan }} quyển</p>
                <p><strong>Tác giả:</strong> {{ $sach->tacGia->tenTG ?? 'Không rõ' }}</p>
                <p><strong>Nhà xuất bản:</strong> {{ $sach->nhaXuatBan->tenNXB ?? 'Không rõ' }}</p>
                <p><strong>Năm xuất bản:</strong> {{ $sach->namXB }}</p>
                <p><strong>Kích thước:</strong> {{ $sach->kichThuoc }}</p>
                <p><strong>Số lượng còn:</strong> {{ $sach->soLuong }}</p>
            </div>

            <div class="book-price mt-3">
                @if($sach->giaDaGiam < $sach->giaGoc)
                    <span class="original-price">{{ number_format($sach->giaGoc) }}₫</span>
                    <span class="discount-price">{{ number_format($sach->giaDaGiam) }}₫</span>
                @else
                    <span class="discount-price">{{ number_format($sach->giaGoc) }}₫</span>
                @endif
            </div>

            <!-- Form mua hàng -->
            <form method="POST">
                @csrf
                <input type="hidden" name="maSach" value="{{ $sach->maSach }}">
                
                <label for="qty" class="me-2 mb-0">Số lượng:</label>
                <input type="number" id="qty" name="soLuong" min="1" max="{{ $sach->soLuong }}" value="1" class="form-control w-25 d-inline-block me-3">

                <!-- Thêm vào giỏ hàng -->
                <button 
                    class="btn btn-add-to-cart" 
                    type="submit" 
                    formaction="{{ route('giohang.them') }}"
                >
                    Thêm vào giỏ hàng
                </button>

                
            </form>

            <!-- Chia sẻ -->
            <div class="mt-3">
                <span class="me-2">Chia sẻ:</span>
                <a href="#" class="me-2"><i class="fa fa-facebook"></i></a>
                <a href="#" class="me-2"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
            </div>

        </div>
    </div>

    <!-- Mô tả -->
    <div class="book-description">
        <h4>Giới thiệu sách</h4>
        <p>{{ $sach->mieuta }}</p>
    </div>
</div>
<section id="featured-books" class="py-5 my-5">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<div class="section-header align-center">
					<div class="title">
						<span></span>
					</div>
					<h2 class="section-title">Sách cùng danh mục</h2>
				</div>

				<div class="product-list" data-aos="fade-up">
					<div class="row">

						@foreach($sachCDM as $sach)
						<div class="col-md-2-4">
							<div class="product-item">
								<figure class="product-style">
									<img src="{{ asset('images/sach/' . $sach->hinhanh) }}" alt="{{ $sach->tenSach }}" class="product-item" style="width: 100%; height: 350px; object-fit: cover;">
									<form action="{{ route('giohang.them') }}" method="POST" style="display: inline;">
										@csrf
										<input type="hidden" name="maSach" value="{{ $sach->maSach }}">
										<input type="hidden" name="soLuong" value="1">
										<button type="submit" class="add-to-cart" data-product-tile="add-to-cart">Thêm vào giỏ</button>
									</form>

								</figure>
								<figcaption>
									<h3>{{ $sach->tenSach }}</h3>
									<span>{{ $sach->tacGia->tenTG ?? 'Không rõ' }}</span>
									<div class="item-price">
										@if($sach->giaDaGiam < $sach->giaGoc)
										
									<span class="prev-price">{{ number_format($sach->giaGoc) }}₫</span>
											&nbsp;
											<span >{{ number_format($sach->giaDaGiam) }}₫</span>
										@else
											{{ number_format($sach->giaGoc) }}₫
										@endif
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
					<a href="#" class="btn-accent-arrow">Xem tất cả sách <i class="icon icon-ns-arrow-right"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
