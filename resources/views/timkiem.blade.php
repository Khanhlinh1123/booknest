@include('header')

<style>
    @media (min-width: 768px) {
        .col-5ths {
            flex: 0 0 auto;
            width: 20%;
        }
    }
    .product-style {
    height: 300px;
    overflow: hidden;
}
</style>

<div class="container mt-4">
    <h4 class="mb-4">Kết quả tìm kiếm: "{{ $keyword }}"</h4>
    <div class="row justify-content-start gx-4 gy-4">
        @foreach ($sachs as $sach)
            <div class="col-5ths">
                <div class="product-item">
                    <figure class="product-style">
                        <a href="{{ route('sach.show', $sach->slug) }}">
                        <img src="{{ asset('images/sach/' . $sach->hinhanh) }}" alt="{{ $sach->tenSach }}" class="product-item" style="width: 100%; height: 350px; object-fit: cover;">
                        </a>
                        <form action="{{ route('giohang.them') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="maSach" value="{{ $sach->maSach }}">
                            <input type="hidden" name="soLuong" value="1">
                            <button type="submit" class="add-to-cart" data-product-tile="add-to-cart">Thêm vào giỏ</button>
                        </form>
                    </figure>
                    <figcaption>
                        <a href="{{ route('sach.show', $sach->slug) }}">
                        <h3>{{ $sach->tenSach }}</h3>
                        </a>
                        <span>{{ $sach->tacGia->tenTG ?? 'Không rõ' }}</span>
                        <div class="item-price">
                            @if($sach->giaDaGiam < $sach->giaGoc)
                                <span class="prev-price">{{ number_format($sach->giaGoc) }}₫</span>
                                &nbsp;
                                <span>{{ number_format($sach->giaDaGiam) }}₫</span>
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
