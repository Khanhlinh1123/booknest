@extends('template.main')
@section('title', 'Thêm bài viết')
@section('content')
<div class="container">
    <h3>Thêm bài viết</h3>
    <form action="{{ route('admin.baiviet.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="tieuDe" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tóm tắt</label>
            <textarea name="tomTat" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
        <label for="noiDung" class="form-label">Nội dung</label>
        <textarea name="noiDung" id="noiDung" class="form-control" rows="10">{{ old('noiDung', $baiviet->noiDung ?? '') }}</textarea>
    </div>


        <div class="mb-3">
            <label>Ảnh bìa</label>
            <input type="file" name="anhBia" class="form-control">
        </div>

        <button class="btn btn-primary">Lưu bài viết</button>
        <a href="{{ route('admin.baiviet.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#noiDung'), {
            simpleUpload: {
                uploadUrl: "{{ route('admin.baiviet.upload') }}", // 👈 Route xử lý upload ảnh
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
