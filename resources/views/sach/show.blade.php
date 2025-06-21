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
                {{-- Hiển thị giá tiền --}}
<div class="mb-3">
    @if($sach->giaDaGiam < $sach->giaGoc)
        <div>
            <span class="text-muted text-decoration-line-through me-2" style="font-size: 18px;">
                {{ number_format($sach->giaGoc) }}₫
            </span>
            <span class="text-danger fw-bold" style="font-size: 22px;">
                {{ number_format($sach->giaDaGiam) }}₫
            </span>
        </div>
    @else
        <div>
            <span class="fw-bold text-dark" style="font-size: 22px;">
                {{ number_format($sach->giaGoc) }}₫
            </span>
        </div>
    @endif
</div>


                {{-- Số lượng dùng chung --}}
                <div class="d-flex align-items-center">
                    <label for="soLuongInput" class="form-label mb-0 me-2" style="min-width: 80px;">Số lượng:</label>
                    <div class="d-flex align-items-center gap-1">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="thayDoiSoLuong(-1)">−</button>
                        <input type="number" id="soLuongInput" class="form-control text-center" value="1" min="1" max="{{ $sach->soLuong }}" style="width: 60px;">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="thayDoiSoLuong(1)">+</button>
                    </div>
                </div>
                <br>
                <div class="d-flex flex-wrap gap-2 align-items-end mt-3">
                    {{-- Nút Thêm vào giỏ --}}
                    <form method="POST" action="{{ route('giohang.them') }}" class="d-inline">
                        @csrf
                        <input type="hidden" name="maSach" value="{{ $sach->maSach }}">
                        <input type="hidden" name="soLuong" id="soLuongHidden" value="1">
                        <button type="submit" class="btn btn-outline-brown rounded-pill px-4">
                            <i class="fa fa-shopping-cart me-2"></i> Thêm vào giỏ
                        </button>
                    </form>

                    {{-- Nút Mua ngay --}}
                    <form method="GET" action="{{ route('checkout') }}" onsubmit="return ganSoLuongMuaNgay()" class="d-inline">
                        <input type="hidden" name="chonSach[]" value="{{ $sach->maSach }}">
                        <input type="hidden" name="soLuong" id="soLuongMuaNgayInput" value="1">
                        <button type="submit" class="btn btn-danger rounded-pill px-4">Mua ngay</button>
                    </form>

                </div>

            </div>

            <!-- Thông tin cơ bản -->
            <div class="book-specs rounded shadow-sm bg-white p-4 mt-5">
                <h3 class="fw-bold mb-3">Thông tin chi tiết</h3>
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
            

            <div class="product-description-box bg-white p-4 rounded-4 shadow-sm mt-5 border">
                <h3 class="fw-bold mb-3">Mô tả sản phẩm</h3>

                <div id="moTaContainer" class="description-collapsed">
                    <div class="text-justify text-muted lh-lg" style="font-size: 1rem;">
                        {!! nl2br(e($sach->mieuta)) !!}
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button class="btn btn-link text-decoration-none" onclick="toggleMoTa()" id="moTaToggle">Xem thêm ▼</button>
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

<div class="container my-5">
    <div class="rounded shadow-sm p-4 bg-white d-flex flex-column flex-md-row justify-content-between align-items-center review-summary-box">
        <!-- Điểm trung bình -->
        <div class="text-center mb-4 mb-md-0" style="min-width: 200px;">
            <div class="fs-1 fw-bold text-dark">{{ number_format($trungBinhSao, 1) }}<span class="fs-4">/5</span></div>
            <div class="text-warning fs-5">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fa{{ $i <= $trungBinhSao ? 's' : 'r' }} fa-star"></i>
                @endfor
            </div>
            <div class="text-muted mt-1">({{ $soDanhGia }} đánh giá)</div>
        </div>  
        <!-- Sao -->
        <div class="flex-grow-1 px-md-5 w-100">
            @for ($i = 5; $i >= 1; $i--)
                @php
                    $count = $sach->danhGias()->where('soSao', $i)->count();
                    $percent = $soDanhGia > 0 ? round($count / $soDanhGia * 100) : 0;
                @endphp
                <div class="d-flex align-items-center mb-2">
                    <div class="text-muted me-2" style="width: 50px;">{{ $i }} sao</div>
                    <div class="progress flex-grow-1" style="height: 8px; background-color: #f1f1f1;">
                        <div class="progress-bar bg-warning" style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="ms-2" style="width: 40px;">{{ $percent }}%</div>
                </div>
            @endfor
        </div>

        <!-- Nút -->
        <div class="text-center mt-3 mt-md-0">
            <a href="#" class="btn btn-outline-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#reviewModal">
                <i class="fa fa-pencil"></i> Viết đánh giá
            </a>
        </div>
    </div>
</div>
<div class="container mt-4" id="user-reviews">
    <h4 class="mb-4 ">ĐÁNH GIÁ TỪ NGƯỜI DÙNG</h4>

    @php
        $visibleCount = 3;
    @endphp

    <div class="row">
        {{-- Đánh giá hiển thị --}}
        @foreach($danhgias->take($visibleCount) as $dg)
            <div class="col-12 mb-3">
                <div class="p-3 rounded border bg-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong class="text-dark">{{ $dg->nguoiDung->tenND ?? 'Ẩn danh' }}</strong>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($dg->created_at)->format('d/m/Y') }}</small>
                    </div>
                    <div class="text-warning mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $dg->soSao)
                                <i class="fa fa-star"></i>
                            @else
                                <i class="fa fa-star-o"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="text-muted lh-base" style="font-size: 15px;">
                        {{ $dg->nhanXet }}
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Phần ẩn --}}
        <div id="hidden-reviews" style="display: none;">
            @foreach($danhgias->skip($visibleCount) as $dg)
                <div class="col-12 mb-3">
                    <div class="p-3 rounded border bg-white shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-dark">{{ $dg->nguoiDung->tenND ?? 'Ẩn danh' }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($dg->created_at)->format('d/m/Y') }}</small>
                        </div>
                        <div class="text-warning mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $dg->soSao)
                                    <i class="fa fa-star"></i>
                                @else
                                    <i class="fa fa-star-o"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="text-muted lh-base" style="font-size: 15px;">
                            {{ $dg->nhanXet }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Nút xem thêm --}}
    @if($danhgias->count() > $visibleCount)
        <div class="text-center mt-3">
            <button class="btn btn-outline-secondary" onclick="document.getElementById('hidden-reviews').style.display='block'; this.remove();">
                Xem thêm đánh giá
            </button>
        </div>
    @endif
</div>



<!-- Modal đánh giá -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4 rounded-3">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Viết đánh giá sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" action="{{ route('danhgia.submit') }}">
        @csrf
        <div class="modal-body">

          <!-- Ngôi sao -->
          <div class="text-center mb-4">
    <label class="form-label fw-bold mb-2">Chọn số sao:</label><br>
    <div class="rating-stars d-inline-flex flex-row-reverse justify-content-center" style="font-size: 32px;">
        @for ($i = 5; $i >= 1; $i--)
            <input type="radio" name="soSao" id="star{{ $i }}" value="{{ $i }}" class="d-none">
            <label for="star{{ $i }}" class="star-label">
                <i class="fa fa-star"></i>
            </label>
        @endfor
    </div>
