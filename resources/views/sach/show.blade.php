@include('header')

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

        <!-- Thông tin sách -->
        <div class="col-md-8">
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
                <input type="number" id="qty" name="qty" min="1" max="{{ $sach->soLuong }}" value="1" class="form-control w-25 d-inline-block me-3">

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

<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
