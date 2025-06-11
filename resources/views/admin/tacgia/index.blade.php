@extends('template.main')
@section('title', 'Quản lý tác giả')
@section('content')
<div class="container">
    <h3>Danh sách tác giả</h3>
    <a href="{{ route('admin.tacgia.create') }}" class="btn btn-success mb-3">Thêm tác giả</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Tên tác giả</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tacgias as $tg)
                <tr>
                    <td>{{ $tg->maTG }}</td>
                    <td>{{ $tg->tenTG }}</td>
                    <td>
                        <a href="{{ route('admin.tacgia.edit', $tg->maTG) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.tacgia.destroy', $tg->maTG) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Xóa tác giả này?')" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tacgias->links() }}

</div>
@endsection
