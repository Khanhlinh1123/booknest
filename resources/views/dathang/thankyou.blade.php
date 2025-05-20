@include('header')
<div class="container my-5 text-center">
    <h2 class="text-success fw-bold">🎉 Đặt hàng thành công!</h2>
    <p>Mã đơn hàng của bạn là <strong>#{{ $donHang->maDH }}</strong></p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Về trang chủ</a>
</div>