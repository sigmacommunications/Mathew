@extends('admin.layouts.app')

@section('content')

<div class="card">
    <div class="card-body">
        <h2>Edit Blog</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $blog->title }}" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" class="form-control" required>{{ $blog->content }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
                @if ($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" style="max-width: 200px;">
                @endif
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="summernote">{{ $blog->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush
