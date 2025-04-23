
<div class="container">
    <h2>Giỏ hàng của bạn</h2>
    @forelse ($items as $item)
        <div class="row mb-3 border-bottom pb-2">
            <div class="col-md-2">
                <img src="{{ asset('images/sach/' . $item['sach']->hinhanh) }}" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h5>{{ $item['sach']->tenSach }}</h5>
                <p>Tác giả: {{ $item['sach']->tacGia->tenTG ?? 'Không rõ' }}</p>
                <p>Giá: {{ number_format($item['sach']->giaDaGiam) }}₫</p>
            </div>
            <div class="col-md-2">
                <p>Số lượng: {{ $item['soLuong'] }}</p>
            </div>
        </div>
    @empty
        <p>Giỏ hàng đang trống.</p>
    @endforelse
</div>
