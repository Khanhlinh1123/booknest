@include('header');
@section('content')
<div class="container py-5">
    <h2 class="mb-4">👤 Thông tin cá nhân</h2>

    {{-- Form cập nhật thông tin cá nhân --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="row mb-3">
            <div class="col-md-4 text-center">
                {{-- Hiển thị avatar --}}
                <img src="{{ asset('images/nguoidung/' . ($nguoidung->avatar ?? 'macdinh.png')) }}"
                     alt="Avatar"
                     class="rounded-circle mb-3"
                     style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #ccc;">
                <div>
                    <label for="avatar" class="form-label">Ảnh đại diện</label>
                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                    @error('avatar')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-8">
                {{-- Tên người dùng --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Họ tên</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Nút lưu --}}
                <button type="submit" class="btn btn-primary">💾 Lưu thay đổi</button>
            </div>
        </div>
    </form>

    <hr class="my-5">

    {{-- Form đổi mật khẩu --}}
    <h4>🔐 Đổi mật khẩu</h4>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
            <input type="password" name="current_password" id="current_password" class="form-control" autocomplete="current-password">
            @error('current_password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu mới</label>
            <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-success">Cập nhật mật khẩu</button>
    </form>

    <hr class="my-5">

    {{-- Form xóa tài khoản --}}
    <h4 class="text-danger">❌ Xóa tài khoản</h4>
    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <p>Bạn có chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác.</p>

        <div class="mb-3">
            <label for="password_delete" class="form-label">Nhập mật khẩu để xác nhận</label>
            <input type="password" name="password" id="password_delete" class="form-control">
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-danger">Xác nhận xoá tài khoản</button>
    </form>
</div>
@endsection
