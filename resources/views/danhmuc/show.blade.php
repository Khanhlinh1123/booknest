@include('header')
<div class="banner-container mb-4">
    <img src="{{ asset('images/banner1.jpg') }}" alt="Banner Sách Mới" class="img-fluid w-100" style="max-height: 300px; object-fit: cover;">
</div>
<style>
    .sort-bar a {
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .sort-bar a:hover {
        background-color: #a47148;
        color: #fff !important;
        border-color: #a47148;
    }

    .product-item {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        transition: 0.3s;
        
    }

    .product-item:hover {
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        transform: translateY(-4px);
    }

    .product-style img {
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .add-to-cart {
        background-color: #a47148;
        border: none;
        padding: 6px 10px;
        font-size: 13px;
        color: white;
        border-radius: 5px;
        margin-top: 5px;
    }

    .add-to-cart:hover {
        background-color: #8d5c3c;
    }
    .filter-box {
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.filter-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
    font-family: 'Times New Roman', Times, serif;
    
}

</style>


<div class="container my-5">
    <div class="row">
        <!-- DANH MỤC -->
        <div class="col-md-2">
        <div class="category-list shadow-sm">
            <h5 class="category-title">Danh mục sách</h5>
            <ul class="list-unstyled mb-0">
                @foreach ($danhmucs as $dm)
                    <li>
                        <a href="{{ url('/danh-muc/' . $dm->maDM) }}" 
                           class="{{ $dm->maDM == $danhmuc->maDM ? 'active' : '' }}">
                            {{ $dm->tenDM }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <br>
        <!-- Lọc theo khoảng giá -->
        <form id="filterForm" method="GET" action="{{ route('danhmuc.show', $danhmuc->maDM) }}">
        
            <div class="filter-box">
                <h6 class="filter-title">Khoảng giá</h6>
                @foreach($priceRanges as $range)
                    <div class="form-check">
                        <input type="checkbox" name="price[]" value="{{ $range['value'] }}" class="form-check-input" {{ in_array($range['value'], request()->get('price', [])) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $range['label'] }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Lọc theo tác giả -->
            <div class="filter-box mt-3">
                <h6 class="filter-title" >Tác giả</h6>
                @foreach($authors as $author)
                    <div class="form-check">
                        <input type="checkbox" name="author[]" value="{{ $author }}" class="form-check-input" {{ in_array($author, request()->get('author', [])) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $author }}</label>
                    </div>
                @endforeach
            </div>
</form>


        
    </div>
    <div class="col-md-1">
    </div>
        <!-- SẢN PHẨM  -->
        <div class="col-md-9">
            <h2 class="mb-4" style="font-family: 'Times New Roman', Times, serif;">Sách thuộc danh mục: {{ $danhmuc->tenDM }}</h2>
            <div class="sort-bar mb-4 d-flex flex-wrap align-items-center gap-2">
                <span class="me-2 fw-semibold">Sắp xếp theo:</span>
                @php
                $sortOptions = [
                    'default' => 'Mặc định',
                    'newest' => 'Sách mới',
                    'price_asc' => 'Giá thấp - cao',
                    'price_desc' => 'Giá cao - thấp',
                ];
                $currentSort = request()->query('sort', 'default'); // lấy từ URL
            @endphp

            @foreach ($sortOptions as $key => $label)
                <a href="{{ request()->fullUrlWithQuery(['sort' => $key]) }}"
                class="btn btn-sm {{ $currentSort === $key ? 'btn-dark text-white' : 'btn-outline-secondary' }}">
                    {{ $label }}
                </a>
            @endforeach


</div>

            <div class="row">
            @forelse($sachs as $sach)
                <div class="col-md-3 mb-4">
                    <div class="product-item border rounded p-2 h-100">
                        <figure class="product-style mb-2">
                            <a href="{{ route('sach.show', $sach->slug) }}">
                                <img src="{{ asset('images/sach/' . $sach->hinhanh) }}" alt="{{ $sach->tenSach }}"
                                    class="img-fluid" style="height: 250px; object-fit: cover;">
                            </a>
                            <form action="{{ route('giohang.them') }}" method="POST" style="display: inline;">
										@csrf
										<input type="hidden" name="maSach" value="{{ $sach->maSach }}">
										<input type="hidden" name="soLuong" value="1">
										<button type="submit" class="add-to-cart" data-product-tile="add-to-cart">Thêm vào giỏ</button>
									</form>                        </figure>
                        <figcaption>
                            <h6>
                                <a href="{{ route('sach.show', $sach->slug) }}" class="text-decoration-none text-dark" style="font-family: 'Times New Roman', Times, serif;">
                                    {{ $sach->tenSach }}
                                </a>
                            </h6>
                            <span class="text-muted">{{ $sach->tacGia->tenTG ?? 'Không rõ' }}</span>
                            <div class="item-price mt-1">
                                @if($sach->giaDaGiam < $sach->giaGoc)
                                    <span class="text-decoration-line-through text-danger me-2">{{ number_format($sach->giaGoc) }}₫</span>
                                    <span class="fw-bold text-success">{{ number_format($sach->giaDaGiam) }}₫</span>
                                @else
                                    <span class="fw-bold">{{ number_format($sach->giaGoc) }}₫</span>
                                @endif
                            </div>
                        </figcaption>
                    </div>
                </div>
            @empty
                <p>Không có sách trong danh mục này.</p>
            @endforelse

            </div>
        </div>
        <div class="d-flex justify-content-center">
    {{ $sachs->links() }}
</div>
    </div>
</div>

<script>
    document.querySelectorAll('#filterForm input[type=checkbox]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });
    });
</script>



