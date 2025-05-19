@include('header')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="mb-4 text-center">🔐 XÁC NHẬN MẬT KHẨU</h3>

            <div class="mb-3 text-muted small">
                Đây là khu vực bảo mật của hệ thống. Vui lòng nhập lại mật khẩu để tiếp tục.
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required autocomplete="current-password">

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        Xác nhận
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
