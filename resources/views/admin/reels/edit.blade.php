@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Edit Uploaded Reel</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('reels.index') }}"><i
                                        class="fa fa-arrow-left"></i> Back</a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('reels.update', $reel->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ old('title', $reel->title) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="4">{{ old('description', $reel->description ?? '') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="video" class="form-label">Reels File (Leave blank to keep
                                            current)</label>
                                        <input type="file" name="video" class="form-control" accept="video/*">
                                        @if ($reel->path)
                                            <video width="320" height="240" controls class="mt-3">
                                                <source src="{{ asset('storage/' . $reel->path) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label">Thumbnail (Leave blank to keep
                                            current)</label>
                                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                        @if ($reel->thumbnail)
                                            <img src="{{ asset('storage/' . $reel->thumbnail) }}" alt="Current Thumbnail"
                                                width="100" class="mt-3">
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Reel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
