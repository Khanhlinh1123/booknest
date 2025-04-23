@include('header')

    <style>
          .category-list {
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 0;
                background-color: #fff;
                overflow: hidden;
            }

            .category-title {
                background-color: #a47148; 
                color: white;
                padding: 10px 12px;
                font-size: 15px;
                margin: 0;
                font-weight: bold;
                border-bottom: 1px solid #ccc;
            }

            .category-list ul {
                padding: 10px 12px;
                margin: 0;
            }

            .category-list li {
                margin-bottom: 4px;
            }

            .category-list a {
                display: block;
                padding: 4px 8px;
                font-size: 14px;
                color: #333;
                text-decoration: none;
                border-radius: 4px;
            }

            .category-list a:hover {
                background-color: #f5f5f5;
            }

            .category-list a.active {
                font-weight: bold;
                color: #a47148;
            }
            .filter-box {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px 12px;
    background-color: #fff;
    margin-bottom: 16px;
}

.filter-title {
    background-color: #a47148; 
    color: white;
    padding: 6px 10px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 5px;
    margin-bottom: 10px;
}

.filter-box ul li {
    margin-bottom: 6px;
}

.filter-box ul li a {
    font-size: 13px;
    color: #333;
    text-decoration: none;
    display: block;
    padding: 4px 6px;
    border-radius: 4px;
}

.filter-box ul li a:hover {
    background-color: #f2f2f2;
    color: #a47148;
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
                <h6 class="filter-title">Tác giả</h6>
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
        <div class="col-md-8">
            <h2 class="mb-4">Sách thuộc danh mục: {{ $danhmuc->tenDM }}</h2>
            <div class="row">
            @forelse($sachs as $sach)
                <div class="col-md-4 mb-4">
                    <div class="product-item border rounded p-2 h-100">
                        <figure class="product-style mb-2">
                            <a href="{{ route('sach.show', $sach->maSach) }}">
                                <img src="{{ asset('images/sach/' . $sach->hinhanh) }}" alt="{{ $sach->tenSach }}"
                                    class="img-fluid" style="height: 250px; object-fit: cover;">
                            </a>
                            <button type="button" class="add-to-cart mt-2 btn btn-outline-dark btn-sm w-100">Thêm vào giỏ</button>
                        </figure>
                        <figcaption>
                            <h6>
                                <a href="{{ route('sach.show', $sach->maSach) }}" class="text-decoration-none text-dark">
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
    </div>
</div>

<script>
    document.querySelectorAll('#filterForm input[type=checkbox]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });
    });
</script>



