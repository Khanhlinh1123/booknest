@extends('template.main')

@section('title', 'Thêm danh mục')

@section('content')
<div class="container">
    <h3>Thêm Danh mục</h3>
    <form action="{{ route('admin.danhmuc.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="tenDM">Tên danh mục</label>
            <input type="text" name="tenDM" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-2">Lưu</button>
        <a href="{{ route('admin.danhmuc.index') }}" class="btn btn-secondary mt-2">Huỷ</a>
    </form>
</div>
@endsection
