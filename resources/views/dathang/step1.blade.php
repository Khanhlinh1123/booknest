@include('header');
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-white shadow-sm rounded p-4">
                <h4 class="mb-4 text-brown fw-bold">Thông tin giao hàng</h4>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('dathang.step1.post') }}">
                    @csrf
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif


                    <div class="mb-3">
                        <label for="ten" class="form-label fw-semibold">Họ và tên</label>
                        <input type="text" name="ten" id="tenND" class="form-control" required value="{{ old('ten', Auth::user()->tenND ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="soDT" class="form-label fw-semibold">Số điện thoại</label>
                        <input type="text" name="soDT" id="soDT" class="form-control" required value="{{ old('soDT', Auth::user()->soDT ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="diaChi" class="form-label fw-semibold">Địa chỉ nhận hàng</label>
                        <textarea name="diaChi" id="diaChi" rows="3" class="form-control" required>{{ old('diaChi', Auth::user()->diaChi ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Tỉnh / Thành phố</label>
                        <select id="tinh" name="tinh" class="form-select" required>
                            <option value="">-- Chọn tỉnh --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Quận / Huyện</label>
                        <select id="huyen" name="huyen" class="form-select" required>
                            <option value="">-- Chọn huyện --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Phường / Xã</label>
                        <select id="xa" name="xa" class="form-select" required>
                            <option value="">-- Chọn xã --</option>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-brown rounded-pill px-4">Tiếp tục</button>
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
{{-- Gắn script --}}
<script src="{{ asset('js/vn-location/vn-location-select.js') }}"></script>
