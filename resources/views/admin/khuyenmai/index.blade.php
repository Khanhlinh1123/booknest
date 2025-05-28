@extends('template.main')
@section('title', 'Quản lý khuyến mãi')
@section('content')
<div class="container">
    <h3>Danh sách khuyến mãi</h3>
    <a href="{{ route('admin.khuyenmai.create') }}" class="btn btn-success mb-3">Thêm mới</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Loại giảm</th>
                <th>Giá trị</th>
                <th>Thời gian</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($khuyenmais as $km)
            <tr>
                <td>{{ $km->tenKM }}</td>
                <td>{{ $km->loaiGiam == 'percent' ? 'Giảm %' : 'Giảm cố định' }}</td>
                <td>{{ $km->giaTri }}</td>
                <td>{{ $km->batDau }} - {{ $km->ketThuc }}</td>
                <td>
                    <a href="{{ route('admin.khuyenmai.sach', $km->maKM) }}" class="btn btn-info btn-sm">Xem sách</a>
                    <a href="{{ route('admin.khuyenmai.edit', $km->maKM) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admin.khuyenmai.destroy', $km->maKM) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $khuyenmais->links() }}
</div>
@endsection
