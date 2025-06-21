@include('header')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row shadow p-4 bg-white rounded">

                <!-- Cột trái -->
                <div class="col-md-6 border-end">
                    <h2 class="mb-4 fw-bold text-center"><b>ĐĂNG NHẬP TÀI KHOẢN</b></h2>

                    @if (session('status'))
                        <div class="alert alert-success text-center">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="tenDangNhap" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control @error('tenDangNhap') is-invalid @enderror"
                                   name="tenDangNhap" id="tenDangNhap"
                                   value="{{ old('tenDangNhap') }}" required autofocus>
                            @error('tenDangNhap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="matKhau" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control @error('matKhau') is-invalid @enderror"
                                   name="matKhau" id="matKhau" required>
                            @error('matKhau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center mb-3">
                            <button type="submit"
                                    class="btn text-white fw-bold rounded-pill shadow-sm py-2 w-75"
                                    style="background-color: #7B3F00;">
                                Đăng nhập
                            </button>
                        </div>

                        <p class="text-center fw-semibold">Hoặc đăng nhập bằng</p>
                        <div class="d-grid mb-3">
                            <a href="{{ route('auth.google.redirect') }}"
                               class="btn fw-bold w-100 rounded-pill shadow-sm text-white"
                               style="background-color: #DB4437;">
                                <i class="fab fa-google me-2"></i>Đăng nhập bằng Google
                            </a>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                Bạn quên mật khẩu?
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Cột phải -->
                <div class="col-md-6 text-center">
                    <h2 class="fw-bold ">QUYỀN LỢI CỦA THÀNH VIÊN</h2>
                    <ul class="list-unstyled mt-3 text-muted text-start ms-4">
                        <li>🚀 Vận chuyển siêu tốc</li>
                        <li>📚 Sản phẩm đa dạng</li>
                        <li>🔁 Đổi trả dễ dàng</li>
                        <li>🎁 Tích điểm đổi quà</li>
                        <li>💸 Giảm giá cho lần mua tiếp theo lên đến 10%</li>
                    </ul>
                    <div class="d-grid mb-3" style="place-items: center;">
                        <a href="{{ route('register') }}"
                        class="btn text-white fw-bold rounded-pill shadow-sm py-2 w-75"
                        style="background-color: #7B3F00;height:60px; display: flex; align-items: center; justify-content: center;">
                            Đăng ký
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
