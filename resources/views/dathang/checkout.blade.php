@include('header')
<div class="container my-5">
    <form method="POST" action="{{ route('checkout.post') }}">
        @csrf
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="row">
            <div class="col-md-6">
                <h5 class="fw-bold text-brown mb-3">📇 Thông tin giao hàng</h5>

                <div class="mb-3">
                    <label>Họ tên</label>
                    <input type="text" name="ten" value="{{ old('ten', Auth::user()->tenND ?? '') }}" required class="form-control">
                </div>

                <div class="mb-3">
                    <label>Số điện thoại</label>
                    <input type="text" name="soDT" value="{{ old('soDT', Auth::user()->soDT ?? '') }}" required class="form-control">
                </div>

                <div class="mb-3">
                    <label>Địa chỉ cụ thể</label>
                    <textarea name="diaChi" required class="form-control">{{ old('diaChi', Auth::user()->diaChi ?? '') }}</textarea>
                </div>
                <select name="tinh" id="tinh" class="form-select" required data-old="{{ old('tinh') }}">
    @if(old('tinh'))
        <option value="{{ old('tinh') }}" selected>Đang tải...</option>
    @else
        <option value="">-- Chọn tỉnh/thành --</option>
    @endif
</select>

<select name="huyen" id="huyen" class="form-select" required data-old="{{ old('huyen') }}">
    @if(old('huyen'))
        <option value="{{ old('huyen') }}" selected>Đang tải...</option>
    @else
        <option value="">-- Chọn quận/huyện --</option>
    @endif
</select>

<select name="xa" id="xa" class="form-select" required data-old="{{ old('xa') }}">
    @if(old('xa'))
        <option value="{{ old('xa') }}" selected>Đang tải...</option>
    @else
        <option value="">-- Chọn phường/xã --</option>
    @endif
</select>



            </div>

            <div class="col-md-6">
                <h5 class="fw-bold text-brown mb-3">💰 Thanh toán</h5>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="pttt" value="cod" checked>
                        <label class="form-check-label">Thanh toán khi nhận hàng (COD)</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="pttt" value="vnpay">
                        <label class="form-check-label">VNPAY</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="pttt" value="momo">
                        <label class="form-check-label">MoMo</label>
                    </div>
                </div>

                <hr>
                <p><strong>Tiền hàng:</strong> {{ number_format($tongTienHang) }}₫</p>
                <p><strong>Phí vận chuyển:</strong> {{ number_format($phiShip) }}₫</p>
                <p class="text-danger fw-bold fs-5">Tổng: {{ number_format($tongTien) }}₫</p>

                <input type="hidden" name="tongTien" value="{{ $tongTien }}">

                <div class="text-end">
                    <button type="submit" class="btn btn-brown px-4 rounded-pill">XÁC NHẬN ĐẶT HÀNG</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('js/vn-location/vn-location-select.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tinh = document.getElementById('tinh');
    const huyen = document.getElementById('huyen');
    const xa = document.getElementById('xa');

    const oldTinh = tinh.dataset.old;
    const oldHuyen = huyen.dataset.old;
    const oldXa = xa.dataset.old;

    fetch('/js/vn-location/tinh_tp.json').then(res => res.json()).then(data => {
        Object.values(data).forEach(t => {
            const opt = document.createElement('option');
            opt.value = t.code;
            opt.textContent = t.name;
            tinh.appendChild(opt);
        });

        if (oldTinh) {
            tinh.value = oldTinh;
            tinh.dispatchEvent(new Event('change'));

            // Load huyện tiếp
            fetch('/js/vn-location/quan_huyen.json').then(res => res.json()).then(huyenData => {
                huyen.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
                Object.values(huyenData).filter(h => h.parent_code == oldTinh).forEach(h => {
                    const opt = document.createElement('option');
                    opt.value = h.code;
                    opt.textContent = h.name;
                    huyen.appendChild(opt);
                });

                if (oldHuyen) {
                    huyen.value = oldHuyen;
                    huyen.dispatchEvent(new Event('change'));

                    // Load xã tiếp
                    fetch('/js/vn-location/xa_phuong.json').then(res => res.json()).then(xaData => {
                        xa.innerHTML = '<option value="">-- Chọn xã/phường --</option>';
                        Object.values(xaData).filter(x => x.parent_code == oldHuyen).forEach(x => {
                            const opt = document.createElement('option');
                            opt.value = x.code;
                            opt.textContent = x.name;
                            xa.appendChild(opt);
                        });

                        if (oldXa) {
                            xa.value = oldXa;
                        }
                    });
                }
            });
        }
    });
});
</script>


