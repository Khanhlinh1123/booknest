@extends('template.main')

@section('title', 'Tạo phiếu nhập')

@section('content')
<div class="container">
  <h1 class="my-4">Tạo phiếu nhập sách</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.phieunhap.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="ngayNhap" class="form-label">Ngày nhập</label>
      <input type="date" id="ngayNhap" name="ngayNhap" class="form-control" value="{{ old('ngayNhap', now()->toDateString()) }}" required>
    </div>

    <div class="mb-3">
      <label for="ghiChu" class="form-label">Ghi chú</label>
      <textarea id="ghiChu" name="ghiChu" class="form-control" rows="2">{{ old('ghiChu') }}</textarea>
    </div>

    <h4 class="mt-4">Chi tiết phiếu nhập</h4>
    <table class="table table-bordered" id="detail-table">
      <thead>
        <tr>
          <th>Sách</th>
          <th>Số lượng</th>
          <th>Đơn giá</th>
          <th style="width: 50px">–</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <select name="sach_id[]" class="form-select book-select" required>
              <option value="">— Chọn sách —</option>
              @foreach($dsSach as $s)
                <option value="{{ $s->maSach }}" data-price="{{ $s->giaGoc }}">{{ $s->tenSach }}</option>
              @endforeach
            </select>
          </td>
          <td><input type="number" name="so_luong[]" class="form-control" min="1" value="1" required></td>
          <td><input type="number" name="don_gia[]" class="form-control unit-price" step="0.01" placeholder="0.00"></td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger remove-row">&times;</button>
          </td>
        </tr>
      </tbody>
    </table>

    <button type="button" id="add-row" class="btn btn-secondary mb-3">
      <i class="fa fa-plus"></i> Thêm dòng
    </button>

    <div>
      <button type="submit" class="btn btn-primary">Lưu phiếu nhập</button>
      <a href="{{ route('admin.phieunhap.create') }}" class="btn btn-light">Hủy</a>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const dsSach = @json($dsSach->map(fn($s)=>['id'=>$s->maSach,'text'=>$s->tenSach, 'price'=>$s->giaGoc]));

    function makeRow() {
      const tr = document.createElement('tr');
      const selectOptions = dsSach.map(s => 
        `<option value="${s.id}" data-price="${s.price}">${s.text}</option>`
      ).join('');

      tr.innerHTML = `
        <td>
          <select name="sach_id[]" class="form-select book-select" required>
            <option value="">— Chọn sách —</option>
            ${selectOptions}
          </select>
        </td>
        <td><input type="number" name="so_luong[]" class="form-control" min="1" value="1" required></td>
        <td><input type="number" name="don_gia[]" class="form-control unit-price" step="0.01" placeholder="0.00"></td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-danger remove-row">&times;</button>
        </td>
      `;
      return tr;
    }

    function bindBookSelect(select) {
      select.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const price = selected.dataset.price || 0;
        const row = this.closest('tr');
        row.querySelector('.unit-price').value = price;
      });
    }

    // Bind sự kiện ban đầu
    document.querySelectorAll('.book-select').forEach(bindBookSelect);

    // Thêm dòng
    document.getElementById('add-row').addEventListener('click', function() {
      const newRow = makeRow();
      document.querySelector('#detail-table tbody').appendChild(newRow);
      bindBookSelect(newRow.querySelector('.book-select'));
    });

    // Xóa dòng
    document.querySelector('#detail-table').addEventListener('click', function(e) {
      if (e.target.classList.contains('remove-row')) {
        const tbody = this.querySelector('tbody');
        if (tbody.rows.length > 1) {
          e.target.closest('tr').remove();
        }
      }
    });
  });
</script>
@endsection
