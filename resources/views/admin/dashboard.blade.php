@extends('template.main')

@section('title','Dashboard')

@section('content')
<div class="row">
    
    <div class="col-md-3">
        <div class="layers bd bgc-white p-20">
            <div class="layer w-100 mB-10">
                <h6 class="lh-1">Lượt truy cập tháng</h6></div>
            <div class="layer w-100">
                <div class="peers ai-sb fxw-nw">
                    <div class="peer peer-greed"><span id="sparklinedash"></span></div>
                    <div class="peer"><span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{ number_format($tongTruyCapThang) }}</span></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Đơn hàng hôm nay -->
    <div class="col-md-3">
        <div class="layers bd bgc-white p-20">
            <div class="layer w-100 mB-10">
                <h6 class="lh-1">Đơn hàng hôm nay</h6></div>
            <div class="layer w-100">
                <div class="peers ai-sb fxw-nw">
                    <div class="peer peer-greed"><span id="sparklinedash2"></span></div>
                    <div class="peer"><span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500">{{ number_format($tongDonHangHomNay) }}</span></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Doanh thu tháng -->
    <div class="col-md-3">
        <div class="layers bd bgc-white p-20">
            <div class="layer w-100 mB-10">
                <h6 class="lh-1">Doanh thu tháng</h6></div>
            <div class="layer w-100">
                <div class="peers ai-sb fxw-nw">
                    <div class="peer peer-greed"><span id="sparklinedash3"></span></div>
                    <div class="peer"><span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500">{{ number_format($doanhThuThang) }} đ</span></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tổng số sách -->
    <div class="col-md-3">
        <div class="layers bd bgc-white p-20">
            <div class="layer w-100 mB-10">
                <h6 class="lh-1">Số sách đã bán</h6></div>
            <div class="layer w-100">
                <div class="peers ai-sb fxw-nw">
                    <div class="peer peer-greed"><span id="sparklinedash4"></span></div>
                    <div class="peer"><span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">{{ number_format($tongSoSach) }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
  <div class="col-md-6">
    <div class="bgc-white p-3 bd">
      <h5>  Biểu đồ doanh thu theo tháng</h5>
      <canvas id="revenueChart" height="200"></canvas>
    </div>
  </div>
  <div class="col-md-6">
    <div class="bgc-white p-3 bd">
      <h5>  Top 5 sách bán chạy</h5>
      <canvas id="topBookChart" height="200"></canvas>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const bookLabels = @json($bookLabels);
  const bookCounts = @json($bookCounts);

  const bookCtx = document.getElementById('topBookChart').getContext('2d');
  new Chart(bookCtx, {
    type: 'bar',
    data: {
      labels: bookLabels,
      datasets: [{
        label: 'Số lượng đã bán',
        data: bookCounts,
        backgroundColor: 'rgba(255, 159, 64, 0.6)',
        borderColor: 'rgba(255, 159, 64, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      },
      responsive: true,
      plugins: {
        legend: { display: false },
        title: {
          display: true,
          text: 'Top 5 sách bán chạy nhất'
        }
      }
    }
  });
</script>

<script>
  window.onload = function () {
    const labels = @json($labels);
    const values = @json($values);
    const soLuong = @json($soLuongSachTheoThang);

    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
    data: {
        labels: labels,
        datasets: [
        {
            type: 'bar',
            label: 'Doanh thu (VND)',
            data: values,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            yAxisID: 'y1',
        },
        {
            type: 'line',
            label: 'Số lượng sách bán',
            data: soLuong,
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            fill: false,
            tension: 0.3,
            yAxisID: 'y2',
        }
        ]
    },
    options: {
        responsive: true,
        plugins: {
        title: {
            display: true,
            text: 'Doanh thu và số sách bán theo tháng'
        }
        },
        scales: {
        y1: {
            type: 'linear',
            position: 'left',
            beginAtZero: true,
            title: { display: true, text: 'Doanh thu (VND)' },
            ticks: {
            callback: value => new Intl.NumberFormat().format(value)
            }
        },
        y2: {
            type: 'linear',
            position: 'right',
            beginAtZero: true,
            title: { display: true, text: 'Số sách bán' },
            grid: { drawOnChartArea: false }
        }
        }
    }
    });

  };
</script>

@endsection
