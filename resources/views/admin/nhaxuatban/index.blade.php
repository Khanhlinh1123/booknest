@extends('template.main')
@section('title', 'Quản lý nhà xuất bản')
@section('content')
<div class="container">
    <h3>Danh sách nhà xuất bản</h3>
    <a href="{{ route('admin.nhaxuatban.create') }}" class="btn btn-success mb-3">Thêm NXB</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Tên NXB</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nxb as $item)
                <tr>
                    <td>{{ $item->maNXB }}</td>
                    <td>{{ $item->tenNXB }}</td>
                    <td>
                        <a href="{{ route('admin.nhaxuatban.edit', $item->maNXB) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.nhaxuatban.destroy', $item->maNXB) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Xóa NXB này?')" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
