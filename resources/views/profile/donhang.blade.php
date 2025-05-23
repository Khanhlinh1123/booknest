@extends('layouts.account')

@section('content')
    <h2 class="mb-4 text-center">📦 ĐƠN HÀNG CỦA TÔI</h2>

    @if($donhangs->count())
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donhangs as $dh)
                        <tr>
                            <td>#{{ $dh->maDH }}</td>
                            <td>{{ $dh->created_at->format('d/m/Y - H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $dh->tinhTrang == 'Đã hủy' ? 'danger' : ($dh->tinhTrang == 'Hoàn tất' ? 'success' : 'secondary') }}">
                                    {{ $dh->tinhTrang }}
                                </span>
                            </td>
                            <td class="text-success fw-bold">{{ number_format($dh->tongTien) }}₫</td>
                            <td>
                                <button class="btn btn-sm btn-outline-dark" data-bs-toggle="collapse" data-bs-target="#ct-{{ $dh->maDH }}">Xem</button>
                            </td>
                        </tr>
                        <tr class="collapse" id="ct-{{ $dh->maDH }}">
                            <td colspan="5">
                                <ul class="list-group">
                                    @foreach($dh->chitiet as $ct)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                📖 {{ $ct->sach->tenSach ?? 'Sách không tồn tại' }} 
                                                <br><small class="text-muted">SL: {{ $ct->soLuong }}</small>
                                            </div>
                                            <div class="fw-bold text-success">{{ number_format($ct->giaMua) }}₫</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            Bạn chưa có đơn hàng nào.
        </div>
    @endif
@endsection
