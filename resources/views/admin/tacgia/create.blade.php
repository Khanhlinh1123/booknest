@extends('template.main')
@section('title', 'Thêm tác giả')
@section('content')
<div class="container">
    <h3>Thêm tác giả</h3>
    <form action="{{ route('admin.tacgia.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="tenTG" class="form-label">Tên tác giả</label>
            <input type="text" name="tenTG" class="form-control" required>
        </div>
        <button class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.tacgia.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
