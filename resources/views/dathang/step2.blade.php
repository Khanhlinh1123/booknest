@include('header');
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="bg-white shadow-sm rounded p-4">
                <h4 class="text-brown fw-bold mb-4">📦 Xác nhận đơn hàng</h4>

                <div class="mb-4">
                    <h6 class="fw-bold mb-2">📇 Thông tin giao hàng</h6>
                    <p><strong>Họ tên:</strong> {{ $thongTin['ten'] }}</p>
                    <p><strong>Điện thoại:</strong> {{ $thongTin['soDT'] }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $thongTin['diaChiFull'] }}</p>
                </div>

                <div class="mb-3">
        <label class="fw-bold mb-2">Phương thức thanh toán</label><br>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="phuongThucGH" id="cod" value="cod" checked>
            <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="phuongThucGH" id="bank" value="bank">
            <label class="form-check-label" for="bank">Chuyển khoản ngân hàng</label>
        </div>
    </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-2">🧾 Tổng cộng</h6>
                    <p class="text-danger fw-bold fs-5">{{ number_format($tongTien) }}₫</p>
                </div>

                <form method="POST" action="{{ route('dathang.step2.post') }}">
                    @csrf
                    <div class="text-end">
                        <button type="submit" class="btn btn-brown px-4 rounded-pill">XÁC NHẬN ĐẶT HÀNG</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<style>
    .text-brown {
        color: #6e4d2e;
    }
    .btn-brown {
        background-color: #6e4d2e;
        color: white;
        border: none;
    }
    .btn-brown:hover {
        background-color: #543920;
    }
</style>
