@include('header')

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">

            <article class="blog-post p-4 bg-white rounded shadow-sm">
        <h1 class="fw-bold mb-3 text-brown" style="font-family: 'Georgia', serif;">{{ $baiViet->tieuDe }}</h1>

        <div class="mb-4 text-muted small">
            <i class="fa fa-user me-1"></i> Bởi <strong>Admin</strong> |
            <i class="fa fa-calendar me-1 ms-3"></i> Ngày đăng: 21/06/2025
        </div>


            {{-- Ảnh bìa bài viết --}}
            <img 
                src="{{ asset($baiViet->anhBia ?? 'images/default.jpg') }}" 
                alt="Bìa sách {{ $baiViet->tieuDe }}" 
                class="img-fluid rounded mb-4 shadow-sm"
                style="max-height: 400px; object-fit: cover;"
            >

            {{-- Nội dung bài viết --}}
            <div class="baiviet-noidung" style="line-height: 1.8; font-size: 1.1rem;">
                {!! $baiViet->noiDung !!}
            </div>

        </div>
</article>
    </div>
</div>
@include('footer');