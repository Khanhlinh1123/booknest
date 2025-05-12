@include('header');
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $baiViet->tieuDe }}</h1>
            <p class="text-muted">
                {{ $baiViet->created_at->format('d/m/Y') }} - Tác giả: {{ $baiViet->nguoiDung->tenND ?? 'Ẩn danh' }}
            </p>
            <img src="{{ asset($baiViet->anhBia ?? 'images/default.jpg') }}" class="img-fluid mb-4" alt="{{ $baiViet->tieuDe }}">
            <div>
                {!! $baiViet->noiDung !!}
            </div>
        </div>
    </div>
</div>
