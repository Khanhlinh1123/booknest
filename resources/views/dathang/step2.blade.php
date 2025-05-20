@include('header');
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="bg-white shadow-sm rounded p-4">
                <h4 class="text-brown fw-bold mb-4">📦 Xác nhận đơn hàng</h4>

                <form id="payment-form" method="POST">
    @csrf

    <div class="mb-4">
        <h6 class="fw-bold mb-2">📇 Thông tin giao hàng</h6>
        <p><strong>Họ tên:</strong> {{ $thongTin['ten'] }}</p>
        <p><strong>Điện thoại:</strong> {{ $thongTin['soDT'] }}</p>
        <p><strong>Địa chỉ:</strong> {{ $thongTin['diaChiFull'] }}</p>
    </div>

            <div class="mb-3">
            <label class="fw-bold">Phương thức thanh toán</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pttt" id="cod" value="cod" checked>
                <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pttt" id="bank" value="bank">
                <label class="form-check-label" for="bank">Chuyển khoản ngân hàng (VNPAY)</label>
            </div>
        </div>


        <div class="mb-4">
            <h6 class="fw-bold mb-2">🧾 Chi tiết thanh toán</h6>
            <p><strong>Tiền hàng:</strong> {{ number_format($tongTienHang) }}₫</p>
            <p><strong>Phí vận chuyển:</strong> {{ number_format($phiShip) }}₫</p>
            <p class="text-danger fw-bold fs-5"><strong>Tổng cộng:</strong> {{ number_format($tongTien) }}₫</p>
        </div>

    <input type="hidden" name="tongTien" value="{{ $tongTien }}">


        {{-- truyền tổng tiền nếu dùng VNPAY --}}
        <input type="hidden" name="tongTien" value="{{ $tongTien }}">

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
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('payment-form');
    const codInput = document.getElementById('cod');
    const bankInput = document.getElementById('bank');

    form.addEventListener('submit', function (e) {
        if (bankInput.checked) {
            e.preventDefault();
            const tongTien = form.querySelector('input[name="tongTien"]').value;
            // Chuyển hướng GET kèm tham số tongTien
            window.location.href = "{{ route('vnpay.create') }}" + "?tongTien=" + tongTien;
        } else {
            form.method = 'POST';
            form.action = "{{ route('dathang.step2.post') }}";
            // Cho phép form submit POST bình thường
        }
    });
});

</script>
