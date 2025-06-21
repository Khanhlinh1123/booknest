@extends('layouts.account')

@section('content')

<h2 class="mb-4 text-center"><b> THÔNG TIN CÁ NHÂN</b></h2>
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Đã xảy ra lỗi:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
                {{-- Các input: tên, email, địa chỉ... --}}
                {{-- Giữ nguyên nội dung như bạn đã có --}}
                <div class="mb-3">
                    <label for="tenND" class="form-label">Họ tên</label>
                    <input type="text" name="tenND" id="tenND" class="form-control" value="{{ old('tenND', $user->tenND) }}" required>
                    @error('tenND') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email"
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', $user->email) }}" required>
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                {{-- Email, địa chỉ, ngày sinh, giới tính, ... --}}

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

        {{-- Mật khẩu cũ, mới, xác nhận --}}
        {{-- ... --}}
        <button type="submit" class="btn btn-success">✅ Cập nhật mật khẩu</button>
    </form>
</div>



@endsection
