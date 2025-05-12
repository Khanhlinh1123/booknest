@include('header')

<div class="banner-container mb-4">
    <img src="{{ asset('images/banner1.jpg') }}" alt="Banner" class="img-fluid w-100" style="max-height: 300px; object-fit: cover;">
</div>

<div class="container my-5">
    <h2 class="mb-4">📚 Tác phẩm của tác giả: <strong>{{ $tacgia->tenTG }}</strong></h2>

    <section id="featured-books" class="py-3 my-3">
    <div class="row">
        @forelse($sachs as $sach)
            <div class="col-md-2 mb-4">
                <div class="product-item">
                    <figure class="product-style">
                        <a href="{{ route('sach.show', $sach->slug) }}">
                            <img src="{{ asset('images/sach/' . $sach->hinhanh) }}" alt="{{ $sach->tenSach }}" class="product-item" style="width: 100%; height: 250px; object-fit: cover;">
                        </a>
                        <form action="{{ route('giohang.them') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="maSach" value="{{ $sach->maSach }}">
                            <input type="hidden" name="soLuong" value="1">
                            <button type="submit" class="add-to-cart">Thêm vào giỏ</button>
                        </form>
                    </figure>
                    <figcaption>
                        <h6>
                            <a href="{{ route('sach.show', $sach->slug) }}" class="text-decoration-none text-dark">{{ $sach->tenSach }}</a>
                        </h6>
                        <div class="item-price">
                            @if($sach->giaDaGiam < $sach->giaGoc)
                                <span class="prev-price text-danger">{{ number_format($sach->giaGoc) }}₫</span>
                                <span>{{ number_format($sach->giaDaGiam) }}₫</span>
                            @else
                                {{ number_format($sach->giaGoc) }}₫
                            @endif
                        </div>
                    </figcaption>
                </div>
            </div>
        @empty
            <p>Không có sách nào.</p>
        @endforelse
    </div>

<div class="d-flex justify-content-center mt-4">
    {{ $sachs->links() }}
</div>

    </section>
</div>

<style>
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

    .prev-price {
        text-decoration: line-through;
        font-size: 14px;
    }

    .item-price {
        font-weight: bold;
        font-size: 15px;
        margin-top: 4px;
    }
</style>
