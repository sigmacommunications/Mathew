@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Edit Video</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('videos.index') }}"><i
                                        class="fa fa-arrow-left"></i>
                                    Back</a>
                            </div>
                            <div class="card-body">

                                <form action="{{ route('videos.update', $video->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="title">Title:</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            value="{{ $video->title }}">
                                    </div>
                                    <div class="form-group">
                                        <!-- <label for="current_video">Current Video:</label> -->
                                        <video width="1000" height="240" controls>
                                            <source src="{{ asset('storage/' . $video->path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    <div class="form-group">
                                        <label for="video">Choose New Video (MP4, MOV, AVI):</label>
                                        <input type="file" name="video" id="video" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="thumbnail">Choose New Thumbnail (Optional, JPG, PNG, JPEG):</label>
                                        <input type="file" name="thumbnail" id="thumbnail" class="form-control"
                                            accept="image/jpeg,image/png,image/jpg">
                                        @error('thumbnail')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
