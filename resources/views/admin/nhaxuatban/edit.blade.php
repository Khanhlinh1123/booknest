@extends('template.main')
@section('title', 'Chỉnh sửa nhà xuất bản')
@section('content')
<div class="container">
    <h3>Chỉnh sửa nhà xuất bản</h3>
    <form action="{{ route('admin.nhaxuatban.update', $nhaxuatban->maNXB) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="tenNXB" class="form-label">Tên NXB</label>
            <input type="text" name="tenNXB" class="form-control" value="{{ $nhaxuatban->tenNXB }}" required>
        </div>
        <button class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.nhaxuatban.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
