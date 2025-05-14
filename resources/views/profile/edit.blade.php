@include('header')
<div class="banner-container mb-4">
    <img src="{{ asset('images/banner1.jpg') }}" alt="Banner Sách Mới" class="img-fluid w-100" style="max-height: 300px; object-fit: cover;">
</div>
<div class="container py-5">
    <h2 class="mb-4 text-center"><b>👤 THÔNG TIN CÁ NHÂN</b></h2>

    {{-- FORM CẬP NHẬT THÔNG TIN --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="card shadow-sm mb-5">
            <div class="row g-0">
                {{-- AVATAR --}}
                <div class="col-md-4 p-4 text-center border-end">
                    <img src="{{ asset('images/nguoidung/' . ($user->avatar ?? 'macdinh.png')) }}"
                        alt="Avatar"
                        class="rounded-circle mb-3"
                        style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #666;">
                    
                    <label for="avatar" class="form-label fw-bold">Ảnh đại diện</label>
                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                    @error('avatar')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- THÔNG TIN NGƯỜI DÙNG --}}
                <div class="col-md-8 p-4">
                    <div class="mb-3">
                        <label for="tenND" class="form-label">Họ tên</label>
                        <input type="text" name="tenND" id="tenND" class="form-control" value="{{ old('tenND', $user->tenND) }}" required>
                        @error('tenND') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="diaChi" class="form-label">Địa chỉ</label>
                        <input type="text" name="diaChi" id="diaChi" class="form-control" value="{{ old('diaChi', $user->diaChi) }}">
                        @error('diaChi') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ngaySinh" class="form-label">Ngày sinh</label>
                        <input type="date" name="ngaySinh" id="ngaySinh" class="form-control" value="{{ old('ngaySinh', $user->ngaySinh) }}">
                        @error('ngaySinh') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gioiTinh" class="form-label">Giới tính</label>
                        <select name="gioiTinh" id="gioiTinh" class="form-select">
                            <option value="Nam" {{ old('gioiTinh', $user->gioiTinh) == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gioiTinh', $user->gioiTinh) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            <option value="Khác" {{ old('gioiTinh', $user->gioiTinh) == 'Khác' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gioiTinh') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-dark">💾 Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </form>

    {{-- FORM ĐỔI MẬT KHẨU --}}
    <div class="card p-4 shadow-sm mb-5">
        <h4 class="mb-4">🔐 ĐỔI MẬT KHẨU</h4>
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

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-success">✅ Cập nhật mật khẩu</button>
        </form>
    </div>

    {{-- FORM XOÁ TÀI KHOẢN --}}
    <div class="card p-4 shadow-sm border-danger">
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
</div>
