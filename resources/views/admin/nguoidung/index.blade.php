@extends('template.main')
@section('title', 'Quản lý nhà xuất bản')
@section('content')
<div class="container">
    <h1 class="mb-4">Danh sách tài khoản</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nguoidungs as $nd)
            <tr>
                <td>{{ $nd->tenND }}</td>
                <td>{{ $nd->email }}</td>
                <td>{{ $nd->phanQuyen ?? 'Không rõ' }}</td>
                <td>{{ \Carbon\Carbon::parse($nd->created_at)->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.nguoidung.show', $nd->maND) }}" class="btn btn-sm btn-primary">Xem</a>
                    {{-- <a href="#" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="#" class="btn btn-sm btn-danger">Xóa</a> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $nguoidungs->links() }}
</div>
@endsection
