@include('header');
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h3 class="mb-4 text-center">📝 Đăng ký tài khoản mới</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Tên đăng nhập -->
                <div class="mb-3">
                    <label for="tenDangNhap" class="form-label">Tên đăng nhập</label>
                    <input type="text" name="tenDangNhap" class="form-control @error('tenDangNhap') is-invalid @enderror" value="{{ old('tenDangNhap') }}" required>
                    @error('tenDangNhap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Họ và tên -->
                <div class="mb-3">
                    <label for="tenND" class="form-label">Họ và tên</label>
                    <input type="text" name="tenND" class="form-control @error('tenND') is-invalid @enderror" value="{{ old('tenND') }}" required>
                    @error('tenND')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số điện thoại -->
                <div class="mb-3">
                    <label for="soDT" class="form-label">Số điện thoại</label>
                    <input type="text" name="soDT" class="form-control @error('soDT') is-invalid @enderror" value="{{ old('soDT') }}" required>
                    @error('soDT')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mật khẩu -->
                <div class="mb-3">
                    <label for="matKhau" class="form-label">Mật khẩu</label>
                    <input type="password" name="matKhau" class="form-control @error('matKhau') is-invalid @enderror" required>
                    @error('matKhau')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nhập lại mật khẩu -->
                <div class="mb-4">
                    <label for="matKhau_confirmation" class="form-label">Nhập lại mật khẩu</label>
                    <input type="password" name="matKhau_confirmation" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('login') }}" class="small text-decoration-none">Đã có tài khoản?</a>
                    <button type="submit" class="btn btn-success">Đăng ký</button>
                </div>
            </form>
        </div>
    </div>
</div>
