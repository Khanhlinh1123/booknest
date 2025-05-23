@extends('template.main')
@section('title', 'Thêm sách')
@section('content')
<div class="container">
    <h3>Thêm sách mới</h3>
    <form action="{{ route('admin.sach.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="mb-3">
            <label for="tenSach" class="form-label">Tên sách</label>
            <input type="text" name="tenSach" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="giaGoc" class="form-label">Giá gốc</label>
            <input type="number" name="giaGoc" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="maDM" class="form-label">Danh mục</label>
            <select name="maDM" class="form-select" required>
                @foreach ($danhmucs as $dm)
                    <option value="{{ $dm->maDM }}">{{ $dm->tenDM }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="maTG" class="form-label">Tác giả</label>
            <select name="maTG" class="form-select" required>
                @foreach ($tacgias as $tg)
                    <option value="{{ $tg->maTG }}">{{ $tg->tenTG }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="namXB" class="form-label">Năm xuất bản</label>
            <input type="number" name="namXB" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="soLuong" class="form-label">Số lượng</label>
            <input type="number" name="soLuong" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kichThuoc" class="form-label">Kích thước</label>
            <input type="text" name="kichThuoc" class="form-control">
        </div>
        <div class="mb-3">
            <label for="kichThuoc" class="form-label">Tên dịch giả</label>
            <input type="text" name="tenDG" class="form-control">
        </div>

        <div class="mb-3">
            <label for="hinhanh" class="form-label">Hình ảnh</label>
            <input type="file" name="hinhanh" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="mieuta" class="form-label">Miêu tả</label>
            <textarea name="mieuta" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="maKM" class="form-label">Khuyến mãi</label>
            <select name="maKM" class="form-select">
                <option value="">Không áp dụng</option>
                @foreach ($khuyenmais as $km)
                    <option value="{{ $km->maKM }}">{{ $km->tenKM }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Thêm sách</button>
        <a href="{{ route('admin.sach.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
