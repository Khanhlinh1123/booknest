@extends('layouts.account')

@section('content')
    <h2 class="mb-4 text-center">✍️ NHẬN XÉT CỦA TÔI</h2>

    @if($sanPhamDaMua->isEmpty())
        <div class="alert alert-info">
            Bạn chưa mua sản phẩm nào để nhận xét.
        </div>
    @else
        <div class="list-group">
            @foreach($sanPhamDaMua as $item)
                <div class="list-group-item py-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            📘 <strong>{{ $item->tenSach }}</strong>
                        </div>
                        <small class="text-muted">Đã mua ngày {{ $item->pivot->created_at->format('d/m/Y') }}</small>
                    </div>

                    @if($item->nhanxet)
                        {{-- Đã nhận xét --}}
                        <div class="mb-2">
                            <strong>Nhận xét:</strong> {{ $item->nhanxet->noiDung }}
                            <br>
                            <small class="text-muted">Đánh giá: {{ $item->nhanxet->sao }} ⭐</small>
                        </div>
                        <a href="{{ route('nhanxet.edit', $item->nhanxet->id) }}" class="btn btn-outline-secondary btn-sm">📝 Sửa nhận xét</a>
                    @else
                        {{-- Chưa nhận xét --}}
                        <form action="{{ route('nhanxet.store') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="maSach" value="{{ $item->maSach }}">
                            <div class="mb-2">
                                <textarea name="noiDung" class="form-control" rows="2" placeholder="Viết nhận xét của bạn..." required></textarea>
                            </div>
                            <div class="mb-2 d-flex align-items-center gap-2">
                                <label>Đánh giá:</label>
                                <select name="sao" class="form-select w-auto">
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }} ⭐</option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Gửi nhận xét</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection
