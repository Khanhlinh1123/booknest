@include('header')

<style>
#cart-table {
    table-layout: fixed; /* Đảm bảo bảng sử dụng chiều rộng cố định */
    width: 100%; /* Bảng chiếm toàn bộ chiều rộng container */
}

#cart-table th, #cart-table td {
    vertical-align: middle; /* Căn giữa theo chiều dọc */
    text-align: center; /* Căn giữa nội dung */
    padding: 10px; /* Khoảng cách trong ô */
}

#cart-table td:first-child {
    text-align: left; /* Căn trái cho cột "Thông tin sản phẩm" */
    
}

#cart-table th:nth-child(1), #cart-table td:nth-child(1) {
    width: 45%; /* Cột "Thông tin sản phẩm" */
}

#cart-table th:nth-child(2), #cart-table td:nth-child(2) {
    width: 15%; /* Cột "Đơn giá" */
}

#cart-table th:nth-child(3), #cart-table td:nth-child(3) {
    width: 15%; /* Cột "Số lượng" */
}

#cart-table th:nth-child(4), #cart-table td:nth-child(4) {
    width: 15%; /* Cột "Thành tiền" */
}

#cart-table th:nth-child(5), #cart-table td:nth-child(5) {
    width: 15%; /* Cột "Thao tác" */
}

#cart-table td img {
    max-width: 70px; /* Giới hạn kích thước hình ảnh */
    height: auto;
}

</style>

<div class="container my-5">
    <h2 class="mb-4" style="color: #2e8b57;">🛒 Giỏ hàng của bạn</h2>

    @if ($items->count() > 0)
        <div class="table-responsive bg-white p-3 rounded shadow-sm">
            <table class="table table-hover align-middle" id="cart-table">
                <thead class="table-light">
                    <tr>
                        <th>Thông tin sản phẩm</th>
                        <th class="text-center">Đơn giá</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-center">Thành tiền</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php $tongTien = 0; @endphp

                    @foreach ($items as $item)
                        @php
                            $thanhTien = $item['sach']->giaDaGiam * $item['soLuong'];
                            $tongTien += $thanhTien;
                        @endphp
                        <tr data-id="{{ $item['sach']->maSach }}">
                            <td class="d-flex align-items-center">
                                <img src="{{ asset('images/sach/' . $item['sach']->hinhanh) }}" alt="{{ $item['sach']->tenSach }}" width="70" class="me-3 rounded">
                                <div>
                                    <div class="fw-bold">{{ $item['sach']->tenSach }}</div>
                                    <small class="text-muted">Tác giả: {{ $item['sach']->tacGia->tenTG ?? 'Không rõ' }}</small>
                                </div>
                            </td>

                            <td class="text-center text-success don-gia" data-dongia="{{ $item['sach']->giaDaGiam }}">
                                {{ number_format($item['sach']->giaDaGiam) }}₫
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <button class="btn btn-light btn-sm btn-giam">-</button>
                                    <span class="px-3 fw-bold so-luong">{{ $item['soLuong'] }}</span>
                                    <button class="btn btn-light btn-sm btn-tang">+</button>
                                </div>
                            </td>

                            <td class="text-center text-success fw-bold thanh-tien">
                                {{ number_format($thanhTien) }}₫
                            </td>

                            <td class="text-center">
                                <button class="btn btn-outline-danger btn-sm btn-xoa">Xóa</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                        <td class="text-center fw-bold text-success" id="tong-tien">{{ number_format($tongTien) }}₫</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            Giỏ hàng của bạn đang trống. 🚀
        </div>
    @endif
</div>

{{-- Axios và xử lý --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function capNhatTongTien() {
        let tong = 0;
        document.querySelectorAll('#cart-table tbody tr').forEach(tr => {
            const thanhTien = tr.querySelector('.thanh-tien');
            if (thanhTien) {
                let text = thanhTien.innerText.replace(/[^\d]/g, '');
                tong += parseInt(text);
            }
        });
        document.getElementById('tong-tien').innerText = tong.toLocaleString('vi-VN') + '₫';
    }

    function capNhatThanhTien(tr) {
        const soLuong = parseInt(tr.querySelector('.so-luong').innerText);
        const donGia = parseInt(tr.querySelector('.don-gia').dataset.dongia);
        const thanhTien = soLuong * donGia;
        tr.querySelector('.thanh-tien').innerText = thanhTien.toLocaleString('vi-VN') + '₫';
    }

    // Tăng số lượng
    document.querySelectorAll('.btn-tang').forEach(button => {
        button.addEventListener('click', function () {
            const tr = this.closest('tr');
            const maSach = tr.dataset.id;

            axios.post('{{ url("/gio-hang/api-tang") }}', { maSach: maSach })
                .then(response => {
                    let soLuongSpan = tr.querySelector('.so-luong');
                    soLuongSpan.innerText = parseInt(soLuongSpan.innerText) + 1;
                    capNhatThanhTien(tr);
                    capNhatTongTien();
                })
                .catch(error => {
                    console.error(error);
                    alert('Lỗi khi tăng số lượng!');
                });
        });
    });

    // Giảm số lượng
    document.querySelectorAll('.btn-giam').forEach(button => {
        button.addEventListener('click', function () {
            const tr = this.closest('tr');
            const maSach = tr.dataset.id;

            axios.post('{{ url("/gio-hang/api-giam") }}', { maSach: maSach })
                .then(response => {
                    let soLuongSpan = tr.querySelector('.so-luong');
                    let currentQty = parseInt(soLuongSpan.innerText);
                    if (currentQty > 1) {
                        soLuongSpan.innerText = currentQty - 1;
                        capNhatThanhTien(tr);
                        capNhatTongTien();
                    } else {
                        tr.remove();
                        capNhatTongTien();
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Lỗi khi giảm số lượng!');
                });
        });
    });

    // Xóa sản phẩm
    document.querySelectorAll('.btn-xoa').forEach(button => {
        button.addEventListener('click', function () {
            if (confirm('Bạn chắc chắn muốn xóa sản phẩm này khỏi giỏ?')) {
                const tr = this.closest('tr');
                const maSach = tr.dataset.id;

                axios.post('{{ url("/gio-hang/api-xoa") }}', { maSach: maSach })
                    .then(response => {
                        tr.remove();
                        capNhatTongTien();
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Lỗi khi xóa sản phẩm!');
                    });
            }
        });
    });

});
</script>
