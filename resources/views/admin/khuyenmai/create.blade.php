@extends('template.main')
@section('title', 'Thêm khuyến mãi')
@section('content')
<div class="container">
    <h3>Thêm khuyến mãi</h3>
    <form action="{{ route('admin.khuyenmai.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="tenKM" class="form-label">Tên khuyến mãi</label>
            <input type="text" name="tenKM" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="moTa" class="form-label">Mô tả</label>
            <textarea name="moTa" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="loaiGiam" class="form-label">Loại giảm</label>
            <select name="loaiGiam" class="form-select" required>
                <option value="percent">Giảm phần trăm</option>
                <option value="amount">Giảm số tiền</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="giaTri" class="form-label">Giá trị</label>
            <input type="number" name="giaTri" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="batDau" class="form-label">Ngày bắt đầu</label>
            <input type="date" name="batDau" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ketThuc" class="form-label">Ngày kết thúc</label>
            <input type="date" name="ketThuc" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Thêm khuyến mãi</button>
        <a href="{{ route('admin.khuyenmai.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
