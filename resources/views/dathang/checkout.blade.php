@include('header')

<div class="container py-5">
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

    <div class="row g-4">
      <!-- Cột trái: Thông tin giao hàng -->
      <div class="col-lg-6">
        <div class="p-4 bg-white shadow-sm rounded">
          <h4 class="fw-bold mb-4">THÔNG TIN GIAO HÀNG</h4>

          <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="ten" class="form-control" required
                   value="{{ old('ten', Auth::user()->tenND ?? '') }}">
          </div>

          <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="soDT" class="form-control" required
                   value="{{ old('soDT', Auth::user()->soDT ?? '') }}">
          </div>

          <div class="mb-3">
            <label class="form-label">Địa chỉ cụ thể</label>
            <textarea name="diaChi" class="form-control" required>{{ old('diaChi', Auth::user()->diaChi ?? '') }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Tỉnh / Thành phố</label>
            <select name="tinh" id="tinh" class="form-select" required data-old="{{ old('tinh') }}">
              <option value="">-- Chọn tỉnh/thành --</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Quận / Huyện</label>
            <select name="huyen" id="huyen" class="form-select" required data-old="{{ old('huyen') }}">
              <option value="">-- Chọn quận/huyện --</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Phường / Xã</label>
            <select name="xa" id="xa" class="form-select" required data-old="{{ old('xa') }}">
              <option value="">-- Chọn phường/xã --</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Cột phải: Thanh toán + Tổng tiền -->
      <div class="col-lg-6">
        <!-- Card 1: Phương thức thanh toán -->
        <div class="p-4 bg-white shadow-sm rounded mb-4">
          <h4 class="fw-bold mb-4">PHƯƠNG THỨC THANH TOÁN</h4>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="pttt" value="cod" checked>
            <label class="form-check-label">Thanh toán khi nhận hàng (COD)</label>
          </div>
          <!-- <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="pttt" value="vnpay">
            <label class="form-check-label">VNPAY</label>
          </div> -->
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="pttt" value="momo">
            <label class="form-check-label">MoMo</label>
          </div>
        </div>

        <!-- Card 2: Tính tiền -->
        <div class="p-4 bg-white shadow-sm rounded">
          <h4 class="fw-bold mb-3">TÓM TẮT ĐƠN HÀNG</h4>
          <p class="mb-1"><strong>Tiền hàng:</strong> {{ number_format($tongTienHang) }}₫</p>
          <p class="mb-1"><strong>Phí vận chuyển:</strong> {{ number_format($phiShip) }}₫</p>
          <p class="text-danger fs-5 fw-bold">Tổng thanh toán: {{ number_format($tongTien) }}₫</p>
          <input type="hidden" name="tongTien" value="{{ $tongTien }}">
        </div>
        <!-- Nút xác nhận -->
    <div class="text-end mt-4">
      <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">Xác nhận đặt hàng</button>
    </div>
      </div>
    </div>

    
  </form>
</div>

<!-- Script xử lý địa chỉ -->
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

          fetch('/js/vn-location/xa_phuong.json').then(res => res.json()).then(xaData => {
            xa.innerHTML = '<option value="">-- Chọn xã/phường --</option>';
            Object.values(xaData).filter(x => x.parent_code == oldHuyen).forEach(x => {
              const opt = document.createElement('option');
              opt.value = x.code;
              opt.textContent = x.name;
              xa.appendChild(opt);
            });

            if (oldXa) xa.value = oldXa;
          });
        }
      });
    }
  });
});
</script>
