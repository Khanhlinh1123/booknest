@extends('template.main')

@section('title', 'Sửa danh mục')

@section('content')
<div class="container">
    <h3>Sửa Danh mục</h3>
    <form action="{{ route('admin.danhmuc.update', $danhmuc->maDM) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="tenDM">Tên danh mục</label>
            <input type="text" name="tenDM" class="form-control" value="{{ $danhmuc->tenDM }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
        <a href="{{ route('admin.danhmuc.index') }}" class="btn btn-secondary mt-2">Huỷ</a>
    </form>
</div>
@endsection
