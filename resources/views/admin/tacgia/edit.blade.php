@extends('template.main')
@section('title', 'Chỉnh sửa tác giả')
@section('content')
<div class="container">
    <h3>Chỉnh sửa tác giả</h3>
    <form action="{{ route('admin.tacgia.update', $tacgia->maTG) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="tenTG" class="form-label">Tên tác giả</label>
            <input type="text" name="tenTG" class="form-control" value="{{ $tacgia->tenTG }}" required>
        </div>
        <button class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.tacgia.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
