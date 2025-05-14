@include('header')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row shadow p-4 bg-white rounded">

                <!-- Cột trái -->
                <div class="col-md-6 border-end">
                    <h2 class="mb-4 text-success fw-bold">ĐĂNG NHẬP TÀI KHOẢN</h2>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
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

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success fw-bold rounded-pill shadow-sm py-2">
                                Đăng nhập
                            </button>
                        </div>

                        <p class="text-center fw-semibold">Hoặc đăng nhập bằng</p>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="#" class="btn fw-bold w-50 me-2 rounded-pill shadow-sm text-white"
                               style="background-color: #3b5998;">
                                <i class="fab fa-facebook-f me-2"></i>Facebook
                            </a>
                            <a href="{{ route('auth.google.redirect') }}"
                               class="btn fw-bold w-50 ms-2 rounded-pill shadow-sm text-white"
                               style="background-color: #DB4437;">
                                <i class="fab fa-google me-2"></i>Google
                            </a>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                Bạn quên mật khẩu bấm vào đây
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Cột phải -->
                <div class="col-md-6">
                    <h2 class="fw-bold text-success">QUYỀN LỢI CỦA THÀNH VIÊN</h2>
                    <ul class="list-unstyled mt-3 text-muted">
                        <li>🚀 Vận chuyển siêu tốc</li>
                        <li>📚 Sản phẩm đa dạng</li>
                        <li>🔁 Đổi trả dễ dàng</li>
                        <li>🎁 Tích điểm đổi quà</li>
                        <li>💸 Giảm giá cho lần mua tiếp theo lên đến 10%</li>
                    </ul>
                    <div class="d-grid mt-4">
                        <a href="{{ route('register') }}" class="btn btn-outline-success fw-bold rounded-pill shadow-sm py-2">
                            Đăng ký
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
