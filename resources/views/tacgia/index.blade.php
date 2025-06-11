@include('header')
<div class="banner-container mb-4">
    <img src="{{ asset('images/banner1.jpg') }}" alt="Banner Sách Mới" class="img-fluid w-100" style="max-height: 300px; object-fit: cover;">
</div>
<div class="container my-5">
    <h2 class="mb-4 ">TÁC GIẢ</h2>

    <div class="row g-4">
        @foreach ($tacgias as $tacgia)
        
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 text-center">
            <a href="{{ route('tacgia.show', ['slug' => $tacgia->slug]) }}" class="text-decoration-none text-dark">
            <div class="author-avatar mx-auto mb-2">
                        @if ($tacgia->hinhanh)
                            <img src="{{ asset('images/tacgia/' . $tacgia->hinhanh) }}" alt="{{ $tacgia->tenTG }}">
                        @else
                            <img src="{{ asset('images/avatar_macdinh.png') }}" alt="avatar">
                        @endif
                    </div>
                    <div class="fw-semibold">{{ $tacgia->tenTG }}</div>
                </a>
            </div>
        @endforeach
    </div>
</div>


<style>
.author-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #ddd;
}
.author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
