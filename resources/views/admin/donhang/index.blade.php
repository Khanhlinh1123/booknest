@extends('template.main')
@section('title', 'Quản lý đơn hàng')
@section('content')

<div class="container">
    <h3>Danh sách đơn hàng</h3>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <table class="table">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Khách hàng</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($donhangs as $dh)
            <tr>
                <td>{{ $dh->maDH }}</td>
                <td>{{ $dh->nguoiDung->tenND ?? 'Ẩn' }}</td>
                <td>{{ $dh->tinhTrang }}</td>
                <td>
                    <form action="{{ route('admin.donhang.updateStatus', $dh->maDH) }}" method="POST" class="d-flex">
                        @csrf
                        <select name="tinhTrang" class="form-select me-2">
    @foreach (\App\Models\Donhang::tinhTrangList() as $key => $val)
        @if ((int) $key > (int) $dh->tinhTrang)
            <option value="{{ $key }}">{{ $val }}</option>
        @endif
    @endforeach
</select>

                        <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $donhangs->links() }}
</div>

@endsection
