@extends('template.main')
@section('title', 'Chỉnh sửa khuyến mãi')
@section('content')
<div class="container">
    <h3>Chỉnh sửa khuyến mãi</h3>
    <form action="{{ route('khuyenmai.update', $khuyenmai->maKM) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label for="tenKM" class="form-label">Tên khuyến mãi</label>
            <input type="text" name="tenKM" class="form-control" value="{{ $khuyenmai->tenKM }}" required>
        </div>

        <div class="mb-3">
            <label for="moTa" class="form-label">Mô tả</label>
            <textarea name="moTa" class="form-control">{{ $khuyenmai->moTa }}</textarea>
        </div>

        <div class="mb-3">
            <label for="loaiGiam" class="form-label">Loại giảm</label>
            <select name="loaiGiam" class="form-select" required>
                <option value="percent" {{ $khuyenmai->loaiGiam == 'percent' ? 'selected' : '' }}>Giảm phần trăm</option>
                <option value="amount" {{ $khuyenmai->loaiGiam == 'amount' ? 'selected' : '' }}>Giảm số tiền</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="giaTri" class="form-label">Giá trị</label>
            <input type="number" name="giaTri" class="form-control" value="{{ $khuyenmai->giaTri }}" required>
        </div>

        <div class="mb-3">
            <label for="batDau" class="form-label">Ngày bắt đầu</label>
            <input type="date" name="batDau" class="form-control" value="{{ $khuyenmai->batDau }}" required>
        </div>

        <div class="mb-3">
            <label for="ketThuc" class="form-label">Ngày kết thúc</label>
            <input type="date" name="ketThuc" class="form-control" value="{{ $khuyenmai->ketThuc }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('khuyenmai.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
