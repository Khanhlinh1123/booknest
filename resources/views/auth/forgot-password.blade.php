@include('header')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="mb-4 text-center"><b>🔑 QUÊN MẬT KHẨU </b></h3>

            <div class="mb-3 text-muted small">
                Vui lòng nhập email đã đăng ký để nhận liên kết đặt lại mật khẩu.
            </div>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autofocus>

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        Gửi liên kết đặt lại mật khẩu
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
