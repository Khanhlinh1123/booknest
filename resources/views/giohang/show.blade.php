@include('header')

<style>
#action-fixed {
    z-index: 1050;
    transition: all 0.3s ease;
}
#btn-dat-hang:disabled {
    background-color: #ccc;
    border-color: #ccc;
    cursor: not-allowed;
}
.breadcrumb a {
    color:rgb(96, 64, 4);
    text-decoration: none;
}
.breadcrumb a:hover {
    text-decoration: underline;
}
</style>

<div class="breadcrumb-banner text-white d-flex align-items-center" style="">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-5">
    <h2 class="mb-4" style="color: #2e8b57;">Giỏ hàng của bạn</h2>

    @if ($items->count() > 0)
    <form action="{{ route('checkout') }}" method="GET" id="form-dat-hang">
    <div class="table-responsive bg-white p-3 rounded shadow-sm">
                <table class="table table-hover align-middle" id="cart-table">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="chon-tat-ca"></th>
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
                                <td class="text-center">
                                    <input type="checkbox" class="chon-sach" name="chonSach[]" value="{{ $item['sach']->maSach }}">
                                </td>
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
                                        <button type="button" class="btn btn-light btn-sm btn-giam">-</button>
                                        <span class="px-3 fw-bold so-luong">{{ $item['soLuong'] }}</span>
                                        <button type="button" class="btn btn-light btn-sm btn-tang">+</button>
                                    </div>
                                </td>

                                <td class="text-center text-success fw-bold thanh-tien">
                                    {{ number_format($thanhTien) }}₫
                                </td>

                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-xoa">Xóa</button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                            <td class="text-center fw-bold text-success" id="tong-tien">{{ number_format($tongTien) }}₫</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div id="action-fixed" class="bg-white shadow-lg border-top p-3 fixed-bottom d-flex justify-content-between align-items-center" style="display: none;">
                <div class="fw-bold fs-5">Tổng tiền: <span id="tong-tien-chon" class="text-success">0₫</span></div>
                <button id="btn-dat-hang" class="btn btn-primary px-4 rounded-pill" disabled>Tiến hành đặt hàng</button>
            </div>

        </form>
    @else
        <div class="alert alert-info">
            Giỏ hàng của bạn đang trống. 🚀
        </div>
    @endif
</div>

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
                        if (confirm('Sản phẩm chỉ còn 1. Bạn có muốn xóa khỏi giỏ hàng?')) {
                            axios.post('{{ url("/gio-hang/api-xoa") }}', { maSach: maSach })
                                .then(() => {
                                    tr.remove();
                                    capNhatTongTien();
                                });
                        }
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
                    .then(() => {
                        tr.remove();
                        capNhatTongTien();
                    });
            }
        });
    });

    // Chọn tất cả
    document.getElementById('chon-tat-ca')?.addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.chon-sach');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

});
function capNhatGiaoDienChon() {
    const checkboxes = document.querySelectorAll('.chon-sach:checked');
    const khuVuc = document.getElementById('action-fixed');
    const tongTienText = document.getElementById('tong-tien-chon');
    const btnDatHang = document.getElementById('btn-dat-hang');

    let tong = 0;

    checkboxes.forEach(cb => {
        const tr = cb.closest('tr');
        const soLuong = parseInt(tr.querySelector('.so-luong').innerText);
        const donGia = parseInt(tr.querySelector('.don-gia').dataset.dongia);
        tong += soLuong * donGia;
    });

    tongTienText.innerText = tong.toLocaleString('vi-VN') + '₫';

    if (checkboxes.length > 0) {
        khuVuc.style.display = 'flex';
        btnDatHang.disabled = false;
    } else {
        tongTienText.innerText = '0₫';
        btnDatHang.disabled = true;
        khuVuc.style.display = 'none';
    }
}

// Bắt sự kiện tick chọn từng sản phẩm
document.querySelectorAll('.chon-sach').forEach(cb => {
    cb.addEventListener('change', capNhatGiaoDienChon);
});

// Bắt sự kiện "chọn tất cả"
document.getElementById('chon-tat-ca')?.addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('.chon-sach');
    checkboxes.forEach(cb => {
        cb.checked = this.checked;
    });
    capNhatGiaoDienChon();
});

// Sự kiện click nút cố định
document.getElementById('btn-dat-hang').addEventListener('click', function () {
    document.getElementById('form-dat-hang').submit();
});

</script>
