@extends('template.main')

@section('title','Dashboard')

@section('content')
<div class="row">
    <!-- Tổng truy cập -->
    <div class="col-md-3">
        <div class="p-3 bgc-white bd">
            <h6>Lượt truy cập tháng</h6>
            <h3>{{ number_format($tongTruyCapThang) }}</h3>
        </div>
    </div>
    <!-- Đơn hàng hôm nay -->
    <div class="col-md-3">
        <div class="p-3 bgc-white bd">
            <h6>Đơn hàng hôm nay</h6>
            <h3>{{ number_format($tongDonHangHomNay) }}</h3>
        </div>
    </div>
    <!-- Doanh thu tháng -->
    <div class="col-md-3">
        <div class="p-3 bgc-white bd">
            <h6>Doanh thu tháng</h6>
            <h3>{{ number_format($doanhThuThang) }} đ</h3>
        </div>
    </div>
    <!-- Tổng số sách -->
    <div class="col-md-3">
        <div class="p-3 bgc-white bd">
            <h6>Số sách đang bán</h6>
            <h3>{{ number_format($tongSoSach) }}</h3>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Bảng đơn hàng gần nhất -->
    <div class="col-12">
        <div class="bgc-white p-3 bd">
            <h5>Đơn hàng gần nhất</h5>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Người nhận</th>
                        <th>SĐT</th>
                        <th>Địa chỉ</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đặt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($donHangGanNhat as $don)
                        <tr>
                            <td>{{ $don->maDH }}</td>
                            <td>{{ $don->tenNguoiNhan }}</td>
                            <td>{{ $don->soDT }}</td>
                            <td>{{ $don->diaChi }}</td>
                            <td>{{ number_format($don->tongTien) }} đ</td>
                            <td>{{ $don->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