</div>


          <!-- Textarea -->
          <div class="mb-2">
            <label class="form-label fw-bold">Nhận xét</label>
            <textarea name="nhanXet" id="nhanXet" class="form-control" rows="4" minlength="100"
                      placeholder="Hãy chia sẻ cảm nhận chi tiết của bạn..." required></textarea>
            <div class="form-text text-end mt-1">
              <span id="charCount">0</span>/100 ký tự tối thiểu
            </div>
            <div class="text-danger mt-1 d-none" id="warning">Vui lòng nhập ít nhất 100 ký tự.</div>
          </div>

        </div>

        <!-- Footer -->
        <div class="modal-footer border-0 d-flex justify-content-end">
          <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-danger px-4">Gửi nhận xét</button>
        </div>

      </form>
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
					<h2 class="section-title">Sách cùng danh mục</h2>
				</div>

				<div class="product-list" data-aos="fade-up">
					<div class="row">

						@foreach($sachCDM as $sach)
						<div class="col-md-2-4">
							<div class="product-item">
								<figure class="product-style position-relative mb-2">
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
                                <img src="{{ asset('images/sach/' . $sach->hinhanh) }}" alt="{{ $sach->tenSach }}"
                                    class="img-fluid" style="height: 250px; object-fit: cover;">
                            </a>
                            <form action="{{ route('giohang.them') }}" method="POST" style="display: inline;">
										@csrf
										<input type="hidden" name="maSach" value="{{ $sach->maSach }}">
										<input type="hidden" name="soLuong" value="1">
										<button type="submit" class="add-to-cart" data-product-tile="add-to-cart">Thêm vào giỏ</button>
									</form>                        
                        </figure>
                        <figcaption>
                            <h6>
                                <a href="{{ route('sach.show', $sach->slug) }}" class="text-decoration-none text-dark" style="font-family: 'Times New Roman', Times, serif;">
                                    {{ $sach->tenSach }}
                                </a>
                            </h6>

                                    <span class="text-muted small">{{ $sach->tacGia->tenTG ?? 'Không rõ' }}</span>

                                    {{-- Giá --}}
                                    <div class="mt-1">
                                        <span class="fw-bold text-danger" style="font-size: 17px;">
                                            {{ number_format($sach->giaDaGiam) }}₫
                                        </span>
                                        @if($sach->giaDaGiam < $sach->giaGoc)
                                            <span class="text-muted text-decoration-line-through ms-2">
                                                {{ number_format($sach->giaGoc) }}₫
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Đánh giá + đã bán --}}
                                    @php
                                        $soDG = $sach->danhGias()->count();
                                        $tbSao = round($sach->danhGias()->avg('soSao'), 1);
                                        $full = floor($tbSao);
                                        $empty = 5 - $full;
                                    @endphp

                                        <div class="mt-1" style="font-size: 14px; color: #555;">
                                            @if($soDG > 0)
                                                <span>
                                                    @for($i = 0; $i < $full; $i++)
                                                        <span style="color: #ffc107;">★</span>
                                                    @endfor
                                                    @for($i = 0; $i < $empty; $i++)
                                                        <span style="color: #ccc;">★</span>
                                                    @endfor
                                                </span>
                                                <span class="ms-1 text-muted">({{ $soDG }})</span>
                                            @endif

                                            <span class="ms-2 text-muted">| Đã bán {{ number_format($sach->soLuongDaBan) }}</span>
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
<script>
    function ganSoLuongMuaNgay() {
        const slDaChon = document.getElementById('soLuongInput').value;
        document.getElementById('soLuongMuaNgayInput').value = slDaChon;
        return true; // Cho phép submit tiếp tục
    }
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('nhanXet');
    const countSpan = document.getElementById('charCount');
    const warning = document.getElementById('warning');

    textarea.addEventListener('input', function () {
      const length = textarea.value.length;
      countSpan.textContent = length;

      if (length < 100) {
        warning.classList.remove('d-none');
      } else {
        warning.classList.add('d-none');
      }
    });
  });
</script>
<style>
    .rating-stars .fa-star {
        color: #ccc;
        transition: color 0.2s;
        cursor: pointer;
    }

    .rating-stars:hover label:hover ~ label .fa-star,
    .rating-stars:hover label:hover .fa-star {
        color: #FFD700 !important; /* Màu tím hover */
    }

    .rating-stars input[type="radio"]:checked ~ label .fa-star {
        color: #FFD700; /* Màu tím khi chọn */
    }

    .rating-stars input[type="radio"]:checked ~ label ~ label .fa-star {
        color: #FFD700;
    }
</style>

<style>
.description-collapsed {
    max-height: 240px;
    overflow: hidden;
    mask-image: linear-gradient(to bottom, black 70%, transparent);
    -webkit-mask-image: linear-gradient(to bottom, black 70%, transparent);
    transition: all 0.4s ease;
}
.description-expanded {
    max-height: none;
    mask-image: none;
    -webkit-mask-image: none;
}
.text-justify {
    text-align: justify;
}
.text-brown {
    color: #6e4d2e;
}
.review-summary-box {
    border-radius: 12px;
    background-color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
</style>
@include('footer');
