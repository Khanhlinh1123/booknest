@extends('template.main')

@section('title', 'Danh sách danh mục')

@section('content')
    <div class="container">
        <h2 class="mb-4">Danh sách danh mục</h2>
        <a href="{{ route('admin.danhmuc.create') }}" class="btn btn-primary mb-3">Thêm danh mục</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã danh mục</th>
                    <th>Tên danh mục</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($danhmucs as $dm)
                    <tr>
                        <td>{{ $dm->maDM }}</td>
                        <td>{{ $dm->tenDM }}</td>
                        <td>
                            <a href="{{ route('admin.danhmuc.edit', $dm->maDM) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('admin.danhmuc.destroy', $dm->maDM) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận xóa?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
