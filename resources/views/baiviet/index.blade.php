@include('header');
<div class="container py-5">
    <h2 class="mb-4">Tất cả bài viết</h2>
    <div class="row">
        @foreach ($dsBaiViet as $bv)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($bv->anhBia ?? 'images/default.jpg') }}" class="card-img-top" alt="{{ $bv->tieuDe }}">
                    <div class="card-body">
                        <h4 class="card-title">{{ $bv->tieuDe }}</h4>
                        <p class="card-text">{{ \Str::limit(strip_tags($bv->tomTat), 100) }}</p>
                        <p><small class="text-muted">{{ $bv->nguoiDung->tenND ?? 'Ẩn danh' }} - {{ \Carbon\Carbon::parse($bv->created_at)->format('d/m/Y') }}
</small></p>
                        <a href="{{  route('baiviet.show', $bv->slug)}}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $dsBaiViet->links() }}
    </div>
</div>
@include('footer');