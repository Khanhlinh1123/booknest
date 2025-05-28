@extends('template.main')
@section('title', 'Sách thuộc khuyến mãi: ' . $khuyenmai->tenKM)

@section('content')
<div class="container">
    <h3>Sách trong khuyến mãi: {{ $khuyenmai->tenKM }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sách</th>
                <th>Giá gốc</th>
                <th>Giá đã giảm</th>
                <th>Miêu tả</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sachs as $sach)
            <tr>
                <td>{{ $sach->tenSach }}</td>
                <td>{{ number_format($sach->giaGoc) }}</td>
                <td>{{ number_format($sach->gia_da_giam) }}</td>
                <td>{{ Str::limit($sach->mieuta, 100) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sachs->links() }}
</div>
@endsection
