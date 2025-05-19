@include('header')
<div class="banner-container mb-4">
    <img src="{{ asset('images/banner1.jpg') }}" alt="Banner Sách Mới" class="img-fluid w-100" style="max-height: 300px; object-fit: cover;">
</div>
<style>
    .text-brown {
        color: #6e4d2e;
    }

    .btn-outline-brown {
        border: 2px solid #6e4d2e;
        color: #6e4d2e;
        background: transparent;
        transition: 0.3s;
    }

    .btn-outline-brown:hover {
        background-color: #6e4d2e;
        color: #fff;
    }

    .sticky-top {
        position: sticky;
        z-index: 1;
    }
    .quantity-input .btn {
    padding: 6px 12px;
    font-weight: bold;
}

.quantity-input input {
    padding: 6px;
    height: 38px;
}

</style>

</style>

<div class="container my-5">
    <div class="row">
        <!-- CỘT TRÁI: ẢNH SÁCH (Sticky) -->
        <div class="col-md-5">
            <div class="sticky-top" style="top: 100px;">
                <div class="card shadow-sm border-0 p-3">
                    <img src="{{ asset('images/sach/' . $sach->hinhanh) }}" alt="{{ $sach->tenSach }}" class="img-fluid rounded w-100">
                    <!-- (Có thể thêm slider phụ bên dưới nếu muốn) -->
                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: THÔNG TIN -->
        <div class="col-md-7 ps-md-5 mt-4 mt-md-0">
        <div class="book-highlight-box bg-white shadow-sm rounded p-4 mb-4">
                <div class="d-flex align-items-center mb-2">
                    <h2 class="mb-0 fw-bold">{{ $sach->tenSach }} <span class="text-muted fs-6">{{ $sach->tenSachPhu ?? '' }}</span></h2>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Nhà cung cấp:</strong> <span class="text-primary">{{ $sach->nhaCungCap ?? 'Đang cập nhật' }}</span></p>
                        <p class="mb-1"><strong>Nhà xuất bản:</strong> {{ $sach->nhaXuatBan->tenNXB ?? 'Không rõ' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Tác giả:</strong> {{ $sach->tacGia->tenTG ?? 'Không rõ' }}</p>
                        <p class="mb-1"><strong>Hình thức bìa:</strong> {{ $sach->loaiBia ?? 'Đang cập nhật' }}</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mt-2 mb-2">
                    @php
                        $soDanhGia = $sach->danhGias()->count();
                        $trungBinhSao = round($sach->danhGias()->avg('soSao'), 1);
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if($i <= floor($trungBinhSao))
                            <i class="fa fa-star text-warning"></i>
                        @elseif($i - $trungBinhSao < 1)
                            <i class="fa fa-star-half-o text-warning"></i>
                        @else
                            <i class="fa fa-star-o text-warning"></i>
                        @endif
                    @endfor
                    <span class="ms-2 text-muted">({{ $soDanhGia }} đánh giá)</span>
                    <span class="text-muted ms-3">Đã bán {{ $sach->soLuongDaBan ?? 0 }}</span>
                </div>
            </div>

            <!-- Thông tin cơ bản -->
            <div class="book-specs rounded shadow-sm bg-white p-4 mt-5">
                <h5 class="fw-bold mb-3">Thông tin chi tiết</h5>
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted">Tác giả</td>
                                <td>{{ $sach->tacGia->tenTG ?? 'Không rõ' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Nhà xuất bản</td>
                                <td>{{ $sach->nhaXuatBan->tenNXB ?? 'Không rõ' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Năm xuất bản</td>
                                <td>{{ $sach->namXB }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kích thước</td>
                                <td>{{ $sach->kichThuoc }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Số trang</td>
                                <td>{{ $sach->soTrang ?? 'Đang cập nhật' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Loại bìa</td>
                                <td>{{ $sach->loaiBia ?? 'Không rõ' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Phiên bản</td>
                                <td>{{ $sach->phienBan ?? 'Thông thường' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Công ty phát hành</td>
                                <td>{{ $sach->congTyPhatHanh ?? 'Đang cập nhật' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Ngày phát hành</td>
                                <td>{{ \Carbon\Carbon::parse($sach->ngayPhatHanh)->format('d/m/Y') ?? 'Không rõ' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Mua hàng -->
            <form method="POST">
                @csrf
                <input type="hidden" name="maSach" value="{{ $sach->maSach }}">
                <div class="d-flex align-items-center mb-4">
                    <label for="soLuongInput" class="form-label mb-0 me-3" style="min-width: 80px;">Số lượng:</label>
                    <div class="d-flex align-items-center gap-1">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="thayDoiSoLuong(-1)">−</button>
                        <input type="number" name="soLuong" id="soLuongInput" class="form-control text-center" value="1" min="1" max="{{ $sach->soLuong }}" style="width: 60px;">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="thayDoiSoLuong(1)">+</button>
                    </div>
                </div>



                <div class="d-flex gap-2">
                    <button type="submit" formaction="{{ route('giohang.them') }}" class="btn btn-outline-brown rounded-pill px-4">
                        <i class="fa fa-shopping-cart me-2"></i> Thêm vào giỏ
                    </button>
                    <button class="btn btn-danger rounded-pill px-4">Mua ngay</button>
                </div>
            </form>

            <div class="product-description-box bg-light p-4 rounded mt-4 shadow-sm">
                <h5 class="fw-bold mb-3">Mô tả sản phẩm</h5>
                <div id="moTaContainer" class="description-collapsed">
                    {!! nl2br(e($sach->mieuta)) !!}
                </div>
                <div class="text-end mt-2">
                    <a href="javascript:void(0)" onclick="toggleMoTa()" id="moTaToggle" class="text-primary">Xem thêm</a>
                </div>
            </div>

            <script>
                function toggleMoTa() {
                    const moTaContainer = document.getElementById('moTaContainer');
                    const moTaToggle = document.getElementById('moTaToggle');

                    if (moTaContainer.classList.contains('description-collapsed')) {
                        moTaContainer.classList.remove('description-collapsed');
                        moTaToggle.innerText = 'Thu gọn';
                    } else {
                        moTaContainer.classList.add('description-collapsed');
                        moTaToggle.innerText = 'Xem thêm';
                    }
                }
            </script>




        </div>
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
<script>
    function thayDoiSoLuong(thayDoi) {
        const input = document.getElementById('soLuongInput');
        let soLuong = parseInt(input.value);
        const min = parseInt(input.min);
        const max = parseInt(input.max);

        if (!isNaN(soLuong)) {
            soLuong += thayDoi;
            if (soLuong < min) soLuong = min;
            if (soLuong > max) soLuong = max;
            input.value = soLuong;
        }
    }

    function toggleMoTa() {
        const container = document.getElementById('moTaContainer');
        const toggleBtn = document.getElementById('moTaToggle');

        container.classList.toggle('description-expanded');
        container.classList.toggle('description-collapsed');

        toggleBtn.textContent = container.classList.contains('description-expanded') ? 'Thu gọn' : 'Xem thêm';
    }
</script>
<style>
.description-collapsed {
    max-height: 180px;
    overflow: hidden;
    position: relative;
    mask-image: linear-gradient(180deg, #000 60%, transparent);
    -webkit-mask-image: linear-gradient(180deg, #000 60%, transparent);
    transition: max-height 0.4s ease;
}
.description-expanded {
    max-height: none;
    mask-image: none;
    -webkit-mask-image: none;
}
</style>
