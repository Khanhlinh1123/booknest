@extends('template.main')
@section('title', 'Thêm nhà xuất bản')
@section('content')
<div class="container">
    <h3>Thêm nhà xuất bản</h3>
    <form action="{{ route('admin.nhaxuatban.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="tenNXB" class="form-label">Tên NXB</label>
            <input type="text" name="tenNXB" class="form-control" required>
        </div>
        <button class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.nhaxuatban.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
