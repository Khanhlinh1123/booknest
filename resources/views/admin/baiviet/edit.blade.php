@extends('template.main')
@section('title', 'Chỉnh sửa bài viết')
@section('content')
<div class="container">
    <h3>Chỉnh sửa: {{ $baiviet->tieuDe }}</h3>
    <form action="{{ route('admin.baiviet.update', $baiviet->maBV) }}" method="POST" enctype="multipart/form-data">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Đã có lỗi xảy ra:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    
    @csrf @method('PUT')

        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="tieuDe" class="form-control" value="{{ $baiviet->tieuDe }}" required>
        </div>

        <div class="mb-3">
            <label>Tóm tắt</label>
            <textarea name="tomTat" class="form-control" rows="3">{{ $baiviet->tomTat }}</textarea>
        </div>

        <div class="mb-3">
            <label>Nội dung</label>
            <textarea name="noiDung" class="form-control" rows="6">{{ $baiviet->noiDung }}</textarea>
        </div>

        <div class="mb-3">
            <label>Ảnh bìa hiện tại</label><br>
            @if ($baiviet->anhBia)
                <img src="{{ asset('images/baiviet/' . $baiviet->anhBia) }}" width="100"><br>
            @endif
            <label>Cập nhật ảnh bìa mới</label>
            <input type="file" name="anhBia" class="form-control">
        </div>

        <button class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.baiviet.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
