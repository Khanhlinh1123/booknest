@extends('template.main')
@section('title', 'Quản lý bài viết')
@section('content')
<div class="container">
    <h3>Danh sách bài viết</h3>
    <a href="{{ route('admin.baiviet.create') }}" class="btn btn-success mb-3">Thêm bài viết</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Ảnh bìa</th>
                <th>Tóm tắt</th>
                <th>Người đăng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($baiviets as $baiviet)
            <tr>
                <td>{{ $baiviet->tieuDe }}</td>
                <td>
                    @if ($baiviet->anhBia)
                        <img src="{{ asset('' . $baiviet->anhBia) }}" width="100">
                    @endif
                </td>
                <td>{{ Str::limit($baiviet->tomTat, 50) }}</td>
                <td>{{ $baiviet->nguoiDung->ten ?? 'N/A' }}</td>
                <td>
                <a href="{{ route('admin.baiviet.edit', $baiviet->maBV) }}" class="btn btn-sm btn-warning">Sửa</a>
                <form action="{{ route('admin.baiviet.destroy', ['baiviet' => $baiviet->maBV]) }}" method="POST" style="display:inline-block">

                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa bài viết này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $baiviets->links() }}
</div>
@endsection
