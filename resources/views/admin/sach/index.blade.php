@extends('template.main')
@section('title', 'Quản lý sách')
@section('content')
<div class="container">
    <h3>Danh sách Sách</h3>
    <a href="{{ route('admin.sach.create') }}" class="btn btn-success mb-3">Thêm sách</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sách</th>
                <th>Hình ảnh</th>
                <th>Giá gốc</th>
                <th>Danh mục</th>
                <th>Tác giả</th>
                <th>Kích thước</th>
                <th>Tên DG</th>
                <th>Năm xuất bản</th>
                <th>Số lượng</th>
                <th>Ngày nhập</th>
                <th>Tên NXB</th>
                <th>Khuyến mãi</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sachs as $sach)
            <tr>
                <td>{{ $sach->tenSach }}</td>
                <td><img src="{{ asset('images/sach/' . $sach->hinhanh) }}" width="100"></td>
                <td>{{ number_format($sach->giaGoc) }}</td>
                <td>{{ $sach->danhmuc->tenDM ?? '' }}</td>
                <td>{{ $sach->tacGia->tenTG ?? '' }}</td>
                <td>{{ $sach->kichThuoc ?? '' }}</td>
                <td>{{ $sach->tenDG ?? '' }}</td>
                <td>{{ $sach->namXB ?? '' }}</td>
                <td>{{ $sach->soLuong ?? '' }}</td>
                <td>{{ $sach->created_at ?? '' }}</td>
                <td>{{ $sach->nhaXuatBan->tenNXB ?? '' }}</td>
                <td>{{ $sach->khuyenMai->tenKM ?? '' }}</td>
                <td>
                    <a href="{{ route('admin.sach.edit', $sach->maSach) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('admin.sach.destroy', $sach->maSach) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Hiển thị phân trang -->
{{ $sachs->links() }}
</div>
@endsection
